<?php

namespace App\Controllers\Admin\Customers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Admin\Customers\CustomerModel;
use App\Models\Admin\Customers\CustomerAddressModel;
use App\Models\Admin\Customers\CustomerReviewModel;
use App\Models\Admin\Customers\CustomerWishlistModel;
use App\Models\Admin\Customers\CustomerGroupModel;

class CustumersController extends BaseController
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
            'total'        => $this->customerModel->countAllResults(),
            'active'       => $this->customerModel->where('is_active', 1)->countAllResults(true),
            'verified'     => $this->customerModel->where('is_verified', 1)->countAllResults(true),
            'two_factor'   => $this->customerModel->where('login_2step', 1)->countAllResults(true),
            'newsletter'   => $this->customerModel->where('newsletter_optin', 1)->countAllResults(true),
            'loyalty'      => $this->customerModel->where('loyalty_points >', 0)->countAllResults(true),
            'new_30_days'  => $this->customerModel->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))->countAllResults(true),
            'active_30_days' => $this->customerModel->where('last_login_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))->countAllResults(true),
        ];
        $customers = $this->customerModel->orderBy('created_at', 'DESC')->findAll();
        $groups    = $this->customerGroupModel->findAll();
        $groupsMap = array_column($groups, 'name', 'id');
        foreach ($customers as &$c) {
            $c['group_name'] = $groupsMap[$c['group_id']] ?? 'Sem grupo';
        }
        $data = [
            'costumers'       => $customers,
            'costumers_group' => $groups,
            'kpi'             => $kpi,
        ];
        return view('admin/customers/index', $data);
    }

    public function edit($id = null)
    {
        if ($id === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cliente não encontrado');
        }
        $customer = $this->customerModel->find($id);
        $groups = $this->customerGroupModel->findAll();
        if (!$customer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Client com ID $id não encontrado");
        }
        $data = [
            'customer' => $customer,
            'costumers_group' => $groups
        ];
        return view('admin/customers/edit', $data);
    }
    public function store()
    {
        $data = $this->request->getJSON(true);
        if (! empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $data['is_active']   = $data['is_active']   ?? 1;
        $data['is_verified'] = $data['is_verified'] ?? 0;
        $data['login_2step'] = $data['login_2step'] ?? 0;
        $this->customerModel->setValidationRule(
            'email',
            'required|valid_email|is_unique[customers.email]'
        );
        if (! $this->customerModel->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->customerModel->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = $this->customerModel->getInsertID();
        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Cliente criado com sucesso!',
            'id'       => $id,
            'redirect' => base_url('admin/customers/edit/' . $id),
            'csrf'     => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function update()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['id'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID do cliente não enviado.',
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = $data['id'];
        unset($data['id']); // não precisamos mandar o id para update()
        // Só hash se vier password
        if (! empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        // defaults
        $data['is_active']   = $data['is_active']   ?? 1;
        $data['is_verified'] = $data['is_verified'] ?? 0;
        $data['login_2step'] = $data['login_2step'] ?? 0;
        // regra dinâmica para update (ignora o email do próprio cliente)
        $this->customerModel->setValidationRule(
            'email',
            "required|valid_email|is_unique[customers.email,id,{$id}]"
        );
        if (! $this->customerModel->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->customerModel->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Cliente atualizado com sucesso!',
            'id'       => $id,
            'csrf'     => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

}
