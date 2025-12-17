<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $now = date('Y-m-d H:i:s');

        /**
         * LIMPAR (ordem correta)
         */
        $tables = [
            'blog_post_categories',
            'blog_comments',
            'website_blog_posts',
            'website_blog_categories',
        ];

        foreach ($tables as $table) {
            if ($db->tableExists($table)) {
                $db->table($table)->truncate();
            }
        }

        /**
         * CATEGORIAS
         */
        $categories = [
            ['name' => 'Novidades',   'slug' => 'novidades'],
            ['name' => 'Dicas',       'slug' => 'dicas'],
            ['name' => 'Tendências',  'slug' => 'tendencias'],
        ];

        $categoryIds = [];

        $pos = 1;
        foreach ($categories as $cat) {
            $db->table('website_blog_categories')->insert([
                'name'       => $cat['name'],
                'slug'       => $cat['slug'],
                'position'   => $pos++,
                'is_active'  => true,
            ]);
            $categoryIds[] = $db->insertID();
        }

        /**
         * POSTS (10)
         */
        for ($i = 1; $i <= 10; $i++) {

            $db->table('website_blog_posts')->insert([
                'title'          => "Artigo de Exemplo {$i}",
                'slug'           => "artigo-exemplo-{$i}",
                'excerpt'        => "Resumo curto do artigo {$i}.",
                'content'        => "<p>Este é o conteúdo completo do artigo {$i}. Texto de exemplo para o módulo de blog.</p>",
                'featured_image' => "blog_{$i}.jpg",
                'author_name'    => 'Admin',
                'status'         => 'published',
                'published_at'   => $now,
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);

            $postId = $db->insertID();

            /**
             * Associar 1–2 categorias aleatórias
             */
            shuffle($categoryIds);
            $use = array_slice($categoryIds, 0, rand(1, 2));

            foreach ($use as $catId) {
                $db->table('website_blog_post_categories')->insert([
                    'post_id'     => $postId,
                    'category_id' => $catId,
                ]);
            }
        }
    }
}
