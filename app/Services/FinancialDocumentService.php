<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\View\View;

class FinancialDocumentService
{
    protected string $storagePath = WRITEPATH . 'financial_docs/';

    public function create(string $type, array $data): array
    {
        if (!is_dir($this->storagePath)) {
            mkdir($this->storagePath, 0775, true);
        }
        $html = view('_pdf/financial_documents/' . $type, [
            'company'  => $data['company'],
            'customer' => $data['customer'],
            'document' => $data['document'],
            'items'    => $data['items'],
            'payment'  => $data['payment'],
        ]);
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $pdf = new Dompdf($options);
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $filename = sprintf(
            '%s_%s_%s.pdf',
            strtoupper($type),
            $data['invoice_number'] ?? uniqid(),
            date('Ymd_His')
        );
        $outputPath = $this->storagePath . $filename;
        file_put_contents($outputPath, $pdf->output());
        return [
            'path' => $outputPath,
            'hash' => hash_file('sha256', $outputPath),
        ];
    }
}
