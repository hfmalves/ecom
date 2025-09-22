<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Products extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields = [
        'sku',
        'ean',
        'upc',
        'isbn',
        'gtin',
        'name',
        'slug',
        'short_description',
        'description',
        'brand_id',
        'category_id',
        'cost_price',
        'base_price',
        'base_price_tax',
        'special_price',
        'special_price_start',
        'special_price_end',
        'discount_type',
        'discount_value',
        'stock_qty',
        'manage_stock',
        'type',
        'visibility',
        'weight',
        'width',
        'height',
        'length',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_featured',
        'is_new',
        'tax_class_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
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
        'id'   => 'permit_empty|is_natural_no_zero',
        'sku'  => 'required|min_length[2]|max_length[100]|is_unique[products.sku,id,{id}]',
        'ean'  => 'permit_empty|is_unique[products.ean,id,{id}]',
        'upc'  => 'permit_empty|is_unique[products.upc,id,{id}]',
        'isbn' => 'permit_empty|is_unique[products.isbn,id,{id}]',
        'gtin' => 'permit_empty|is_unique[products.gtin,id,{id}]',
        'name' => 'required|min_length[2]|max_length[255]',
        'slug' => 'required|min_length[2]|max_length[255]',
        'brand_id'         => 'permit_empty|integer',
        'category_id'      => 'permit_empty|integer',
        'cost_price'       => 'permit_empty|decimal',
        'base_price'       => 'required|decimal',
        'base_price_tax'   => 'permit_empty|decimal',
        'special_price'    => 'permit_empty|decimal',
        'special_price_start' => 'permit_empty|valid_date',
        'special_price_end'   => 'permit_empty|valid_date',
        'discount_type'    => 'permit_empty|in_list[percent,fixed]',
        'discount_value'   => 'permit_empty|decimal',
        'stock_qty'        => 'permit_empty|integer',
        'manage_stock'     => 'permit_empty|in_list[0,1]',
        'type'             => 'permit_empty|string',
        'visibility' => 'required|in_list[catalog,search,both,none]',
        'weight'           => 'permit_empty|decimal',
        'width'            => 'permit_empty|decimal',
        'height'           => 'permit_empty|decimal',
        'length'           => 'permit_empty|decimal',
        'meta_title'       => 'permit_empty|max_length[255]',
        'meta_description' => 'permit_empty|max_length[500]',
        'meta_keywords'    => 'permit_empty|max_length[255]',
        'is_featured'      => 'permit_empty|in_list[0,1]',
        'is_new' => 'permit_empty|in_list[0,1,true,false]',
        'tax_class_id'     => 'permit_empty|integer',
        'status'           => 'permit_empty|in_list[active,inactive,draft,archived]',
    ];
    protected $validationMessages = [
        'sku'  => 'required|min_length[2]|max_length[100]|is_unique[products.sku,id,{id}]',
        'ean'  => 'permit_empty|is_unique[products.ean,id,{id}]',
        'upc'  => 'permit_empty|is_unique[products.upc,id,{id}]',
        'isbn' => 'permit_empty|is_unique[products.isbn,id,{id}]',
        'gtin' => 'permit_empty|is_unique[products.gtin,id,{id}]',
        'name' => [
            'required'   => 'O nome do produto é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 2 caracteres.',
            'max_length' => 'O nome não pode ter mais de 255 caracteres.',
        ],
        'base_price' => [
            'required' => 'O preço base é obrigatório.',
            'decimal'  => 'O preço base deve ser numérico.',
        ],
        'manage_stock' => [
            'required' => 'O campo "Gerir Stock" é obrigatório.',
            'in_list'  => 'O campo "Gerir Stock" deve ser 0 (não) ou 1 (sim).',
        ],
        'type' => [
            'required' => 'O tipo de produto é obrigatório.',
            'in_list'  => 'O tipo de produto deve ser: simple, configurable, virtual ou pack.',
        ],
        'visibility' => [
            'required' => 'A visibilidade é obrigatória.',
            'in_list'  => 'A visibilidade deve ser: catalog, search, both ou none.',
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
