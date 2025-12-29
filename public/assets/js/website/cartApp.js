document.addEventListener('alpine:init', () => {
    Alpine.data('cartApp', () => ({
        selected: {},
        currentVariant: null,
        oldPrice: null,
        curPrice: null,

        init() {
            this.oldPrice = document.querySelector('.product-single__price .old-price');
            this.curPrice = document.querySelector('.product-single__price .current-price');

            this.bindQtyControls();

            const root = this.$el.closest('[data-product-id]');
            const type = root?.dataset.productType;

            if (type === 'simple') {
                const source = document.querySelector('.product-single__price [data-price-base]');
                if (source) {
                    const base = parseFloat(source.dataset.priceBase || 0);
                    const special = parseFloat(source.dataset.priceSpecial || 0);
                    this.setPrice(base, special);
                }
                this.enableAddToCart();
                return;
            }

            this.curPrice.textContent = '';
            this.oldPrice.classList.add('d-none');
            this.bindConfigurable();
        },
        bindQtyControls() {
            const input = document.querySelector('.qty-control__number');
            if (!input) return;

            const min = parseInt(input.getAttribute('min')) || 1;

            document.querySelector('.qty-control__increase')?.addEventListener('click', () => {
                input.value = parseInt(input.value || min) + 1;
            });

            document.querySelector('.qty-control__reduce')?.addEventListener('click', () => {
                const next = parseInt(input.value || min) - 1;
                input.value = next < min ? min : next;
            });
        },

        async addToCart(qty = 1) {
            const root = this.$el.closest('[data-product-id]');
            const type = root?.dataset.productType;
            const productId = root?.dataset.productId;

            const payload = { quantity: qty };

            if (type === 'configurable') {
                if (!this.currentVariant) return;
                payload.variant_id = this.currentVariant;
            } else {
                if (!productId) {
                    console.error('product_id em falta');
                    return;
                }
                payload.product_id = productId;
            }

            const res = await fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            });

            const json = await res.json();
            if (!json.success) return;

            this.updateDrawer(json.cart);
            this.openDrawer();
        },

        setPrice(base, special = 0) {
            if (special && special > 0) {
                this.oldPrice.textContent = `€${base.toFixed(2)}`;
                this.oldPrice.classList.remove('d-none');
                this.curPrice.textContent = `€${special.toFixed(2)}`;
            } else {
                this.oldPrice.classList.add('d-none');
                this.curPrice.textContent = `€${base.toFixed(2)}`;
            }
        },

        bindConfigurable() {
            this.selected = {};

            document.querySelectorAll('.js-swatch').forEach(label => {
                const input = document.getElementById(label.getAttribute('for'));
                if (input.checked) {
                    this.selected[label.dataset.attr] = label.dataset.value;
                }

                label.addEventListener('click', () => {
                    this.selected[label.dataset.attr] = label.dataset.value;
                    this.resolveVariant();
                });
            });

            this.resolveVariant();
        },

        resolveVariant() {
            if (!document.querySelector('#variants-map')) return;

            const variants = document.querySelectorAll('#variants-map .variant');
            let found = null;

            for (const v of variants) {
                let match = true;

                for (const key in this.selected) {
                    if (v.dataset[key] !== this.selected[key]) {
                        match = false;
                        break;
                    }
                }

                if (match) {
                    found = v;
                    break;
                }
            }

            if (found) {
                this.setPrice(
                    parseFloat(found.dataset.base),
                    parseFloat(found.dataset.special || 0)
                );
                this.currentVariant = found.dataset.id;
                this.enableAddToCart();
            } else {
                this.curPrice.textContent = 'Não disponível';
                this.oldPrice.classList.add('d-none');
                this.currentVariant = null;
                this.disableAddToCart();
            }

            this.updateSwatchAvailability();
        },

        updateSwatchAvailability() {
            const variants = document.querySelectorAll('#variants-map .variant');

            document.querySelectorAll('.js-swatch').forEach(swatch => {
                const attr = swatch.dataset.attr;
                const value = swatch.dataset.value;
                let valid = false;

                for (const v of variants) {
                    let match = true;

                    for (const key in this.selected) {
                        if (key === attr) continue;
                        if (v.dataset[key] !== this.selected[key]) {
                            match = false;
                            break;
                        }
                    }

                    if (match && v.dataset[attr] === value) {
                        valid = true;
                        break;
                    }
                }

                swatch.classList.toggle('is-disabled', !valid);
            });
        },

        disableAddToCart() {
            document.querySelector('.btn-addtocart')?.setAttribute('disabled', true);
        },

        enableAddToCart() {
            document.querySelector('.btn-addtocart')?.removeAttribute('disabled');
        }
    }));
});
