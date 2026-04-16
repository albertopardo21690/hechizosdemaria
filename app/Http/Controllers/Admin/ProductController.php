<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lunar\FieldTypes\Text;
use Lunar\Models\Collection;
use Lunar\Models\Currency;
use Lunar\Models\Price;
use Lunar\Models\Product;
use Lunar\Models\ProductType;
use Lunar\Models\ProductVariant;
use Lunar\Models\TaxClass;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $query = Product::query()->with(['variants.prices.currency', 'collections', 'media']);

        if ($q) {
            $query->whereRaw("JSON_EXTRACT(attribute_data, '$.name.value') LIKE ?", ['%'.$q.'%']);
        }
        if ($status && in_array($status, ['published', 'draft'])) {
            $query->where('status', $status);
        }

        $products = $query->orderByDesc('id')->paginate(30)->withQueryString();

        return view('admin.products.index', compact('products', 'q', 'status'));
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => null,
            'collections' => Collection::with('urls')->get(),
            'selectedCollections' => [],
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request);

        $product = Product::create([
            'product_type_id' => ProductType::firstOrCreate(['name' => 'General'])->id,
            'status' => $data['status'],
            'attribute_data' => collect([
                'name' => new Text($data['name']),
                'description' => new Text($data['description'] ?? ''),
            ]),
        ]);

        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'tax_class_id' => TaxClass::where('default', true)->value('id') ?? TaxClass::firstOrCreate(['name' => 'Standard'])->id,
            'sku' => $data['sku'] ?: 'HDM-'.$product->id,
            'stock' => $data['stock'] ?? 999,
            'unit_quantity' => 1,
            'min_quantity' => 1,
            'quantity_increment' => 1,
            'shippable' => true,
            'purchasable' => 'always',
        ]);

        $this->syncPrices($variant, $data);
        $this->syncUrl($product, $data['slug']);
        $this->syncCollections($product, $request->input('collections', []));

        return redirect()->route('admin.products.edit', $product)->with('status', 'Producto creado.');
    }

    public function edit(Product $product)
    {
        $product->load(['variants.prices.currency', 'collections', 'urls', 'media']);

        return view('admin.products.form', [
            'product' => $product,
            'collections' => Collection::with('urls')->get(),
            'selectedCollections' => $product->collections->pluck('id')->toArray(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validate($request);

        $product->update([
            'status' => $data['status'],
            'attribute_data' => collect([
                'name' => new Text($data['name']),
                'description' => new Text($data['description'] ?? ''),
            ]),
        ]);

        $variant = $product->variants->first();
        if ($variant) {
            $variant->update([
                'sku' => $data['sku'] ?: $variant->sku,
                'stock' => $data['stock'] ?? $variant->stock,
            ]);
            $this->syncPrices($variant, $data);
        }

        $this->syncUrl($product, $data['slug']);
        $this->syncCollections($product, $request->input('collections', []));

        return redirect()->route('admin.products.edit', $product)->with('status', 'Producto actualizado.');
    }

    public function destroy(Product $product)
    {
        $product->forceDelete();

        return redirect()->route('admin.products.index')->with('status', 'Producto eliminado.');
    }

    public function uploadImage(Request $request, Product $product)
    {
        $request->validate([
            'file' => 'required|file|mimetypes:image/jpeg,image/png,image/webp|max:8192',
        ]);

        $product->addMediaFromRequest('file')->toMediaCollection('images');

        return back()->with('status', 'Imagen subida.');
    }

    public function deleteImage(Product $product, int $mediaId)
    {
        $product->getMedia('images')->where('id', $mediaId)->each->delete();

        return back()->with('status', 'Imagen eliminada.');
    }

    protected function validate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:published,draft',
            'sku' => 'nullable|string|max:64',
            'stock' => 'nullable|integer|min:0',
            'price_eur' => 'required|numeric|min:0',
            'price_usd' => 'nullable|numeric|min:0',
        ]);
    }

    protected function syncPrices(ProductVariant $variant, array $data): void
    {
        $eur = Currency::where('code', 'EUR')->first();
        $usd = Currency::where('code', 'USD')->first();

        if ($eur) {
            Price::updateOrCreate(
                ['priceable_type' => 'product_variant', 'priceable_id' => $variant->id, 'currency_id' => $eur->id, 'min_quantity' => 1],
                ['price' => (int) round($data['price_eur'] * 100)]
            );
        }
        if ($usd) {
            $priceUsd = $data['price_usd'] ?? ($data['price_eur'] * $usd->exchange_rate);
            Price::updateOrCreate(
                ['priceable_type' => 'product_variant', 'priceable_id' => $variant->id, 'currency_id' => $usd->id, 'min_quantity' => 1],
                ['price' => (int) round($priceUsd * 100)]
            );
        }
    }

    protected function syncUrl(Product $product, string $slug): void
    {
        $language = \Lunar\Models\Language::where('default', true)->firstOrFail();
        $url = $product->urls()->where('default', true)->first();
        if ($url) {
            $url->update(['slug' => $slug]);
        } else {
            $product->urls()->create(['language_id' => $language->id, 'slug' => $slug, 'default' => true]);
        }
    }

    protected function syncCollections(Product $product, array $ids): void
    {
        $sync = [];
        foreach ($ids as $id) {
            $sync[$id] = ['position' => 1];
        }
        $product->collections()->sync($sync);
    }
}
