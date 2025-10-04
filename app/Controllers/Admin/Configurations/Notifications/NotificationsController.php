<?php

namespace App\Controllers\Admin\Configurations\Notifications;

use App\Controllers\BaseController;

class NotificationsController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/notifications/index');
    }
}
