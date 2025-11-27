<?php
// garantir que existe SEMPRE
$products = $data['products'] ?? [];
$pins     = $data['pins'] ?? [];
$banner   = $data['banner'] ?? 'https://placehold.co/1400x1400?text=Banner';
$title    = $title ?? '';
$subtitle = $subtitle ?? '';
?>

<section class="flat-spacing pt-10 tf-lookbook-hover">
    <div class="container">
        <div class="row align-items-center">

            <!-- LEFT = BANNER (RIGHT MODULE = banner fica à esquerda) -->
            <div class="col-lg-6">
                <div class="banner-lookbook wrap-lookbook_hover">

                    <img class="lazyload img-banner"
                         src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                         data-src="<?= esc($banner) ?>"
                         alt="<?= esc($title) ?>">

                    <?php foreach ($pins as $i => $pin): ?>
                        <div class="lookbook-item position<?= $i + 7 ?>">
                            <div class="dropdown dropup-center dropdown-custom <?= $i === 0 ? 'dropstart' : '' ?>">

                                <div role="dialog"
                                     class="tf-pin-btn bundle-pin-item swiper-button"
                                     style="top: <?= esc($pin['y'] ?? 0) ?>%; left: <?= esc($pin['x'] ?? 0) ?>%;">
                                    <span></span>
                                </div>

                                <ul class="dropdown-menu look-book dropdown-custome-animation">
                                    <li>
                                        <a href="<?= base_url('shop/product/' . ($pin['product_id'] ?? 0)) ?>"
                                           class="lookbook-content">
                                            <div class="image">
                                                <img class="lazyload"
                                                     src="<?= $pin['product_image'] ?? 'https://placehold.co/300x300' ?>"
                                                     data-src="<?= $pin['product_image'] ?? 'https://placehold.co/300x300' ?>"
                                                     alt="<?= esc($pin['product_name'] ?? '') ?>">
                                            </div>
                                            <div class="content">
                                                <h6 class="product-name"><?= esc($pin['product_name'] ?? '') ?></h6>
                                                <span class="price"><?= esc($pin['product_price'] ?? '') ?></span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- RIGHT = PRODUCTS -->
            <div class="col-lg-6">
                <div class="flat-spacing p-lg-0 pb-0">

                    <div class="sect-title wow fadeInUp">
                        <h1 class="s-title mb-8"><?= esc($title) ?></h1>
                        <p class="s-subtitle h6"><?= esc($subtitle) ?></p>
                    </div>

                    <div dir="ltr"
                         class="swiper tf-sw-lookbook bundle-hover-wrap"
                         data-preview="2" data-tablet="2" data-mobile="2"
                         data-space-lg="48" data-space-md="24" data-space="16"
                         data-pagination="1">

                        <div class="swiper-wrapper">

                            <?php foreach ($products as $i => $product): ?>
                                <div class="swiper-slide">
                                    <div class="wow fadeInUp">
                                        <div class="card-product bundle-hover-item pin<?= $i + 1 ?>">

                                            <div class="card-product_wrapper d-flex">
                                                <a href="<?= base_url('product/' . $product['id']) ?>"
                                                   class="product-img">

                                                    <?php
                                                    $img = $product['image']
                                                            ?? 'https://placehold.co/600x600?text=Produto';
                                                    ?>

                                                    <img class="lazyload img-product"
                                                         src="<?= $img ?>"
                                                         data-src="<?= $img ?>"
                                                         alt="<?= esc($product['name'] ?? 'Produto') ?>">

                                                    <img class="lazyload img-hover"
                                                         src="<?= $img ?>"
                                                         data-src="<?= $img ?>"
                                                         alt="<?= esc($product['name'] ?? 'Produto') ?>">
                                                </a>

                                                <ul class="product-action_list">
                                                    <li>
                                                        <a href="#shoppingCart"
                                                           data-bs-toggle="offcanvas"
                                                           class="hover-tooltip tooltip-left box-icon">
                                                            <span class="icon icon-shopping-cart-simple"></span>
                                                            <span class="tooltip">Add to cart</span>
                                                        </a>
                                                    </li>

                                                    <li class="wishlist">
                                                        <a href="javascript:void(0);"
                                                           class="hover-tooltip tooltip-left box-icon">
                                                            <span class="icon icon-heart"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="card-product_info">
                                                <a href="<?= base_url('product/' . $product['id']) ?>"
                                                   class="name-product h4 link">
                                                    <?= esc($product['name'] ?? 'Produto') ?>
                                                </a>

                                                <div class="price-wrap mb-0">
                                                    <span class="price-old h6 fw-normal">
                                                        <?= esc($product['old_price'] ?? '') ?>
                                                    </span>
                                                    <span class="price-new h6">
                                                        <?= esc($product['base_price_tax'] ?? '') ?>€
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>

                        <div class="sw-dot-default sw-pagination-lookbook"></div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
