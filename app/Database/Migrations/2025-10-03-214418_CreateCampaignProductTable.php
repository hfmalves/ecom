<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCampaignProductTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'campaign_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'product_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'variant_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('campaign_id', 'campaigns', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('variant_id', 'products_variants', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('campaigns_product');
    }

    public function down()
    {
        $this->forge->dropTable('campaigns_product');
    }
}
