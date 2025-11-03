<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Admin\Marketing\CampaignModel;
use App\Models\Admin\Marketing\CampaignProductModel;
use App\Models\Admin\Marketing\CampaignCategoryModel;
use App\Models\Admin\Marketing\CampaignGroupModel;
use App\Models\Admin\Marketing\CampaignBrandModel;

class CampaignsController extends BaseController
{
    protected $campaignModel;
    protected $campaignProductModel;
    protected $campaignCategoryModel;
    protected $campaignGroupModel;
    protected $campaignBrandModel;

    public function __construct()
    {
        $this->campaignModel        = new CampaignModel();
        $this->campaignProductModel = new CampaignProductModel();
        $this->campaignCategoryModel = new CampaignCategoryModel();
        $this->campaignGroupModel   = new CampaignGroupModel();
        $this->campaignBrandModel   = new CampaignBrandModel();
    }
    public function index()
    {
        $kpi = [
            'total'         => $this->campaignModel->countAllResults(),
            'active'        => $this->campaignModel->where('status', 'active')->countAllResults(true),
            'inactive'      => $this->campaignModel->where('status', 'inactive')->countAllResults(true),
            'running'       => $this->campaignModel
                ->where('status', 'active')
                ->where('start_date <=', date('Y-m-d'))
                ->where('end_date >=', date('Y-m-d'))
                ->countAllResults(true),
            'upcoming'      => $this->campaignModel
                ->where('start_date >', date('Y-m-d'))
                ->countAllResults(true),
            'expired'       => $this->campaignModel
                ->where('end_date <', date('Y-m-d'))
                ->countAllResults(true),
            'last_30_days'  => $this->campaignModel
                ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                ->countAllResults(true),
        ];
        $campaigns = $this->campaignModel->orderBy('created_at', 'DESC')->findAll();
        return view('admin/marketing/campaigns/index', [
            'kpi' => $kpi,
            'campaigns' => $campaigns,
        ]);
    }
    public function store()
    {
        $data = $this->request->getJSON(true);
        if (! $this->campaignModel->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->campaignModel->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = $this->campaignModel->getInsertID();
        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Campanha criada com sucesso!',
            'id'       => $id,
            'redirect' => base_url('admin/marketing/campaigns/edit/' . $id),
            'csrf'     => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function edit($id = null)
    {
        if (!$id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Campanha não encontrada.');
        }
        $campaign = $this->campaignModel->find($id);
        if (!$campaign) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Campanha #$id não encontrada.");
        }
        $campaign['categories'] = array_map(static function ($row) {
            return [
                'id'      => (int) $row['category_id'],
                'name'    => 'Categoria #' . $row['category_id'],
                'include' => (bool) ($row['include'] ?? 1),
            ];
        }, $this->campaignCategoryModel->where('campaign_id', $id)->findAll());

        $categoriesJSON = htmlspecialchars(
            json_encode($campaign['categories'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ENT_QUOTES,
            'UTF-8'
        );
        $campaign['products'] = array_map(static function ($row) {
            return [
                'id'      => (int) $row['product_id'],
                'name'    => 'Produto #' . $row['product_id'],
                'include' => (bool) ($row['include'] ?? 1),
            ];
        }, $this->campaignProductModel->where('campaign_id', $id)->findAll());
        $productsJSON = htmlspecialchars(
            json_encode($campaign['products'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ENT_QUOTES,
            'UTF-8'
        );
        $campaign['groups'] = array_map(static function ($row) {
            return [
                'id'      => (int) $row['group_id'],
                'name'    => 'Grupo #' . $row['group_id'],
            ];
        }, $this->campaignGroupModel->where('campaign_id', $id)->findAll());
        $campaign['brands'] = array_map(static function ($row) {
            return [
                'id'      => (int) $row['brand_id'],
                'name'    => 'Marca #' . $row['brand_id'],
            ];
        }, $this->campaignBrandModel->where('campaign_id', $id)->findAll());
        $categories = $this->campaignCategoryModel
            ->select('category_id')
            ->where('deleted_at', null)
            ->findAll();
        $products = $this->campaignProductModel
            ->select('product_id, variant_id')
            ->where('deleted_at', null)
            ->findAll();
        $groups = $this->campaignGroupModel
            ->select('group_id')
            ->where('deleted_at', null)
            ->findAll();
        $brands = $this->campaignBrandModel
            ->select('brand_id')
            ->where('deleted_at', null)
            ->findAll();
        return view('admin/marketing/campaigns/edit', [
            'campaign'       => $campaign,
            'categories'     => $categories,
            'products'       => $products,
            'groups'         => $groups,
            'brands'         => $brands,
            'categoriesJSON' => $categoriesJSON,
            'productsJSON'   => $productsJSON,
        ]);
    }
    public function update()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID da campanha não enviado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = (int) $data['id'];
        unset($data['id']);
        $data['status']         = $data['status'] ?? 'inactive';
        $data['discount_value'] = isset($data['discount_value']) ? (float) $data['discount_value'] : 0.0;

        // Validação dinâmica (nome único por exemplo)
        $this->campaignModel->setValidationRule(
            'name',
            "required|min_length[3]|is_unique[campaigns.name,id,{$id}]"
        );
        // Atualiza a campanha
        if (!$this->campaignModel->update($id, $data)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'errors'  => $this->campaignModel->errors(),
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Campanha atualizada com sucesso!',
            'id'      => $id,
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }


}
