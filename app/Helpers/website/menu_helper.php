<?php

function renderMenuTF(array $tree, $parentId = null)
{
    if (!isset($tree[$parentId])) {
        return;
    }
    echo buildMenuHTML($tree, $parentId);
}

/**
 * Constrói o HTML do menu (normal, lista ou mega)
 */
function buildMenuHTML(array $tree, $parentId)
{
    $html = "<ul class=\"box-nav-menu\">";

    foreach ($tree[$parentId] as $item) {
        $hasChildren = isset($tree[$item['id']]);
        $type        = (int)$item['type']; // 0 = normal, 1 = mega, 2 = lista
        $liClass = "menu-item";
        if ($item['type'] == 2) {
            $liClass .= " position-relative";
        }
        $html .= "<li class=\"{$liClass}\">";
        $url  = $item['url'] ?: 'javascript:void(0)';
        $icon = $hasChildren ? "<i class=\"icon icon-caret-down\"></i>" : "";
        $html .= <<<HTML
            <a href="{$url}" class="item-link">
                {$item['title']} {$icon}
            </a>
        HTML;
        if ($hasChildren) {
            if ($type === 1) {
                $html .= buildMegaMenu($tree, $item['id']);
            }
            elseif ($type === 2) {
                $html .= "<div class=\"sub-menu\">";
                $html .= buildListMenu($tree, $item['id']);
                $html .= "</div>";
            }
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
 * MENU LISTA — igual ao BLOG
 */
function buildListMenu(array $tree, int $parentId)
{
    $html = "<ul class=\"sub-menu_list\">";

    foreach ($tree[$parentId] as $item) {
        $url = $item['url'] ?: '#';
        $html .= "<li><a href=\"{$url}\" class=\"sub-menu_link\">{$item['title']}</a></li>";
    }

    $html .= "</ul>";
    return $html;
}

/**
 * MEGA MENU PROFISSIONAL
 */
function buildMegaMenu(array $tree, int $parentId)
{
    // Placeholder universal
    $placeholder = "https://placehold.co/122x122";

    $html = <<<HTML
        <div class="sub-menu mega-menu">
            <div class="container">
                <div class="row">
    HTML;

    foreach ($tree[$parentId] as $child) {

        $col = "<div class=\"col-2\"><div class=\"mega-menu-item\">";
        $col .= "<h4 class=\"menu-heading\">{$child['title']}</h4>";

        switch ($child['block_type']) {

            /* =======================================================
             *  PRODUTOS RECENTES (BLOCO DE PRODUTOS)
             * ======================================================= */
            case 2:
                $items = json_decode($child['block_data'], true);

                // Wrapper correto da coluna
                $col .= "<ul class=\"list-ver\">";

                foreach ($items as $prod) {

                    // Imagem fallback
                    $imgRelative = ltrim($prod['image'], '/');
                    $imgPath     = FCPATH . $imgRelative;
                    $img         = file_exists($imgPath) ? base_url($imgRelative) : $placeholder;

                    $col .= <<<HTML
            <li class="prd-recent hover-img">
              

                <div class="content">
                    <span class="badge-tag">{$prod['category']}</span>

                    <a href="{$prod['url']}" class="name-prd h6 fw-medium link">
                        {$prod['name']}
                    </a>

                    <span class="price-wrap h6 fw-semibold text-black">
                        {$prod['price']}
                    </span>
                </div>
            </li>

            <li class="br-line"></li>
        HTML;
                }

                $col .= "</ul>";
                break;



            case 3:
                $items = json_decode($child['block_data'], true);
                $col  .= "<div class=\"mega-spot\">";

                foreach ($items as $spot) {

                    $img = !empty($spot['image']) ? $spot['image'] : $placeholder;

                    $col .= <<<HTML
                        <div class="spot-item">
                            <img src="{$img}" alt="">
                            <div class="label">{$spot['label']}</div>
                            <a class="cta" href="{$spot['url']}">{$spot['cta']}</a>
                        </div>
                    HTML;
                }

                $col .= "</div>";
                break;

            /* =======================================================
             *  LISTA NORMAL (LINKS DE SUBMENUS)
             * ======================================================= */
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

        $col .= "</div></div>"; // fecha coluna e bloco
        $html .= $col;
    }

    $html .= "</div></div></div>"; // fecha mega wrapper
    return $html;
}
