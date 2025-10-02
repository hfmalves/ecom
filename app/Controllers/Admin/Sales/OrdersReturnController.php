<?php

namespace App\Controllers\Admin\Sales;

use App\Controllers\BaseController;
use App\Models\Admin\Customers\CustomerModel;
use App\Models\Admin\Sales\OrdersItemsModel;
use App\Models\Admin\Sales\OrdersModel;
use App\Models\Admin\Sales\OrdersReturnItemsModel;
use App\Models\Admin\Sales\OrdersReturnsModel;
use CodeIgniter\HTTP\ResponseInterface;

class OrdersReturnController extends BaseController
{
    protected $returnsModel;
    protected $returnItemsModel;
    protected $ordersModel;
    protected $ordersItemsModel;
    protected $customerModel;

    public function __construct()
    {
        $this->returnsModel      = new OrdersReturnsModel();
        $this->returnItemsModel  = new OrdersReturnItemsModel();
        $this->ordersModel       = new OrdersModel();
        $this->ordersItemsModel  = new OrdersItemsModel();
        $this->customerModel     = new CustomerModel();
    }

    public function index()
    {
        $returns = $this->returnsModel->findAll();
        $orders    = array_column($this->ordersModel->findAll(), null, 'id');
        $customers = array_column($this->customerModel->findAll(), null, 'id');
        $items     = $this->ordersItemsModel->findAll();
        $returnItems = $this->returnItemsModel->findAll();
        $mapReturnItems = [];
        foreach ($returnItems as $ri) {
            $mapReturnItems[$ri['rma_request_id']][] = $ri;
        }
        foreach ($returns as &$r) {
            $r['order']    = $orders[$r['order_id']] ?? null;
            $r['customer'] = $customers[$r['customer_id']] ?? null;
            $r['items']    = $mapReturnItems[$r['id']] ?? [];
        }
        return view('admin/sales/returns/index', [
            'returns' => $returns
        ]);
    }
}
