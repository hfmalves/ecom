<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CampaignSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $campaignsTable = $db->table('campaigns');
        $campaignProductTable = $db->table('campaigns_product');

        // Cria 5 campanhas
        $campaignIds = [];
        for ($i = 1; $i <= 5; $i++) {
            $data = [
                'name'          => "Campanha $i",
                'description'   => "Descrição da campanha $i",
                'discount_type' => (rand(0, 1) ? 'percent' : 'fixed'),
                'discount_value'=> (rand(0, 1) ? rand(5, 30) : rand(1, 50)),
                'start_date'    => date('Y-m-d H:i:s', strtotime('-1 week')),
                'end_date'      => date('Y-m-d H:i:s', strtotime('+1 month')),
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ];
            $campaignsTable->insert($data);
            $campaignIds[] = $db->insertID();
        }

        // Buscar produtos e variantes
        $products = $db->table('products')->select('id')->get()->getResultArray();
        $variants = $db->table('products_variants')->get()->getResultArray();

        if (empty($products)) {
            echo "⚠ Nenhum produto encontrado na tabela products.\n";
            return;
        }

        // Indexar variantes por product_id para lookup rápido
        $variantsByProduct = [];
        foreach ($variants as $v) {
            $variantsByProduct[$v['product_id']][] = $v;
        }

        // Associar produtos/variantes às campanhas
        foreach ($campaignIds as $campaignId) {
            $selectedProducts = array_rand($products, min(40, count($products)));

            if (!is_array($selectedProducts)) {
                $selectedProducts = [$selectedProducts];
            }

            foreach ($selectedProducts as $idx) {
                $productId = $products[$idx]['id'];

                // Se tem variantes → inserir TODAS
                if (!empty($variantsByProduct[$productId])) {
                    foreach ($variantsByProduct[$productId] as $variant) {
                        $campaignProductTable->insert([
                            'campaign_id' => $campaignId,
                            'product_id'  => $productId,
                            'variant_id'  => $variant['id'],
                            'created_at'  => date('Y-m-d H:i:s'),
                            'updated_at'  => date('Y-m-d H:i:s'),
                        ]);
                    }
                } else {
                    // Produto sem variantes → insere só o produto
                    $campaignProductTable->insert([
                        'campaign_id' => $campaignId,
                        'product_id'  => $productId,
                        'variant_id'  => null,
                        'created_at'  => date('Y-m-d H:i:s'),
                        'updated_at'  => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }

        echo "✅ Seeder CampaignSeeder executado: 5 campanhas criadas + produtos/variantes associados.\n";
    }
}
