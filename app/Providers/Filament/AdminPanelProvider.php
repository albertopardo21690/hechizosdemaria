<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Lunar\Admin\Support\Facades\LunarPanel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $lunarPanel = null;

        LunarPanel::panel(function ($p) use (&$lunarPanel) {
            return $lunarPanel = $p
                ->default()
                ->path('filament')
                ->brandName('Hechizos de Maria')
                ->colors([
                    'primary' => Color::Amber,
                    'secondary' => Color::Purple,
                    'gray' => Color::Slate,
                ])
                ->font('Lato')
                ->sidebarCollapsibleOnDesktop()
                ->discoverResources(
                    in: app_path('Filament/Resources'),
                    for: 'App\\Filament\\Resources'
                )
                ->discoverWidgets(
                    in: app_path('Filament/Widgets'),
                    for: 'App\\Filament\\Widgets'
                );
        })->register();

        return $lunarPanel;
    }
}
