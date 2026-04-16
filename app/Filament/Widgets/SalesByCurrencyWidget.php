<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Lunar\Models\Order;

class SalesByCurrencyWidget extends BaseWidget
{
    protected static ?int $sort = -2;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totals = Order::query()
            ->select('currency_code', DB::raw('COUNT(*) as n'), DB::raw('SUM(total) as sum'))
            ->whereIn('status', ['payment-received', 'dispatched'])
            ->groupBy('currency_code')
            ->get()
            ->keyBy('currency_code');

        $eur = $totals->get('EUR');
        $usd = $totals->get('USD');

        $eurAmount = $eur ? number_format($eur->sum / 100, 2, ',', '.').' €' : '0 €';
        $eurCount = $eur ? $eur->n : 0;
        $usdAmount = $usd ? '$'.number_format($usd->sum / 100, 2, '.', ',') : '$0';
        $usdCount = $usd ? $usd->n : 0;

        $pending = Order::where('status', 'payment-offline')->count();
        $totalOrders = Order::count();

        return [
            Stat::make('Facturado EUR', $eurAmount)
                ->description("{$eurCount} pedidos cobrados")
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Facturado USD', $usdAmount)
                ->description("{$usdCount} pedidos cobrados")
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Pendientes', $pending)
                ->description("{$totalOrders} pedidos totales")
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
        ];
    }
}
