<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class CustomersSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT'); // podes mudar para 'en_US'

        $customers = [];

        // 200 clientes
        for ($i = 0; $i < 200; $i++) {
            $customers[] = [
                'name'        => $faker->name,
                'email'       => $faker->unique()->safeEmail,
                'password'    => password_hash('123456', PASSWORD_DEFAULT), // senha padrão
                'phone'       => $faker->phoneNumber,
                'is_active'   => $faker->boolean(90),  // 90% ativos
                'is_verified' => $faker->boolean(80),  // 80% verificados
                'login_2step' => $faker->boolean(20),  // 20% têm 2FA
                'created_at'  => $faker->dateTimeThisDecade->format('Y-m-d H:i:s'),
                'updated_at'  => $faker->dateTimeThisYear->format('Y-m-d H:i:s'),
                'deleted_at'  => null,
            ];
        }

        // inserir clientes
        $this->db->table('customers')->insertBatch($customers);

        // buscar IDs
        $customerIds = $this->db->table('customers')->select('id')->get()->getResultArray();
        $customerIds = array_column($customerIds, 'id');

        // addresses
        $addresses = [];
        foreach ($customerIds as $cid) {
            $addresses[] = [
                'customer_id' => $cid,
                'type'        => 'home',
                'street'      => $faker->streetAddress,
                'city'        => $faker->city,
                'postcode'    => $faker->postcode,
                'country'     => $faker->country,
                'is_default'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];
        }
        $this->db->table('customers_addresses')->insertBatch($addresses);

        // wishlists (cada cliente pode ter 0–3 produtos)
        $wishlists = [];
        foreach ($customerIds as $cid) {
            $count = rand(0, 3);
            for ($i = 0; $i < $count; $i++) {
                $wishlists[] = [
                    'customer_id' => $cid,
                    'product_id'  => rand(1, 50), // supondo produtos de 1 a 50
                    'created_at'  => date('Y-m-d H:i:s'),
                ];
            }
        }
        if ($wishlists) {
            $this->db->table('customers_wishlists')->insertBatch($wishlists);
        }

        // reviews (cada cliente 0–2 reviews)
        $reviews = [];
        foreach ($customerIds as $cid) {
            $count = rand(0, 2);
            for ($i = 0; $i < $count; $i++) {
                $reviews[] = [
                    'customer_id' => $cid,
                    'product_id'  => rand(1, 50),
                    'rating'      => rand(1, 5),
                    'comment'     => $faker->sentence(10),
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ];
            }
        }
        if ($reviews) {
            $this->db->table('customers_reviews')->insertBatch($reviews);
        }

        // tokens (ex.: email verification)
        $tokens = [];
        foreach ($customerIds as $cid) {
            if ($faker->boolean(20)) { // 20% têm token ativo
                $tokens[] = [
                    'customer_id' => $cid,
                    'token'       => bin2hex(random_bytes(16)),
                    'type'        => $faker->randomElement(['password_reset','2fa','email_verification']),
                    'expires_at'  => date('Y-m-d H:i:s', strtotime('+7 days')),
                    'created_at'  => date('Y-m-d H:i:s'),
                ];
            }
        }
        if ($tokens) {
            $this->db->table('customers_tokens')->insertBatch($tokens);
        }
    }
}
