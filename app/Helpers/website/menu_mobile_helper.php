<?php

if (! function_exists('website_menu_mobile')) {

    function website_menu_mobile(array $menu): string
    {
        ob_start(); ?>
        <ul class="navigation__list list-unstyled position-relative">
            <?php foreach ($menu as $item): ?>
                <li class="navigation__item">

                    <?php if (!empty($item['children'])): ?>
                        <a href="<?= $item['url'] ? esc($item['url']) : '#' ?>"
                           class="navigation__link js-nav-right d-flex align-items-center">
                            <?= esc($item['title']) ?>
                            <svg class="ms-auto" width="7" height="11">
                                <use href="#icon_next_sm" />
                            </svg>
                        </a>

                        <div class="sub-menu position-absolute top-0 start-100 w-100 d-none">
                            <a href="#"
                               class="navigation__link js-nav-left d-flex align-items-center border-bottom mb-2">
                                <svg class="me-2" width="7" height="11">
                                    <use href="#icon_prev_sm" />
                                </svg>
                                <?= esc($item['title']) ?>
                            </a>

                            <ul class="list-unstyled">
                                <?php foreach ($item['children'] as $child): ?>
                                    <li class="sub-menu__item">
                                        <a href="<?= $child['url'] ? esc($child['url']) : '#' ?>"
                                           class="menu-link menu-link_us-s">
                                            <?= esc($child['title']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    <?php else: ?>
                        <a href="<?= $item['url'] ? esc($item['url']) : '#' ?>"
                           class="navigation__link">
                            <?= esc($item['title']) ?>
                        </a>
                    <?php endif; ?>

                </li>
            <?php endforeach; ?>
        </ul>
        <?php
        return ob_get_clean();
    }
}
