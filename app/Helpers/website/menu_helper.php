<?php

function menu_tree(array $items): array
{
    $indexed = [];
    $tree = [];

    foreach ($items as $item) {
        $item['children'] = [];
        $indexed[$item['id']] = $item;
    }

    foreach ($indexed as &$item) {
        if ($item['parent_id'] !== null && isset($indexed[$item['parent_id']])) {
            $indexed[$item['parent_id']]['children'][] = &$item;
        } else {
            $tree[] = &$item;
        }
    }

    return $tree;
}

function website_menu(array $menu): string
{
    ob_start(); ?>
    <nav class="navigation mx-auto mx-xxl-0">
        <ul class="navigation__list list-unstyled d-flex">

            <?php foreach ($menu as $item): ?>
                <li class="navigation__item">
                    <a href="<?= $item['url'] ?: '#' ?>" class="navigation__link">
                        <?= esc($item['title']) ?>
                    </a>

                    <?php if (empty($item['children'])) continue; ?>

                    <?php if ((int)$item['type'] === 1): ?>
                        <!-- MEGA MENU -->
                        <div class="mega-menu">
                            <div class="container d-flex">
                                <?php foreach ($item['children'] as $col): ?>
                                    <div class="col pe-4">
                                        <a href="<?= $col['url'] ?: '#' ?>" class="sub-menu__title">
                                            <?= esc($col['title']) ?>
                                        </a>

                                        <?php if (!empty($col['children'])): ?>
                                            <ul class="sub-menu__list list-unstyled">
                                                <?php foreach ($col['children'] as $child): ?>
                                                    <li class="sub-menu__item">
                                                        <a href="<?= $child['url'] ?: '#' ?>" class="menu-link menu-link_us-s">
                                                            <?= esc($child['title']) ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    <?php elseif ((int)$item['type'] === 2): ?>
                        <!-- MENU LISTA NORMAL -->
                        <ul class="default-menu list-unstyled">
                            <?php foreach ($item['children'] as $child): ?>
                                <li class="sub-menu__item">
                                    <a href="<?= $child['url'] ?: '#' ?>" class="menu-link menu-link_us-s">
                                        <?= esc($child['title']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                </li>
            <?php endforeach; ?>

        </ul>
    </nav>
    <?php
    return ob_get_clean();
}
