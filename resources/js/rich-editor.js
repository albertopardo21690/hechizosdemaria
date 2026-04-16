function loadTinymce() {
    if (window.tinymce) return Promise.resolve(window.tinymce);
    if (window.__tinymceLoading) return window.__tinymceLoading;
    window.__tinymceLoading = new Promise((resolve, reject) => {
        const s = document.createElement('script');
        s.src = '/vendor/tinymce/tinymce.min.js';
        s.referrerPolicy = 'origin';
        s.onload = () => resolve(window.tinymce);
        s.onerror = reject;
        document.head.appendChild(s);
    });
    return window.__tinymceLoading;
}

function initEditor(el, tinymce) {
    if (el.dataset.tinymceLoaded === '1') return;
    el.dataset.tinymceLoaded = '1';
    tinymce.init({
        target: el,
        height: 420,
        menubar: false,
        base_url: '/vendor/tinymce',
        suffix: '.min',
        plugins: 'advlist autolink lists link charmap preview searchreplace code wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | link removeformat | blockquote | code preview',
        content_style: `body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif; font-size: 15px; color: #374151; line-height: 1.6; padding: 12px; } p { margin: 0 0 .8rem } h2,h3 { color: #be185d; font-family: 'Cinzel', serif; } a { color: #db2777 } blockquote { border-left: 3px solid #ec4899; padding-left: 12px; color: #6b7280; font-style: italic }`,
        language: 'es',
        language_url: '/vendor/tinymce/langs/es.js',
        browser_spellcheck: true,
        branding: false,
        promotion: false,
        paste_as_text: false,
        paste_data_images: false,
        paste_retain_style_properties: '',
        paste_webkit_styles: 'none',
        paste_merge_formats: true,
        valid_classes: '',
        valid_styles: { '*': 'text-align,text-decoration' },
        extended_valid_elements: 'a[href|target|rel]',
        invalid_elements: 'script,style,iframe,form,input,object,embed',
        block_formats: 'Párrafo=p; Encabezado 2=h2; Encabezado 3=h3; Encabezado 4=h4',
        paste_preprocess(plugin, args) {
            args.content = args.content
                .replace(/<span[^>]*>/gi, '')
                .replace(/<\/span>/gi, '')
                .replace(/ class="[^"]*"/gi, '')
                .replace(/ style="[^"]*"/gi, '')
                .replace(/&nbsp;/gi, ' ')
                .replace(/<o:p>[\s\S]*?<\/o:p>/gi, '');
        },
        setup(editor) {
            editor.on('change keyup blur', () => editor.save());
        },
    });
}

async function initAll() {
    const els = document.querySelectorAll('textarea[data-rich-editor]');
    if (!els.length) return;
    const tinymce = await loadTinymce();
    els.forEach((el) => initEditor(el, tinymce));
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAll);
} else {
    initAll();
}

window.initRichEditors = initAll;
