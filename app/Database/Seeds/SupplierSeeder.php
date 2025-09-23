<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT');

        $suppliers = [];

        for ($i = 0; $i < 50; $i++) {
            $suppliers[] = [
                'name'           => $faker->company,
                'contact_person' => $faker->name,
                'legal_number'   => $faker->numerify('PT#########'),
                'vat'            => $faker->numerify('PT#########'),
                'email'          => $faker->unique()->companyEmail,
                'phone'          => $faker->phoneNumber,
                'website'        => $faker->domainName,
                'address'        => $faker->address,
                'country'        => $faker->country,
                'iban'           => $faker->iban('PT'),
                'payment_terms'  => $faker->randomElement(['30 dias', '45 dias', '60 dias']),
                'currency'       => $faker->randomElement(['EUR', 'USD', 'GBP']),
                'status'         => $faker->randomElement(['active', 'inactive']),
                'created_at'     => date('Y-m-d H:i:s'),
            ];
        }

        // Inserir suppliers em batch
        $this->db->table('suppliers')->insertBatch($suppliers);

        // Buscar IDs dos suppliers
        $supplierIds = $this->db->table('suppliers')->select('id')->get()->getResultArray();
        $supplierIds = array_column($supplierIds, 'id');

        // Buscar produtos
        $products = $this->db->table('products')->select('id')->get()->getResultArray();

        foreach ($products as $product) {
            $randomSupplier = $supplierIds[array_rand($supplierIds)];
            $this->db->table('products')
                ->where('id', $product['id'])
                ->update(['supplier_id' => $randomSupplier]);
        }
    }
}
