<?php

namespace App\Controllers\Admin\Customers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Admin\Customers\CustomerModel;
use App\Models\Admin\Customers\CustomerAddressModel;
use App\Models\Admin\Customers\CustomerReviewModel;
use App\Models\Admin\Customers\CustomerWishlistModel;
use App\Models\Admin\Customers\CustomerGroupModel;

class CustumersGroupsController extends BaseController
{
    protected $customerModel;
    protected $customerAddressModel;
    protected $customerReviewModel;
    protected $customerWishlistModel;
    protected $customerGroupModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->customerAddressModel = new CustomerAddressModel();
        $this->customerReviewModel = new CustomerReviewModel();
        $this->customerWishlistModel = new CustomerWishlistModel();
        $this->customerGroupModel = new CustomerGroupModel();
    }
    public function index()
    {
        $kpi = [
            'total'        => $this->customerGroupModel->countAllResults(),
            'active'       => $this->customerGroupModel->where('status', 'active')->countAllResults(true),
            'inactive'     => $this->customerGroupModel->where('status', 'inactive')->countAllResults(true),
            'defaultGroup' => $this->customerGroupModel->where('is_default', 1)->countAllResults(true),
        ];
        $customers_groups = $this->customerGroupModel->orderBy('name', 'ASC')->findAll();
        $data = [
            'costumers_groups' => $customers_groups,
            'kpi'              => $kpi,
        ];
        return view('admin/customers/groups/index', $data);
    }
    public function store()
    {
        $data = $this->request->getJSON(true);
        if (! $this->customerGroupModel->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->customerGroupModel->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Grupo de cliente criado com sucesso!',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function update()
    {
        $data = $this->request->getJSON(true);
        $id   = $data['id'] ?? null;
        if (! $id || ! $this->customerGroupModel->find($id)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Grupo de cliente não encontrado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        if (! $this->customerGroupModel->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->customerGroupModel->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Grupo de cliente atualizado com sucesso!',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function delete()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID do grupo não enviado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = $data['id'];
        if (! $this->customerGroupModel->delete($id)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Erro ao eliminar grupo de cliente.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Grupo de cliente eliminado com sucesso.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function deactivate()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID do grupo não enviado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = $data['id'];
        if (! $this->customerGroupModel->update($id, ['status' => 'inactive'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Erro ao desativar grupo de cliente.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Grupo de cliente desativado com sucesso.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
}
