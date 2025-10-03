<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CartRulesSeeder extends Seeder
{
    public function run()
    {
        $categories     = $this->db->table('categories')->select('id')->get()->getResult();
        $products       = $this->db->table('products')->select('id')->get()->getResult();
        $groups         = $this->db->table('customers_groups')->select('id')->get()->getResult();

        if (empty($categories) || empty($products) || empty($groups)) {
            echo "⚠️ Precisas ter categories, products e customers_groups populados primeiro.\n";
            return;
        }

        $rules = [
            [
                'name' => 'Frete grátis acima de 50€',
                'discount_type' => 'free_shipping',
                'discount_value' => 0,
                'condition_json' => json_encode(['subtotal_min' => 50]),
            ],
            [
                'name' => 'Leve 3 Pague 2 em Acessórios',
                'discount_type' => 'buy_x_get_y',
                'discount_value' => 0,
                'condition_json' => json_encode(['category' => 2, 'x' => 3, 'y' => 2]),
            ],
            [
                'name' => '10% desconto no carrinho acima de 100€',
                'discount_type' => 'percent',
                'discount_value' => 10,
                'condition_json' => json_encode(['subtotal_min' => 100]),
            ],
            [
                'name' => 'Desconto fixo 5€ no total',
                'discount_type' => 'fixed',
                'discount_value' => 5,
                'condition_json' => json_encode([]),
            ],
            [
                'name' => '20% desconto clientes VIP',
                'discount_type' => 'percent',
                'discount_value' => 20,
                'condition_json' => json_encode(['group' => 'vip']),
            ],
            [
                'name' => '5€ desconto na categoria Eletrónica',
                'discount_type' => 'fixed',
                'discount_value' => 5,
                'condition_json' => json_encode(['category' => 1]),
            ],
            [
                'name' => '10% desconto em produtos específicos',
                'discount_type' => 'percent',
                'discount_value' => 10,
                'condition_json' => json_encode(['products' => [1, 2]]),
            ],
            [
                'name' => 'Portes grátis clientes registados',
                'discount_type' => 'free_shipping',
                'discount_value' => 0,
                'condition_json' => json_encode(['group' => 'logged_in']),
            ],
            [
                'name' => 'Leve 2 pague 1 em Promoções',
                'discount_type' => 'buy_x_get_y',
                'discount_value' => 0,
                'condition_json' => json_encode(['category' => 3, 'x' => 2, 'y' => 1]),
            ],
            [
                'name' => '30% desconto total Black Friday',
                'discount_type' => 'percent',
                'discount_value' => 30,
                'condition_json' => json_encode(['date' => 'black_friday']),
            ],
        ];

        foreach ($rules as $i => $r) {
            // 1) Cria a regra
            $this->db->table('cart_rules')->insert([
                'name'          => $r['name'],
                'description'   => $r['name'],
                'discount_type' => $r['discount_type'],
                'discount_value'=> $r['discount_value'],
                'condition_json'=> $r['condition_json'],
                'start_date'    => date('Y-m-d H:i:s'),
                'end_date'      => date('Y-m-d H:i:s', strtotime('+30 days')),
                'priority'      => $i + 1,
                'status'        => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);

            $ruleId = $this->db->insertID();

            // 2) Associa a pelo menos uma categoria
            $this->db->table('cart_rule_categories')->insert([
                'rule_id'     => $ruleId,
                'category_id' => $categories[array_rand($categories)]->id,
            ]);

            // 3) Associa a pelo menos um produto
            $this->db->table('cart_rule_products')->insert([
                'rule_id'   => $ruleId,
                'product_id'=> $products[array_rand($products)]->id,
            ]);

            // 4) Associa a pelo menos um grupo de clientes
            $this->db->table('cart_rule_customer_groups')->insert([
                'rule_id'          => $ruleId,
                'customer_group_id'=> $groups[array_rand($groups)]->id,
            ]);

            // 5) Opcional: cria cupão para algumas regras
            if ($i % 2 === 0) {
                $this->db->table('cart_rule_coupons')->insert([
                    'rule_id'          => $ruleId,
                    'code'             => strtoupper('CUPOM' . ($i + 1)),
                    'uses_per_coupon'  => 100,
                    'uses_per_customer'=> 1,
                    'times_used'       => 0,
                    'created_at'       => date('Y-m-d H:i:s'),
                    'updated_at'       => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo "✅ Inseridas 10 cart rules com categorias, produtos, grupos e cupões.\n";
    }
}
