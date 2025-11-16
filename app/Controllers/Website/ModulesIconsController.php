<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use App\Models\Website\ModuleIconsModel;

class ModulesIconsController extends BaseController
{
    public function icons()
    {
        $model = new ModuleIconsModel();

        $data['icons'] = $model
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        return view('layout/partials_website/modules/box_icons', $data);
    }
}
