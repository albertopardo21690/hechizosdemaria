<?php

namespace App\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Lunar\Models\Collection;
use Lunar\Models\Product;

class ShopGrid extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'col')]
    public string $collection = '';

    #[Url(as: 'orden')]
    public string $sort = 'price_asc';

    #[Url(as: 'min')]
    public string $priceMin = '';

    #[Url(as: 'max')]
    public string $priceMax = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCollection(): void
    {
        $this->resetPage();
    }

    public function updatingSort(): void
    {
        $this->resetPage();
    }

    public function updatingPriceMin(): void
    {
        $this->resetPage();
    }

    public function updatingPriceMax(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'collection', 'sort', 'priceMin', 'priceMax']);
        $this->resetPage();
    }

    protected function eurPrice(Product $p): float
    {
        return $p->variants->first()?->prices->firstWhere('currency.code', 'EUR')?->price->decimal ?? PHP_INT_MAX;
    }

    public function render()
    {
        $query = Product::where('status', 'published')
            ->with(['variants.prices.currency', 'media', 'collections', 'urls']);

        if ($this->search) {
            $term = $this->search;
            $query->where(function ($q) use ($term) {
                $q->whereRaw("JSON_EXTRACT(attribute_data, '$.name.value') LIKE ?", ["%{$term}%"])
                  ->orWhereRaw("JSON_EXTRACT(attribute_data, '$.description.value') LIKE ?", ["%{$term}%"]);
            });
        }

        if ($this->collection) {
            $query->whereHas('collections.urls', fn ($q) => $q->where('slug', $this->collection));
        }

        $all = $query->get();

        // Price filter in PHP (reliable with Lunar's price objects)
        if ($this->priceMin || $this->priceMax) {
            $min = $this->priceMin ? (float) $this->priceMin : 0;
            $max = $this->priceMax ? (float) $this->priceMax : PHP_INT_MAX;
            $all = $all->filter(function ($p) use ($min, $max) {
                $price = $this->eurPrice($p);
                return $price >= $min && $price <= $max;
            });
        }

        // Sort in PHP
        $all = match ($this->sort) {
            'price_asc' => $all->sortBy(fn ($p) => $this->eurPrice($p)),
            'price_desc' => $all->sortByDesc(fn ($p) => $this->eurPrice($p)),
            'name_asc' => $all->sortBy(fn ($p) => $p->attribute_data['name']?->getValue() ?? ''),
            'name_desc' => $all->sortByDesc(fn ($p) => $p->attribute_data['name']?->getValue() ?? ''),
            default => $all->sortByDesc('created_at'),
        };

        $all = $all->values();
        $page = max(1, (int) request('page', 1));
        $perPage = 24;

        $products = new LengthAwarePaginator(
            $all->forPage($page, $perPage)->values(),
            $all->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $collections = Collection::with('urls')
            ->orderBy('id')
            ->get()
            ->map(fn ($c) => (object) [
                'slug' => $c->urls->where('default', true)->first()?->slug ?? $c->urls->first()?->slug,
                'name' => $c->attribute_data['name']?->getValue() ?? '-',
            ])
            ->filter(fn ($c) => $c->slug);

        $hasFilters = $this->search || $this->collection || $this->priceMin || $this->priceMax || $this->sort !== 'price_asc';

        return view('livewire.shop-grid', compact('products', 'collections', 'hasFilters'));
    }
}
