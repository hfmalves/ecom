<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class NewsletterController extends BaseController
{
    protected NewsletterModel $newsletterModel;

    public function __construct()
    {
        $this->newsletterModel = new NewsletterModel();
    }

    public function subscribe()
    {
        $payload = $this->request->getJSON(true);
        $email   = $payload['email'] ?? null;
        if (!$email) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'ok'    => false,
                    'error' => 'Email é obrigatório.',
                ]);
        }
        if (!$this->newsletterModel->subscribe($email)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'ok'     => false,
                    'errors' => $this->newsletterModel->getErrors(),
                ]);
        }
        cache()->save(
            'newsletter_seen_' . md5($this->request->getIPAddress()),
            true,
            60 * 30
        );
        return $this->response->setJSON(['ok' => true]);
    }
    public function seen()
    {
        cache()->save(
            'newsletter_seen_' . md5($this->request->getIPAddress()),
            true,
            60 * 30
        );
        return $this->response->setJSON(['ok' => true]);
    }
}
