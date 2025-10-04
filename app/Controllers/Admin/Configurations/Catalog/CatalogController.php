<?php

namespace App\Controllers\Admin\Configurations\Catalog;

use App\Controllers\BaseController;

class CatalogController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/catalog/index');
    }
}
