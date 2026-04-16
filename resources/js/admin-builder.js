import Sortable from 'sortablejs';

const CLIPBOARD_KEY = 'hdm-page-builder-clipboard';

window.pageBuilderClipboard = {
    set(kind, payload) {
        try {
            localStorage.setItem(CLIPBOARD_KEY, JSON.stringify({ kind, payload, at: Date.now() }));
        } catch (e) {
            console.error('Clipboard set failed', e);
        }
    },
    get() {
        try {
            const raw = localStorage.getItem(CLIPBOARD_KEY);
            return raw ? JSON.parse(raw) : null;
        } catch (e) {
            return null;
        }
    },
    clear() {
        localStorage.removeItem(CLIPBOARD_KEY);
    },
};

document.addEventListener('alpine:init', () => {
    window.Alpine.store('clipboard', {
        kind: null,
        label: null,
        init() {
            this.refresh();
            window.addEventListener('storage', () => this.refresh());
        },
        refresh() {
            const c = window.pageBuilderClipboard.get();
            this.kind = c ? c.kind : null;
            this.label = c ? (c.kind === 'section' ? 'Sección copiada' : 'Widget copiado') : null;
        },
        copySection(section) {
            window.pageBuilderClipboard.set('section', section);
            this.refresh();
        },
        copyWidget(widget) {
            window.pageBuilderClipboard.set('widget', widget);
            this.refresh();
        },
        pasteSection(wire) {
            const c = window.pageBuilderClipboard.get();
            if (!c || c.kind !== 'section') return;
            wire.dispatch('clipboard-paste-section', { payload: c.payload });
        },
        pasteWidget(wire, sectionId, columnId) {
            const c = window.pageBuilderClipboard.get();
            if (!c || c.kind !== 'widget') return;
            wire.dispatch('clipboard-paste-widget', { sectionId, columnId, payload: c.payload });
        },
    });

    window.Alpine.data('sortableSections', () => ({
        instance: null,
        init() {
            this.instance = Sortable.create(this.$el, {
                animation: 180,
                handle: '.section-drag-handle',
                ghostClass: 'opacity-40',
                chosenClass: 'ring-2',
                dragClass: 'cursor-grabbing',
                onEnd: () => {
                    const ids = Array.from(this.$el.children)
                        .map((el) => el.dataset.sectionId)
                        .filter(Boolean);
                    this.$wire.reorderSections(ids);
                },
            });
        },
    }));

    window.Alpine.data('sortableWidgets', ({ sectionId }) => ({
        instance: null,
        init() {
            this.instance = Sortable.create(this.$el, {
                animation: 180,
                group: `widgets-${sectionId}`,
                handle: '.widget-drag-handle',
                ghostClass: 'opacity-40',
                chosenClass: 'ring-2',
                draggable: '[data-widget-id]',
                onEnd: (evt) => {
                    const widgetId = evt.item?.dataset?.widgetId;
                    const toColumnId = evt.to?.dataset?.columnId;
                    const toSectionId = evt.to?.dataset?.sectionId;
                    const toIndex = evt.newIndex;
                    if (!widgetId || !toColumnId || !toSectionId) return;
                    this.$wire.moveWidget(widgetId, toSectionId, toColumnId, toIndex);
                },
            });
        },
    }));
});
