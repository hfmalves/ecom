<div class="tf-slideshow tf-btn-swiper-main">
    <div dir="ltr" class="swiper tf-swiper sw-slide-show slider_effect_fade"
         data-preview="1.33" data-tablet="1.2" data-auto="true"
         data-delay="3000" data-loop="true" data-center="true" data-space="8">

        <div class="swiper-wrapper">

            <?php foreach ($data as $s): ?>

                <?php
                $img = (
                        !empty($s['image']) &&
                        is_file(FCPATH . 'assets/website/uploads/slides/' . $s['image'])
                )
                        ? base_url('assets/website/uploads/slides/' . $s['image'])
                        : 'https://placehold.co/1920x1080?text=Sem+Imagem';
                ?>

                <div class="swiper-slide">
                    <div class="slider-wrap">

                        <div class="sld_image">
                            <img src="<?= esc($img) ?>"
                                 alt="<?= esc($s['title']) ?>"
                                 class="lazyload scale-item scale-item-1">
                        </div>

                        <div class="sld_content type-2">
                            <div class="content-sld_wrap">

                                <h2 class="title_sld type-semibold fade-item fade-item-1">
                                    <a href="<?= esc($s['cta_url']) ?>" class="link">
                                        <?= esc($s['title']) ?>
                                    </a>
                                </h2>

                                <div class="price-wrap fade-item fade-item-2">
                                    <span class="price-old h6 fw-normal"><?= esc($s['price_old']) ?></span>
                                    <span class="price-new h6"><?= esc($s['price_new']) ?></span>
                                </div>

                                <span class="br-line width-item width-item-3"></span>

                                <div class="fade-item fade-item-4">
                                    <a href="<?= esc($s['cta_url']) ?>" class="tf-btn-link link h6 fw-semibold">
                                        <?= esc($s['cta_text']) ?>
                                        <i class="icon icon-arrow-right"></i>
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

