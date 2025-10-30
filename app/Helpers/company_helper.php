<?php

use CodeIgniter\Config\DotEnv;

if (!function_exists('companyInfo')) {
    function companyInfo(): array
    {
        // 🔒 Garante que o .env foi lido
        $env = new DotEnv(ROOTPATH);
        $env->load();

        return [
            'name'    => getenv('COMPANY_NAME') ?: 'Empresa Sem Nome',
            'address' => getenv('COMPANY_ADDRESS') ?: 'Morada não configurada',
            'vat'     => getenv('COMPANY_VAT') ?: 'PT000000000',
            'email'   => getenv('COMPANY_EMAIL') ?: 'email@exemplo.pt',
            'phone'   => getenv('COMPANY_PHONE') ?: '',
        ];
    }
}