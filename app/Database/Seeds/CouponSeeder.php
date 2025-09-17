<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class CouponSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT');

        $coupons = [];
        for ($i=1; $i<=10; $i++) {
            $coupons[] = [
                'code'       => strtoupper($faker->bothify('CUP##??')),
                'type'       => $faker->randomElement(['percent','fixed']),
                'value'      => $faker->randomFloat(2, 5, 30),
                'max_uses'   => $faker->numberBetween(1, 50),
                'expires_at' => $faker->dateTimeBetween('now', '+6 months')->format('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }
        $this->db->table('coupons')->insertBatch($coupons);

        $coupons   = $this->db->table('coupons')->get()->getResultArray();
        $users     = $this->db->table('users')->get()->getResultArray();
        $orders    = $this->db->table('orders')->get()->getResultArray();

        foreach ($orders as $order) {
            if ($faker->boolean(20)) {
                $this->db->table('coupon_usages')->insert([
                    'coupon_id'=> $faker->randomElement($coupons)['id'],
                    'user_id'  => $order['user_id'],
                    'order_id' => $order['id'],
                    'used_at'  => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo "✅ Coupons + usages gerados!\n";
    }
}
