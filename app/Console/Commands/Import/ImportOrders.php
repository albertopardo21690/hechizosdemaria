<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Lunar\Models\Channel;
use Lunar\Models\Country;
use Lunar\Models\Customer;
use Lunar\Models\Order;
use Lunar\Models\OrderAddress;
use Lunar\Models\OrderLine;
use Lunar\Models\ProductVariant;

class ImportOrders extends Command
{
    protected $signature = 'hechizos:import-orders
                            {--file=/root/proyectos/hechizosdemaria/extraccion/pedidos.json}
                            {--limit=0}
                            {--truncate}';

    protected $description = 'Importa pedidos historicos de WooCommerce a Lunar';

    protected array $statusMap = [
        'processing' => 'payment-received',
        'completed' => 'dispatched',
        'on-hold' => 'payment-offline',
        'failed' => 'cancelled',
        'cancelled' => 'cancelled',
        'refunded' => 'refunded',
        'pending' => 'awaiting-payment',
    ];

    public function handle(): int
    {
        $orders = json_decode(file_get_contents($this->option('file')), true);
        $limit = (int) $this->option('limit');
        if ($limit > 0) {
            $orders = array_slice($orders, 0, $limit);
        }

        $productMap = cache()->get('hechizos:product_map', []);
        if (empty($productMap)) {
            $this->error('No hay mapa producto. Ejecuta hechizos:import-products primero');

            return self::FAILURE;
        }

        if ($this->option('truncate')) {
            \DB::statement('SET FOREIGN_KEY_CHECKS=0');
            \DB::table('lunar_order_addresses')->delete();
            \DB::table('lunar_order_lines')->delete();
            \DB::table('lunar_orders')->delete();
            \DB::table('lunar_customers')->delete();
            \DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        $channel = Channel::where('default', true)->firstOrFail();
        $countries = Country::pluck('id', 'iso2')->toArray();

        $variantMap = $this->buildVariantMap($productMap);
        $customerMap = [];

        $this->info(count($orders).' pedidos a importar');
        $bar = $this->output->createProgressBar(count($orders));
        $bar->start();

        $created = 0;
        $skipped = 0;

        foreach ($orders as $o) {
            try {
                $billing = $o['billing'] ?? [];
                $email = $billing['email'] ?? null;

                $customer = null;
                if ($email) {
                    if (! isset($customerMap[$email])) {
                        $customerMap[$email] = Customer::firstOrCreate(
                            ['account_ref' => 'wc-'.substr(md5($email), 0, 16)],
                            [
                                'first_name' => $billing['first_name'] ?? '',
                                'last_name' => $billing['last_name'] ?? '',
                                'company_name' => $billing['company'] ?? null,
                                'meta' => ['email' => $email],
                            ]
                        )->id;
                    }
                    $customer = $customerMap[$email];
                }

                $placedAt = Carbon::parse($o['date_created']);
                $totalMinor = (int) round(((float) $o['total']) * 100);
                $subtotalMinor = (int) round(((float) ($o['total'] ?? 0) - (float) ($o['total_tax'] ?? 0) - (float) ($o['shipping_total'] ?? 0) + (float) ($o['discount_total'] ?? 0)) * 100);
                $taxMinor = (int) round(((float) ($o['total_tax'] ?? 0)) * 100);
                $shipMinor = (int) round(((float) ($o['shipping_total'] ?? 0)) * 100);
                $discMinor = (int) round(((float) ($o['discount_total'] ?? 0)) * 100);

                $order = Order::create([
                    'customer_id' => $customer,
                    'channel_id' => $channel->id,
                    'new_customer' => false,
                    'status' => $this->statusMap[$o['status']] ?? 'awaiting-payment',
                    'reference' => 'WC-'.$o['id'],
                    'sub_total' => $subtotalMinor,
                    'discount_breakdown' => collect(),
                    'discount_total' => $discMinor,
                    'shipping_breakdown' => new \Lunar\Base\ValueObjects\Cart\ShippingBreakdown,
                    'shipping_total' => $shipMinor,
                    'tax_breakdown' => new \Lunar\Base\ValueObjects\Cart\TaxBreakdown,
                    'tax_total' => $taxMinor,
                    'total' => $totalMinor,
                    'currency_code' => $o['currency'] ?? 'EUR',
                    'compare_currency_code' => $o['currency'] ?? 'EUR',
                    'exchange_rate' => 1,
                    'placed_at' => $placedAt,
                    'notes' => $o['customer_note'] ?? null,
                    'meta' => [
                        'wc_id' => $o['id'],
                        'payment_method' => $o['payment_method'] ?? null,
                        'payment_title' => $o['payment_method_title'] ?? null,
                        'transaction_id' => $o['transaction_id'] ?? null,
                    ],
                ]);

                foreach ($o['line_items'] ?? [] as $li) {
                    $wcProductId = $li['product_id'];
                    $lunarProductId = $productMap[$wcProductId] ?? null;
                    $variantId = $variantMap[$lunarProductId] ?? null;

                    $unitPrice = (int) round(((float) $li['subtotal']) * 100 / max(1, $li['quantity']));
                    $subtotal = (int) round(((float) $li['subtotal']) * 100);
                    $lineTotal = (int) round(((float) $li['total']) * 100);
                    $lineTax = (int) round(((float) ($li['total_tax'] ?? 0)) * 100);

                    OrderLine::create([
                        'order_id' => $order->id,
                        'purchasable_type' => $variantId ? 'product_variant' : 'product_variant',
                        'purchasable_id' => $variantId ?? 0,
                        'type' => 'physical',
                        'description' => $li['name'],
                        'identifier' => $li['sku'] ?: ('WC-PROD-'.$wcProductId),
                        'unit_price' => $unitPrice,
                        'unit_quantity' => 1,
                        'quantity' => (int) $li['quantity'],
                        'sub_total' => $subtotal,
                        'discount_total' => 0,
                        'tax_breakdown' => new \Lunar\Base\ValueObjects\Cart\TaxBreakdown,
                        'tax_total' => $lineTax,
                        'total' => $lineTotal,
                    ]);
                }

                foreach (['billing' => 'billing', 'shipping' => 'shipping'] as $src => $type) {
                    $addr = $o[$src] ?? [];
                    if (empty($addr['first_name']) && empty($addr['address_1'])) {
                        continue;
                    }

                    OrderAddress::create([
                        'order_id' => $order->id,
                        'country_id' => $countries[$addr['country'] ?? 'ES'] ?? ($countries['ES'] ?? null),
                        'first_name' => $addr['first_name'] ?? '',
                        'last_name' => $addr['last_name'] ?? '',
                        'company_name' => $addr['company'] ?? null,
                        'line_one' => $addr['address_1'] ?? '',
                        'line_two' => $addr['address_2'] ?? null,
                        'city' => $addr['city'] ?? '',
                        'state' => $addr['state'] ?? null,
                        'postcode' => $addr['postcode'] ?? null,
                        'contact_email' => $src === 'billing' ? ($addr['email'] ?? null) : null,
                        'contact_phone' => $addr['phone'] ?? null,
                        'type' => $type,
                    ]);
                }

                $created++;
            } catch (\Throwable $e) {
                $skipped++;
                $this->newLine();
                $this->warn("Skip WC#{$o['id']}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Creados: {$created}  |  Saltados: {$skipped}  |  Clientes unicos: ".count($customerMap));

        return self::SUCCESS;
    }

    private function buildVariantMap(array $productMap): array
    {
        // Producto Lunar id -> primera variant id
        return ProductVariant::whereIn('product_id', array_values($productMap))
            ->get(['id', 'product_id'])
            ->groupBy('product_id')
            ->map(fn ($vs) => $vs->first()->id)
            ->toArray();
    }
}
