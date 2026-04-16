<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Command;
use Lunar\FieldTypes\Text;
use Lunar\Models\Collection;
use Lunar\Models\CollectionGroup;
use Lunar\Models\Language;
use Lunar\Models\Url;

class ImportCategories extends Command
{
    protected $signature = 'hechizos:import-categories
                            {--file=/root/proyectos/hechizosdemaria/extraccion/categorias.json}
                            {--truncate : Borra las colecciones existentes antes de importar}';

    protected $description = 'Importa las categorias de WooCommerce a colecciones Lunar';

    public function handle(): int
    {
        $path = $this->option('file');
        if (! file_exists($path)) {
            $this->error("Archivo no encontrado: {$path}");

            return self::FAILURE;
        }

        $cats = json_decode(file_get_contents($path), true);
        $this->info(count($cats).' categorias a importar');

        if ($this->option('truncate')) {
            $this->warn('Truncando colecciones y grupos existentes...');
            \DB::table('lunar_urls')->where('element_type', 'collection')->delete();
            \DB::table('lunar_urls')->where('element_type', Collection::class)->delete();
            Collection::query()->forceDelete();
            CollectionGroup::query()->delete();
        }

        $group = CollectionGroup::firstOrCreate(
            ['handle' => 'categorias'],
            ['name' => 'Categorias']
        );
        $this->info("CollectionGroup id={$group->id} handle={$group->handle}");

        $language = Language::where('default', true)->firstOrFail();

        $bar = $this->output->createProgressBar(count($cats));
        $bar->start();

        $map = [];
        $created = 0;

        foreach ($cats as $c) {
            $collection = Collection::create([
                'collection_group_id' => $group->id,
                'type' => 'static',
                'attribute_data' => collect([
                    'name' => new Text($c['name']),
                    'description' => new Text($c['description'] ?? ''),
                ]),
            ]);

            $collection->urls()->create([
                'language_id' => $language->id,
                'slug' => $c['slug'],
                'default' => true,
            ]);

            $map[$c['id']] = $collection->id;
            $created++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Creadas {$created} colecciones");

        // Segundo paso: aplicar parents (aunque en este dataset todos son parent=0)
        $withParents = collect($cats)->filter(fn ($c) => ($c['parent'] ?? 0) > 0);
        if ($withParents->isNotEmpty()) {
            $this->info("Aplicando jerarquia a {$withParents->count()} colecciones con parent...");
            foreach ($withParents as $c) {
                if (isset($map[$c['parent']]) && isset($map[$c['id']])) {
                    $child = Collection::find($map[$c['id']]);
                    $parent = Collection::find($map[$c['parent']]);
                    $child->parent_id = $parent->id;
                    $child->save();
                }
            }
        }

        cache()->put('hechizos:category_map', $map, now()->addHours(24));
        $this->info('Mapa WooID -> LunarID guardado en cache (24h) como hechizos:category_map');

        return self::SUCCESS;
    }
}
