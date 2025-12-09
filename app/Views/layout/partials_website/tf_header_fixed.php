<header class="tf-header header-fixed">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 col-3 d-xl-none">
                <a href="#mobileMenu" data-bs-toggle="offcanvas" class="btn-mobile-menu">
                    <span></span>
                </a>
            </div>
            <div class="col-xl-3 col-md-4 col-6 text-center text-xl-start">
                <a href="index-2.html" class="logo-site justify-content-center justify-content-xl-start">
                    <img src="images/logo/logo.svg" alt="Logo">
                </a>
            </div>
            <div class="col-xl-6 d-none d-xl-block">
                <nav class="box-navigation">
                    <?php renderMenuTF($menu_tree); ?>
                </nav>
            </div>
            <div class="col-xl-3 col-md-4 col-3">
                <ul class="nav-icon-list">
                    <li class="d-none d-lg-flex">
                        <a class="nav-icon-item link" href="login.html"><i class="icon icon-user"></i></a>
                    </li>
                    <li class="d-none d-md-flex">
                        <a class="nav-icon-item link" href="#search" data-bs-toggle="modal">
                            <i class="icon icon-magnifying-glass"></i>
                        </a>
                    </li>
                    <li class="d-none d-sm-flex">
                        <a class="nav-icon-item link" href="wishlist.html"><i class="icon icon-heart"></i></a>
                    </li>
                    <li class="shop-cart" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart">
                        <a class="nav-icon-item link" href="#shoppingCart" data-bs-toggle="offcanvas">
                            <i class="icon icon-shopping-cart-simple"></i>
                        </a>
                        <span class="count">24</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>