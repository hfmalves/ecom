<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class CartSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT');

        // Limpa tabelas
        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        $this->db->table('shopping_carts_items')->truncate();
        $this->db->table('shopping_carts')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');

        // Busca referência
        $users    = $this->db->table('users')->get()->getResultArray();
        $products = $this->db->table('products')->get()->getResultArray();
        $variants = $this->db->table('product_variants')->get()->getResultArray();

        if (empty($users) || empty($products)) {
            echo "⚠️ Não há users ou products suficientes.\n";
            return;
        }

        // Gera 30 carrinhos
        for ($i = 0; $i < 30; $i++) {
            $user = $faker->randomElement($users);

            $this->db->table('shopping_carts')->insert([
                'user_id'    => $user['id'],
                'session_id' => $faker->uuid(),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $cartId = $this->db->insertID();

            // Cada carrinho com 1–5 itens
            $numItems = rand(1, 5);
            for ($j = 0; $j < $numItems; $j++) {
                $product = $faker->randomElement($products);
                $prodVariants = array_filter($variants, fn($v) => $v['product_id'] == $product['id']);
                $variant = !empty($prodVariants) ? $faker->randomElement($prodVariants) : null;

                $qty   = rand(1, 3);
                $price = $product['base_price'];

                $this->db->table('shopping_carts_items')->insert([
                    'cart_id'    => $cartId,
                    'product_id' => $product['id'],
                    'variant_id' => $variant['id'] ?? null,
                    'qty'        => $qty,
                    'price'      => $price,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo "✅ Foram criados 30 carrinhos com itens.\n";
    }
}
