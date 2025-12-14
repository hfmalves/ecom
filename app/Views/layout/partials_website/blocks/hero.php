<?php $slides = $data['slides'] ?? []; ?>
<?php if (!empty($slides)): ?>
<section class="swiper-container js-swiper-slider slideshow full-width_padding-20 slideshow-md"
         data-settings='{
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": 1,
        "effect": "fade",
        "loop": true,
        "pagination": {
          "el": ".slideshow-pagination",
          "type": "bullets",
          "clickable": true
        }
      }'>
    <div class="swiper-wrapper">
    <?php if (!empty($slides)): ?>
        <?php foreach ($slides as $slide): ?>
        <div class="swiper-slide">
            <div class="overflow-hidden position-relative h-100">
                <div class="slideshow-bg">
                    <img loading="lazy" src="<?= base_url('public/uploads/sliders/large/' . esc($slide['background_image'])) ?>" width="1863" height="700" alt="" class="slideshow-bg__img object-fit-cover object-position-right">
                </div>
                <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                    <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">TRENDING 2023</h6>
                    <h2 class="text-uppercase h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5"><?= $slide['title'] ?></h2>
                    <p class="animate animate_fade animate_btt animate_delay-6"><?= $slide['description'] ?></p>
                    <a href="<?= base_url( esc($slide['type_link'] . '/' . $slide['button_link'])) ?>" class="btn-link btn-link_sm default-underline text-uppercase fw-medium animate animate_fade animate_btt animate_delay-7">
                        <?= esc($slide['button_text']) ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </div><!-- /.slideshow-wrapper js-swiper-slider -->

    <div class="slideshow-pagination position-left-center"></div>
    <!-- /.products-pagination -->
</section><!-- /.slideshow -->
<?php else: ?>
<?php endif; ?>