document.addEventListener('alpine:init', () => {
    Alpine.data('newsletterPopup', () => ({

        submit() {
            const email = this.$refs.email?.value;
            if (!email) return;

            fetch('/newsletter/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ email })
            }).then(() => {
                this.markSeen();
            });
        },

        close() {
            this.markSeen();
        },

        markSeen() {
            fetch('/newsletter/seen', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        }

    }));
});
