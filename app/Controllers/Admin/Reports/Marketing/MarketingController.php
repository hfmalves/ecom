<?php

namespace App\Controllers\Admin\Reports\Marketing;

use App\Controllers\BaseController;

class MarketingController extends BaseController
{
    public function index()
    {
        return view('admin/reports/Marketing/index');
    }
}
