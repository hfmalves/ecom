<?php

namespace App\Controllers\Admin\Reports\Inventory;

use App\Controllers\BaseController;

class InventoryController extends BaseController
{
    public function index()
    {
        return view('admin/reports/Inventory/index');
    }
}
