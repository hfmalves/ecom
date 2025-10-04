<?php

namespace App\Controllers\Admin\Configurations\Users;

use App\Controllers\BaseController;

class UsersController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/users/index');
    }
}
