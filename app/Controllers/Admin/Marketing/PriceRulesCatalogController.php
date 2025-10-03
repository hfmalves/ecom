<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use App\Models\Admin\Marketing\CatalogRuleModel;
use App\Models\Admin\Marketing\CatalogRuleCategoryModel;
use App\Models\Admin\Marketing\CatalogRuleProductModel;
use App\Models\Admin\Marketing\CatalogRuleCustomerGroupModel;

class PriceRulesCatalogController extends BaseController
{
    public function index()
    {
        $ruleModel     = new CatalogRuleModel();
        $categoryModel = new CatalogRuleCategoryModel();
        $productModel  = new CatalogRuleProductModel();
        $groupModel    = new CatalogRuleCustomerGroupModel();

        // Busca todas as regras
        $rules = $ruleModel->findAll();

        // Junta informações auxiliares
        foreach ($rules as &$rule) {
            $rule['categories'] = $categoryModel
                ->where('rule_id', $rule['id'])
                ->findAll();

            $rule['products'] = $productModel
                ->where('rule_id', $rule['id'])
                ->findAll();

            $rule['groups'] = $groupModel
                ->where('rule_id', $rule['id'])
                ->findAll();
        }
        $data = [
            'rules' => $rules,
        ];

        return view('admin/marketing/catalog-rules/index', $data);
    }
}
