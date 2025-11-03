<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use App\Models\Admin\Marketing\Coupons;
use App\Models\Admin\Marketing\CouponsUsagesModel;
use App\Models\Admin\Marketing\CouponsCategoryModel;
use App\Models\Admin\Marketing\CouponsCustomerGroupModel;
use App\Models\Admin\Marketing\CouponsProductModel;
use App\Models\Admin\Customers\CustomerGroupModel;

use CodeIgniter\HTTP\ResponseInterface;

class CouponsController extends BaseController
{

    protected $coupons;
    protected $couponsUsages;
    protected $couponsCategoryModel;
    protected $couponsCustomerGroupModel;
    protected $couponsProductModel;

    protected $customerGroupModel;
    public function __construct()
    {
        $this->coupons = new Coupons();
        $this->couponsUsages = new CouponsUsagesModel();
        $this->couponsCategoryModel = new CouponsCategoryModel();
        $this->couponsCustomerGroupModel = new CouponsCustomerGroupModel();
        $this->couponsProductModel = new CouponsProductModel();
        $this->customerGroupModel = new CustomerGroupModel();
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
    public function edit($id = null)
    {
        if (!$id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cupão não encontrado.');
        }
        $coupon = $this->coupons->find($id);
        if (!$coupon) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Cupão #$id não encontrado.");
        }
        $coupon['categories'] = array_map(static function ($row) {
            return [
                'id'      => (int) $row['category_id'],
                'name'    => 'Categoria #' . $row['category_id'],
                'include' => (bool) ($row['include'] ?? 1),
            ];
        }, $this->couponsCategoryModel->where('coupon_id', $id)->findAll());
        $categoriesJSON = htmlspecialchars(
            json_encode($coupon['categories'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ENT_QUOTES,
            'UTF-8'
        );
        $coupon['products'] = array_map(static function ($row) {
            return [
                'id'      => (int) $row['product_id'],
                'name'    => 'Produto #' . $row['product_id'],
                'include' => (bool) ($row['include'] ?? 1),
            ];
        }, $this->couponsProductModel->where('coupon_id', $id)->findAll());
        $productsJSON = htmlspecialchars(
            json_encode($coupon['products'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ENT_QUOTES,
            'UTF-8'
        );
        $coupon['groups'] = $this->couponsCustomerGroupModel
            ->where('coupon_id', $id)
            ->findAll();
        $customerGroups = $this->customerGroupModel
            ->select('id, name')
            ->findAll();
        $products = $this->couponsProductModel
            ->select('product_id, variant_id')
            ->where('deleted_at', null)
            ->findAll();
        $categories = $this->couponsCategoryModel
            ->select('category_id')
            ->where('deleted_at', null)
            ->findAll();
        return view('admin/marketing/coupons/edit', [
            'coupon'         => $coupon,
            'customerGroups' => $customerGroups,
            'products'       => $products,
            'categories'     => $categories,
            'categoriesJSON' => $categoriesJSON,
            'productsJSON'   => $productsJSON,
        ]);
    }

    public function update()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID do cupão não enviado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $id = (int) $data['id'];
        unset($data['id']); // não é necessário no update()

        // Definições por omissão
        $data['is_active'] = isset($data['is_active']) ? (int) $data['is_active'] : 1;
        $data['stackable'] = isset($data['stackable']) ? (int) $data['stackable'] : 0;
        $data['value']     = isset($data['value']) ? (float) $data['value'] : 0.0;

        // Validação dinâmica — código deve ser único (exceto o próprio cupão)
        $this->coupons->setValidationRule(
            'code',
            "required|min_length[3]|is_unique[coupons.code,id,{$id}]"
        );

        // Atualizar
        if (! $this->coupons->update($id, $data)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'errors'  => $this->coupons->errors(),
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Cupão atualizado com sucesso!',
            'id'      => $id,
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

    public function addCategory()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['coupon_id']) || empty($data['category_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Cupão ou categoria não especificado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $include = isset($data['include']) ? (int)$data['include'] : 1;

        $this->couponsCategoryModel->insert([
            'coupon_id'   => $data['coupon_id'],
            'category_id' => $data['category_id'],
            'include'     => $include,
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Categoria associada ao cupão com sucesso.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function updateCategoryInclude()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['coupon_id']) || empty($data['category_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Cupão ou categoria não especificado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $include = isset($data['include']) ? (int)$data['include'] : 1;

        $this->couponsCategoryModel
            ->where('coupon_id', $data['coupon_id'])
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

        if (empty($data['coupon_id']) || empty($data['category_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Cupão ou categoria não especificado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $this->couponsCategoryModel
            ->where('coupon_id', $data['coupon_id'])
            ->where('category_id', $data['category_id'])
            ->delete();

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Categoria removida do cupão.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

    public function addProduct()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['coupon_id']) || empty($data['product_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Cupão ou produto não especificado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $include = isset($data['include']) ? (int)$data['include'] : 1;

        $this->couponsProductModel->insert([
            'coupon_id'  => $data['coupon_id'],
            'product_id' => $data['product_id'],
            'include'    => $include,
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Produto associado ao cupão com sucesso.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function updateProductInclude()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['coupon_id']) || empty($data['product_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Cupão ou produto não especificado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $include = isset($data['include']) ? (int)$data['include'] : 1;

        $this->couponsProductModel
            ->where('coupon_id', $data['coupon_id'])
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

        if (empty($data['coupon_id']) || empty($data['product_id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Cupão ou produto não especificado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $this->couponsProductModel
            ->where('coupon_id', $data['coupon_id'])
            ->where('product_id', $data['product_id'])
            ->delete();

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Produto removido do cupão.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

}
