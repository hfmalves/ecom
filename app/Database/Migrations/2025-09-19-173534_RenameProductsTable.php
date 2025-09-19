<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameAllEcommerceTables extends Migration
{
    public function up()
    {
        // Products
        $this->forge->renameTable('attributes', 'products_attributes');
        $this->forge->renameTable('attribute_values', 'products_attribute_values');
        $this->forge->renameTable('product_variants', 'products_variants');
        $this->forge->renameTable('product_variant_attributes', 'products_variant_attributes');
        $this->forge->renameTable('product_categories', 'products_categories');
        $this->forge->renameTable('images', 'products_images');

        // Orders
        $this->forge->renameTable('shipments', 'orders_shipments');
        $this->forge->renameTable('shipment_items', 'orders_shipment_items');
        $this->forge->renameTable('rma_requests', 'orders_returns');
        $this->forge->renameTable('rma_request_items', 'orders_return_items');
        $this->forge->renameTable('shopping_carts', 'orders_carts');
        $this->forge->renameTable('shopping_carts_items', 'orders_cart_items');

        // Users
        $this->forge->renameTable('user_addresses', 'users_addresses');
        $this->forge->renameTable('user_reviews', 'users_reviews');
        $this->forge->renameTable('user_tokens', 'users_tokens');
        $this->forge->renameTable('user_wishlists', 'users_wishlists');

        // Stores
        $this->forge->renameTable('stores_stock_products', 'stores_products_stock');
        $this->forge->renameTable('order_status_history', 'orders_status_history');


    }

    public function down()
    {
        // Revert Products
        $this->forge->renameTable('products_attributes', 'attributes');
        $this->forge->renameTable('products_attribute_values', 'attribute_values');
        $this->forge->renameTable('products_variants', 'product_variants');
        $this->forge->renameTable('products_variant_attributes', 'product_variant_attributes');
        $this->forge->renameTable('products_categories', 'product_categories');
        $this->forge->renameTable('products_images', 'images');

        // Revert Orders
        $this->forge->renameTable('orders_shipments', 'shipments');
        $this->forge->renameTable('orders_shipment_items', 'shipment_items');
        $this->forge->renameTable('orders_returns', 'rma_requests');
        $this->forge->renameTable('orders_return_items', 'rma_request_items');
        $this->forge->renameTable('orders_carts', 'shopping_carts');
        $this->forge->renameTable('orders_cart_items', 'shopping_carts_items');

        // Revert Users
        $this->forge->renameTable('users_addresses', 'user_addresses');
        $this->forge->renameTable('users_reviews', 'user_reviews');
        $this->forge->renameTable('users_tokens', 'user_tokens');
        $this->forge->renameTable('users_wishlists', 'user_wishlists');

        // Revert Stores
        $this->forge->renameTable('stores_products_stock', 'stores_stock_products');

        $this->forge->renameTable('orders_status_history', 'order_status_history');
    }
}
