<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Admin\Sales\OrdersModel;
use App\Models\Admin\Sales\FinancialDocumentsModel;

class InvoicesSeeder extends Seeder
{
    public function run()
    {
        $ordersModel   = new OrdersModel();
        $invoicesModel = new FinancialDocumentsModel();

        $orders = $ordersModel->findAll();
        if (empty($orders)) {
            echo "⚠️ Não existem orders.\n";
            return;
        }

        $countUpdates = 0;
        $countCreates = 0;

        foreach ($orders as $order) {
            // Mapear estados de orders -> invoices
            switch ($order['status']) {
                case 'pending':
                    $type           = 'invoice';
                    $status         = 'draft';
                    $paymentStatus  = 'pending';
                    break;
                case 'processing':
                    $type           = 'invoice';
                    $status         = 'issued';
                    $paymentStatus  = 'pending';
                    break;
                case 'completed':
                    $type           = 'invoice';
                    $status         = 'issued';
                    $paymentStatus  = 'paid';
                    break;
                case 'canceled':
                    $type           = 'invoice';
                    $status         = 'canceled';
                    $paymentStatus  = 'canceled';
                    break;
                case 'refunded':
                    $type           = 'credit_note';
                    $status         = 'refunded';
                    $paymentStatus  = 'refunded';
                    break;
                default:
                    $type           = 'invoice';
                    $status         = 'issued';
                    $paymentStatus  = 'pending';
            }

            // Dados para preencher invoice
            $invoiceData = [
                'order_id'            => $order['id'],
                'customer_id'         => $order['customer_id'],
                'billing_address_id'  => $order['billing_address_id'],
                'shipping_address_id' => $order['shipping_address_id'],
                'shipping_method_id'  => $order['shipping_method_id'],
                'payment_method_id'   => $order['payment_method_id'],
                'series'              => '2025',
                'type'                => $type,
                'status'              => $status,
                'payment_status'      => $paymentStatus,
                'subtotal'            => $order['total_items'] ?? 0,
                'tax_total'           => $order['total_tax'] ?? 0,
                'discount_total'      => $order['total_discount'] ?? 0,
                'total'               => $order['grand_total'] ?? $order['total'] ?? 0,
                'currency'            => 'EUR',
                'notes'               => 'Atualizado automaticamente',
                'updated_at'          => date('Y-m-d H:i:s'),
            ];

            // Verifica se já existe invoice para esta order
            $invoice = $invoicesModel->where('order_id', $order['id'])->first();

            if ($invoice) {
                // update
                $invoicesModel->update($invoice['id'], $invoiceData);
                $countUpdates++;
            } else {
                // criar nova se quiseres
                $lastInvoice   = $invoicesModel->orderBy('id', 'DESC')->first();
                $nextNumber    = $lastInvoice ? $lastInvoice['id'] + 1 : 1;
                $invoiceNumber = sprintf("2025/%04d", $nextNumber);

                $invoiceData['invoice_number'] = $invoiceNumber;
                $invoiceData['created_at']     = date('Y-m-d H:i:s');
                $invoicesModel->insert($invoiceData);
                $countCreates++;
            }
        }

        echo "✅ {$countUpdates} invoices atualizadas, {$countCreates} criadas.\n";
    }
}

