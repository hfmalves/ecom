<?php
$config = $block['blockConfig'] ?? null;
$tabs   = $block['tabs'] ?? [];

if (!$config || empty($tabs)) return;
?>

<section class="products-carousel container">

    <h2 class="section-title text-uppercase fw-bold text-center mb-1 mb-md-3 pb-xl-2 mb-xl-4">
        <?= esc($config['title']) ?>
    </h2>

    <!-- TABS -->
    <ul class="nav nav-tabs mb-3 mb-xl-5 text-uppercase justify-content-center"
        id="collections-tab" role="tablist">

        <?php foreach ($tabs as $i => $tab): ?>
            <li class="nav-item" role="presentation">
                <a
                        class="nav-link nav-link_underscore <?= $i === 0 ? 'active' : '' ?>"
                        id="collections-tab-<?= $tab['id'] ?>-trigger"
                        data-bs-toggle="tab"
                        href="#collections-tab-<?= $tab['id'] ?>"
                        role="tab"
                        aria-controls="collections-tab-<?= $tab['id'] ?>"
                        aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                >
                    <?= esc($tab['label']) ?>
                </a>
            </li>
        <?php endforeach; ?>

    </ul>

    <!-- CONTENT -->
    <div class="tab-content pt-2" id="collections-tab-content">

        <?php foreach ($tabs as $i => $tab): ?>
            <div
                    class="tab-pane fade <?= $i === 0 ? 'show active' : '' ?>"
                    id="collections-tab-<?= $tab['id'] ?>"
                    role="tabpanel"
                    aria-labelledby="collections-tab-<?= $tab['id'] ?>-trigger"
            >

                <div class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                         data-settings='{
              "autoplay": { "delay": <?= (int)$config['autoplay_delay'] ?> },
              "slidesPerView": <?= (int)$config['slides_desktop'] ?>,
              "slidesPerGroup": <?= (int)$config['slides_desktop'] ?>,
              "effect": "none",
              "loop": <?= (int)$config['loop'] ? 'true' : 'false' ?>,
              "pagination": {
                "el": "#collections-tab-<?= $tab['id'] ?> .products-pagination",
                "type": "bullets",
                "clickable": true
              },
              "navigation": {
                "nextEl": "#collections-tab-<?= $tab['id'] ?> .products-carousel__next",
                "prevEl": "#collections-tab-<?= $tab['id'] ?> .products-carousel__prev"
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": <?= (int)$config['slides_mobile'] ?>,
                  "slidesPerGroup": <?= (int)$config['slides_mobile'] ?>,
                  "spaceBetween": 14
                },
                "768": {
                  "slidesPerView": <?= (int)$config['slides_tablet'] ?>,
                  "slidesPerGroup": <?= (int)$config['slides_tablet'] ?>,
                  "spaceBetween": 24
                },
                "992": {
                  "slidesPerView": <?= (int)$config['slides_desktop'] ?>,
                  "slidesPerGroup": 1,
                  "spaceBetween": 30,
                  "pagination": false
                }
              }
            }'>

                        <div class="swiper-wrapper">

                            <?php foreach ($tab['items'] as $item):
                                $product = $item['product'];
                                $image   = $product['images'][0]['path'] ?? 'images/placeholder.jpg';
                                ?>

                                <div class="swiper-slide product-card">
                                    <div class="pc__img-wrapper">
                                        <a href="<?= base_url('product/' . $product['slug']) ?>">
                                            <img
                                                    loading="lazy"
                                                    src="<?= !empty($image) ? base_url($image) : 'https://placehold.co/330x400' ?>"
                                                    width="330"
                                                    height="400"
                                                    alt="<?= esc($product['name']) ?>"
                                                    class="pc__img"
                                                    onerror="this.onerror=null;this.src='https://placehold.co/330x400';"
                                            />


                                        </a>

                                        <div class="anim_appear-bottom position-absolute bottom-0 start-0 w-100 d-none d-sm-flex align-items-center">
                                            <button class="btn btn-primary flex-grow-1 fs-base ps-3 pe-0 border-0 text-uppercase fw-medium">
                                               Adicioanr
                                            </button>
                                            <button class="btn btn-primary flex-grow-1 fs-base ps-0 pe-3 border-0 text-uppercase fw-medium">
                                                Ver
                                            </button>
                                        </div>

                                        <button class="pc__btn-wl position-absolute bg-body rounded-circle border-0 text-primary">
                                            <svg width="16" height="16"><use href="#icon_heart" /></svg>
                                        </button>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <p class="pc__category third-color">
                                            <?= esc($product['category_name'] ?? '') ?>
                                        </p>
                                        <h6 class="pc__title">
                                            <a href="<?= base_url('product/' . $product['slug']) ?>">
                                                <?= esc($product['name']) ?>
                                            </a>
                                        </h6>
                                        <div class="product-card__price d-flex">
                                            <?php if (!empty($product['special_price'])): ?>
                                                <span class="money price price-old"><?= esc($product['base_price_tax']) ?> €</span>
                                                <span class="money price"><?= esc($product['special_price']) ?> €</span>
                                            <?php else: ?>
                                                <span class="money price"><?= esc($product['base_price_tax']) ?> €</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                        </div>
                    </div>

                    <div class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25"><use href="#icon_prev_md" /></svg>
                    </div>

                    <div class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25"><use href="#icon_next_md" /></svg>
                    </div>

                    <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>

                </div>
            </div>
        <?php endforeach; ?>

    </div>
</section>
