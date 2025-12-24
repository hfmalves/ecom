<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Website\NewsletterModel;

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
            return $this->response->setStatusCode(400)->setJSON([
                'ok' => false,
                'error' => 'Email é obrigatório.',
            ]);
        }

        $ok = $this->newsletterModel->insert([
            'email'      => $email,
            'status'     => 'subscribed',
            'source'     => 'popup',
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()?->getAgentString(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if ($ok === false) {
            return $this->response->setStatusCode(422)->setJSON([
                'ok'     => false,
                'errors' => $this->newsletterModel->errors(),
            ]);
        }

        session()->set('newsletter_subscribed', true);
        log_message('error', 'NEWSLETTER SUBSCRIBE | session antes: ' . json_encode($_SESSION ?? []));
        session()->set('newsletter_subscribed', true);
        log_message('error', 'NEWSLETTER SUBSCRIBE | session depois: ' . json_encode($_SESSION ?? []));
        return $this->response->setJSON(['ok' => true]);
    }


    public function seen()
    {
        session()->set(
            'newsletter_closed_until',
            time() + 3600 // 1 hora
        );
        log_message('error', 'NEWSLETTER SEEN | session antes: ' . json_encode($_SESSION ?? []));
        session()->set('newsletter_closed_until', time() + 3600);
        log_message('error', 'NEWSLETTER SEEN | session depois: ' . json_encode($_SESSION ?? []));
        return $this->response->setJSON(['ok' => true]);
    }


    public function status()
    {
        log_message('error', 'NEWSLETTER STATUS | session atual: ' . json_encode($_SESSION ?? []));

        if (session()->get('newsletter_subscribed')) {
            log_message('error', 'STATUS: subscribed = TRUE');
            return $this->response->setJSON(['can_open' => false]);
        }

        if (session()->get('newsletter_closed_until') > time()) {
            log_message('error', 'STATUS: closed_until ativo');
            return $this->response->setJSON(['can_open' => false]);
        }

        log_message('error', 'STATUS: pode abrir');
        return $this->response->setJSON(['can_open' => true]);

        return $this->response->setJSON(['can_open' => true]);
    }



}
