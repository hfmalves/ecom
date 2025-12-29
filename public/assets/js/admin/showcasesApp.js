document.addEventListener('alpine:init', () => {
    Alpine.data('showcasesApp', () => ({
        draggedEl: null,

        dragStart(e) {
            this.draggedEl = e.target;
        },

        drop(e) {
            const container = e.target.closest('[data-block-id]');
            if (!container || !this.draggedEl) return;

            if (e.target.tagName === 'IMG') {
                container.insertBefore(this.draggedEl, e.target);
            } else {
                container.appendChild(this.draggedEl);
            }

            this.draggedEl = null;
        }
    }));
});
