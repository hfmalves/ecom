<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WebsiteMenuSeeder extends Seeder
{
    public function run()
    {
        // limpa a tabela
        $this->db->query('TRUNCATE TABLE website_menu');

        $now = date('Y-m-d H:i:s');

        $menu = [

            // ============================================
            // MENU PRINCIPAL
            // ============================================

            [
                'id' => 1, 'parent_id' => null, 'title' => 'Início', 'url' => '/',
                'type' => 0, 'image' => null, 'sort_order' => 1, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 0, 'block_data' => null,
            ],
            [
                'id' => 2, 'parent_id' => null, 'title' => 'Loja', 'url' => '#',
                'type' => 1, 'image' => null, 'sort_order' => 2, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 0, 'block_data' => null,
            ],
            [
                'id' => 3, 'parent_id' => null, 'title' => 'Produtos', 'url' => '#',
                'type' => 1, 'image' => null, 'sort_order' => 3, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 0, 'block_data' => null,
            ],
            [
                'id' => 4, 'parent_id' => null, 'title' => 'Páginas', 'url' => '#',
                'type' => 0, 'image' => null, 'sort_order' => 4, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 0, 'block_data' => null,
            ],
            [
                'id' => 5, 'parent_id' => null, 'title' => 'Blog', 'url' => '#',
                'type' => 0, 'image' => null, 'sort_order' => 5, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 0, 'block_data' => null,
            ],

            // ============================================
            // MEGA MENU: LOJA (COLUNAS)
            // ============================================

            [
                'id' => 10, 'parent_id' => 2, 'title' => 'Shop Layout', 'url' => '#',
                'type' => 0, 'image' => null, 'sort_order' => 1, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 1, 'block_data' => null,
            ],
            [
                'id' => 11, 'parent_id' => 2, 'title' => 'Shop Features', 'url' => '#',
                'type' => 0, 'image' => null, 'sort_order' => 2, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 1, 'block_data' => null,
            ],
            [
                'id' => 12, 'parent_id' => 2, 'title' => 'Shop Hover', 'url' => '#',
                'type' => 0, 'image' => null, 'sort_order' => 3, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 1, 'block_data' => null,
            ],

            // ============================================
            // FILHOS DO SHOP LAYOUT (id=10)
            // ============================================

            [
                'id' => 100, 'parent_id' => 10, 'title' => 'Shop Default', 'url' => '/shop/default',
                'type' => 0, 'image' => null, 'sort_order' => 1, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 0, 'block_data' => null,
            ],
            [
                'id' => 101, 'parent_id' => 10, 'title' => 'Shop Grid', 'url' => '/shop/grid',
                'type' => 0, 'image' => null, 'sort_order' => 2, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 0, 'block_data' => null,
            ],
            [
                'id' => 102, 'parent_id' => 10, 'title' => 'Shop List', 'url' => '/shop/list',
                'type' => 0, 'image' => null, 'sort_order' => 3, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 0, 'block_data' => null,
            ],

            // ============================================
            // FILHOS DO SHOP FEATURES (id=11)
            // ============================================

            [
                'id' => 110, 'parent_id' => 11, 'title' => 'Featured 1', 'url' => '/shop/featured-1',
                'type' => 0, 'image' => null, 'sort_order' => 1, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 0, 'block_data' => null,
            ],
            [
                'id' => 111, 'parent_id' => 11, 'title' => 'Featured 2', 'url' => '/shop/featured-2',
                'type' => 0, 'image' => null, 'sort_order' => 2, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 0, 'block_data' => null,
            ],
            [
                'id' => 112, 'parent_id' => 11, 'title' => 'Featured 3', 'url' => '/shop/featured-3',
                'type' => 0, 'image' => null, 'sort_order' => 3, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 0, 'block_data' => null,
            ],

            // ============================================
            // FILHOS DO SHOP HOVER (id=12)
            // ============================================

            [
                'id' => 120, 'parent_id' => 12, 'title' => 'Hover Style 1', 'url' => '/shop/hover-1',
                'type' => 0, 'image' => null, 'sort_order' => 1, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 0, 'block_data' => null,
            ],
            [
                'id' => 121, 'parent_id' => 12, 'title' => 'Hover Style 2', 'url' => '/shop/hover-2',
                'type' => 0, 'image' => null, 'sort_order' => 2, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 0, 'block_data' => null,
            ],
            [
                'id' => 122, 'parent_id' => 12, 'title' => 'Hover Style 3', 'url' => '/shop/hover-3',
                'type' => 0, 'image' => null, 'sort_order' => 3, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 0, 'block_data' => null,
            ],

            // ============================================
            // BLOCOS DO MEGA-MENU (PRODUTOS RECENTES, ETC.)
            // ============================================

            [
                'id' => 20, 'parent_id' => 2, 'title' => 'Produtos Recentes', 'url' => null,
                'type' => 1, 'image' => null, 'sort_order' => 90, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 2,
                'block_data' => json_encode([
                    [
                        'image' => '/images/products/e1.jpg',
                        'category' => 'Earring',
                        'name' => 'Luna Drop Earrings',
                        'price' => '69.99',
                        'url' => '/product/1',
                    ],
                    [
                        'image' => '/images/products/e2.jpg',
                        'category' => 'Ring',
                        'name' => 'Stackable Gold Rings',
                        'price' => '59.99',
                        'url' => '/product/2',
                    ],
                ]),
            ],

            [
                'id' => 21, 'parent_id' => 2, 'title' => 'Destaques', 'url' => null,
                'type' => 1, 'image' => null, 'sort_order' => 91, 'is_active' => 1,
                'created_at' => $now, 'updated_at' => $now, 'block_type' => 3,
                'block_data' => json_encode([
                    [
                        'image' => '/images/jewel/necklace.jpg',
                        'label' => 'Necklace',
                        'cta' => 'Shop Now',
                        'url' => '/shop/necklace',
                    ],
                    [
                        'image' => '/images/jewel/bracelet.jpg',
                        'label' => 'Bracelet',
                        'cta' => 'Shop Now',
                        'url' => '/shop/bracelet',
                    ],
                ]),
            ],

        ];

        $this->db->table('website_menu')->insertBatch($menu);
    }
}
