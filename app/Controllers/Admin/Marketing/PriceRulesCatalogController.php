<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PriceRulesCatalogController extends BaseController
{
    public function index()
    {
        $data = [

        ];
        return view('admin/marketing/catalog-rules/index', $data);
    }
}
