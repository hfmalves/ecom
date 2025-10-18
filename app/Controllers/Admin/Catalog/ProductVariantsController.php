<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\ProductsVariantsModel;
use App\Models\Admin\Catalog\ProductsVariantsAttributes;

use App\Models\Admin\Catalog\ProductsAttributesModel;
use App\Models\Admin\Catalog\ProductsAttributesValuesModel;

class ProductVariantsController extends BaseController
{
    protected $productsVariants;
    protected $productsVariantsAttributes;
    protected  $productsAttributes;
    protected  $productsAttributesValues;
    public function __construct()
    {
        $this->productsVariants = new ProductsVariantsModel();
        $this->productsVariantsAttributes = new ProductsVariantsAttributes();
        $this->productsAttributes = new ProductsAttributesModel();
        $this->productsAttributesValues = new ProductsAttributesValuesModel();
    }

    public function update()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)
                ->setJSON(['success' => false, 'message' => 'Acesso inválido.']);
        }

        $input = $this->request->getJSON(true);
        $id = (int) ($input['id'] ?? 0);

        if ($id <= 0) {
            return $this->response->setStatusCode(400)
                ->setJSON(['success' => false, 'message' => 'ID da variante em falta.']);
        }

        // Remove o token CSRF e outros campos desnecessários
        unset($input['csrf_test_name'], $input['csrf_token_name']);

        // Garante que updated_at é atualizado
        $input['updated_at'] = date('Y-m-d H:i:s');

        try {
            $updated = $this->productsVariants->update($id, $input);

            if (!$updated) {
                return $this->response->setJSON([
                    'success'   => false,
                    'message'   => 'Falha ao atualizar variante.',
                    'errors'    => $this->variants->errors(),
                    'lastQuery' => (string) $this->variants->db->getLastQuery(),
                    'csrf'      => csrf_hash(),
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Variante atualizada com sucesso!',
                'data'    => $input,
                'csrf'    => csrf_hash(),
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'message' => 'Erro interno: ' . $e->getMessage(),
                ]);
        }
    }

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)
                ->setJSON(['success' => false, 'message' => 'Acesso inválido.']);
        }
        $id = (int) $id;
        if ($id <= 0) {
            return $this->response->setStatusCode(400)
                ->setJSON(['success' => false, 'message' => 'ID da variante em falta.']);
        }
        try {
            $variant = $this->productsVariants->find($id);
            if (!$variant) {
                return $this->response->setStatusCode(404)
                    ->setJSON(['success' => false, 'message' => 'Variante não encontrada.']);
            }
            $this->productsVariants->delete($id);
            if ($this->productsVariants->db->affectedRows() === 0) {
                return $this->response->setStatusCode(500)
                    ->setJSON(['success' => false, 'message' => 'Falha ao eliminar a variante.']);
            }
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Variante eliminada com sucesso.',
                'id'      => $id,
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'message' => 'Erro interno: ' . $e->getMessage(),
                ]);
        }
    }
    public function create()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)
                ->setJSON(['success' => false, 'message' => 'Acesso inválido.']);
        }
        $input = $this->request->getJSON(true);
        $productId = (int) ($input['product_id'] ?? 0);
        $attributes = $input['attributes'] ?? [];
        $skuBase = trim($input['sku_base'] ?? '');
        if ($productId <= 0 || empty($attributes)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Produto ou atributos inválidos.'
            ]);
        }
        $attrIds = array_values($attributes);
        sort($attrIds);
        $comboKey = implode('-', $attrIds);
        $existing = $this->productsVariantsAttributes
            ->select('variant_id')
            ->join('products_variants v', 'v.id = products_variant_attributes.variant_id')
            ->where('v.product_id', $productId)
            ->findAll();
        $existingCombos = [];
        foreach ($existing as $row) {
            $vals = $this->productsVariantsAttributes
                ->where('variant_id', $row['variant_id'])
                ->findColumn('attribute_value_id');
            if ($vals) {
                sort($vals);
                $existingCombos[] = implode('-', $vals);
            }
        }
        if (in_array($comboKey, $existingCombos)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Já existe uma variante com esta combinação de atributos.'
            ]);
        }
        $sku = $skuBase ?: 'VAR-' . strtoupper(uniqid());
        $sku .= '-' . implode('', $attrIds);
        $dups = $this->productsVariants
            ->groupStart()
            ->where('sku', $sku)
            ->orWhere('ean', $sku)
            ->orWhere('upc', $sku)
            ->orWhere('isbn', $sku)
            ->orWhere('gtin', $sku)
            ->groupEnd()
            ->findAll();
        if (!empty($dups)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Já existe uma variante com o mesmo SKU/EAN/UPC/ISBN/GTIN.'
            ]);
        }
        $dataVariant = [
            'product_id'      => $productId,
            'sku'             => $sku,
            'price'           => 0.00,
            'cost_price'      => 0.00,
            'base_price'      => 0.00,
            'base_price_tax'  => 0.00,
            'stock_qty'       => 0,
            'manage_stock'    => 1,
            'status'          => 1,
            'is_default'      => 0,
            'created_at'      => date('Y-m-d H:i:s'),
        ];
        $this->productsVariants->setValidationRule('id', 'permit_empty|integer');

        $variantId = $this->productsVariants->insert($dataVariant, true);
        if (!$variantId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Falha ao criar variante.',
                'errors'  => $this->productsVariants->errors(),
            ]);
        }
        foreach ($attrIds as $valId) {
            $this->productsVariantsAttributes->insert([
                'variant_id'         => $variantId,
                'attribute_value_id' => $valId
            ]);
        }
        $newVariant = $this->productsVariants->find($variantId);
        $newVariant['attributes'] = $attrIds;
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Variante criada com sucesso!',
            'variant' => $newVariant,
            'csrf'    => csrf_hash(),
        ]);
    }



}
