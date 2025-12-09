<header class="tf-header style-3">
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 col-3 d-xl-none">
                    <a href="#mobileMenu" data-bs-toggle="offcanvas" class="btn-mobile-menu">
                        <span></span>
                    </a>
                </div>
                <div class="col-xl-4 d-none d-xl-block">
                    <form class="form_search-product">
                        <div class="select-category">
                            <select name="product_cat" id="product_cat" class="dropdown_product_cat">
                                <option value="" selected="selected">Categorias</option>
                                <option class="level-0" value="skincare">Skincare</option>
                            </select>
                            <ul class="select-options">
                                <li class="link" rel=""><span>Categorias</span></li>
                                <li class="link" rel="skincare"><span>Skincare</span> </li>
                            </ul>
                        </div>
                        <span class="br-line type-vertical"></span>
                        <input class="style-def" type="text" placeholder="Procurar productos.">
                    </form>
                </div>
                <div class="col-xl-4 col-md-4 col-6">
                    <a href=""<?= base_url(); ?>" class="logo-site justify-content-center">
                        <img src="<?= base_url('assets/website/uploads/logo.svg'); ?>" alt="Logo">
                    </a>
                </div>
                <div class="col-xl-4 col-md-4 col-3">
                    <ul class="nav-icon-list">
                        <li class="d-none d-lg-flex">
                            <a class="nav-icon-item link" href="<?= base_url('cart'); ?>"><i class="icon icon-user"></i></a>
                        </li>
                        <li class="d-none none">
                            <a class="nav-icon-item link" href="#search" data-bs-toggle="modal">
                                <i class="icon icon-magnifying-glass"></i>
                            </a>
                        </li>
                        <li class="d-none d-sm-flex">
                            <a class="nav-icon-item link" href="<?= base_url('wishlist'); ?>"><i class="icon icon-heart"></i></a>
                        </li>
                        <li class="shop-cart" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart">
                            <a class="nav-icon-item link" href="#shoppingCart" data-bs-toggle="offcanvas">
                                <i class="icon icon-shopping-cart-simple"></i>
                            </a>
                            <span class="count">0</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-inner d-none d-xl-block">
        <div class="container">
            <span class="br-line d-block"></span>
            <nav class="box-navigation">
                <?php renderMenuTF($menu_tree); ?>
            </nav>
        </div>
    </div>
</header>