<?= $this->extend('layout/main_website') ?>
<?= $this->section('content') ?>
<div class="mb-4 pb-4"></div>

<section class="shop-checkout container">
    <h2 class="page-title">Carrinho</h2>

    <div class="checkout-steps">
        <a href="<?= base_url('cart') ?>" class="checkout-steps__item active">
            <span class="checkout-steps__item-number">01</span>
            <span class="checkout-steps__item-title">
        <span>Saco de Compras</span>
        <em>Gerir os seus produtos</em>
      </span>
        </a>

        <a href="<?= base_url('checkout') ?>" class="checkout-steps__item">
            <span class="checkout-steps__item-number">02</span>
            <span class="checkout-steps__item-title">
        <span>Envio e Checkout</span>
        <em>Finalizar a encomenda</em>
      </span>
        </a>

        <a href="<?= base_url('order_complete') ?>" class="checkout-steps__item">
            <span class="checkout-steps__item-number">03</span>
            <span class="checkout-steps__item-title">
        <span>Confirmação</span>
        <em>Rever e submeter encomenda</em>
      </span>
        </a>
    </div>

    <div class="shopping-cart">
        <div class="cart-table__wrapper">
            <table class="cart-table">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th></th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                <!-- ITEM -->
                <tr>
                    <td>
                        <div class="shopping-cart__product-item">
                            <a href="<?= base_url('product/zessi-dresses') ?>">
                                <img loading="lazy" src="<?= base_url('images/cart-item-1.jpg') ?>" width="120" height="120" alt="">
                            </a>
                        </div>
                    </td>
                    <td>
                        <div class="shopping-cart__product-item__detail">
                            <h4><a href="<?= base_url('product/zessi-dresses') ?>">Zessi Dresses</a></h4>
                            <ul class="shopping-cart__product-item__options">
                                <li>Cor: Amarelo</li>
                                <li>Tamanho: L</li>
                            </ul>
                        </div>
                    </td>
                    <td><span class="shopping-cart__product-price">€99</span></td>
                    <td>
                        <div class="qty-control position-relative">
                            <input type="number" value="3" min="1" class="qty-control__number text-center">
                            <div class="qty-control__reduce">-</div>
                            <div class="qty-control__increase">+</div>
                        </div>
                    </td>
                    <td><span class="shopping-cart__subtotal">€297</span></td>
                    <td>
                        <a href="#" class="remove-cart">
                            ✕
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="cart-table-footer">
                <form class="position-relative bg-body">
                    <input class="form-control" type="text" placeholder="Código de desconto">
                    <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4"
                           type="submit" value="APLICAR">
                </form>

                <button class="btn btn-light">Atualizar Carrinho</button>
            </div>
        </div>

        <div class="shopping-cart__totals-wrapper">
            <div class="sticky-content">
                <div class="shopping-cart__totals">
                    <h3>Totais do Carrinho</h3>

                    <table class="cart-totals">
                        <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>€1300</td>
                        </tr>
                        <tr>
                            <th>Envio</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="free_shipping">
                                    <label for="free_shipping">Envio grátis</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flat_rate">
                                    <label for="flat_rate">Taxa fixa: €49</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="local_pickup">
                                    <label for="local_pickup">Levantamento local: €8</label>
                                </div>
                                <div>Envio para Portugal</div>
                                <a href="#" class="menu-link menu-link_us-s">ALTERAR MORADA</a>
                            </td>
                        </tr>
                        <tr>
                            <th>IVA</th>
                            <td>€19</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>€1319</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mobile_fixed-btn_wrapper">
                    <div class="button-wrapper container">
                        <a href="<?= base_url('checkout') ?>" class="btn btn-primary btn-checkout">
                            Avançar para Checkout
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
