<?= $this->extend('layout/main_website') ?>

<?= $this->section('content') ?>
<section class="product-single container">
    <?php
    /** @var array $product */
    /** @var array $images */
    /** @var array $variants */
    /** @var array $attributes */
    ?>
    <div class="row">
        <!-- GALERIA -->
        <div class="col-lg-7">
            <div class="product-single__media vertical-thumbnail product-media-initialized">
                <div class="product-single__thumbnail">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php foreach ($images as $img): ?>
                                <div class="swiper-slide product-single__image-item">
                                    <img
                                            src="<?= !empty($img['path'])
                                                    ? base_url('uploads/product_images/' . esc($img['path']))
                                                    : 'https://placehold.co/104x104'; ?>"
                                            width="104"
                                            height="104"
                                            onerror="this.onerror=null;this.src='https://placehold.co/104x104';"
                                    >
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="product-single__image">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php foreach ($images as $img): ?>
                                <div class="swiper-slide product-single__image-item">
                                    <img
                                        loading="lazy"
                                        class="h-auto"
                                        src="<?= !empty($img['path'])
                                            ? base_url('uploads/product_images/' . esc($img['path']))
                                            : 'https://placehold.co/674x674'; ?>"
                                        width="674"
                                        height="674"
                                        alt="<?= esc($product['name']) ?>"
                                        onerror="this.onerror=null;this.src='https://placehold.co/674x674';"
                                    >
                                    <a data-fancybox="gallery"
                                       href="<?= !empty($img['path'])
                                           ? base_url('uploads/product_images/' . esc($img['path']))
                                           : 'https://placehold.co/674x674'; ?>">
                                        <svg width="16" height="16">
                                            <use href="#icon_zoom"/>
                                        </svg>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php if (!empty($product['special_price'])): ?>
                    <div class="product-label sale-label">
                        <span>EM DESCONTO</span>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <!-- INFO -->
        <div class="col-lg-5">
            <h1 class="product-single__name">
                <?= esc($product['name']) ?>
            </h1>
            <div class="product-single__price">
                <?php if (!empty($product['special_price'])): ?>
                    <span class="old-price">
                        €<?= number_format($product['base_price'], 2, ',', '.') ?>
                    </span>
                                <span class="special-price">
                        €<?= number_format($product['special_price'], 2, ',', '.') ?>
                    </span>
                            <?php else: ?>
                                <span class="current-price">
                        €<?= number_format($product['base_price'], 2, ',', '.') ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="product-single__short-desc">
                <?= esc($product['short_description']) ?>
                <?= esc($product['description']) ?>
            </div>
            <?php
            $grouped = [];
            foreach ($attributes as $variantId => $attrs) {
                foreach ($attrs as $code => $values) {
                    $grouped[$code] = array_unique(
                        array_merge($grouped[$code] ?? [], $values)
                    );
                }
            }
            ?>
            <!-- FORM ÚNICO -->
            <form name="addtocart-form" method="post">
                <!-- VARIANTES -->
                <div class="product-single__swatches">
                    <?php foreach ($attributesMeta as $attr): ?>
                    <?php
                    $code = $attr['code'];
                    if (empty($grouped[$code])) continue;

                    $isColor = ($attr['type'] === 'color');
                    $i = 1;
                    ?>

                    <div class="product-swatch <?= $isColor ? 'color-swatches' : 'text-swatches' ?>">
                        <label><?= esc($attr['name']) ?></label>

                        <div class="swatch-list">
                            <?php foreach ($grouped[$code] as $v): ?>

                                <input
                                    type="radio"
                                    name="<?= esc($code) ?>"
                                    id="swatch-<?= esc($code) ?>-<?= $i ?>"
                                    <?= $i === 1 ? 'checked' : '' ?>
                                >

                                <?php if ($isColor): ?>
                                    <label
                                        class="swatch swatch-color js-swatch"
                                        for="swatch-<?= esc($code) ?>-<?= $i ?>"
                                        aria-label="<?= esc($v) ?>"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="<?= esc($v) ?>"
                                        style="color: <?= esc($v) ?>"
                                    ></label>
                                <?php else: ?>
                                    <label
                                        class="swatch js-swatch"
                                        for="swatch-<?= esc($code) ?>-<?= $i ?>"
                                        aria-label="<?= esc($v) ?>"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="<?= esc($v) ?>"
                                    >
                                        <?= esc($v) ?>
                                    </label>
                                <?php endif; ?>

                                <?php $i++; endforeach; ?>
                        </div>
                    </div>

                <?php endforeach; ?>
                </div>
                <!-- QTD + ADD TO CART -->
                <div class="product-single__addtocart">
                    <div class="qty-control position-relative qty-initialized">
                        <input
                            type="number"
                            name="quantity"
                            value="1"
                            min="1"
                            class="qty-control__number text-center"
                        >
                        <div class="qty-control__reduce">-</div>
                        <div class="qty-control__increase">+</div>
                    </div>
                    <button
                        type="submit"
                        class="btn btn-primary btn-addtocart js-open-aside"
                        data-aside="cartDrawer"
                    >
                       Comprar
                    </button>
                </div>
            </form>
            <!-- META -->
            <div class="product-single__meta-info mt-4">
                <div><strong>SKU:</strong> <?= esc($product['sku'] ?? 'N/A') ?></div>
