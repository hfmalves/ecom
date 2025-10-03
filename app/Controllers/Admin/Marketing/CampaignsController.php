<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CampaignsController extends BaseController
{
    public function index()
    {
        return view('admin/marketing/campaigns/index');
    }
}
