<?php

namespace App\Controllers\Admin\Configurations\Emails;

use App\Controllers\BaseController;

class EmailsController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/emails/index');
    }
}
