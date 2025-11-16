<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use App\Models\Website\MenuModel;
use App\Models\Website\SliderModel;
use App\Models\Website\ModuleIconsModel;
class HomeController extends BaseController
{
    protected $menuModel;
    protected $sliderModel;
    protected $moduleIconsModel;

    public function __construct()
    {
        $this->menuModel   = new MenuModel();
        $this->sliderModel = new SliderModel();
        $this->moduleIconsModel = new ModuleIconsModel();
    }

    public function index()
    {
        // MENU
        $items = $this->menuModel
            ->where('is_active', 1)
            ->orderBy('parent_id ASC, sort_order ASC')
            ->findAll();

        $tree = [];
        foreach ($items as $item) {
            $tree[$item['parent_id']][] = $item;
        }

        // SLIDES
        $slides = $this->sliderModel
            ->orderBy('sort_order ASC')
            ->findAll();

        $realPath   = FCPATH . 'assets/website/uploads/slides/';
        $publicPath = 'assets/website/uploads/slides/';

        foreach ($slides as &$s) {
            $imageName = trim($s['image'] ?? '');

            $s['image'] = ($imageName && is_file($realPath . $imageName))
                ? base_url($publicPath . $imageName)
                : 'https://placehold.co/1200x600?text=Sem+Imagem';

            $s['cta_url']  = $s['cta_url']  ?: '#';
            $s['cta_text'] = $s['cta_text'] ?: 'Ver mais';
            $s['title']    = $s['title']    ?: 'Sem título';
        }

        // ICONS
        $icons = $this->moduleIconsModel
            ->where('is_active', 1)
            ->orderBy('sort_order ASC')
            ->findAll();

        return view('website/home/index', [
            'menu_tree' => $tree,
            'slides'    => $slides,
            'icons'     => $icons,
        ]);
    }
}
