<?php

namespace App\Controllers\Admin\Configurations\Integrations;

use App\Controllers\BaseController;

class IntegrationsController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/integrations/index');
    }
}
