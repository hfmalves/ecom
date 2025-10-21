<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\BrandsModel;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\SuppliersModel;
class BrandsController extends BaseController
{
    protected $brands;
    protected $products;
    protected $suppliers;

    public function __construct()
    {
        $this->brands = new BrandsModel();
        $this->products = new ProductsModel();
        $this->suppliers = new SuppliersModel();
    }
    public function index()
    {
        $brands = $this->brands->findAll();
        foreach ($brands as &$brand) {
            // total de produtos associados
            $brand['product_count'] = $this->products
                ->where('brand_id', $brand['id'])
                ->countAllResults();
            $supplier = $this->suppliers
                ->select('name')
                ->where('id', $brand['supplier_id'])
                ->get()
                ->getRowArray();
            $brand['supplier_name'] = $supplier['name'] ?? '—';
        }
        $totalBrands     = count($brands);
        $activeBrands    = array_sum(array_column($brands, 'is_active'));
        $featuredBrands  = array_sum(array_column($brands, 'featured'));
        $totalProducts   = $this->products->countAllResults();
        $data = [
            'brands' => $brands,
            'kpi' => [
                'total'     => $totalBrands,
                'active'    => $activeBrands,
                'featured'  => $featuredBrands,
                'products'  => $totalProducts,
            ],
        ];
        return view('admin/catalog/brands/index', $data);
    }
    public function store()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['is_active'])) {
            $data['is_active'] = '1';
        }
        if (empty($data['slug']) && ! empty($data['name'])) {
            helper('text'); // garante que o helper está carregado
            $data['slug'] = url_title(convert_accented_characters($data['name']), '-', true);
        }
        if (! $this->brands->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->brands->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = $this->brands->getInsertID();
        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Marca criado com sucesso!',
            'id'       => $id,
            'redirect' => base_url('admin/catalog/brands/edit/'.$id),
            'csrf'     => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function edit($id = null)
    {
        if ($id === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Marca não encontrada');
        }
        $brand = $this->brands->find($id);
        if (!$brand) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Marca com ID {$id} não encontrada");
        }
        $suppliers = $this->suppliers
            ->select('id, name')
            ->orderBy('name', 'ASC')
            ->findAll();
        $data = [
            'brands'    => $brand,
            'suppliers' => $suppliers,
        ];
        return view('admin/catalog/brands/edit', $data);
    }
    public function update()
    {
        $data = $this->request->getJSON(true);
        $id   = $data['id'] ?? null;

        if (! $id || ! $this->brands->find($id)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Marca não encontrada.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $this->brands->setValidationRule(
            'name',
            "required|min_length[2]|max_length[150]|is_unique[brands.name,id,{$id}]"
        );
        $this->brands->setValidationRule(
            'slug',
            "required|min_length[2]|max_length[150]|is_unique[brands.slug,id,{$id}]"
        );
        if (! $this->brands->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->brands->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Marca atualizada com sucesso!',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function uploadLogo()
    {
        $file = $this->request->getFile('file');
        $brandId = $this->request->getPost('brand_id');
        if (! $file || ! $file->isValid()) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Ficheiro inválido ou não enviado.',
            ]);
        }
        $validTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (! in_array($file->getMimeType(), $validTypes)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Formato de imagem inválido. Apenas JPG, PNG ou WEBP são permitidos.',
            ]);
        }
        $uploadPath = FCPATH . 'uploads/brands/';
        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        $newName = 'brand_' . time() . '_' . bin2hex(random_bytes(3)) . '.' . $file->getExtension();
        if (! $file->move($uploadPath, $newName)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Falha ao mover o ficheiro.',
            ]);
        }
        if ($brandId) {
            $this->brands->update($brandId, ['logo' => $newName]);
        }
        return $this->response->setJSON([
            'status'    => 'success',
            'message'   => 'Logo carregado com sucesso!',
            'url'       => base_url('uploads/brands/' . $newName),
            'filename'  => $newName,
        ]);
    }


    public function deleteLogo()
    {
        $data = $this->request->getJSON(true);
        $fileUrl = $data['file'] ?? '';
        $brandId = $data['brand_id'] ?? null;

        if (empty($fileUrl)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'URL do ficheiro não recebido.',
            ]);
        }

        // Extrai o caminho físico correto
        $filePath = FCPATH . str_replace(base_url(), '', $fileUrl);

        if (is_file($filePath)) {
            unlink($filePath);

            // Atualiza o campo no model, se tiver ID
            if ($brandId) {
                $this->brands->update($brandId, ['logo' => null]);
            }

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Logo removido com sucesso!',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Ficheiro não encontrado.',
        ]);
    }



}