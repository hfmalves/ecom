<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class CustomersSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT');
        $db = \Config\Database::connect();
        // 🔧 Desativar FKs e limpar tabelas relacionadas
        $db->query('SET FOREIGN_KEY_CHECKS = 0');
        $db->query('TRUNCATE TABLE customers_tokens');
        $db->query('TRUNCATE TABLE customers_reviews');
        $db->query('TRUNCATE TABLE customers_wishlists');
        $db->query('TRUNCATE TABLE customers_addresses');
        $db->query('TRUNCATE TABLE customers');
        $db->query('SET FOREIGN_KEY_CHECKS = 1');

        $customers = [];

        for ($i = 0; $i < 2000; $i++) {
            $customers[] = [
                'group_id'               => rand(1, 3),
                'name'                   => $faker->name,
                'username'               => strtolower($faker->userName),
                'email'                  => $faker->unique()->safeEmail,
                'password'               => password_hash('123456', PASSWORD_DEFAULT),
                'phone'                  => $faker->phoneNumber,
                'date_of_birth'          => $faker->date('Y-m-d', '-18 years'), // ✅ fix
                'gender'                 => $faker->randomElement(['M', 'F', 'O']),
                'is_active'              => $faker->boolean(90),
                'is_verified'            => $faker->boolean(80),
                'newsletter_optin'       => $faker->boolean(60),
                'login_2step'            => $faker->boolean(20),
                'last_login_at'          => $faker->optional(0.8, null)->dateTimeThisYear()?->format('Y-m-d H:i:s'),
                'last_ip'                => $faker->ipv4,
                'referral_code'          => strtoupper(substr(md5($faker->uuid), 0, 8)),
                'loyalty_points'         => rand(0, 5000),
                'preferred_language'     => $faker->randomElement(['pt_PT', 'en_US', 'es_ES']),
                'preferred_currency'     => $faker->randomElement(['EUR', 'USD', 'GBP']),
                'password_reset_token'   => null,
                'password_reset_expires' => null,
                'login_attempts'         => 0,
                'last_failed_login'      => null,
                'created_by'             => null,
                'notes'                  => $faker->optional(0.3, null)->sentence(6),
                'source'                 => $faker->randomElement(['web', 'api', 'import']),
                'created_at'             => $faker->dateTimeThisDecade()->format('Y-m-d H:i:s'),
                'updated_at'             => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'deleted_at'             => null,
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

        // wishlists
        $wishlists = [];
        foreach ($customerIds as $cid) {
            $count = rand(0, 3);
            for ($i = 0; $i < $count; $i++) {
                $wishlists[] = [
                    'customer_id' => $cid,
                    'product_id'  => rand(1, 50),
                    'created_at'  => date('Y-m-d H:i:s'),
                ];
            }
        }
        if ($wishlists) {
            $this->db->table('customers_wishlists')->insertBatch($wishlists);
        }

        // reviews
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

        // tokens
        $tokens = [];
        foreach ($customerIds as $cid) {
            if ($faker->boolean(20)) {
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
