<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OrdersFlow extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        echo "⚙️ A preparar base de dados...\n";

        // ============================================================
        // 1. DESATIVAR FK E LIMPAR TABELAS
        // ============================================================
        $db->query('SET FOREIGN_KEY_CHECKS = 0');

        $tables = [
            'orders_items',
            'orders_status_history',
            'payments',
            'financial_documents',
            'orders',
        ];

        foreach ($tables as $table) {
            $db->query("TRUNCATE TABLE {$table}");
        }

        $db->query('SET FOREIGN_KEY_CHECKS = 1');
        echo "🧹 Tabelas limpas.\n";

        // ============================================================
        // 2. BUSCAR CLIENTES, MORADAS E PRODUTOS REAIS
        // ============================================================
        $customers = $db->table('customers')->where('is_active', 1)->get()->getResultArray();
        $addresses = $db->table('customers_addresses')->get()->getResultArray();
        $products  = $db->table('products')->where('status', 1)->get()->getResultArray();

        if (empty($customers) || empty($addresses) || empty($products)) {
            echo "❌ Dados insuficientes para gerar encomendas.\n";
            return;
        }

        echo "🚀 A gerar encomendas...\n";
        $counter = 0;

        // ============================================================
        // 3. GERAR ENCOMENDAS COM ESTADOS REALISTAS
        // ============================================================
        foreach ($customers as $cust) {
            if ($counter >= 200) break;

            // Moradas
            $custAddresses = array_values(array_filter($addresses, fn($a) => $a['customer_id'] == $cust['id']));
            if (empty($custAddresses)) continue;

            $billingId  = $custAddresses[0]['id'];
            $shippingId = $custAddresses[0]['id'];

            // Produtos diferentes
            shuffle($products);
            $selected = array_slice($products, 0, rand(2, 5));

            // Calcular totais
            $totalItems = 0;
            $subtotal   = 0;
            $totalTax   = 0;
            $orderItems = [];

            foreach ($selected as $p) {
                $qty = rand(1, 4); // quantidade variável por item
                $lineSubtotal = $p['base_price'] * $qty;
                $lineTax = $p['base_price_tax'] * $qty;
                $lineTotal = $lineSubtotal + $lineTax;

                $orderItems[] = [
                    'product' => $p,
                    'qty'     => $qty,
                    'subtotal'=> $lineSubtotal,
                    'tax'     => $lineTax,
                    'total'   => $lineTotal,
                ];

                $totalItems += $qty;
                $subtotal   += $lineSubtotal;
                $totalTax   += $lineTax;
            }

            $grandTotal = $subtotal + $totalTax;

            // Estado da encomenda
            $possibleStatuses = [
                'pending'    => 25,
                'processing' => 25,
                'completed'  => 30,
                'canceled'   => 10,
                'refunded'   => 10,
            ];
            $rand = rand(1, 100);
            $accum = 0;
            $status = 'pending';
            foreach ($possibleStatuses as $s => $p) {
                $accum += $p;
                if ($rand <= $accum) {
                    $status = $s;
                    break;
                }
            }

            $paymentStatus = match ($status) {
                'pending'    => 'pending',
                'processing' => 'partial',
                'completed'  => 'paid',
                'canceled'   => 'failed',
                'refunded'   => 'refunded',
                default      => 'pending',
            };

            // Criar encomenda
            $order = [
                'customer_id'         => $cust['id'],
                'user_id'             => 1,
                'status'              => $status,
                'total_items'         => $totalItems,
                'total_tax'           => $totalTax,
                'total_discount'      => 0,
                'grand_total'         => $grandTotal,
                'billing_address_id'  => $billingId,
                'shipping_address_id' => $shippingId,
                'shipping_method_id'  => 1,
                'payment_method_id'   => 1,
                'created_at'          => date('Y-m-d H:i:s', strtotime('-' . rand(1, 60) . ' days')),
                'updated_at'          => date('Y-m-d H:i:s'),
            ];
            $db->table('orders')->insert($order);
            $orderId = $db->insertID();

            // Inserir itens reais
            foreach ($orderItems as $line) {
                $p   = $line['product'];
                $qty = $line['qty'];

                $db->table('orders_items')->insert([
                    'order_id'   => $orderId,
                    'cart_id'    => null,
                    'product_id' => $p['id'],
                    'variant_id' => null,
                    'name'       => $p['name'],
                    'sku'        => $p['sku'] ?: 'SKU-' . $p['id'],
                    'qty'        => $qty,
                    'price'      => $p['base_price'],
                    'price_tax'  => $p['base_price_tax'],
                    'discount'   => 0,
                    'row_total'  => ($p['base_price'] + $p['base_price_tax']) * $qty,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            // Documento financeiro (fatura)
            $db->table('financial_documents')->insert([
                'order_id'            => $orderId,
                'customer_id'         => $cust['id'],
                'billing_address_id'  => $billingId,
                'shipping_address_id' => $shippingId,
                'shipping_method_id'  => 1,
                'payment_method_id'   => 1,
                'invoice_number'      => str_pad($orderId, 6, '0', STR_PAD_LEFT),
                'series'              => 'A',
                'type'                => 'invoice',
                'status'              => in_array($status, ['canceled']) ? 'canceled' : 'paid',
                'payment_status'      => $paymentStatus,
                'paid_at'             => in_array($paymentStatus, ['paid','refunded']) ? date('Y-m-d H:i:s') : null,
                'due_date'            => date('Y-m-d H:i:s', strtotime('+10 days')),
                'total'               => $grandTotal,
                'subtotal'            => $subtotal,
                'tax_total'           => $totalTax,
                'discount_total'      => 0,
                'currency'            => 'EUR',
                'notes'               => 'Documento gerado automaticamente pelo seeder.',
                'pdf_path'            => null,
                'hash'                => md5(uniqid((string)$orderId, true)),
                'created_by'          => 1,
                'updated_by'          => 1,
                'created_at'          => date('Y-m-d H:i:s'),
                'updated_at'          => date('Y-m-d H:i:s'),
            ]);

            $invoiceId = $db->insertID();

            // Pagamento
            $db->table('payments')->insert([
                'invoice_id'        => $invoiceId,
                'order_id'          => $orderId,
                'amount'            => $grandTotal,
                'currency'          => 'EUR',
                'exchange_rate'     => 1.0,
                'method'            => 'Multibanco',
                'payment_method_id' => 1,
                'status'            => $paymentStatus,
                'transaction_id'    => 'TXN-' . str_pad($orderId, 6, '0', STR_PAD_LEFT),
                'reference'         => 'MB-' . rand(100000, 999999),
                'notes'             => 'Pagamento ' . $paymentStatus . ' gerado automaticamente.',
                'created_by'        => 1,
                'updated_by'        => 1,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
                'paid_at'           => in_array($paymentStatus, ['paid','refunded']) ? date('Y-m-d H:i:s') : null,
            ]);

            // Histórico
            $history = [
                [
                    'order_id'   => $orderId,
                    'status'     => 'pending',
                    'comment'    => 'Encomenda criada.',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                ]
            ];

            if ($status !== 'pending') {
                $history[] = [
                    'order_id'   => $orderId,
                    'status'     => $status,
                    'comment'    => ucfirst($status) . ' automaticamente pelo seeder.',
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }

            $db->table('orders_status_history')->insertBatch($history);
            $counter++;
        }

        echo "✅ {$counter} encomendas reais criadas com sucesso.\n";
    }
}
