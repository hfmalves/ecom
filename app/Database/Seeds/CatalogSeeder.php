<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run()
    {
        // Limpa a tabela antes de inserir
        $this->db->table('conf_catalog_settings')->truncate();

        $data = [
            // Paginação e Ordenação
            ['name'=>'Produtos por página','key'=>'products_per_page','value'=>'20','type'=>'number','options'=>null,'status'=>1],
            ['name'=>'Ordenação padrão','key'=>'default_sort','value'=>'name_asc','type'=>'select','options'=>json_encode(['name_asc'=>'Nome (A-Z)','name_desc'=>'Nome (Z-A)','price_asc'=>'Preço (Crescente)','price_desc'=>'Preço (Decrescente)'], JSON_PRETTY_PRINT),'status'=>1],

            // Exibição
            ['name'=>'Exibir produtos em destaque','key'=>'show_featured','value'=>'1','type'=>'boolean','options'=>null,'status'=>1],
            ['name'=>'Exibir produtos em promoção','key'=>'show_sale','value'=>'1','type'=>'boolean','options'=>null,'status'=>1],
            ['name'=>'Exibir produtos esgotados','key'=>'show_out_of_stock','value'=>'0','type'=>'boolean','options'=>null,'status'=>1],
            ['name'=>'Layout do catálogo','key'=>'catalog_layout','value'=>'grid','type'=>'select','options'=>json_encode(['grid'=>'Grade','list'=>'Lista'], JSON_PRETTY_PRINT),'status'=>1],
            ['name'=>'Exibir badges de novo','key'=>'show_new_badge','value'=>'1','type'=>'boolean','options'=>null,'status'=>1],
            ['name'=>'Exibir badges de desconto','key'=>'show_discount_badge','value'=>'1','type'=>'boolean','options'=>null,'status'=>1],

            // Filtros
            ['name'=>'Filtro de categorias ativo','key'=>'category_filter','value'=>'1','type'=>'boolean','options'=>null,'status'=>1],
            ['name'=>'Filtro de preço ativo','key'=>'price_filter','value'=>'1','type'=>'boolean','options'=>null,'status'=>1],
            ['name'=>'Filtro de marcas ativo','key'=>'brand_filter','value'=>'1','type'=>'boolean','options'=>null,'status'=>1],
            ['name'=>'Filtro de atributos ativo','key'=>'attribute_filter','value'=>'1','type'=>'boolean','options'=>null,'status'=>1],

            // SEO
            ['name'=>'Título padrão do catálogo','key'=>'catalog_seo_title','value'=>'Nossa Loja - Produtos','type'=>'text','options'=>null,'status'=>1],
            ['name'=>'Meta descrição padrão','key'=>'catalog_seo_description','value'=>'Confira todos os nossos produtos e promoções.','type'=>'text','options'=>null,'status'=>1],

            // Estoque
            ['name'=>'Exibir quantidade em estoque','key'=>'show_stock_quantity','value'=>'1','type'=>'boolean','options'=>null,'status'=>1],
            ['name'=>'Quantidade mínima para alerta','key'=>'stock_alert_min','value'=>'5','type'=>'number','options'=>null,'status'=>1],

            // Imagens
            ['name'=>'Tamanho da miniatura','key'=>'thumbnail_size','value'=>'150x150','type'=>'text','options'=>null,'status'=>1],
            ['name'=>'Tamanho da imagem do produto','key'=>'product_image_size','value'=>'800x800','type'=>'text','options'=>null,'status'=>1],

            // Outros
            ['name'=>'Mostrar avaliações de produtos','key'=>'show_reviews','value'=>'1','type'=>'boolean','options'=>null,'status'=>1],
            ['name'=>'Ativar comparador de produtos','key'=>'enable_comparison','value'=>'1','type'=>'boolean','options'=>null,'status'=>1],
        ];

        $this->db->table('conf_catalog_settings')->insertBatch($data);
    }
}
