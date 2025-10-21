<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class BrandSeeder extends Seeder
{
    public function run()
    {
        helper('text');
        $faker = Factory::create('pt_PT');

        $this->db->disableForeignKeyChecks();
        $this->db->table('brands')->truncate();
        $this->db->enableForeignKeyChecks();

        $suppliers = $this->db->table('suppliers')->select('id')->get()->getResultArray();
        $supplierIds = array_column($suppliers, 'id');

        // Categorias de marcas comerciais
        $brandCategories = [
            'alimentar' => [
                'FrigoPure', 'DoceLuz', 'Agroterra', 'Nutriwell', 'Saboris', 'PanDouro',
                'Monte Verde', 'Frescana', 'Almar', 'Cerealor', 'Casa do Trigo', 'Delivra'
            ],
            'beleza' => [
                'Lumea', 'PureSkin', 'NaturaBelle', 'Vitta', 'Aurum', 'Belezza',
                'Sensia', 'GlowTime', 'UrbanSkin', 'Ritualis', 'Floréa', 'DermaLuxe'
            ],
            'casa' => [
                'CasaVerde', 'Nordwood', 'AquaBlue', 'Lumea Home', 'BrightCasa',
                'SoftTouch', 'ZenLiving', 'EcoRoom', 'Armonia', 'HomeEase', 'Woodify', 'Portaterra'
            ],
            'tecnologia' => [
                'Voltis', 'NeuraOne', 'Axion', 'Techline', 'Pixen', 'BrightWare',
                'SmartEase', 'Nextron', 'DataCore', 'Luminox', 'Gearify', 'Omnitech'
            ],
            'vestuario' => [
                'Velina', 'Linea Moda', 'UrbanWear', 'Tessuto', 'Bettina', 'Karelia',
                'Modea', 'Auri', 'Zafira', 'Lusitex', 'NovaFit', 'TrendyFox'
            ],
            'ferramentas' => [
                'PowerPro', 'Duramax', 'IronForge', 'TecnoHand', 'GripLine', 'Fixar',
                'SteelPro', 'WorkEdge', 'PrimeTool', 'Mechanor', 'Hardline', 'Rivet'
            ],
        ];

        $brands = [];
        $usedNames = [];

        // Geração principal
        for ($i = 0; $i < 60; $i++) {
            $category = array_rand($brandCategories);
            $baseName = $faker->randomElement($brandCategories[$category]);

            // Evita duplicações
            while (in_array($baseName, $usedNames)) {
                $category = array_rand($brandCategories);
                $baseName = $faker->randomElement($brandCategories[$category]);
            }
            $usedNames[] = $baseName;

            // Slug limpo
            $slug = url_title(convert_accented_characters($baseName), '-', true);

            $brands[] = [
                'supplier_id'      => !empty($supplierIds) ? $faker->randomElement($supplierIds) : null,
                'name'             => $baseName,
                'slug'             => $slug,
                'description'      => $faker->realText(120),
                'logo'             => strtolower(str_replace(' ', '_', $slug)) . '.png',
                'website'          => 'https://www.' . strtolower($slug) . '.com',
                'country'          => $faker->country,
                'meta_title'       => $baseName . ' — Produtos Oficiais',
                'meta_description' => $faker->sentence(10),
                'banner'           => strtolower(str_replace(' ', '_', $slug)) . '_banner.jpg',
                'sort_order'       => $faker->numberBetween(1, 100),
                'featured'         => $faker->boolean(25),
                'is_active'        => $faker->boolean(90) ? 1 : 0,
                'created_by'       => 1,
                'updated_by'       => 1,
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ];
        }

        $this->db->table('brands')->insertBatch($brands);

        echo "✅ Foram criadas " . count($brands) . " marcas comerciais distintas.\n";
    }
}
