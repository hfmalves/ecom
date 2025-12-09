<?php
$categories = $data ?? [];
$title = $title ?? 'Shop by Departments';
?>
<section class="flat-spacing flat-animate-tab pt-0">
    <div class="container">

        <div class="sect-title wow fadeInUp">
            <h1 class="title text-center mb-24"><?= esc($title) ?></h1>

            <ul class="tab-product_list" role="tablist">
                <?php foreach ($categories as $idx => $cat): ?>
                    <li class="nav-tab-item" role="presentation">
                        <a href="#tab-<?= $cat['id'] ?>"
                           data-bs-toggle="tab"
                           class="tf-btn-line tf-btn-tab <?= $idx === 0 ? 'active' : '' ?>">
                            <?= esc($cat['name']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="tab-content">

            <?php foreach ($categories as $idx => $cat): ?>
                <div class="tab-pane <?= $idx === 0 ? 'active show' : '' ?>"
                     id="tab-<?= $cat['id'] ?>"
                     role="tabpanel">

                    <div dir="ltr"
                         class="swiper tf-swiper wow fadeInUp"
                         data-preview="4"
                         data-tablet="3"
                         data-mobile-sm="2"
                         data-mobile="2"
                         data-space-lg="48"
                         data-space-md="30"
                         data-space="12"
                         data-pagination="2">

                        <div class="swiper-wrapper">

                            <?php foreach ($cat['products'] as $product): ?>

                                <?php
                                $img = $product['image']
                                        ?? 'https://placehold.co/600x600?text=Produto';

                                // fallback em JS se imagem falhar
                                $imgOnError = "this.onerror=null;this.src='https://placehold.co/600x600?text=Produto';";
                                ?>

                                <div class="swiper-slide">
                                    <div class="card-product">

                                        <div class="card-product_wrapper d-flex">
                                            <a href="<?= base_url('product/' . $product['id']) ?>"
                                               class="product-img">

                                                <img class="lazyload img-product"
                                                     src="<?= $img ?>"
                                                     data-src="<?= $img ?>"
                                                     alt="<?= esc($product['name']) ?>"
                                                     onerror="<?= $imgOnError ?>">

                                                <img class="lazyload img-hover"
                                                     src="<?= $img ?>"
                                                     data-src="<?= $img ?>"
                                                     alt="<?= esc($product['name']) ?>"
                                                     onerror="<?= $imgOnError ?>">
                                            </a>

                                            <ul class="product-action_list">
                                                <li>
                                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
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
                                                <li class="compare">
                                                    <a href="#compare" data-bs-toggle="offcanvas"
                                                       class="hover-tooltip tooltip-left box-icon ">
                                                        <span class="icon icon-compare"></span>
                                                        <span class="tooltip">Compare</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#quickView" data-bs-toggle="modal"
                                                       class="hover-tooltip tooltip-left box-icon">
                                                        <span class="icon icon-view"></span>
                                                        <span class="tooltip">Quick view</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-product_info">
                                            <a href="<?= base_url('product/' . $product['id']) ?>"
                                               class="name-product h4 link">
                                                <?= esc($product['name']) ?>
                                            </a>

                                            <div class="price-wrap mb-0">
                                                <span class="price-old h6 fw-normal">
                                                    <?= esc($product['old_price'] ?? '') ?>
                                                </span>
                                                <span class="price-new h6">
                                                    <?= esc($product['base_price_tax'] ?? '0') ?>€
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="sw-dot-default tf-sw-pagination"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
