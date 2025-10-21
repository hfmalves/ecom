<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT');

        // 🚫 Desativar verificação de chaves estrangeiras (para truncate seguro)
        $this->db->disableForeignKeyChecks();

        // 🔥 Limpar tabela
        $this->db->table('suppliers')->truncate();

        // ✅ Reativar FKs no fim do processo
        $this->db->enableForeignKeyChecks();

        $suppliers = [];

        for ($i = 0; $i < 50; $i++) {
            $suppliers[] = [
                'code'            => 'SUP' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'name'            => $faker->company,
                'contact_person'  => $faker->name,
                'legal_number'    => $faker->numerify('PT#########'),
                'vat'             => $faker->numerify('PT#########'),
                'email'           => $faker->unique()->companyEmail,
                'phone'           => $faker->phoneNumber,
                'website'         => 'https://' . $faker->domainName,
                'address'         => $faker->address,
                'country'         => $faker->country,
                'iban'            => $faker->iban('PT'),
                'swift'           => strtoupper($faker->bothify('BIC?????###')),
                'payment_terms'   => $faker->randomElement(['30 dias', '45 dias', '60 dias']),
                'currency'        => $faker->randomElement(['EUR', 'USD', 'GBP']),
                'status'          => $faker->randomElement(['active', 'inactive']),
                'risk_level'      => $faker->randomElement(['low', 'medium', 'high']),
                'type'            => $faker->randomElement(['manufacturer', 'distributor', 'service', 'other']),
                'api_key'         => $faker->uuid,
                'api_url'         => $faker->url,
                'logo'            => 'logos/supplier_' . ($i + 1) . '.png',
                'notes'           => $faker->sentence(8),
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ];
        }

        // 💾 Inserir em batch
        $this->db->table('suppliers')->insertBatch($suppliers);

        // 🔗 Atribuir suppliers aleatórios aos produtos
        $supplierIds = $this->db->table('suppliers')->select('id')->get()->getResultArray();
        $supplierIds = array_column($supplierIds, 'id');

        $products = $this->db->table('products')->select('id')->get()->getResultArray();

        foreach ($products as $product) {
            $randomSupplier = $supplierIds[array_rand($supplierIds)];
            $this->db->table('products')
                ->where('id', $product['id'])
                ->update(['supplier_id' => $randomSupplier]);
        }

        echo "✅ Suppliers repovoados com sucesso.\n";
    }
}
