<?php
use CodeIgniter\Config\Services;

if (!function_exists('sendEmail')) {
    /**
     * Send an email using a view, dynamic variables and optional attachments
     *
     * @param string       $to         Recipient email
     * @param string       $subject    Email subject
     * @param string       $view       View path (e.g., 'emails/order_confirmation')
     * @param array        $data       Variables passed to the view
     * @param string|null  $from       Optional sender email
     * @param array        $attachments Array of file paths for attachments
     * @return bool
     */
    function sendEmail(
        string $to,
        string $subject,
        string $view,
        array $data = [],
        ?string $from = null,
        array $attachments = []
    ): bool {
        $email = Services::email();

        // Sender
        $fromEmail = $from ?? getenv('email.fromEmail');
        $fromName  = getenv('email.fromName') ?? 'Ecom System';

        $email->setFrom($fromEmail, $fromName);
        $email->setTo($to);
        $email->setSubject($subject);

        // Renderiza a view como HTML
        $body = view($view, $data);
        $email->setMessage($body);

        // Adiciona anexos se existirem
        foreach ($attachments as $filePath) {
            if (is_file($filePath)) {
                $email->attach($filePath);
            }
        }

        return $email->send();
    }
    /*
     * Como usar
    $data = [
        'user'  => ['name' => 'x'],
        'order' => ['id' => 123, 'total' => '59.90'],
    ];
    // Com anexos
    sendEmail(
        'wolf@example.com',
        'Order #123 Confirmation',
        'emails/order_confirmation',
        $data,
        null,
        [WRITEPATH . 'invoices/order_123.pdf'] // exemplo de anexo
    );
    */
}
