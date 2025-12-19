<?php
$footerConfig = $block['footer']['config'] ?? [];
$categories   = $block['footer']['categories'] ?? [];
?>
<footer id="footer" class="footer footer_type_2 bordered">
    <?php if (!empty($footerConfig['show_newsletter'])): ?>
        <div class="footer-top container">
            <div class="block-newsletter">
                <h3 class="block__title">ASSINE NOSSA NEWSLETTER E APROVEITE</h3>
                <p>Receba as últimas novidades, produtos exclusivos e atualizações diárias de forma direta!</p>
                <form action="<?= base_url(); ?>" class="block-newsletter__form">
                    <input class="form-control" type="email" name="email" placeholder="Endereço de email">
                    <button class="btn btn-secondary fw-medium" type="submit">Subscrever</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
    <div class="footer-middle container">
        <div class="row row-cols-lg-5 row-cols-2">
            <div class="footer-column footer-store-info col-12 mb-4 mb-lg-0">
                <div class="logo">
                    <a href="<?= base_url(); ?>">
                        <img src="<?= base_url('assets/website/images/logo.png'); ?>"
                             alt="Logo"
                             class="logo__image d-block">
                    </a>
                </div>
                <?php if (!empty($footerConfig['show_info'])): ?>
                    <p class="footer-address">1418 River Drive, Suite 35 Cottonhall, CA 9622 United States</p>

                    <p class="m-0">
                        <strong class="fw-medium">sale@uomo.com</strong>
                    </p>
                    <p>
                        <strong class="fw-medium">+1 246-345-0695</strong>
                    </p>
                <?php endif; ?>
                <?php if (!empty($footerConfig['show_social'])): ?>
                    <ul class="social-links list-unstyled d-flex flex-wrap mb-0">
                        <li>
                            <a href="https://www.facebook.com/" class="footer__social-link d-block">
                                <svg class="svg-icon svg-icon_facebook" width="9" height="15" viewBox="0 0 9 15" xmlns="http://www.w3.org/2000/svg"><use href="#icon_facebook" /></svg>
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
            <?php foreach ($categories as $category): ?>
                <div class="footer-column footer-menu mb-4 mb-lg-0">
                    <h6 class="sub-menu__title text-uppercase">
                        <?= esc($category['title']) ?>
                    </h6>
                    <?php if (!empty($category['items'])): ?>
                        <ul class="sub-menu__list list-unstyled">
                            <?php foreach ($category['items'] as $item): ?>
                                <li class="sub-menu__item">
                                    <a
                                            href="<?= esc($item['url'] ?? '#') ?>"
                                            class="menu-link menu-link_us-s"
                                    >
                                        <?= esc($item['label']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <?php if (!empty($footerConfig['show_opening_times'])): ?>
                <div class="footer-column mb-4 mb-lg-0">
                    <h6 class="sub-menu__title text-uppercase">Opening Time</h6>
                    <ul class="list-unstyled">
                        <li><span class="menu-link">Mon - Fri: 8AM - 9PM</span></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container d-md-flex align-items-center">
            <span class="footer-copyright me-auto">Todos os direitos reservados. ©Nokeme - Produtos de Higine</span>
            <div class="footer-settings d-md-flex align-items-center">
                <span class="footer-copyright me-auto">BAGG - ECOMERCE by HUGO -  Digital Studio</span>
            </div><!-- /.footer-settings -->
        </div><!-- /.container d-flex align-items-center -->
    </div><!-- /.footer-bottom container -->
</footer>
