<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Admin\Marketing\CampaignModel;
use App\Models\Admin\Marketing\CampaignProductModel;

class CampaignsController extends BaseController
{
    protected $campaignModel;
    protected $campaignProductModel;

    public function __construct()
    {
        $this->campaignModel = new CampaignModel();
        $this->campaignProductModel = new CampaignProductModel();
    }
    public function index()
    {
        $campaigns = $this->campaignModel->findAll();
        $data = [
            'campaigns' => $campaigns
        ];
        return view('admin/marketing/campaigns/index', $data);
    }
}
