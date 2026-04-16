<section class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 prose prose-pink max-w-none text-gray-700 [&_a]:text-pink-600 [&_h2]:font-heading [&_h2]:text-pink-700 [&_h3]:font-heading [&_h3]:text-pink-700">
        {!! \App\Support\DynamicContent::render($block['props']['html'] ?? '') !!}
    </div>
</section>
