<section class="themesFlat">
    <div class="container">

        <div class="sect-title text-center wow fadeInUp">
            <h1 class="title mb-8"><?= esc($block['title']) ?></h1>

            <?php if (!empty($block['subtitle'])): ?>
                <p class="s-subtitle h6"><?= esc($block['subtitle']) ?></p>
            <?php endif; ?>
        </div>

        <div dir="ltr"
             class="swiper tf-swiper wow fadeInUp"
             data-preview="6"
             data-tablet="4"
             data-mobile-sm="3"
             data-mobile="2"
             data-space-lg="48"
             data-space-md="32"
             data-space="12"
             data-pagination="2"
             data-pagination-sm="3"
             data-pagination-md="4"
             data-pagination-lg="6">

            <div class="swiper-wrapper">

                <?php foreach ($categories as $cat): ?>
                    <div class="swiper-slide">
                        <a href="<?= base_url('shop/category/' . $cat['id']) ?>"
                           class="widget-collection style-circle hover-img">

                            <div class="collection_image img-style">
                                <img class="lazyload"
                                     src="<?= $cat['image'] ?>"
                                     data-src="<?= $cat['image'] ?>"
                                     alt="<?= esc($cat['name']) ?>">
                            </div>

                            <div class="collection_content">
                                <p class="collection_name h4 link"><?= esc($cat['name']) ?></p>
                                <span class="collection_count h6 text-main-2">
                                    <?= $cat['total_products'] ?> product<?= $cat['total_products'] == 1 ? '' : 's' ?>
                                </span>
                            </div>

                        </a>
                    </div>
                <?php endforeach; ?>

            </div>

            <div class="sw-dot-default tf-sw-pagination"></div>
        </div>

    </div>
</section>
