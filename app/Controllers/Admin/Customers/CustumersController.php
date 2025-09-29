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
            'costumers' => $customers
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
}
