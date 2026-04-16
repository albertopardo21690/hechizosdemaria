<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Lunar\FieldTypes\Text;
use Lunar\Models\Collection;
use Lunar\Models\Currency;
use Lunar\Models\Language;
use Lunar\Models\Price;
use Lunar\Models\Product;
use Lunar\Models\ProductType;
use Lunar\Models\ProductVariant;
use Lunar\Models\TaxClass;
use Lunar\Models\Url;

class ImportProducts extends Command
{
    protected $signature = 'hechizos:import-products
                            {--file=/root/proyectos/hechizosdemaria/extraccion/productos.json}
                            {--truncate : Borra productos existentes antes de importar}
                            {--limit=0 : Limita numero de productos a importar (0 = todos)}';

    protected $description = 'Importa los productos de WooCommerce a Lunar';

    public function handle(): int
    {
        $path = $this->option('file');
        if (! file_exists($path)) {
            $this->error("Archivo no encontrado: {$path}");

            return self::FAILURE;
        }

        $products = json_decode(file_get_contents($path), true);
        $limit = (int) $this->option('limit');
        if ($limit > 0) {
            $products = array_slice($products, 0, $limit);
        }

        $this->info(count($products).' productos a importar');

        if ($this->option('truncate')) {
            $this->warn('Truncando productos existentes...');
            \DB::table('lunar_urls')->where('element_type', 'product')->delete();
            \DB::table('lunar_prices')->where('priceable_type', 'product_variant')->delete();
            \DB::table('lunar_prices')->where('priceable_type', ProductVariant::class)->delete();
            ProductVariant::query()->forceDelete();
            Product::query()->forceDelete();
            \DB::table('lunar_collection_product')->delete();
        }

        $productType = ProductType::firstOrCreate(['name' => 'General']);
        $taxClass = TaxClass::firstOrCreate(['name' => 'Standard'], ['default' => true]);
        $language = Language::where('default', true)->firstOrFail();
        $eur = Currency::where('code', 'EUR')->firstOrFail();
        $usd = Currency::where('code', 'USD')->firstOrFail();

        $categoryMap = cache()->get('hechizos:category_map', []);
        if (empty($categoryMap)) {
            $this->warn('No hay mapa de categorias en cache. Ejecuta primero hechizos:import-categories');
        }

        $bar = $this->output->createProgressBar(count($products));
        $bar->start();

        $map = [];
        $created = 0;
        $skipped = 0;
        $noImage = 0;

        foreach ($products as $p) {
            try {
                $sku = $p['sku'] ?: 'HDM-'.$p['id'];
                $priceEur = (float) ($p['regular_price'] ?: $p['price'] ?: 0);
                $priceUsd = round($priceEur * $usd->exchange_rate, 2);

                $name = $this->cleanHtml($p['name']);
                $desc = $p['description'] ?: $p['short_description'] ?: '';

                $status = $p['status'] === 'publish' ? 'published' : 'draft';

                $product = Product::create([
                    'product_type_id' => $productType->id,
                    'status' => $status,
                    'attribute_data' => collect([
                        'name' => new Text($name),
                        'description' => new Text($desc),
                    ]),
                ]);

                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'tax_class_id' => $taxClass->id,
                    'sku' => $sku,
                    'stock' => $p['manage_stock'] && $p['stock_quantity'] !== null
                        ? (int) $p['stock_quantity']
                        : 999,
                    'unit_quantity' => 1,
                    'min_quantity' => 1,
                    'quantity_increment' => 1,
                    'shippable' => ! ($p['virtual'] ?? false),
                    'purchasable' => 'always',
                ]);

                $variant->prices()->create([
                    'currency_id' => $eur->id,
                    'price' => (int) round($priceEur * 100),
                    'min_quantity' => 1,
                ]);

                $variant->prices()->create([
                    'currency_id' => $usd->id,
                    'price' => (int) round($priceUsd * 100),
                    'min_quantity' => 1,
                ]);

                $product->urls()->create([
                    'language_id' => $language->id,
                    'slug' => $p['slug'],
                    'default' => true,
                ]);

                $collectionIds = [];
                foreach ($p['categories'] ?? [] as $cat) {
                    if (isset($categoryMap[$cat['id']])) {
                        $collectionIds[$categoryMap[$cat['id']]] = ['position' => 1];
                    }
                }
                if ($collectionIds) {
                    $product->collections()->sync($collectionIds);
                }

                if (empty($p['images'])) {
                    $noImage++;
                }

                $map[$p['id']] = $product->id;
                $created++;
            } catch (\Throwable $e) {
                $skipped++;
                $this->newLine();
                $this->error("Skip {$p['id']} ({$p['name']}): {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Creados: {$created}  |  Saltados: {$skipped}  |  Sin imagen: {$noImage}");

        cache()->put('hechizos:product_map', $map, now()->addHours(24));
        $this->info('Mapa WooID -> LunarID guardado en cache (24h) como hechizos:product_map');

        return self::SUCCESS;
    }

    private function cleanHtml(string $s): string
    {
        $s = html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $s = strip_tags($s);

        return trim($s);
    }
}
