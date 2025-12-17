<div class="mb-2 mb-xl-5 pt-1 pb-2"></div>
<!-- asd -->
<?php $products = $products_home_deals_day ?? []; ?>
<section class="products-carousel container">
    <h2 class="section-title fw-normal text-center mb-3 pb-xl-3 mb-xl-3"><?= $data['title'] ?></h2>
    <?php if (!empty($products)): ?>
    <div id="best-sellers" class="position-relative">
        <div class="swiper-container js-swiper-slider"
             data-settings='{
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 4,
              "slidesPerGroup": 4,
              "effect": "none",
              "loop": false,
              "pagination": {
                "el": "#best-sellers .products-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 1,
                  "spaceBetween": 14
                },
                "768": {
                  "slidesPerView": 3,
                  "slidesPerGroup": 1,
                  "spaceBetween": 22
                },
                "992": {
                  "slidesPerView": 4,
                  "slidesPerGroup": 1,
                  "spaceBetween": 30
                }
              }
            }'>
            <div class="swiper-wrapper">
                <?php foreach ($products as $product): ?>
                    <div class="swiper-slide product-card">
                        <div class="pc__img-wrapper">
                            <a href="<?= base_url('product/' . $product['slug']) ?>">
                                <?php if (!empty($product['images'])): ?>
                                    <?php foreach ($product['images'] as $img): ?>
                                        <img
                                                loading="lazy"
                                                src="<?= base_url('uploads/' . $img['image_path']) ?>"
                                                alt="<?= esc($product['name']) ?>"
                                                width="330" height="400"
                                                class="pc__img mb-2"
                                        />
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <img
                                            loading="lazy"
                                            src="<?= base_url('uploads/no-picture-available.jpg') ?>"
                                            alt="Imagem não disponível"
                                            width="330" height="400"
                                            class="pc__img mb-2"
                                    />
                                <?php endif; ?>
                            </a>
                            <form method="post" class="addtocart-form">
                                <input type="hidden" name="product_id" value="<?= esc($product['id']) ?>">
                                <input type="hidden" name="product_variation_id" value="<?= esc($product['variation']['id'] ?? '') ?>">

                                <input id="product-quantity-<?= $product['id'] ?>"
                                       type="number"
                                       name="quantity"
                                       value="1"
                                       min="1"
                                       class="qty-control__number text-center product-quantity">

                                <button
                                        type="button"
                                        class="js-add-cart pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium js-open-aside"
                                        data-aside="cartDrawer"
                                        data-product-id="<?= $product['id'] ?>"
                                        data-variation-id="<?= $product['variation']['id'] ?? '' ?>"
                                        data-quantity-input="#product-quantity-<?= $product['id'] ?>"
                                        title="Add To Cart">
                                    Adicionar ao Carrinho
                                </button>
                            </form>
                            <div class="anim_appear-right position-absolute top-0 mt-2 me-2">
                                <?php if (isInWishlist($product['id'], $variation['id'] ?? null)): ?>
                                    <!-- Remover -->
                                    <button type="button"
                                            class="btn btn-round-sm btn-hover-red d-block border-0 text-uppercase js-remove-wishlist"
                                            title="Remover da Wishlist"
                                            data-product-id="<?= $product['id'] ?>"
                                            data-variation-id="<?= $variation['id'] ?? '' ?>">
                                        <svg width="14" height="14" viewBox="0 0 20 20"><use href="#icon_close"></use></svg>
                                    </button>
                                <?php else: ?>
                                    <!-- Adicionar -->
                                    <button type="button"
                                            class="btn btn-round-sm btn-hover-red d-block border-0 text-uppercase js-add-wishlist"
                                            title="Adicionar à Wishlist"
                                            data-product-id="<?= $product['id'] ?>"
                                            data-variation-id="<?= $variation['id'] ?? '' ?>">
                                        <svg width="14" height="14" viewBox="0 0 20 20"><use href="#icon_heart"></use></svg>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="product-card__price d-flex">

                        </div>
                        <div class="pc__info position-relative">
                            <p class="pc__category"><?= $product['category']['name']; ?></p>
                            <h6 class="pc__title">
                                <a href="<?= base_url('product/' . $product['slug']) ?>"><?= esc($product['name']) ?>
                                    <?php if (!empty($product['variation_attributes'])): ?>
                                        <?php $first = true; ?>
                                        <?php foreach ($product['variation_attributes'] as $attr): ?>
                                            <?php if ($first): ?>
                                                <span>com <?= esc($attr['name']) ?> <?= esc($attr['value']) ?></span>
                                                <?php $first = false; ?>
                                            <?php else: ?>
                                                <span><?= esc($attr['name']) ?> <?= esc($attr['value']) ?></span>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </a>
                            </h6>
                            <div class="product-card__price d-flex">
                                <?php if (!empty($product['price_discount']) && $product['price_discount'] < $product['price']): ?>
                                    <span class="money price price-old"><?= esc($product['price']) ?> €</span>
                                    <span class="money price price-sale"><?= esc($product['price_discount']) ?> €</span>
                                <?php else: ?>
                                    <span class="money price"><?= esc($product['price']) ?> €</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div><!-- /.swiper-wrapper -->
        </div><!-- /.swiper-container js-swiper-slider -->

        <div class="products-pagination type2 mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
        <!-- /.products-pagination -->
    </div><!-- /.position-relative -->
    <?php else: ?>
        <p class="text-muted text-center">Nenhum produto disponível neste momento.</p>
    <?php endif; ?>
</section>

