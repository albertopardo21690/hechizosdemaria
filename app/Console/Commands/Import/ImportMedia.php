<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Command;
use Lunar\Models\Product;

class ImportMedia extends Command
{
    protected $signature = 'hechizos:import-media
                            {--file=/root/proyectos/hechizosdemaria/extraccion/productos.json}
                            {--limit=0}
                            {--skip-existing : Salta productos que ya tengan imagenes}';

    protected $description = 'Descarga las imagenes de productos desde WooCommerce y las asocia a Lunar';

    public function handle(): int
    {
        $products = json_decode(file_get_contents($this->option('file')), true);
        $limit = (int) $this->option('limit');
        if ($limit > 0) {
            $products = array_slice($products, 0, $limit);
        }

        $productMap = cache()->get('hechizos:product_map', []);
        if (empty($productMap)) {
            $this->error('No hay mapa producto en cache. Ejecuta primero hechizos:import-products');

            return self::FAILURE;
        }

        $withImages = array_filter($products, fn ($p) => ! empty($p['images']));
        $this->info(count($withImages).' productos con imagenes a procesar');

        $bar = $this->output->createProgressBar(count($withImages));
        $bar->start();

        $ok = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($withImages as $p) {
            if (! isset($productMap[$p['id']])) {
                $failed++;
                $bar->advance();

                continue;
            }

            $product = Product::find($productMap[$p['id']]);
            if (! $product) {
                $failed++;
                $bar->advance();

                continue;
            }

            if ($this->option('skip-existing') && $product->getMedia('images')->isNotEmpty()) {
                $skipped++;
                $bar->advance();

                continue;
            }

            foreach ($p['images'] as $idx => $img) {
                try {
                    $media = $product->addMediaFromUrl($img['src'])
                        ->usingName($img['name'] ?? $p['name'])
                        ->toMediaCollection('images');

                    if ($idx === 0) {
                        $media->setCustomProperty('primary', true);
                        $media->save();
                    }
                    $ok++;
                } catch (\Throwable $e) {
                    $failed++;
                    $this->newLine();
                    $this->warn("  Falla {$p['name']}: {$e->getMessage()}");
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Descargadas: {$ok}  |  Saltadas: {$skipped}  |  Fallos: {$failed}");

        return self::SUCCESS;
    }
}
