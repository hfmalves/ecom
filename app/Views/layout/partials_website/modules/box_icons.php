<div class="flat-spacing">
    <div class="container">
        <div dir="ltr" class="swiper tf-swiper"
             data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="1"
             data-space-lg="97" data-space-md="33" data-space="13"
             data-pagination="1" data-pagination-sm="2" data-pagination-md="3" data-pagination-lg="4">

            <div class="swiper-wrapper">

                <?php foreach ($icons as $i): ?>
                    <div class="swiper-slide">
                        <div class="box-icon_V01 wow fadeInLeft">
            <span class="icon">
                <i class="<?= esc($i['icon']) ?>"></i>
            </span>
                            <div class="content">
                                <h4 class="title fw-normal"><?= esc($i['title']) ?></h4>
                                <p class="text"><?= esc($i['text']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>


            </div>

            <div class="sw-dot-default tf-sw-pagination"></div>
        </div>
    </div>
</div>
