<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Admin\Sales\PaymentsModel;
use App\Models\Admin\Sales\FinancialDocumentsModel;
use App\Models\Admin\Sales\OrdersModel;
use App\Models\Admin\Config\payments\PaymentMethodsModel;
use Faker\Factory;

class PaymentsUpdateSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT');

        $paymentsModel        = new PaymentsModel();
        $financialDocsModel   = new FinancialDocumentsModel();
        $ordersModel          = new OrdersModel();
        $paymentMethodsModel  = new PaymentMethodsModel();

        // Mapear métodos de pagamento existentes pelo nome
        $methods = $paymentMethodsModel->findAll();
        $mapMethods = [];
        foreach ($methods as $m) {
            $mapMethods[strtolower($m['name'])] = $m['id'];
            $mapMethods[strtolower($m['code'] ?? $m['name'])] = $m['id'];
        }

        $payments = $paymentsModel->findAll();
        $updated = 0;

        foreach ($payments as $p) {
            $updateData = [];

            // Buscar o documento financeiro para puxar o order_id
            $doc = $financialDocsModel->find($p['invoice_id']);
            if ($doc) {
                $updateData['order_id'] = $doc['order_id'];
            }

            // Currency & Exchange rate
            $updateData['currency']       = $p['currency'] ?? 'EUR';
            $updateData['exchange_rate']  = $p['exchange_rate'] ?? 1.0000;

            // payment_method_id: tenta mapear pelo nome existente em "method"
            $methodName = strtolower($p['method'] ?? '');
            if ($methodName && isset($mapMethods[$methodName])) {
                $updateData['payment_method_id'] = $mapMethods[$methodName];
            }

            // Status: se já tem paid_at → pago, senão → pendente
            $updateData['status'] = !empty($p['paid_at']) ? 'paid' : 'pending';

            // Dados simulados
            $updateData['transaction_id'] = $p['transaction_id'] ?? strtoupper($faker->bothify('TXN-########'));
            $updateData['reference']      = $p['reference'] ?? strtoupper($faker->bothify('REF-#####'));
            $updateData['notes']          = $p['notes'] ?? $faker->sentence(6);

            // Auditoria
            $updateData['created_by'] = $p['created_by'] ?? 1;
            $updateData['updated_by'] = $p['updated_by'] ?? null;

            // Datas
            $updateData['created_at'] = $p['created_at'] ?? date('Y-m-d H:i:s');
            $updateData['updated_at'] = date('Y-m-d H:i:s'); // marca update agora

            // Atualiza no DB
            $paymentsModel->update($p['id'], $updateData);
            $updated++;
        }

        echo "✅ Foram atualizados {$updated} pagamentos com dados complementares.\n";
    }
}
