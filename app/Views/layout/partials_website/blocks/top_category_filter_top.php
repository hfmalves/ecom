<div class="mb-2 mb-xl-5 pt-1 pb-2"></div>
<div class="bg-white">
    <section class="products-carousel container">
        <h2 class="section-title fw-normal text-center mb-3 pb-xl-3 mb-xl-3"><?= $data['title'] ?></h2>

        <ul class="nav nav-tabs mb-3 mb-xl-5 justify-content-center" id="collections-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore active" id="collections-tab-1-trigger" data-bs-toggle="tab" href="#collections-tab-1" role="tab" aria-controls="collections-tab-1" aria-selected="true">Todos</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore" id="collections-tab-2-trigger" data-bs-toggle="tab" href="#collections-tab-2" role="tab" aria-controls="collections-tab-2" aria-selected="true">Mais Vendidos</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore" id="collections-tab-3-trigger" data-bs-toggle="tab" href="#collections-tab-3" role="tab" aria-controls="collections-tab-3" aria-selected="true">Mais Vistos</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore" id="collections-tab-4-trigger" data-bs-toggle="tab" href="#collections-tab-4" role="tab" aria-controls="collections-tab-4" aria-selected="true">Tendencias</a>
            </li>

        </ul>

        <div class="tab-content" id="collections-tab-content">
            <div class="tab-pane fade show active" id="collections-tab-1" role="tabpanel" aria-labelledby="collections-tab-1-trigger">
                <div class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                         data-settings='{
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 5,
                  "slidesPerGroup": 5,
                  "effect": "none",
                  "loop": false,
                  "pagination": {
                    "el": "#collections-tab-1 .products-pagination",
                    "type": "bullets",
                    "clickable": true
                  },
                  "navigation": {
                    "nextEl": "#collections-tab-1 .products-carousel__next",
                    "prevEl": "#collections-tab-1 .products-carousel__prev"
                  },
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 2,
                      "spaceBetween": 14
                    },
                    "768": {
                      "slidesPerView": 3,
                      "slidesPerGroup": 3,
                      "spaceBetween": 20
                    },
                    "992": {
                      "slidesPerView": 4,
                      "slidesPerGroup": 1,
                      "spaceBetween": 24,
                      "pagination": false
                    },
                    "1200": {
                      "slidesPerView": 5,
                      "slidesPerGroup": 1,
                      "spaceBetween": 28,
                      "pagination": false
                    }
                  }
                }'>
                        <div class="swiper-wrapper">
                            <?php foreach (array_merge($trending, $top_views, $top_sales) as $product): ?>
                                <div class="swiper-slide product-card">
                                <div class="pc__img-wrapper">
                                    <a href="<?= base_url('product/' . $product['slug']) ?>">
                                        <?php if (!empty($product['images'])): ?>
                                            <?php foreach ($product['images'] as $img): ?>
                                                <img
                                                        loading="lazy"
                                                        src="<?= base_url('uploads/product_images/' . $img['image_path']) ?>"
                                                        alt="<?= esc($product['name']) ?>"
                                                        width="330" height="400"
                                                        class="pc__img mb-2"
                                                />
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <img
                                                    loading="lazy"
                                                    src="<?= base_url('uploads/no-picture-available.jpg') ?>"
                                                    alt="Sem imagem disponível"
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

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Dresses</p>
                                    <h6 class="pc__title"><a href="<?= base_url('product/' . $product['slug']) ?>"><?= esc($product['name']) ?></a></h6>
                                    <div class="product-card__price d-flex">
                                        <span class="money price"><?= esc($product['price']) ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>

                        </div><!-- /.swiper-wrapper -->
                    </div><!-- /.swiper-container js-swiper-slider -->

                    <div class="products-carousel__prev type2 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_md" /></svg>
                    </div><!-- /.products-carousel__prev -->
                    <div class="products-carousel__next type2 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_md" /></svg>
                    </div><!-- /.products-carousel__next -->

                    <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                    <!-- /.products-pagination -->
                </div><!-- /.position-relative -->
            </div><!-- /.tab-pane fade show-->
            <div class="tab-pane fade" id="collections-tab-2" role="tabpanel" aria-labelledby="collections-tab-2-trigger">
                <div class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                         data-settings='{
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 5,
                  "slidesPerGroup": 5,
                  "effect": "none",
                  "loop": false,
                  "pagination": {
                    "el": "#collections-tab-2 .products-pagination",
                    "type": "bullets",
                    "clickable": true
                  },
                  "navigation": {
                    "nextEl": "#collections-tab-2 .products-carousel__next",
                    "prevEl": "#collections-tab-2 .products-carousel__prev"
                  },
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 2,
                      "spaceBetween": 14
                    },
                    "768": {
                      "slidesPerView": 3,
                      "slidesPerGroup": 3,
                      "spaceBetween": 20
                    },
                    "992": {
                      "slidesPerView": 4,
                      "slidesPerGroup": 1,
                      "spaceBetween": 24,
                      "pagination": false
                    },
                    "1200": {
                      "slidesPerView": 5,
                      "slidesPerGroup": 1,
                      "spaceBetween": 28,
                      "pagination": false
                    }
                  }
                }'>
                        <div class="swiper-wrapper">
                            <?php foreach ($top_sales as $product): ?>
                                <div class="swiper-slide product-card">
                                    <div class="pc__img-wrapper">
                                        <a href="<?= base_url('product/' . $product['slug']) ?>">
                                            <?php foreach ($product['images'] as $img): ?>
                                                <img
                                                        loading="lazy"
                                                        src="<?= base_url('public/shop_assets/uploads/' . $img['image_path']) ?>"
                                                        alt="<?= esc($product['name']) ?>"
                                                        width="330" height="400"
                                                        class="pc__img mb-2"
                                                />
                                            <?php endforeach; ?>
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

                                    <div class="pc__info position-relative">
                                        <p class="pc__category">Dresses</p>
                                        <h6 class="pc__title"><a href="<?= base_url('product/' . $product['slug']) ?>"><?= esc($product['name']) ?></a></h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price"><?= esc($product['price']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div><!-- /.swiper-wrapper -->
                    </div><!-- /.swiper-container js-swiper-slider -->

                    <div class="products-carousel__prev type2 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_md" /></svg>
                    </div><!-- /.products-carousel__prev -->
                    <div class="products-carousel__next type2 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_md" /></svg>
                    </div><!-- /.products-carousel__next -->

                    <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                    <!-- /.products-pagination -->
                </div><!-- /.position-relative -->
            </div><!-- /.tab-pane fade show-->
            <div class="tab-pane fade" id="collections-tab-3" role="tabpanel" aria-labelledby="collections-tab-3-trigger">
                <div class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                         data-settings='{
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 5,
                  "slidesPerGroup": 5,
                  "effect": "none",
                  "loop": false,
                  "pagination": {
                    "el": "#collections-tab-3 .products-pagination",
                    "type": "bullets",
                    "clickable": true
                  },
                  "navigation": {
                    "nextEl": "#collections-tab-3 .products-carousel__next",
                    "prevEl": "#collections-tab-3 .products-carousel__prev"
                  },
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 2,
                      "spaceBetween": 14
                    },
                    "768": {
                      "slidesPerView": 3,
                      "slidesPerGroup": 3,
                      "spaceBetween": 20
                    },
                    "992": {
                      "slidesPerView": 4,
                      "slidesPerGroup": 1,
                      "spaceBetween": 24,
                      "pagination": false
                    },
                    "1200": {
                      "slidesPerView": 5,
                      "slidesPerGroup": 1,
                      "spaceBetween": 28,
                      "pagination": false
                    }
                  }
                }'>
                        <div class="swiper-wrapper">

                            <?php foreach ($top_views as $product): ?>
                                <div class="swiper-slide product-card">
                                    <div class="pc__img-wrapper">
                                        <a href="<?= base_url('product/' . $product['slug']) ?>">
                                            <?php foreach ($product['images'] as $img): ?>
                                                <img
                                                        loading="lazy"
                                                        src="<?= base_url('public/shop_assets/uploads/' . $img['image_path']) ?>"
                                                        alt="<?= esc($product['name']) ?>"
                                                        width="330" height="400"
                                                        class="pc__img mb-2"
                                                />
                                            <?php endforeach; ?>
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

                                    <div class="pc__info position-relative">
                                        <p class="pc__category">Dresses</p>
                                        <h6 class="pc__title"><a href="<?= base_url('product/' . $product['slug']) ?>"><?= esc($product['name']) ?></a></h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price"><?= esc($product['price']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div><!-- /.swiper-wrapper -->
                    </div><!-- /.swiper-container js-swiper-slider -->

                    <div class="products-carousel__prev type2 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_md" /></svg>
                    </div><!-- /.products-carousel__prev -->
                    <div class="products-carousel__next type2 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_md" /></svg>
                    </div><!-- /.products-carousel__next -->

                    <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                    <!-- /.products-pagination -->
                </div><!-- /.position-relative -->
            </div><!-- /.tab-pane fade show-->
            <div class="tab-pane fade" id="collections-tab-4" role="tabpanel" aria-labelledby="collections-tab-4-trigger">
                <div class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                         data-settings='{
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 5,
                  "slidesPerGroup": 5,
                  "effect": "none",
                  "loop": false,
                  "pagination": {
                    "el": "#collections-tab-4 .products-pagination",
                    "type": "bullets",
                    "clickable": true
                  },
                  "navigation": {
                    "nextEl": "#collections-tab-4 .products-carousel__next",
                    "prevEl": "#collections-tab-4 .products-carousel__prev"
                  },
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 2,
                      "spaceBetween": 14
                    },
                    "768": {
                      "slidesPerView": 3,
                      "slidesPerGroup": 3,
                      "spaceBetween": 20
                    },
                    "992": {
                      "slidesPerView": 4,
                      "slidesPerGroup": 1,
                      "spaceBetween": 24,
                      "pagination": false
                    },
                    "1200": {
                      "slidesPerView": 5,
                      "slidesPerGroup": 1,
                      "spaceBetween": 28,
                      "pagination": false
                    }
                  }
                }'>
                        <div class="swiper-wrapper">
                            <?php foreach ($trending  as $product_top_sales): ?>
                                <div class="swiper-slide product-card">
                                    <div class="pc__img-wrapper">
                                        <a href="<?= base_url('product/' . $product_top_sales['slug']) ?>">
                                            <?php foreach ($product_top_sales['images'] as $img): ?>
                                                <img
                                                        loading="lazy"
                                                        src="<?= base_url('public/shop_assets/uploads/' . $img['image_path']) ?>"
                                                        alt="<?= esc($product_top_sales['name']) ?>"
                                                        width="330" height="400"
                                                        class="pc__img mb-2"
                                                />
                                            <?php endforeach; ?>
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

                                    <div class="pc__info position-relative">
                                        <p class="pc__category">Dresses</p>
                                        <h6 class="pc__title"><a href="<?= base_url('product/' . $product_top_sales['slug']) ?>"><?= esc($product_top_sales['name']) ?></a></h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price">$29</span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div><!-- /.swiper-wrapper -->
                    </div><!-- /.swiper-container js-swiper-slider -->

                    <div class="products-carousel__prev type2 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_md" /></svg>
                    </div><!-- /.products-carousel__prev -->
                    <div class="products-carousel__next type2 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_md" /></svg>
                    </div><!-- /.products-carousel__next -->

                    <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                    <!-- /.products-pagination -->
                </div><!-- /.position-relative -->
            </div><!-- /.tab-pane fade show-->
        </div><!-- /.tab-content pt-2 -->
    </section><!-- /.products-grid -->
</div>