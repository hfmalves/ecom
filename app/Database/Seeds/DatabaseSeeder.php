<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Taxonomias / catálogos primeiro
        $this->call('BrandsCategoriesTaxesSeeder');
        $this->call('EcommerceSeeder');

        // Utilizadores
        $this->call('UserSeeder');              // users + tokens
        $this->call('UserAddressesSeeder');     // user_addresses

        // Produtos
        $this->call('ProductsSeeder');          // products
        $this->call('ProductVariantsSeeder');   // product_variants
        $this->call('ProductCategoriesSeeder'); // associa produtos a categorias
        $this->call('ReviewsSeeder');           // reviews de produtos
        $this->call('WishlistsSeeder');         // wishlists

        // OrdersModel & fluxo
        $this->call('OrderSeeder');             // orders + order_items
        $this->call('OrderStatusHistorySeeder');// histórico de estados
        $this->call('ShipmentSeeder');          // shipments
        $this->call('ShipmentItemsSeeder');     // shipment_items
        $this->call('CartSeeder');              // carrinhos

        // Faturação e pagamentos
        $this->call('InvoiceSeeder');           // invoices
        $this->call('PaymentSeeder');           // payments

        // Promoções
        $this->call('CouponSeeder');            // coupons
        $this->call('CouponUsagesSeeder');      // coupon_usages
    }
}
