<?php
$products = $block['products'] ?? [];
$title    = $block['blockConfig']['title'] ?? '';
?>
<div class="mb-2 mb-xl-5 pt-1 pb-2"></div>
<section class="products-carousel container">

    <?php if ($title): ?>
        <h2 class="section-title text-uppercase text-center mb-1 mb-md-3 pb-xl-2 mb-xl-4">
            <?= esc($title) ?>
        </h2>
    <?php endif; ?>

    <?php if (empty($products)): ?>
        <p class="text-muted text-center">Nenhum produto disponível.</p>
        <?php return; ?>
    <?php endif; ?>

    <div id="home-deals-day" class="position-relative">
        <div class="swiper-container js-swiper-slider"
             data-settings='{
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "loop": false,
                "breakpoints": {
                  "320": { "slidesPerView": 2 },
                  "768": { "slidesPerView": 3 },
                  "992": { "slidesPerView": 4 }
                }
             }'>

            <div class="swiper-wrapper">

                <?php foreach ($products as $product): ?>
                    <?php $variationId = $product['variation']['id'] ?? null; ?>
                    <div class="swiper-slide product-card">

                        <div class="pc__img-wrapper">
                            <a href="<?= base_url('product/' . $product['slug']) ?>">

                                <?php if (!empty($product['images'])): ?>
                                    <img
                                            loading="lazy"
                                            src="<?= base_url('uploads/' . esc($product['images'][0]['path'])) ?>"
                                            onerror="this.src='https://placehold.co/330x400';"
                                            width="330"
                                            height="400"
                                            class="pc__img mb-2"
                                    >
                                <?php else: ?>
                                    <img
                                            loading="lazy"
                                            src="https://placehold.co/330x400"
                                            width="330"
                                            height="400"
                                            class="pc__img mb-2"
                                    >
                                <?php endif; ?>

                            </a>
                        </div>

                        <div class="pc__info text-center">
                            <h6 class="pc__title">
                                <?= esc($product['name']) ?>
                            </h6>
                            <div class="product-card__price">
                                <?php if (!empty($product['special_price'])): ?>
                                    <span class="money price price-old"><?= esc($product['base_price_tax']) ?> €</span>
                                    <span class="money price price-sale"><?= esc($product['special_price']) ?> €</span>
                                <?php else: ?>
                                    <span class="money price"><?= esc($product['base_price_tax']) ?> €</span>
                                <?php endif; ?>
                            </div>

                        </div>

                    </div>
                <?php endforeach; ?>

            </div>
        </div>
        <div class="products-pagination mt-4 d-flex justify-content-center"></div>
    </div>
</section>