<!--                <div><strong>Estado:</strong> --><?php //= esc($product['status']) ?><!--</div>-->
            </div>
            <div class="product-single__addtolinks">
                <a href="#" class="menu-link menu-link_us-s add-to-wishlist"><svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_heart" /></svg><span>Adicionar Favoritos</span></a>
                <share-button class="share-button">
                    <button class="menu-link menu-link_us-s to-share border-0 bg-transparent d-flex align-items-center">
                        <svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_sharing" /></svg>
                        <span>Partilhar</span>
                    </button>
                    <details id="Details-share-template__main" class="m-1 xl:m-1.5" hidden="">
                        <summary class="btn-solid m-1 xl:m-1.5 pt-3.5 pb-3 px-5">+</summary>
                        <div id="Article-share-template__main" class="share-button__fallback flex items-center absolute top-full left-0 w-full px-2 py-4 bg-container shadow-theme border-t z-10">
                            <div class="field grow mr-4">
                                <label class="field__label sr-only" for="url">Link</label>
                                <input type="text" class="field__input w-full" id="url" value="https://uomo-crystal.myshopify.com/blogs/news/go-to-wellness-tips-for-mental-health" placeholder="Link" onclick="this.select();" readonly="">
                            </div>
                            <button class="share-button__copy no-js-hidden">
                                <svg class="icon icon-clipboard inline-block mr-1" width="11" height="13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" viewBox="0 0 11 13">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2 1a1 1 0 011-1h7a1 1 0 011 1v9a1 1 0 01-1 1V1H2zM1 2a1 1 0 00-1 1v9a1 1 0 001 1h7a1 1 0 001-1V3a1 1 0 00-1-1H1zm0 10V3h7v9H1z" fill="currentColor"></path>
                                </svg>
                                <span class="sr-only">Copy link</span>
                            </button>
                        </div>
                    </details>
                </share-button>
            </div>
        </div>
    </div>
    <div class="product-single__details-tab">
        <ul class="nav nav-tabs" id="myTab1" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab" href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">Descrição</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore" id="tab-additional-info-tab" data-bs-toggle="tab" href="#tab-additional-info" role="tab" aria-controls="tab-additional-info" aria-selected="false">Informação Adicional</a>
            </li>
