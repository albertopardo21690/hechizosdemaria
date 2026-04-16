import Sortable from 'sortablejs';

document.addEventListener('alpine:init', () => {
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
