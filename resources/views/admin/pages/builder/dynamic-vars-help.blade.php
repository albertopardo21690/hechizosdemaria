<details class="mt-3 text-xs bg-pink-50/60 border border-pink-200 rounded-md">
    <summary class="cursor-pointer px-3 py-2 text-pink-700 font-semibold uppercase tracking-widest">⚡ Variables dinámicas disponibles</summary>
    <div class="px-3 pb-3 pt-1 text-gray-600 space-y-2">
        <p>Puedes insertar datos del contexto actual escribiendo variables entre llaves dobles. En páginas y plantillas donde no exista el contexto, la variable se renderiza vacía.</p>
        <div class="grid md:grid-cols-2 gap-2 font-mono text-[11px]">
            <div><strong>Producto:</strong><br>{{ '{{' }} product.name {{ '}}' }}<br>{{ '{{' }} product.price {{ '}}' }}<br>{{ '{{' }} product.sku {{ '}}' }}<br>{{ '{{' }} product.stock {{ '}}' }}<br>{{ '{{' }} product.slug {{ '}}' }}</div>
            <div><strong>Colección:</strong><br>{{ '{{' }} collection.name {{ '}}' }}<br>{{ '{{' }} collection.slug {{ '}}' }}<br><br><strong>Página:</strong><br>{{ '{{' }} page.title {{ '}}' }}<br>{{ '{{' }} page.excerpt {{ '}}' }}</div>
            <div class="md:col-span-2"><strong>Sitio:</strong> {{ '{{' }} site.name {{ '}}' }} · {{ '{{' }} site.email {{ '}}' }} · {{ '{{' }} site.phone {{ '}}' }} · {{ '{{' }} site.year {{ '}}' }}</div>
        </div>
    </div>
</details>
