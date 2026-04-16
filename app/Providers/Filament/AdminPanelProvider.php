<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Lunar\Admin\Support\Facades\LunarPanel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $lunarPanel = null;

        LunarPanel::panel(function ($p) use (&$lunarPanel) {
            return $lunarPanel = $p->default()->path('admin');
        })->register();

        return $lunarPanel;
    }
}
