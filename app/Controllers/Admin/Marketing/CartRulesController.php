<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use App\Models\Admin\Marketing\CartRuleModel;
use App\Models\Admin\Marketing\CartRuleCategoryModel;
use App\Models\Admin\Marketing\CartRuleProductModel;
use App\Models\Admin\Marketing\CartRuleCustomerGroupModel;

class CartRulesController extends BaseController
{
    protected $cartRuleModel;
    protected $cartRuleCategoryModel;
    protected $cartRuleProductModel;
    protected $cartRuleCustomerGroupModel;

    public function __construct()
    {
        $this->cartRuleModel = new CartRuleModel();
        $this->cartRuleCategoryModel = new CartRuleCategoryModel();
        $this->cartRuleProductModel = new CartRuleProductModel();
        $this->cartRuleCustomerGroupModel = new CartRuleCustomerGroupModel();
    }
    public function index()
    {
        $today = date('Y-m-d');
        $kpi = [
            'total' => $this->cartRuleModel->countAll(),
            'active' => (new \App\Models\Admin\Marketing\CartRuleModel())
                ->where('status', 1)
                ->countAllResults(),
            'inactive' => (new \App\Models\Admin\Marketing\CartRuleModel())
                ->where('status', 0)
                ->countAllResults(),
            'running' => (new \App\Models\Admin\Marketing\CartRuleModel())
                ->where('status', 1)
                ->where('start_date <=', $today)
                ->where('end_date >=', $today)
                ->countAllResults(),
            'upcoming' => (new \App\Models\Admin\Marketing\CartRuleModel())
                ->where('start_date >', $today)
                ->countAllResults(),
            'expired' => (new \App\Models\Admin\Marketing\CartRuleModel())
                ->where('end_date <', $today)
                ->countAllResults(),
            'last_30_days' => (new \App\Models\Admin\Marketing\CartRuleModel())
                ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                ->countAllResults(),
            'modified_30_days' => (new \App\Models\Admin\Marketing\CartRuleModel())
                ->where('updated_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                ->countAllResults(),
        ];
        $rules = $this->cartRuleModel->findAll();
        foreach ($rules as &$rule) {
            $cats  = $this->cartRuleCategoryModel->where('rule_id', $rule['id'])->findAll();
            $prods = $this->cartRuleProductModel->where('rule_id', $rule['id'])->findAll();
            $grps  = $this->cartRuleCustomerGroupModel->where('rule_id', $rule['id'])->findAll();
            $rule['include_categories'] = array_column($cats, 'include');
            $rule['include_products']   = array_column($prods, 'include');
            $rule['include_groups']     = array_column($grps, 'include');
            if (!empty($rule['end_date'])) {
                $expiresAt = new \DateTime($rule['end_date']);
                $now = new \DateTime();
                $interval = $now->diff($expiresAt);
                $rule['days_left'] = $expiresAt < $now ? 0 : $interval->days;
            } else {
                $rule['days_left'] = null;
            }
            if (!empty($rule['end_date']) && $expiresAt < $now) {
                $rule['status_label'] = 'Expirada';
                $rule['status_class'] = 'danger';
            } elseif (!$rule['status']) {
                $rule['status_label'] = 'Inativa';
                $rule['status_class'] = 'secondary';
            } else {
                $rule['status_label'] = 'Ativa';
                $rule['status_class'] = 'success';
            }
        }
        return view('admin/marketing/cart-rules/index', [
            'rules' => $rules,
            'kpi'   => $kpi,
        ]);
    }
    public function edit($id = null)
    {
        if (!$id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Regra não encontrada.');
        }

        $rule = $this->cartRuleModel->find($id);
        if (!$rule) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Regra #$id não encontrada.");
        }

        // --- Categorias associadas
        $rule['categories'] = array_map(static function ($row) {
            return [
                'id'      => (int) $row['category_id'],
                'name'    => 'Categoria #' . $row['category_id'],
                'include' => (bool) ($row['include'] ?? 1),
            ];
        }, $this->cartRuleCategoryModel->where('rule_id', $id)->findAll());

        $categoriesJSON = htmlspecialchars(
            json_encode($rule['categories'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ENT_QUOTES,
            'UTF-8'
        );

        // --- Produtos associados
        $rule['products'] = array_map(static function ($row) {
            return [
                'id'      => (int) $row['product_id'],
                'name'    => 'Produto #' . $row['product_id'],
                'include' => (bool) ($row['include'] ?? 1),
            ];
        }, $this->cartRuleProductModel->where('rule_id', $id)->findAll());

        $productsJSON = htmlspecialchars(
            json_encode($rule['products'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ENT_QUOTES,
            'UTF-8'
        );

        // --- Grupos de clientes associados
        $rule['groups'] = array_map(static function ($row) {
            return [
                'id'      => (int) $row['customer_group_id'],
                'name'    => 'Grupo #' . $row['customer_group_id'],
                'include' => (bool) ($row['include'] ?? 1),
            ];
        }, $this->cartRuleCustomerGroupModel->where('rule_id', $id)->findAll());

        $groupsJSON = htmlspecialchars(
            json_encode($rule['groups'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ENT_QUOTES,
            'UTF-8'
        );

        // --- Listas disponíveis para associar
        $products = $this->cartRuleProductModel
            ->select('product_id')
            ->where('deleted_at', null)
            ->findAll();

        $categories = $this->cartRuleCategoryModel
            ->select('category_id')
            ->where('deleted_at', null)
            ->findAll();

        $groups = $this->cartRuleCustomerGroupModel
            ->select('customer_group_id')
            ->where('deleted_at', null)
            ->findAll();

        // --- Renderiza a view
        return view('admin/marketing/cart-rules/edit', [
            'rule'           => $rule,
            'products'       => $products,
            'categories'     => $categories,
            'groups'         => $groups,
            'categoriesJSON' => $categoriesJSON,
            'productsJSON'   => $productsJSON,
            'groupsJSON'     => $groupsJSON,
        ]);
    }

    public function store()
    {
        $data = $this->request->getJSON(true);
        if (! $this->cartRuleModel->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->cartRuleModel->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = $this->cartRuleModel->getInsertID();
        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Regra de carrinho criada com sucesso!',
            'id'       => $id,
            'redirect' => base_url('admin/marketing/cart-rules/edit/' . $id),
            'csrf'     => [
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
                'message' => 'ID da regra não especificado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = (int)$data['id'];
        $rule = $this->cartRuleModel->find($id);
        if (! $rule) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Regra não encontrada.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        if (! $this->cartRuleModel->delete($id)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Falha ao eliminar a regra.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Regra eliminada com sucesso!',
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
                'message' => 'ID da regra não especificado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = (int)$data['id'];
        $rule = $this->cartRuleModel->find($id);
        if (! $rule) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Regra não encontrada.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $newStatus = (int)!$rule['status']; // alterna entre 1 e 0
        $statusLabel = $newStatus ? 'ativada' : 'desativada';
        if (! $this->cartRuleModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Falha ao alterar o estado da regra.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => "Regra {$statusLabel} com sucesso!",
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }


    public function addCategory()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['rule_id']) || empty($data['category_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Regra ou categoria não especificada.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $include = isset($data['include']) ? (int)$data['include'] : 1;

        $this->cartRuleCategoryModel->insert([
            'rule_id'     => $data['rule_id'],
            'category_id' => $data['category_id'],
            'include'     => $include,
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Categoria associada à regra com sucesso.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function updateCategoryInclude()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['rule_id']) || empty($data['category_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Regra ou categoria não especificada.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $include = isset($data['include']) ? (int)$data['include'] : 1;

        $this->cartRuleCategoryModel
            ->where('rule_id', $data['rule_id'])
            ->where('category_id', $data['category_id'])
            ->set(['include' => $include])
            ->update();

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Estado de inclusão da categoria atualizado.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function deleteCategory()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['rule_id']) || empty($data['category_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Regra ou categoria não especificada.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $this->cartRuleCategoryModel
            ->where('rule_id', $data['rule_id'])
            ->where('category_id', $data['category_id'])
            ->delete();

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Categoria removida da regra.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

    public function addProduct()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['rule_id']) || empty($data['product_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Regra ou produto não especificado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $include = isset($data['include']) ? (int)$data['include'] : 1;

        $this->cartRuleProductModel->insert([
            'rule_id'    => $data['rule_id'],
            'product_id' => $data['product_id'],
            'include'    => $include,
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Produto associado à regra com sucesso.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function updateProductInclude()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['rule_id']) || empty($data['product_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Regra ou produto não especificado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $include = isset($data['include']) ? (int)$data['include'] : 1;

        $this->cartRuleProductModel
            ->where('rule_id', $data['rule_id'])
            ->where('product_id', $data['product_id'])
            ->set(['include' => $include])
            ->update();

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Estado de inclusão do produto atualizado.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function deleteProduct()
    {
        $data = $this->request->getJSON(true);

        if (emty($data['rule_id']) || empty($data['product_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Regra ou produto não especificado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $this->cartRuleProductModel
            ->where('rule_id', $data['rule_id'])
            ->where('product_id', $data['product_id'])
            ->delete();
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Produto removido da regra.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

    public function addGroup()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['rule_id']) || empty($data['customer_group_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Regra ou grupo de cliente não especificado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $include = isset($data['include']) ? (int)$data['include'] : 1;
        $this->cartRuleCustomerGroupModel->insert([
            'rule_id'          => $data['rule_id'],
            'customer_group_id'=> $data['customer_group_id'],
            'include'          => $include,
        ]);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Grupo de cliente associado à regra com sucesso.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function updateGroupInclude()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['rule_id']) || empty($data['customer_group_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Regra ou grupo de cliente não especificado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $include = isset($data['include']) ? (int)$data['include'] : 1;
        $this->cartRuleCustomerGroupModel
            ->where('rule_id', $data['rule_id'])
            ->where('customer_group_id', $data['customer_group_id'])
            ->set(['include' => $include])
            ->update();
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Estado de inclusão do grupo de cliente atualizado.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function deleteGroup()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['rule_id']) || empty($data['customer_group_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Regra ou grupo de cliente não especificado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $this->cartRuleCustomerGroupModel
            ->where('rule_id', $data['rule_id'])
            ->where('customer_group_id', $data['customer_group_id'])
            ->delete();
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Grupo de cliente removido da regra.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }



}
