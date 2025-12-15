<!-- Header Type 5 -->
<header id="header" class="header header_sticky header-fullwidth">
    <div class="header-desk header-desk_type_5">
        <div class="logo">
            <a href="index.html">
                <img src="../images/logo-dark-blue.png" alt="Uomo" class="logo__image d-block">
            </a>
        </div><!-- /.logo -->

        <form action="https://uomo-html.flexkitux.com/Demo9/" method="GET" class="header-search search-field d-none d-xxl-flex">
            <button class="btn header-search__btn" type="submit">
                <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_search" /></svg>
            </button>
            <input class="header-search__input w-100" type="text" name="search-keyword" placeholder="Search products...">
            <div class="hover-container position-relative">
                <div class="js-hover__open">
                    <input class="header-search__category search-field__actor border-0 bg-white w-100" type="text" name="search-category" placeholder="All Category" readonly>
                </div>
                <div class="header-search__category-list js-hidden-content mt-2">
                    <ul class="search-suggestion list-unstyled">
                        <li class="search-suggestion__item js-search-select">All Category</li>
                        <li class="search-suggestion__item js-search-select">Men</li>
                        <li class="search-suggestion__item js-search-select">Women</li>
                        <li class="search-suggestion__item js-search-select">Kids</li>
                    </ul>
                </div>
            </div>
        </form><!-- /.header-search -->

        <?= view('layout/partials_website/menu') ?>

        <div class="header-tools d-flex align-items-center">
            <div class="header-tools__item hover-container d-block d-xxl-none">
                <div class="js-hover__open position-relative">
                    <a class="js-search-popup search-field__actor" href="#">
                        <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_search" /></svg>
                        <i class="btn-icon btn-close-lg"></i>
                    </a>
                </div>

                <div class="search-popup js-hidden-content">
                    <form action="https://uomo-html.flexkitux.com/Demo9/search_result.html" method="GET" class="search-field container">
                        <p class="text-uppercase text-secondary fw-medium mb-4">What are you looking for?</p>
                        <div class="position-relative">
                            <input class="search-field__input search-popup__input w-100 fw-medium" type="text" name="search-keyword" placeholder="Search products">
                            <button class="btn-icon search-popup__submit" type="submit">
                                <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_search" /></svg>
                            </button>
                            <button class="btn-icon btn-close-lg search-popup__reset" type="reset"></button>
                        </div>

                        <div class="search-popup__results">
                            <div class="sub-menu search-suggestion">
                                <h6 class="sub-menu__title fs-base">Quicklinks</h6>
                                <ul class="sub-menu__list list-unstyled">
                                    <li class="sub-menu__item"><a href="shop2.html" class="menu-link menu-link_us-s">New Arrivals</a></li>
                                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Dresses</a></li>
                                    <li class="sub-menu__item"><a href="shop3.html" class="menu-link menu-link_us-s">Accessories</a></li>
                                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Footwear</a></li>
                                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Sweatshirt</a></li>
                                </ul>
                            </div>

                            <div class="search-result row row-cols-5"></div>
                        </div>
                    </form><!-- /.header-search -->
                </div><!-- /.search-popup -->
            </div><!-- /.header-tools__item hover-container -->

            <div class="header-tools__item hover-container">
                <a class="header-tools__item js-open-aside" href="#" data-aside="customerForms">
                    <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_user" /></svg>
                </a>
            </div>

            <a class="header-tools__item" href="account_wishlist.html">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_heart" /></svg>
            </a>

            <a href="#" class="header-tools__item header-tools__cart js-open-aside" data-aside="cartDrawer">
                <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_cart" /></svg>
                <span class="cart-amount d-block position-absolute js-cart-items-count">3</span>
            </a>

            <a class="header-tools__item" href="#" data-bs-toggle="modal" data-bs-target="#siteMap">
                <svg class="nav-icon" width="25" height="18" viewBox="0 0 25 18" xmlns="http://www.w3.org/2000/svg">
                    <rect width="25" height="2"/><rect y="8" width="20" height="2"/><rect y="16" width="25" height="2"/>
                </svg>
            </a>
        </div><!-- /.header__tools -->
    </div><!-- /.header-desk header-desk_type_1 -->
</header>
<!-- End Header Type 5 -->