<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use App\Models\Admin\Marketing\Coupons;
use App\Models\Admin\Marketing\CouponsUsagesModel;
use App\Models\Admin\Marketing\CouponsCategoryModel;
use App\Models\Admin\Marketing\CouponsCustomerGroupModel;
use App\Models\Admin\Marketing\CouponsProductModel;

use CodeIgniter\HTTP\ResponseInterface;

class CouponsController extends BaseController
{

    protected $coupons;
    protected $couponsUsages;
    protected $couponsCategoryModel;
    protected $couponsCustomerGroupModel;
    protected $couponsProductModel;
    public function __construct()
    {
        $this->coupons = new Coupons();
        $this->couponsUsages = new CouponsUsagesModel();
        $this->couponsCategoryModel = new CouponsCategoryModel();
        $this->couponsCustomerGroupModel = new CouponsCustomerGroupModel();
        $this->couponsProductModel = new CouponsProductModel();
    }
    public function index()
    {
        $coupons = $this->coupons->findAll();

        foreach ($coupons as &$coupon) {
            // Total de usos feitos
            $coupon['usages'] = $this->couponsUsages
                ->where('coupon_id', $coupon['id'])
                ->countAllResults();

            // Produtos
            $coupon['products'] = $this->couponsProductModel
                ->where('coupon_id', $coupon['id'])
                ->findAll();

            // Categorias
            $coupon['categories'] = $this->couponsCategoryModel
                ->where('coupon_id', $coupon['id'])
                ->findAll();

            // Grupos
            $coupon['groups'] = $this->couponsCustomerGroupModel
                ->where('coupon_id', $coupon['id'])
                ->findAll();

            // Dias restantes até expirar (se tiver expires_at)
            if (!empty($coupon['expires_at'])) {
                $expiresAt = new \DateTime($coupon['expires_at']);
                $now = new \DateTime();
                $interval = $now->diff($expiresAt);
                $coupon['days_left'] = $expiresAt < $now ? 0 : $interval->days;
            } else {
                $coupon['days_left'] = null; // sem expiração
            }

            // Estado calculado
            if (!empty($coupon['expires_at']) && $expiresAt < $now) {
                $coupon['status_label'] = 'Expirado';
                $coupon['status_class'] = 'danger';
            } elseif (!$coupon['is_active']) {
                $coupon['status_label'] = 'Inativo';
                $coupon['status_class'] = 'secondary';
            } else {
                $coupon['status_label'] = 'Ativo';
                $coupon['status_class'] = 'success';
            }
        }

        return view('admin/marketing/coupons/index', [
            'coupons' => $coupons
        ]);
    }


}
