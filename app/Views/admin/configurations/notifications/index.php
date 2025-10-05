<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Canais de Notificação<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="card-title mb-0">Canais de Notificação</h4>
                        <p class="text-muted">Gestão dos canais de notificações do sistema</p>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <button type="button"
                                x-data="systemModal()"
                                @click="open('#createNotification', 'md')"
                                class="btn btn-primary">
                            <i class="mdi mdi-plus me-1"></i> Adicionar
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered nowrap w-100">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Canal</th>
                            <th>Provider</th>
                            <th>Status</th>
                            <th>Atualizado em</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($notifications)): ?>
                            <?php foreach ($notifications as $n): ?>
                                <tr>
                                    <td><?= esc($n['id']) ?></td>
                                    <td><?= esc($n['channel']) ?></td>
                                    <td><?= esc($n['provider']) ?></td>
                                    <td>
                                        <?= $n['status']
                                            ? '<span class="badge bg-success">Ativo</span>'
                                            : '<span class="badge bg-secondary">Inativo</span>' ?>
                                    </td>
                                    <td><?= esc($n['updated_at'] ?? '—') ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#editNotification', 'md', {
                                                                id: '<?= $n['id'] ?>',
                                                                channel: '<?= $n['channel'] ?>',
                                                                provider: '<?= $n['provider'] ?>',
                                                                config_json: `<?= esc($n['config_json']) ?>`,
                                                                status: '<?= $n['status'] ?>'
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-pencil text-success me-1"></i> Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#deleteNotification', 'md', {
                                                                id: '<?= $n['id'] ?>',
                                                                provider: '<?= $n['provider'] ?>'
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-trash-can text-danger me-1"></i> Eliminar
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">Nenhum canal registado.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Create Notification -->
<div id="createNotification" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/notifications/store', {
            channel: '', provider: '', config_json: '{}', status: 1,
            <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         }, { resetOnSuccess: true })"
         x-init="csrfHandler(form)">
        <div class="modal-header">
            <h5 class="modal-title">Criar Canal de Notificação</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="submit()">

                <div class="mb-3">
                    <label>Canal *</label>
                    <select class="form-select" x-model="form.channel">
                        <option value="">Selecione...</option>
                        <option value="Email">Email</option>
                        <option value="SMS">SMS</option>
                        <option value="Push">Push</option>
                    </select>
                    <div class="text-danger small" x-text="errors.channel"></div>
                </div>

                <div class="mb-3">
                    <label>Provider *</label>
                    <input type="text" class="form-control" x-model="form.provider" placeholder="Ex: Twilio, Mailgun, Firebase">
                    <div class="text-danger small" x-text="errors.provider"></div>
                </div>

                <div class="mb-3">
                    <label>Configuração (JSON)</label>
                    <textarea class="form-control font-monospace small" rows="4" x-model="form.config_json" placeholder='{"api_key": "", "sender": ""}'></textarea>
                </div>

                <div class="mb-3">
                    <label>Status *</label>
                    <select class="form-select" x-model="form.status">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary w-100" :disabled="loading">
                        <span x-show="!loading">Guardar</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A guardar...</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Edit Notification -->
<div id="editNotification" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/notifications/update', {
             id:'', channel:'', provider:'', config_json:'{}', status:1,
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="csrfHandler(form); $el.addEventListener('fill-form', e => { Object.assign(form, e.detail); });">
        <div class="modal-header">
            <h5 class="modal-title">Editar Canal de Notificação</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">

                <div class="mb-3">
                    <label>Canal *</label>
                    <select class="form-select" x-model="form.channel">
                        <option value="Email">Email</option>
                        <option value="SMS">SMS</option>
                        <option value="Push">Push</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Provider *</label>
                    <input type="text" class="form-control" x-model="form.provider">
                </div>

                <div class="mb-3">
                    <label>Configuração (JSON)</label>
                    <textarea class="form-control font-monospace small" rows="4" x-model="form.config_json"></textarea>
                </div>

                <div class="mb-3">
                    <label>Status *</label>
                    <select class="form-select" x-model="form.status">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary w-100" :disabled="loading">
                        <span x-show="!loading">Guardar</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A guardar...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Notification -->
<div id="deleteNotification" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/notifications/delete', {
             id:'', provider:'',
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="$el.addEventListener('fill-form', e => { Object.assign(form, e.detail); csrfHandler(form); });">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar Canal de Notificação</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">
                <p>Tem a certeza que deseja eliminar o canal <strong x-text="form.provider"></strong>?</p>
                <div class="modal-footer">
                    <button class="btn btn-danger w-100">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
