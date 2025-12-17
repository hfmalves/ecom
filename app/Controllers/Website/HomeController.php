<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;

use App\Models\Website\HomeModel;
use App\Models\Website\HomeBlockModel;
use App\Models\Website\BlockHeroModel;
use App\Models\Website\BlockHeroSlideModel;
use App\Models\Website\BlockGridBannerModel;
use App\Models\Website\BlockGridBannerItemModel;

class HomeController extends BaseController
{
    protected HomeModel $homeModel;
    protected HomeBlockModel $homeBlockModel;

    public function __construct()
    {
        $this->homeModel      = new HomeModel();
        $this->homeBlockModel = new HomeBlockModel();
    }

    public function index()
    {
        $home = $this->homeModel
            ->where('home_code', 'default')
            ->first();
        if (!$home) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Home não encontrada');
        }
        $blocks = $this->homeBlockModel
            ->where('home_id', $home['id'])
            ->where('is_active', 1)
            ->orderBy('position', 'ASC')
            ->findAll();
        /**
         * RESOLVER BLOCOS (UM A UM)
         */
        foreach ($blocks as &$block) {
            if ($block['block_type'] === 'hero') {
                $block = $this->resolveHero($block);
            }
            if ($block['block_type'] === 'grid_banner') {
                $block = $this->resolveGridBanner($block);
            }
        }
        unset($block);
        return view('website/home/index', [
            'home'   => $home,
            'blocks' => $blocks,
        ]);
    }
    private function resolveHero(array $block): array
    {
        $heroModel  = new BlockHeroModel();
        $slideModel = new BlockHeroSlideModel();
        $block['config'] = $heroModel
            ->where('block_id', $block['id'])
            ->first();
        $block['data'] = [
            'slides' => $slideModel
                ->where('block_id', $block['id'])
                ->orderBy('position', 'ASC')
                ->findAll()
        ];
        return $block;
    }
    private function resolveGridBanner(array $block): array
    {
        $gridModel  = new BlockGridBannerModel();
        $itemModel  = new BlockGridBannerItemModel();

        $block['config'] = $gridModel
            ->where('block_id', $block['id'])
            ->first();

        $items = $itemModel
            ->where('block_id', $block['id'])
            ->where('is_active', 1)
            ->orderBy('position', 'ASC')
            ->findAll();

        $block['data'] = [
            'items' => $items,
        ];

        return $block;
    }

}
