<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Templates de Emails<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="card-title mb-0">Templates de Emails</h4>
                        <p class="text-muted">Gerir templates de emails do sistema</p>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <button type="button"
                                x-data="systemModal()"
                                @click="open('#createEmail', 'md')"
                                class="btn btn-primary">
                            <i class="mdi mdi-plus me-1"></i> Adicionar
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered dt-responsive nowrap w-100">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Assunto</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($emails)): ?>
                            <?php foreach($emails as $e): ?>
                                <tr>
                                    <td><?= esc($e['id']) ?></td>
                                    <td><?= esc($e['code']) ?></td>
                                    <td><?= esc($e['subject']) ?></td>
                                    <td>
                                        <?= $e['status'] ? '<span class="badge bg-success">Ativo</span>' : '<span class="badge bg-secondary">Inativo</span>' ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#editEmail','md',{
                                                                id:'<?= $e['id'] ?>',
                                                                code:'<?= $e['code'] ?>',
                                                                subject:'<?= esc($e['subject']) ?>',
                                                                body_html:`<?= esc($e['body_html']) ?>`,
                                                                status:'<?= $e['status'] ?>'
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-pencil text-success me-1"></i> Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#deleteEmail','md',{
                                                                id:'<?= $e['id'] ?>',
                                                                code:'<?= $e['code'] ?>'
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
                            <tr><td colspan="5" class="text-center">Nenhum template registado.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Create Email -->
<div id="createEmail" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/emails/store',{
             code:'', subject:'', body_html:'', status:1,
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         },{ resetOnSuccess:true })"
         x-init="csrfHandler(form)">
        <div class="modal-header">
            <h5 class="modal-title">Criar Template de Email</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form @submit.prevent="submit()">
                <div class="mb-3">
                    <label>Código *</label>
                    <input type="text" class="form-control" x-model="form.code">
                    <div class="text-danger small" x-text="errors.code"></div>
                </div>
                <div class="mb-3">
                    <label>Assunto *</label>
                    <input type="text" class="form-control" x-model="form.subject">
                    <div class="text-danger small" x-text="errors.subject"></div>
                </div>
                <div class="mb-3">
                    <label>Corpo HTML *</label>
                    <textarea class="form-control font-monospace" rows="6" x-model="form.body_html"></textarea>
                    <div class="text-danger small" x-text="errors.body_html"></div>
                </div>
                <div class="mb-3">
                    <label>Status</label>
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

<!-- Edit Email -->
<div id="editEmail" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/emails/update',{
             id:'', code:'', subject:'', body_html:'', status:1,
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="$el.addEventListener('fill-form',e=>{ Object.assign(form,e.detail); csrfHandler(form); })">
        <div class="modal-header">
            <h5 class="modal-title">Editar Template de Email</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">
                <div class="mb-3">
                    <label>Código *</label>
                    <input type="text" class="form-control" x-model="form.code">
                </div>
                <div class="mb-3">
                    <label>Assunto *</label>
                    <input type="text" class="form-control" x-model="form.subject">
                </div>
                <div class="mb-3">
                    <label>Corpo HTML *</label>
                    <textarea class="form-control font-monospace" rows="6" x-model="form.body_html"></textarea>
                </div>
                <div class="mb-3">
                    <label>Status</label>
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

<!-- Delete Email -->
<div id="deleteEmail" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/emails/delete',{
             id:'', code:'',
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="$el.addEventListener('fill-form', e => { Object.assign(form,e.detail); csrfHandler(form); })">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar Template de Email</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">
                <p>Tem a certeza que deseja eliminar o template <strong x-text="form.code"></strong>?</p>
                <div class="modal-footer">
                    <button class="btn btn-danger w-100">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
