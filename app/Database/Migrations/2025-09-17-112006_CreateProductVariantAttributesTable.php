<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductVariantAttributesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'variant_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'attribute_value_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('variant_id', 'product_variants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('attribute_value_id', 'attribute_values', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_variant_attributes');
    }

    public function down()
    {
        $this->forge->dropTable('product_variant_attributes');
    }
}
