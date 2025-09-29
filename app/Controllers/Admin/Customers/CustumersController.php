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
        $customers = $this->customerModel->findAll();
        $groups = $this->customerGroupModel->findAll();
        $groupsMap = array_column($groups, 'name', 'id');
        foreach ($customers as &$c) {
            $c['group_name'] = $groupsMap[$c['group_id']] ?? 'Sem grupo';
        }
        $data = [
            'costumers' => $customers,
            'costumers_group' => $groups
        ];
        return view('admin/customers/index', $data);
    }
    public function edit($id = null)
    {
        if ($id === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cliente não encontrado');
        }
        $customer = $this->customerModel->find($id);
        if (!$customer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Client com ID $id não encontrado");
        }
        $data = [
            'customer' => $customer
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


}
