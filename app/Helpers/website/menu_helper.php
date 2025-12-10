<?php
function renderMenuTF(array $tree, $parentId = null)
{
    if (!isset($tree[$parentId])) {
        return;
    }
    echo buildMenuHTML($tree, $parentId);
}
/**
 * Constrói o HTML do menu de forma limpa (sem echo partido)
 */
function buildMenuHTML(array $tree, $parentId)
{
    $html = "<ul class=\"box-nav-menu\">";
    foreach ($tree[$parentId] as $item) {
        $hasChildren = isset($tree[$item['id']]);
        $isMega      = ($item['type'] == 1);
        $html .= "<li class=\"menu-item\">";
        // LINK PRINCIPAL
        $url  = $item['url'] ?: 'javascript:void(0)';
        $icon = $hasChildren ? "<i class=\"icon icon-caret-down\"></i>" : "";
        $html .= <<<HTML
            <a href="{$url}" class="item-link">
                {$item['title']} {$icon}
            </a>
        HTML;
        // SE TEM SUBMENUS
        if ($hasChildren) {
            // MEGA MENU
            if ($isMega) {
                $html .= buildMegaMenu($tree, $item['id']);
            }
            // MENU NORMAL
            else {
                $html .= "<div class=\"sub-menu\">";
                $html .= buildMenuHTML($tree, $item['id']);
                $html .= "</div>";
            }
        }
        $html .= "</li>";
    }
    $html .= "</ul>";
    return $html;
}
/**
 * MEGA MENU PROFISSIONAL
 */
function buildMegaMenu(array $tree, int $parentId)
{
    $html = <<<HTML
        <div class="sub-menu mega-menu">
            <div class="container">
                <div class="row">
    HTML;
    foreach ($tree[$parentId] as $child) {
        $col = "<div class=\"col-2\"><div class=\"mega-menu-item\">";
        $col .= "<h4 class=\"menu-heading\">{$child['title']}</h4>";
        switch ($child['block_type']) {
            // -----------------------------------
            // PRODUTOS RECENTES
            // -----------------------------------
            case 2:
                $items = json_decode($child['block_data'], true);
                $col  .= "<div class=\"mega-products\">";

                foreach ($items as $prod) {
                    $col .= <<<HTML
                        <div class="mega-product">
                            <img src="{$prod['image']}" alt="">
                            <div class="cat">{$prod['category']}</div>
                            <div class="name">{$prod['name']}</div>
                            <div class="price">{$prod['price']}</div>
                        </div>
                    HTML;
                }
                $col .= "</div>";
                break;
            // -----------------------------------
            // DESTAQUES
            // -----------------------------------
            case 3:
                $items = json_decode($child['block_data'], true);
                $col  .= "<div class=\"mega-spot\">";
                foreach ($items as $spot) {
                    $col .= <<<HTML
                        <div class="spot-item">
                            <img src="{$spot['image']}" alt="">
                            <div class="label">{$spot['label']}</div>
                            <a class="cta" href="{$spot['url']}">{$spot['cta']}</a>
                        </div>
                    HTML;
                }
                $col .= "</div>";
                break;
            // -----------------------------------
            // LISTA NORMAL
            // -----------------------------------
            default:
                if (isset($tree[$child['id']])) {
                    $col .= "<ul class=\"sub-menu_list\">";
                    foreach ($tree[$child['id']] as $subItem) {
                        $surl = $subItem['url'] ?: '#';
                        $col .= "<li><a href=\"{$surl}\" class=\"sub-menu_link\">{$subItem['title']}</a></li>";
                    }
                    $col .= "</ul>";
                }
        }
        $col .= "</div></div>"; // fecha mega-menu-item e coluna
        $html .= $col;
    }
    $html .= "</div></div></div>"; // fecha mega-menu container
    return $html;
}
