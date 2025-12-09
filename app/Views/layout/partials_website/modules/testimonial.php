<section class="flat-spacing bg-white-smoke">
    <div class="container">

        <div class="sect-title text-center wow fadeInUp">
            <h1 class="s-title mb-8"><?= esc($title) ?></h1>
            <p class="s-subtitle h6"><?= esc($subtitle) ?></p>
        </div>

        <div class="tf-btn-swiper-main pst-2">
            <div dir="ltr" class="swiper tf-swiper"
                 data-preview="3" data-tablet="2" data-mobile-sm="1" data-mobile="1"
                 data-space-lg="48" data-space-md="32" data-space="12"
                 data-pagination="1" data-pagination-sm="1"
                 data-pagination-md="2" data-pagination-lg="3">

                <div class="swiper-wrapper">

                    <?php foreach ($data as $t): ?>
                        <div class="swiper-slide">
                            <div class="testimonial-V01 border-0 wow fadeInLeft">

                                <div>
                                    <h4 class="tes_title"><?= esc($t['title']) ?></h4>

                                    <p class="tes_text h4">“<?= esc($t['review_text']) ?>”</p>

                                    <div class="tes_author">
                                        <p class="author-name h4"><?= esc($t['author_name']) ?></p>

                                        <?php if ($t['author_verified']): ?>
                                            <i class="author-verified icon-check-circle fs-24"></i>
                                        <?php endif; ?>
                                    </div>

                                    <div class="rate_wrap">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="icon-star <?= $i <= $t['rating'] ? 'text-star' : '' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>

                                <span class="br-line"></span>

                                <?php if (!empty($t['product'])): ?>
                                    <div class="tes_product">
                                        <div class="product-image">
                                            <img class="lazyload"
                                                 src="<?= esc($t['product']['image'] ?? 'https://placehold.co/300x300') ?>"
                                                 alt="<?= esc($t['product']['name'] ?? 'Product') ?>">
                                        </div>

                                        <div class="product-infor">
                                            <h5 class="prd_name">
                                                <a href="/product/<?= esc($t['product']['id']) ?>" class="link">
                                                    <?= esc($t['product']['name']) ?>
                                                </a>
                                            </h5>

                                            <h6 class="prd_price">
                                                <?= esc($t['product']['price'] ?? '') ?>
                                            </h6>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

                <div class="sw-dot-default tf-sw-pagination"></div>
            </div>

            <div class="tf-sw-nav nav-prev-swiper">
                <i class="icon icon-caret-left"></i>
            </div>
            <div class="tf-sw-nav nav-next-swiper">
                <i class="icon icon-caret-right"></i>
            </div>
        </div>
    </div>
</section>
