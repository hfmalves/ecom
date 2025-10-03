<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CatalogRulesSeeder extends Seeder
{
    public function run()
    {
        $categories     = $this->db->table('categories')->select('id')->get()->getResult();
        $customerGroups = $this->db->table('customers_groups')->select('id')->get()->getResult();
        $products       = $this->db->table('products')->select('id')->get()->getResult();

        if (empty($categories) || empty($customerGroups) || empty($products)) {
            echo "⚠️ É preciso ter dados em categories, customers_groups e products primeiro.\n";
            return;
        }

        $discountTypes = ['percent', 'fixed'];
        $rulesToCreate = 10; // pelo menos 10 regras

        for ($i = 0; $i < $rulesToCreate; $i++) {
            $category      = $categories[$i % count($categories)];
            $customerGroup = $customerGroups[$i % count($customerGroups)];
            $product       = $products[$i % count($products)];
            $discountType  = $discountTypes[$i % 2];
            $discountValue = $discountType === 'percent' ? rand(5, 30) : rand(5, 50);

            // --- Criar regra
            $this->db->table('catalog_rules')->insert([
                'name'           => "Regra Promo #".($i+1),
                'description'    => "Promoção automática sobre categoria {$category->id}",
                'discount_type'  => $discountType,
                'discount_value' => $discountValue,
                'start_date'     => date('Y-m-d H:i:s'),
                'end_date'       => date('Y-m-d H:i:s', strtotime('+30 days')),
                'priority'       => $i+1,
                'status'         => 1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);

            $ruleId = $this->db->insertID();

            // --- Ligar regra à categoria
            $this->db->table('catalog_rule_categories')->insert([
                'rule_id'     => $ruleId,
                'category_id' => $category->id,
            ]);

            // --- Ligar regra a um produto
            $this->db->table('catalog_rule_products')->insert([
                'rule_id'    => $ruleId,
                'product_id' => $product->id,
            ]);

            // --- Ligar regra a um grupo de cliente
            $this->db->table('catalog_rule_customer_groups')->insert([
                'rule_id'           => $ruleId,
                'customer_group_id' => $customerGroup->id,
            ]);
        }

        echo "✅ Criadas {$rulesToCreate} catalog rules com categorias, produtos e grupos de clientes.\n";
    }
}
