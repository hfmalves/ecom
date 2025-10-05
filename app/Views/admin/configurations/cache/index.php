<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Configurações de Cache<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="card-title mb-0">Cache</h4>
                        <p class="text-muted">Gestão dos drivers de cache</p>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <button type="button" x-data="systemModal()" @click="open('#createCache', 'md')" class="btn btn-primary">
                            <i class="mdi mdi-plus me-1"></i> Adicionar
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered dt-responsive nowrap w-100">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Driver</th>
                            <th>Configuração</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($cache)): ?>
                            <?php foreach($cache as $c): ?>
                                <tr>
                                    <td><?= esc($c['id']) ?></td>
                                    <td><?= esc($c['driver']) ?></td>
                                    <td><pre class="small"><?= esc($c['config_json']) ?></pre></td>
                                    <td><?= $c['status'] ? '<span class="badge bg-success">Ativo</span>' : '<span class="badge bg-secondary">Inativo</span>' ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#editCache', 'md', {
                                                                id: '<?= $c['id'] ?>',
                                                                driver: '<?= $c['driver'] ?>',
                                                                config_json: '<?= esc($c['config_json']) ?>',
                                                                status: '<?= $c['status'] ?>'
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-pencil text-success me-1"></i> Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#deleteCache', 'md', {
                                                                id: '<?= $c['id'] ?>',
                                                                driver: '<?= $c['driver'] ?>'
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-trash-can text-danger me-1"></i> Apagar
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">Nenhum driver de cache registado.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Create Cache -->
<div id="createCache" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/cache/store', {
            driver: '',
            config_json: '',
            status: 1,
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
         }, { resetOnSuccess: true })"
         x-init="csrfHandler(form)">
        <div class="modal-header">
            <h5 class="modal-title">Criar Driver de Cache</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="submit()">
                <div class="mb-3">
                    <label>Driver *</label>
                    <input type="text" class="form-control" x-model="form.driver">
                    <div class="text-danger small" x-text="errors.driver"></div>
                </div>

                <div class="mb-3">
                    <label>Configuração (JSON)</label>
                    <textarea class="form-control" rows="5" x-model="form.config_json"
                              placeholder='{"host":"localhost","port":6379}'></textarea>
                    <div class="text-danger small" x-text="errors.config_json"></div>
                </div>

                <div class="mb-3">
                    <label>Status *</label>
                    <select class="form-select" x-model="form.status">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                    <div class="text-danger small" x-text="errors.status"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" :disabled="loading">
                        <span x-show="!loading">Guardar</span>
                        <span x-show="loading">
                            <i class="fa fa-spinner fa-spin"></i> A guardar...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Cache -->
<div id="editCache" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/cache/update', {
            id: '', driver: '', config_json: '', status: '',
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
         })"
         x-init="
            csrfHandler(form);
            $el.addEventListener('fill-form', e => { Object.assign(form, e.detail) });
         ">
        <div class="modal-header">
            <h5 class="modal-title">Editar Driver de Cache</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">

                <div class="mb-3">
                    <label>Driver *</label>
                    <input type="text" class="form-control" x-model="form.driver">
                    <div class="text-danger small" x-text="errors.driver"></div>
                </div>

                <div class="mb-3">
                    <label>Configuração (JSON)</label>
                    <textarea class="form-control" rows="5" x-model="form.config_json"></textarea>
                    <div class="text-danger small" x-text="errors.config_json"></div>
                </div>

                <div class="mb-3">
                    <label>Status *</label>
                    <select class="form-select" x-model="form.status">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                    <div class="text-danger small" x-text="errors.status"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" :disabled="loading">
                        <span x-show="!loading">Guardar Alterações</span>
                        <span x-show="loading">
                            <i class="fa fa-spinner fa-spin"></i> A guardar...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Cache -->
<div id="deleteCache" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/cache/delete', {
            id: '', driver: '',
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
         })"
         x-init="
            csrfHandler(form);
            $el.addEventListener('fill-form', e => { Object.assign(form, e.detail) });
         ">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar Driver de Cache</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">
                <p>Tem a certeza que deseja eliminar o driver <strong x-text="form.driver"></strong>?</p>
                <div class="modal-footer">
                    <button class="btn btn-danger" :disabled="loading">
                        <span x-show="!loading">Eliminar</span>
                        <span x-show="loading">
                            <i class="fa fa-spinner fa-spin"></i> A eliminar...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
