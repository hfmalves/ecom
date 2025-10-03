<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use App\Models\Admin\Marketing\CartRuleModel;
use App\Models\Admin\Marketing\CartRuleCategoryModel;
use App\Models\Admin\Marketing\CartRuleProductModel;
use App\Models\Admin\Marketing\CartRuleCustomerGroupModel;
use App\Models\Admin\Marketing\CartRuleCouponModel;

class CartRulesController extends BaseController
{
    public function index()
    {
        $ruleModel     = new CartRuleModel();
        $categoryModel = new CartRuleCategoryModel();
        $productModel  = new CartRuleProductModel();
        $groupModel    = new CartRuleCustomerGroupModel();
        $couponModel   = new CartRuleCouponModel();

        $rules = $ruleModel->findAll();

        foreach ($rules as &$rule) {
            $rule['categories'] = $categoryModel->where('rule_id', $rule['id'])->findAll();
            $rule['products']   = $productModel->where('rule_id', $rule['id'])->findAll();
            $rule['groups']     = $groupModel->where('rule_id', $rule['id'])->findAll();
            $rule['coupons']    = $couponModel->where('rule_id', $rule['id'])->findAll();
        }

        return view('admin/marketing/cart-rules/index', [
            'rules' => $rules
        ]);
    }
}