<!--            <li class="nav-item" role="presentation">-->
<!--                <a class="nav-link nav-link_underscore" id="tab-reviews-tab" data-bs-toggle="tab" href="#tab-reviews" role="tab" aria-controls="tab-reviews" aria-selected="false">Analises ()</a>-->
<!--            </li>-->
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-description" role="tabpanel" aria-labelledby="tab-description-tab">
                <div class="product-single__description">

                    <?php if (!empty($product['short_description'])): ?>
                        <h3 class="block-title mb-4">
                            <?= esc($product['short_description']) ?>
                        </h3>
                    <?php endif; ?>

                    <?php if (!empty($product['description'])): ?>
                        <p class="content">
                            <?= $product['description'] ?>
                        </p>
                    <?php endif; ?>

                </div>
            </div>
            <div class="tab-pane fade" id="tab-additional-info" role="tabpanel" aria-labelledby="tab-additional-info-tab">
                <div class="product-single__addtional-info">

                    <?php if (!empty($product['weight'])): ?>
                        <div class="item">
                            <label class="h6">Peso</label>
                            <span><?= esc($product['weight']) ?> kg</span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product['width']) || !empty($product['height']) || !empty($product['length'])): ?>
                        <div class="item">
                            <label class="h6">Dimenções</label>
                            <span>
                    <?= esc($product['width'] ?? '-') ?>
                    x <?= esc($product['height'] ?? '-') ?>
                    x <?= esc($product['length'] ?? '-') ?> cm
                </span>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!--            <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-tab">-->
