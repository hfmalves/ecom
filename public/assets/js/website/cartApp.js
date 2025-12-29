// ===============================
// ALPINE — PRODUTO
// ===============================
document.addEventListener('alpine:init', () => {
    Alpine.data('cartApp', () => ({
        selected: {},
        currentVariant: null,
        oldPrice: null,
        curPrice: null,

        init() {
            this.oldPrice = document.querySelector('.product-single__price .old-price');
            this.curPrice = document.querySelector('.product-single__price .current-price');

            const root = this.$el.closest('[data-product-id]');
            if (!root) return;

            if (root.dataset.productType === 'simple') {
                const source = document.querySelector('[data-price-base]');
                if (source) {
                    this.setPrice(
                        parseFloat(source.dataset.priceBase || 0),
                        parseFloat(source.dataset.priceSpecial || 0)
                    );
                }
                return;
            }

            this.bindConfigurable();
        },

        async addToCart(qty = 1) {
            const root = this.$el.closest('[data-product-id]');
            if (!root) return;

            const payload = {
                quantity: parseInt(qty, 10)
            };

            if (root.dataset.productType === 'configurable') {
                if (!this.currentVariant) return;
                payload.variant_id = this.currentVariant;
            } else {
                payload.product_id = root.dataset.productId;
            }

            const res = await fetch('/cart/add', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            });

            const json = await res.json();
            if (!json.success) return;

            await refreshDrawer();
            openDrawer();
        },

        setPrice(base, special = 0) {
            if (!this.curPrice) return;

            if (special > 0) {
                if (this.oldPrice) {
                    this.oldPrice.textContent = `€${base.toFixed(2)}`;
                    this.oldPrice.classList.remove('d-none');
                }
                this.curPrice.textContent = `€${special.toFixed(2)}`;
            } else {
                if (this.oldPrice) this.oldPrice.classList.add('d-none');
                this.curPrice.textContent = `€${base.toFixed(2)}`;
            }
        },

        bindConfigurable() {
            this.selected = {};

            document.querySelectorAll('.js-swatch').forEach(label => {
                label.addEventListener('click', () => {
                    this.selected[label.dataset.attr] = label.dataset.value;
                    this.resolveVariant();
                });
            });

            this.resolveVariant();
        },

        resolveVariant() {
            const variants = document.querySelectorAll('#variants-map .variant');
            let found = null;

            for (const v of variants) {
                const match = Object.keys(this.selected)
                    .every(k => v.dataset[k] === this.selected[k]);

                if (match) {
                    found = v;
                    break;
                }
            }

            // ❌ NENHUMA VARIANTE VÁLIDA
            if (!found) {
                this.currentVariant = null;
                this.curPrice.textContent = 'Preço indisponível';
                this.oldPrice.classList.add('d-none');
                this.disableAddToCart();
                return;
            }

            const base = parseFloat(found.dataset.base || 0);
            const special = parseFloat(found.dataset.special || 0);

            // ❌ VARIANTE SEM PREÇO
            if (base <= 0 && special <= 0) {
                this.currentVariant = null;
                this.curPrice.textContent = 'Preço indisponível';
                this.oldPrice.classList.add('d-none');
                this.disableAddToCart();
                return;
            }

            // ✅ VARIANTE OK
            this.currentVariant = found.dataset.id;
            this.setPrice(base, special);
            this.enableAddToCart();
        },
        disableAddToCart() {
            document.querySelector('.btn-addtocart')?.setAttribute('disabled', true);
        },

        enableAddToCart() {
            document.querySelector('.btn-addtocart')?.removeAttribute('disabled');
        }

    }));
});

// ===============================
// DRAWER — FUNÇÕES GLOBAIS
// ===============================
async function refreshDrawer() {
    const res = await fetch('/cart/drawer', {
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });

    const html = await res.text();
    const target = document.getElementById('cartDrawerContent');
    if (target) target.innerHTML = html;
}

function openDrawer() {
    document.getElementById('cartDrawer')?.classList.add('is-open');
}
// ===============================
// CART ACTIONS
// ===============================
async function updateCartQty(input) {
    const payload = {
        product_id: input.dataset.product,
        quantity: parseInt(input.value, 10)
    };
    if (input.dataset.variant !== undefined) {
        payload.variant_id = input.dataset.variant;
    }
    await fetch('/cart/update', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(payload)
    });
    await refreshDrawer();
}
async function removeCartItem(btn) {
    const payload = {
        product_id: btn.dataset.product
    };
    if (btn.dataset.variant && btn.dataset.variant !== '') {
        payload.variant_id = btn.dataset.variant;
    }
    await fetch('/cart/remove', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(payload)
    });
    await refreshDrawer();
}
document.addEventListener('click', async (e) => {

    /* =========================
       PRODUTO — NUNCA UPDATE
    ========================= */
    if (e.target.closest('.product-single__addtocart')) {
        const input = e.target.closest('.qty-control')?.querySelector('input');
        if (!input) return;

        if (e.target.classList.contains('qty-control__increase')) {
            input.value = parseInt(input.value, 10) + 1;
            return;
        }

        if (e.target.classList.contains('qty-control__reduce')) {
            const min = parseInt(input.getAttribute('min'), 10) || 1;
            input.value = Math.max(min, parseInt(input.value, 10) - 1);
            return;
        }
    }

    /* =========================
       CARRINHO — UPDATE
    ========================= */
    if (e.target.closest('#cartDrawer')) {

        // QTY
        if (
            e.target.classList.contains('qty-control__increase') ||
            e.target.classList.contains('qty-control__reduce')
        ) {
            const input = e.target.closest('.qty-control')?.querySelector('input');
            if (!input) return;

            if (e.target.classList.contains('qty-control__increase')) {
                input.value = parseInt(input.value, 10) + 1;
            } else {
                const min = parseInt(input.getAttribute('min'), 10) || 1;
                input.value = Math.max(min, parseInt(input.value, 10) - 1);
            }

            await updateCartQty(input);
            return;
        }

        // REMOVE
        const removeBtn = e.target.closest('.js-cart-item-remove');
        if (removeBtn) {
            await removeCartItem(removeBtn);
            return;
        }
    }
});
