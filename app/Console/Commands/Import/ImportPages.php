<?php

namespace App\Console\Commands\Import;

use App\Models\Page;
use Illuminate\Console\Command;

class ImportPages extends Command
{
    protected $signature = 'hechizos:import-pages
                            {--file=/root/proyectos/hechizosdemaria/extraccion/paginas.json}
                            {--truncate}';

    protected $description = 'Importa las paginas de WordPress al modelo Page';

    public function handle(): int
    {
        $pages = json_decode(file_get_contents($this->option('file')), true);

        $this->info(count($pages).' paginas a importar');

        if ($this->option('truncate')) {
            Page::query()->delete();
        }

        $created = 0;
        $skipped = 0;

        foreach ($pages as $p) {
            try {
                $title = html_entity_decode($p['title']['rendered'] ?? '?', ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $content = $p['content']['rendered'] ?? '';
                $excerpt = $p['excerpt']['rendered'] ?? null;

                Page::updateOrCreate(
                    ['wc_id' => $p['id']],
                    [
                        'title' => $title,
                        'slug' => $p['slug'],
                        'content' => $content,
                        'excerpt' => $excerpt ? html_entity_decode(strip_tags($excerpt), ENT_QUOTES | ENT_HTML5, 'UTF-8') : null,
                        'status' => $p['status'] === 'publish' ? 'published' : 'draft',
                        'template' => $p['template'] ?: 'default',
                        'sort' => $p['menu_order'] ?? 0,
                        'seo' => [
                            'parent' => $p['parent'] ?? 0,
                        ],
                    ]
                );
                $created++;
            } catch (\Throwable $e) {
                $skipped++;
                $this->warn("Skip {$p['id']}: {$e->getMessage()}");
            }
        }

        $this->info("Upserted: {$created}  |  Saltados: {$skipped}");

        return self::SUCCESS;
    }
}
