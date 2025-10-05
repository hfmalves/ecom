<?php

namespace App\Controllers\Admin\Configurations\Notifications;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Notifications\NotificationModel;

class NotificationsController extends BaseController
{
    protected $notifications;

    public function __construct()
    {
        $this->notifications = new NotificationModel();
    }

    public function index()
    {
        $data['notifications'] = $this->notifications->findAll();

        foreach ($data['notifications'] as &$n) {
            $n['config'] = json_decode($n['config_json'], true) ?? [];
        }

        return view('admin/configurations/notifications/index', $data);
    }

    public function store()
    {
        $data = $this->request->getJSON(true);
        $data['status'] = $data['status'] ?? 1;

        if (! $this->notifications->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->notifications->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Notificação criada com sucesso!',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

    public function update()
    {
        $data = $this->request->getJSON(true);
        $id = $data['id'] ?? null;

        if (! $id || ! $this->notifications->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Notificação não encontrada.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        if (! $this->notifications->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->notifications->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Notificação atualizada com sucesso!',
            'csrf' => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

    public function delete()
    {
        $data = $this->request->getJSON(true);
        $id = $data['id'] ?? null;

        if (! $id || ! $this->notifications->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Notificação não encontrada.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        if (! $this->notifications->delete($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro ao eliminar a notificação.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Notificação eliminada com sucesso!',
            'modalClose' => true,
            'csrf' => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
}
