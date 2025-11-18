<section class="flat-spacing pt-10 tf-lookbook-hover">
    <div class="container">
        <div class="row align-items-center d-flex flex-wrap-reverse">

            <!-- LEFT = BANNER -->
            <div class="col-lg-6">
                <div class="banner-lookbook wrap-lookbook_hover">

                    <img class="lazyload img-banner"
                         src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                         data-src="https://placehold.co/1200x800?text=Banner"
                         alt="<?= esc($block['title']) ?>">

                    <?php foreach ($block['pins'] as $i => $pin): ?>
                        <div class="lookbook-item position<?= $i+7 ?>">
                            <div class="dropdown dropup-center dropdown-custom <?= $i === 0 ? 'dropstart' : '' ?>">

                                <div role="dialog"
                                     class="tf-pin-btn bundle-pin-item swiper-button"
                                     data-slide="<?= $pin['slide'] ?>"
                                     id="pin<?= $i ?>-left"
                                     data-bs-toggle="dropdown"
                                     aria-expanded="false">
                                    <span></span>
                                </div>

                                <div class="dropdown-menu p-0 d-lg-none">
                                    <div class="lookbook-product style-row">

                                        <div class="content">
                                            <span class="tag"><?= esc($block['title']) ?></span>
                                            <?php $product = $block['products'][$i] ?? null; ?>

                                            <?php if ($product): ?>
                                                <h6 class="name-prd">
                                                    <a href="<?= base_url('product/'.$product['id']) ?>" class="link">
                                                        <?= esc($product['name']) ?>
                                                    </a>
                                                </h6>

                                                <div class="price-wrap">
                                                    <span class="price-new h6">
                                                        <?= esc($product['base_price_tax']) ?>€
                                                    </span>
                                                    <span class="text-third h6">In Stock</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($product): ?>
                                            <a href="<?= base_url('product/'.$product['id']) ?>" class="image">
                                                <img class="lazyload"
                                                     src="https://placehold.co/300x300?text=Imagem"
                                                     data-src="https://placehold.co/300x300?text=Imagem"
                                                     alt="<?= esc($product['name'] ?? 'Produto') ?>">
                                            </a>
                                        <?php endif; ?>

                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- RIGHT = PRODUCTS -->
            <div class="col-lg-6">
                <div class="flat-spacing p-lg-0 pb-0">

                    <div class="sect-title wow fadeInUp">
                        <h1 class="s-title mb-8"><?= esc($block['title']) ?></h1>
                        <p class="s-subtitle h6"><?= esc($block['subtitle']) ?></p>
                    </div>

                    <div dir="ltr"
                         class="swiper tf-sw-lookbook tf-sw-lookbook bundle-hover-wrap"
                         data-preview="2" data-tablet="2" data-mobile="2"
                         data-space-lg="48" data-space-md="24" data-space="16"
                         data-pagination="1" data-pagination-md="1" data-pagination-lg="1">

                        <div class="swiper-wrapper">

                            <?php foreach ($block['products'] as $i => $product): ?>
                                <div class="swiper-slide">
                                    <div class="wow fadeInUp">
                                        <div class="card-product bundle-hover-item pin<?= $i+1 ?>">

                                            <div class="card-product_wrapper d-flex">
                                                <a href="<?= base_url('product/'.$product['id']) ?>" class="product-img">

                                                    <img class="lazyload img-product"
                                                         src="https://placehold.co/600x600?text=Produto"
                                                         data-src="https://placehold.co/600x600?text=Produto"
                                                         alt="<?= esc($product['name'] ?? 'Produto') ?>">

                                                    <img class="lazyload img-hover"
                                                         src="https://placehold.co/600x600?text=Produto"
                                                         data-src="https://placehold.co/600x600?text=Produto"
                                                         alt="<?= esc($product['name'] ?? 'Produto') ?>">

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
                                                </ul>
                                            </div>

                                            <div class="card-product_info">
                                                <a href="<?= base_url('product/'.$product['id']) ?>"
                                                   class="name-product h4 link">
                                                    <?= esc($product['name']) ?>
                                                </a>

                                                <div class="price-wrap mb-0">
                                                    <span class="price-old h6 fw-normal">
                                                        <?= esc($product['old_price'] ?? '') ?>
                                                    </span>

                                                    <span class="price-new h6">
                                                        <?= esc($product['base_price_tax']) ?>€
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
