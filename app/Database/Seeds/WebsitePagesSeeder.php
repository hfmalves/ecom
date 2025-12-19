<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WebsitePagesSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $pages = [
            /* EMPRESA (Company) */
            ['store_id'=>1,'slug'=>'sobre-nos','title'=>'Sobre Nós','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>1,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],
            ['store_id'=>1,'slug'=>'carreiras','title'=>'Carreiras','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>2,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],
            ['store_id'=>1,'slug'=>'afiliados','title'=>'Afiliados','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>3,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],
            ['store_id'=>1,'slug'=>'blog','title'=>'Blog','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>4,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],
            ['store_id'=>1,'slug'=>'contactos','title'=>'Contactos','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>5,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],

            /* AJUDA (Help) */
            ['store_id'=>1,'slug'=>'apoio-ao-cliente','title'=>'Apoio ao Cliente','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>20,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],
            ['store_id'=>1,'slug'=>'minha-conta','title'=>'A Minha Conta','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>21,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],
            ['store_id'=>1,'slug'=>'encontrar-loja','title'=>'Encontrar uma Loja','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>22,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],
            ['store_id'=>1,'slug'=>'privacidade','title'=>'Política de Privacidade','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>23,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],
            ['store_id'=>1,'slug'=>'termos','title'=>'Termos e Condições','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>24,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],
            ['store_id'=>1,'slug'=>'trocas-devolucoes','title'=>'Trocas e Devoluções','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>25,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],
            ['store_id'=>1,'slug'=>'envios-entregas','title'=>'Envios e Entregas','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>26,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],
            ['store_id'=>1,'slug'=>'pagamentos','title'=>'Pagamentos','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>27,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],
            ['store_id'=>1,'slug'=>'perguntas-frequentes','title'=>'Perguntas Frequentes','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>28,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],

            /* PÁGINAS COMUNS (legais/operacionais) */
            ['store_id'=>1,'slug'=>'politica-cookies','title'=>'Política de Cookies','content'=>null,'link_type'=>'internal','external_url'=>null,'meta_title'=>null,'meta_description'=>null,'position'=>40,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],
            ['store_id'=>1,'slug'=>'livro-reclamacoes','title'=>'Livro de Reclamações','content'=>null,'link_type'=>'external','external_url'=>'https://www.livroreclamacoes.pt/','meta_title'=>null,'meta_description'=>null,'position'=>41,'show_in_footer'=>1,'show_in_header'=>0,'template'=>'default','is_active'=>1,'published_at'=>$now],
        ];

        $this->db->table('website_pages')->insertBatch($pages);
    }
}
