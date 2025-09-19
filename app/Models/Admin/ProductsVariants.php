<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ProductsVariants extends Model
{
    protected $table            = 'product_variants';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'product_id',
        'sku',
        'price',
        'stock_qty',
        'image',
        'is_default',
        'created_at',
        'updated_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'product_id' => 'required|integer',
        'sku'        => 'required|min_length[2]|max_length[100]|is_unique[product_variants.sku,id,{id}]',
        'price'      => 'required|decimal',
        'stock_qty'  => 'permit_empty|integer',
        'image'      => 'permit_empty|max_length[255]',
        'is_default' => 'required|in_list[0,1]',
    ];

    protected $validationMessages = [
        'product_id' => [
            'required' => 'O campo Product ID é obrigatório.',
            'integer'  => 'O Product ID deve ser um número inteiro.',
        ],
        'sku' => [
            'required'   => 'O SKU é obrigatório.',
            'min_length' => 'O SKU deve ter pelo menos 2 caracteres.',
            'max_length' => 'O SKU não pode ter mais de 100 caracteres.',
            'is_unique'  => 'Este SKU já existe, escolha outro.',
        ],
        'price' => [
            'required' => 'O preço é obrigatório.',
            'decimal'  => 'O preço deve estar no formato numérico (ex: 10.50).',
        ],
        'stock_qty' => [
            'integer' => 'A quantidade em stock deve ser um número inteiro.',
        ],
        'image' => [
            'max_length' => 'O caminho da imagem não pode ter mais de 255 caracteres.',
        ],
        'is_default' => [
            'required' => 'É necessário indicar se é a variante padrão.',
            'in_list'  => 'O valor deve ser 0 (não) ou 1 (sim).',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
