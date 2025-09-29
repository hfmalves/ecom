<div class="vertical-menu">
    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title">Loja Online</li>

                <li class="mm-active">
                    <a href="<?= base_url('admin/dashboard') ?>" class="waves-effect active">
                        <i class="bx bx-home-circle"></i>
                        <span>Painel</span>
                    </a>
                </li>

                <!-- Produtos -->
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-package"></i>
                        <span>Catálogo</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= base_url('admin/catalog/products') ?>">Produtos</a></li>
                        <li><a href="<?= base_url('admin/catalog/categories') ?>">Categorias</a></li>
                        <li><a href="<?= base_url('admin/catalog/attributes') ?>">Atributos</a></li>
                        <li><a href="<?= base_url('admin/catalog/suppliers') ?>">Fornecedores</a></li>
                        <li><a href="<?= base_url('admin/catalog/brands') ?>">Marcas</a></li>
                    </ul>
                </li>

                <!-- Clientes -->
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-user"></i>
                        <span>Clientes</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= base_url('admin/customers') ?>">Lista de Clientes</a></li>
                        <li><a href="<?= base_url('admin/customers/groups') ?>">Grupos de Clientes</a></li>
                    </ul>
                </li>

                <!-- Encomendas -->
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-cart"></i>
                        <span>Vendas</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= base_url('admin/sales/orders') ?>">Encomendas</a></li>
                        <li><a href="<?= base_url('admin/sales/transactions') ?>">Transações</a></li>
                        <li><a href="<?= base_url('admin/sales/invoices') ?>">Faturas</a></li>
                        <li><a href="<?= base_url('admin/sales/shipments') ?>">Envios</a></li>
                        <li><a href="<?= base_url('admin/sales/returns') ?>">Devoluções</a></li>
                        <li><a href="<?= base_url('admin/sales/cart') ?>">Carrinhos</a></li>
                    </ul>
                </li>

                <!-- Campanhas / Marketing -->
                <li class="menu-title">Campanhas</li>
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-bullseye"></i>
                        <span>Marketing</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= base_url('admin/marketing/coupons') ?>">Cupões de Desconto</a></li>
                        <li><a href="<?= base_url('admin/marketing/campaigns') ?>">Promoções</a></li>
                        <li><a href="<?= base_url('admin/marketing/catalog-rules') ?>">Regras de Preço do Catálogo</a></li>
                        <li><a href="<?= base_url('admin/marketing/cart-rules') ?>">Regras de Carrinho</a></li>
                    </ul>
                </li>

                <!-- Website -->
                <li class="menu-title">Conteúdos</li>
                <li>
                    <a href="<?= base_url('admin/slides') ?>" class="waves-effect">
                        <i class="bx bx-slideshow"></i>
                        <span>Slides</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/product-groups') ?>" class="waves-effect">
                        <i class="bx bx-grid-alt"></i>
                        <span>Blocos de Produtos</span>
                    </a>
                </li>

                <!-- Relatórios -->
                <li class="menu-title">Relatórios</li>
                <li>
                    <a href="<?= base_url('admin/reports') ?>" class="waves-effect">
                        <i class="bx bx-bar-chart"></i>
                        <span>Relatórios</span>
                    </a>
                </li>

                <!-- Configurações -->
                <li class="menu-title">Configurações</li>
                <li>
                    <a href="<?= base_url('admin/settings') ?>" class="waves-effect">
                        <i class="bx bx-cog"></i>
                        <span>Configurações</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar End -->

    </div>
</div>