<!--                <h2 class="product-single__reviews-title">Reviews</h2>-->
<!--                <div class="product-single__reviews-list">-->
<!--                    <div class="product-single__reviews-item">-->
<!--                        <div class="customer-avatar">-->
<!--                            <img loading="lazy" src="../images/avatar.jpg" alt="">-->
<!--                        </div>-->
<!--                        <div class="customer-review">-->
<!--                            <div class="customer-name">-->
<!--                                <h6>Janice Miller</h6>-->
<!--                                <div class="reviews-group d-flex">-->
<!--                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>-->
<!--                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>-->
<!--                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>-->
<!--                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>-->
<!--                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="review-date">April 06, 2023</div>-->
<!--                            <div class="review-text">-->
<!--                                <p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est…</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="product-single__reviews-item">-->
<!--                        <div class="customer-avatar">-->
<!--                            <img loading="lazy" src="../images/avatar.jpg" alt="">-->
<!--                        </div>-->
<!--                        <div class="customer-review">-->
<!--                            <div class="customer-name">-->
<!--                                <h6>Benjam Porter</h6>-->
<!--                                <div class="reviews-group d-flex">-->
<!--                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>-->
<!--                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>-->
<!--                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>-->
<!--                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>-->
<!--                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="review-date">April 06, 2023</div>-->
<!--                            <div class="review-text">-->
<!--                                <p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est…</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="product-single__review-form">-->
<!--                    <form name="customer-review-form">-->
<!--                        <h5>Be the first to review “Message Cotton T-Shirt”</h5>-->
<!--                        <p>Your email address will not be published. Required fields are marked *</p>-->
<!--                        <div class="select-star-rating">-->
<!--                            <label>Your rating *</label>-->
<!--                            <span class="star-rating">-->
<!--                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">-->
<!--                      <path d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z"/>-->
<!--                    </svg>-->
<!--                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">-->
<!--                      <path d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z"/>-->
<!--                    </svg>-->
<!--                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">-->
<!--                      <path d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z"/>-->
<!--                    </svg>-->
<!--                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">-->
<!--                      <path d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z"/>-->
<!--                    </svg>-->
<!--                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">-->
<!--                      <path d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z"/>-->
<!--                    </svg>-->
<!--                  </span>-->
<!--                            <input type="hidden" id="form-input-rating" value="">-->
<!--                        </div>-->
<!--                        <div class="mb-4">-->
<!--                            <textarea id="form-input-review" class="form-control form-control_gray" placeholder="Your Review" cols="30" rows="8"></textarea>-->
<!--                        </div>-->
<!--                        <div class="form-label-fixed mb-4">-->
<!--                            <label for="form-input-name" class="form-label">Name *</label>-->
<!--                            <input id="form-input-name" class="form-control form-control-md form-control_gray">-->
<!--                        </div>-->
<!--                        <div class="form-label-fixed mb-4">-->
<!--                            <label for="form-input-email" class="form-label">Email address *</label>-->
<!--                            <input id="form-input-email" class="form-control form-control-md form-control_gray">-->
<!--                        </div>-->
<!--                        <div class="form-check mb-4">-->
<!--                            <input class="form-check-input form-check-input_fill" type="checkbox" value="" id="remember_checkbox">-->
<!--                            <label class="form-check-label" for="remember_checkbox">-->
<!--                                Save my name, email, and website in this browser for the next time I comment.-->
<!--                            </label>-->
<!--                        </div>-->
<!--                        <div class="form-action">-->
<!--                            <button type="submit" class="btn btn-primary">Submit</button>-->
<!--                        </div>-->
<!--                    </form>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</section>
<section class="products-carousel container">
    <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">
        Related <strong>Products</strong>
    </h2>

    <div id="related_products" class="position-relative">
        <div class="swiper-container js-swiper-slider"
             data-settings='{
                "autoplay": false,
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "effect": "none",
                "loop": true,
                "pagination": {
                  "el": "#related_products .products-pagination",
                  "type": "bullets",
                  "clickable": true
                },
                "navigation": {
                  "nextEl": "#related_products .products-carousel__next",
                  "prevEl": "#related_products .products-carousel__prev"
                },
                "breakpoints": {
                  "320": { "slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 14 },
                  "768": { "slidesPerView": 3, "slidesPerGroup": 3, "spaceBetween": 24 },
                  "992": { "slidesPerView": 4, "slidesPerGroup": 4, "spaceBetween": 30 }
                }
             }'>

            <div class="swiper-wrapper">

                <?php foreach ($relatedProducts as $p): ?>
                    <div class="swiper-slide product-card">
                        <div class="pc__img-wrapper">
                            <a href="<?= base_url('product/'.$p['slug']) ?>">
                                <img loading="lazy"
                                     src="<?= !empty($p['images'][0]['path'])
                                         ? base_url('uploads/product_images/'.$p['images'][0]['path'])
                                         : 'https://placehold.co/330x400' ?>"
                                     onerror="this.onerror=null;this.src='https://placehold.co/330x400';"
                                     width="330" height="400"
                                     class="pc__img">

                                <img loading="lazy"
                                     src="<?= !empty($p['images'][1]['path'])
                                         ? base_url('uploads/product_images/'.$p['images'][1]['path'])
                                         : (!empty($p['images'][0]['path'])
                                             ? base_url('uploads/product_images/'.$p['images'][0]['path'])
                                             : 'https://placehold.co/330x400') ?>"
                                     onerror="this.onerror=null;this.src='https://placehold.co/330x400';"
                                     width="330" height="400"
                                     class="pc__img pc__img-second">
                            </a>

                            <button class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium">
                                Add To Cart
                            </button>
                        </div>

                        <div class="pc__info position-relative">
                            <h6 class="pc__title">
                                <a href="<?= base_url('product/'.$p['slug']) ?>">
                                    <?= esc($p['name']) ?>
                                </a>
                            </h6>

                            <div class="product-card__price d-flex">
                                <?php if (!empty($p['special_price'])): ?>
                                    <span class="money price price-old"><?= esc($p['base_price_tax']) ?> €</span>
                                    <span class="money price price-sale"><?= esc($p['special_price']) ?> €</span>
                                <?php else: ?>
                                    <span class="money price"><?= esc($p['base_price_tax']) ?> €</span>
                                <?php endif; ?>
                            </div>

                            <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0">
                                <svg width="16" height="16">
                                    <use href="#icon_heart"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <div class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
            <svg width="25" height="25"><use href="#icon_prev_md"/></svg>
        </div>

        <div class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
            <svg width="25" height="25"><use href="#icon_next_md"/></svg>
        </div>

        <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
    </div>
</section>

<?= $this->endSection() ?>
