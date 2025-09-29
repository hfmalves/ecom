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
        $customers_groups = $this->customerGroupModel->findAll();
        $data = [
            'costumers_groups' => $customers_groups
        ];
        return view('admin/customers/groups/index', $data);
    }
}
