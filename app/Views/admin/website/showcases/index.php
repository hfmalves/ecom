<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Gestão de Vitrines
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0 fw-bold">Gestão de Vitrines</h4>
                    <small class="text-muted">Visualize, edite ou remova vitrines da loja</small>
                </div>
                <button type="button"
                        class="btn btn-primary btn-sm"
                        x-data="systemModal()"
                        @click="
                            close();
                            setTimeout(() => {
                                new bootstrap.Modal(document.getElementById('formShowcase')).show();
                            }, 300);
                        "
                        >
                    <i class="bx bx-plus-circle me-1"></i> Nova Home
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-hover align-middle nowrap w-100">
                        <thead class="table-light">
                        <tr>
                            <th>Loja</th>
                            <th>Default</th>
                            <th>Estado</th>
                            <th>Codigo</th>
                            <th>Nome</th>
                            <th>Ativo desde</th>
                            <th>Ativo até</th>
                            <th class="text-center">Ações</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($showcases as $showcase): ?>
                            <tr>
                                <td><?= esc($showcase['store_id'] ?? '-') ?></td>

                                <td>
                                    <?php if (!empty($showcase['is_default'])): ?>
                                        <span class="badge bg-success w-100">Sim</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary w-100">Não</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (!empty($showcase['is_active'])): ?>
                                        <span class="badge bg-success w-100">Ativo</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger w-100">Inativo</span>
                                    <?php endif; ?>
                                </td>

                                <td><?= esc($showcase['home_code'] ?? '-') ?></td>
                                <td><?= esc($showcase['name'] ?? '-') ?></td>
                                <td><?= esc($showcase['active_start'] ?? '-') ?></td>
                                <td><?= esc($showcase['active_end'] ?? '-') ?></td>

                                <td class="text-center">
                                    <ul class="list-unstyled hstack gap-1 mb-0 justify-content-center">
                                        <li>
                                            <a href="<?= site_url('admin/website/showcases/edit/' . $showcase['id']) ?>"
                                               class="btn btn-sm btn-light text-info"
                                               title="Editar Home">
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </a>
                                        </li>

                                        <li>
                                            <button type="button"
                                                    class="btn btn-sm btn-light text-warning"
                                                    onclick="
                                                            window.dispatchEvent(new CustomEvent('showcase-deactivate', {
                                                            detail: {
                                                            id: <?= (int) $showcase['id'] ?>,
                                                            home_code: '<?= esc($showcase['home_code'], 'js') ?>',
                                                            name: '<?= esc($showcase['name'] ?: '-', 'js') ?>'
                                                            }
                                                            }));
                                                            new bootstrap.Modal(document.getElementById('modalDeactivateShowcase')).show();
                                                            "
                                                    title="Desativar Home">
                                                <i class="mdi mdi-cancel"></i>
                                            </button>

                                        </li>

                                        <li>
                                            <button type="button"
                                                    class="btn btn-sm btn-light text-danger"
                                                    onclick="
                                                            window.dispatchEvent(new CustomEvent('showcase-delete', {
                                                            detail: {
                                                            id: <?= (int) $showcase['id'] ?>,
                                                            home_code: '<?= esc($showcase['home_code'], 'js') ?>',
                                                            name: '<?= esc($showcase['name'] ?: '-', 'js') ?>'
                                                            }
                                                            }));
                                                            new bootstrap.Modal(document.getElementById('modalDeleteShowcase')).show();
                                                            "
                                                    title="Eliminar Home">
                                                <i class="mdi mdi-trash-can-outline"></i>
                                            </button>



                                        </li>
                                    </ul>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalDeactivateShowcase" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', name: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/website/showcases/deactivate', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        bootstrap.Modal.getInstance(
                            document.getElementById('modalDeactivateShowcase')
                        ).hide();
                        if (data.message) {
                            showToast(data.message, data.status === 'success' ? 'success' : 'error');
                        }
                    })
                    .catch(() => this.loading = false);
                }
             }"
             x-init="
                window.addEventListener('showcase-deactivate', e => {
                    form.id = e.detail.id;
                    form.name = e.detail.name;
                    form.home_code = e.detail.home_code;
                });
             ">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title text-warning">Desativar Home</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <i class="mdi mdi-alert-outline text-warning fs-1"></i>
                <p class="mt-2">Tem a certeza que quer desativar esta home?</p>
                <p><strong>Código:</strong> <span x-text="form.home_code"></span></p>
                <p><strong>Nome:</strong> <span x-text="form.name"></span></p>
            </div>

            <div class="modal-footer">
                <button @click="submit" type="button" class="btn btn-warning" :disabled="loading">
                    <span x-show="!loading">Confirmar</span>
                    <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A processar…</span>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteShowcase" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', name: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/website/showcases/delete', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        bootstrap.Modal.getInstance(
                            document.getElementById('modalDeleteShowcase')
                        ).hide();
                        if (data.message) {
                            showToast(data.message, data.status === 'success' ? 'success' : 'error');
                        }
                    })
                    .catch(() => this.loading = false);
                }
             }"
             x-init="
                window.addEventListener('showcase-delete', e => {
                    form.id = e.detail.id;
                    form.name = e.detail.name;
                    form.home_code = e.detail.home_code;
                });
             ">
            <div class="modal-header bg-danger-subtle">
                <h5 class="modal-title text-danger">Eliminar Home</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <i class="mdi mdi-alert-octagram text-danger fs-1"></i>
                <p class="mt-2">Esta ação é irreversível.</p>
                <p><strong>Código:</strong> <span x-text="form.home_code"></span></p>
                <p><strong>Nome:</strong> <span x-text="form.name"></span></p>
            </div>

            <div class="modal-footer">
                <button @click="submit" type="button" class="btn btn-danger" :disabled="loading">
                    <span x-show="!loading">Eliminar</span>
                    <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A processar…</span>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="formShowcase" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"
             x-data="{
                form: {
                    name: '',
                    is_active: 1,
                    is_default: 0,
                    active_start: '',
                    active_end: '',
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/website/showcases/create', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.form['<?= csrf_token() ?>']
                        },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        if (data.status === 'success') {
                            bootstrap.Modal.getInstance(
                                document.getElementById('formShowcase')
                            ).hide();
                            location.reload();
                        } else {
                            showToast(data.message, 'error');
                        }
                    })
                    .catch(() => this.loading = false);
                }
             }">
            <div class="modal-header">
                <h5 class="modal-title">Nova Home</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" x-model="form.name">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Ativo desde</label>
                        <input type="datetime-local" class="form-control" x-model="form.active_start">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ativo até</label>
                        <input type="datetime-local" class="form-control" x-model="form.active_end">
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="switchIsActive"
                                   x-model="form.is_active">
                            <label class="form-check-label" for="switchIsActive">
                                Ativo
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="switchIsDefault"
                                   x-model="form.is_default">
                            <label class="form-check-label" for="switchIsDefault">
                                Default
                            </label>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-primary" @click="submit" :disabled="loading">
                    <span x-show="!loading">Criar</span>
                    <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A criar…</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
