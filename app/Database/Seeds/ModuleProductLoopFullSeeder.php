<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ModuleProductLoopFullSeeder extends Seeder
{
    public function run()
    {
        //-----------------------------------------------------
        // LIMPAR TABELAS (DELETE + RESET AI)
        //-----------------------------------------------------
        $tables = [
            'website_module_product_loop_products',
            'website_module_product_loop_categories',
            'website_module_product_loop_link',
        ];

        foreach ($tables as $tbl) {
            $this->db->query("DELETE FROM `$tbl`");
            $this->db->query("ALTER TABLE `$tbl` AUTO_INCREMENT = 1");
        }

        //-----------------------------------------------------
        // 1) MÓDULO PRINCIPAL (TITLE DO BLOCO)
        //-----------------------------------------------------
        $module = [
            'title'         => 'Shop By Departments',
            'subtitle'      => null,
            'limit_products'=> 8,
            'sort_order'    => 1,
            'is_active'     => 1,
        ];

        $this->db->table('website_module_product_loop_link')->insert($module);
        $moduleId = $this->db->insertID();

        //-----------------------------------------------------
        // 2) CATEGORIAS DO TOPO (TABS)
        //-----------------------------------------------------
        $categoriesData = [
            [
                'module_id'   => $moduleId,
                'name'        => 'Produtos novos na loja',
                'sort_order'  => 1,
                'category_id' => null,
            ],
            [
                'module_id'   => $moduleId,
                'name'        => 'Os produtos mais procurados',
                'sort_order'  => 2,
                'category_id' => null,
            ],
            [
                'module_id'   => $moduleId,
                'name'        => 'Até 60% desconto',
                'sort_order'  => 3,
                'category_id' => null,
            ],
        ];

        $this->db->table('website_module_product_loop_categories')->insertBatch($categoriesData);

        $moduleCategories = $this->db
            ->table('website_module_product_loop_categories')
            ->select('id')
            ->orderBy('id')
            ->get()
            ->getResultArray();

        //-----------------------------------------------------
        // 3) PRODUTOS (8 POR CADA CATEGORIA)
        //-----------------------------------------------------
        $products = [];

        foreach ($moduleCategories as $cat) {
            $categoryId = $cat['id'];

            for ($p = 1; $p <= 8; $p++) {
                $products[] = [
                    'module_category_id' => $categoryId,
                    'product_id'         => rand(1, 50), // ID real dos products
                    'sort_order'         => $p,
                ];
            }
        }

        $this->db->table('website_module_product_loop_products')->insertBatch($products);
    }
}
