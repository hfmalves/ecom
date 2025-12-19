<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSocialAndOpeningHoursToConfSettings extends Migration
{
    public function up()
    {
        $this->forge->addColumn('conf_settings', [

            // ===== REDES SOCIAIS =====
            'facebook_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'contact_phone',
            ],
            'instagram_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'facebook_url',
            ],
            'twitter_url' => [ // X
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'instagram_url',
            ],
            'linkedin_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'twitter_url',
            ],
            'youtube_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'linkedin_url',
            ],

            // ===== HORÁRIOS DE ABERTURA =====
            'opening_monday' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'youtube_url',
            ],
            'opening_tuesday' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'opening_monday',
            ],
            'opening_wednesday' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'opening_tuesday',
            ],
            'opening_thursday' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'opening_wednesday',
            ],
            'opening_friday' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'opening_thursday',
            ],
            'opening_saturday' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'opening_friday',
            ],
            'opening_sunday' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'opening_saturday',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('conf_settings', [
            'facebook_url',
            'instagram_url',
            'twitter_url',
            'linkedin_url',
            'youtube_url',
            'opening_monday',
            'opening_tuesday',
            'opening_wednesday',
            'opening_thursday',
            'opening_friday',
            'opening_saturday',
            'opening_sunday',
        ]);
    }
}
