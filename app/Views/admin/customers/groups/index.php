<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <div class="search-box me-2 mb-2 d-inline-block">
                            <div class="position-relative">
                                <h4 class="card-title">Default Datatable</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <button type="button" x-data="systemModal()"
                                    @click="open('#formSupplier', 'md')"
                                    class="btn btn-primary">
                                <i class="fa-solid fa-plus me-1"></i> Adicionar
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <h1>Grupos de Clientes</h1>
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                            <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Desconto (%)</th>
                                <th>Min. Encomenda</th>
                                <th>Max. Encomenda</th>
                                <th>Padrão</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($costumers_groups as $g): ?>
                                <tr>
                                    <td><?= esc($g['name']) ?></td>
                                    <td><?= esc($g['description']) ?></td>
                                    <td><?= esc($g['discount_percent']) ?>%</td>
                                    <td><?= $g['min_order_value'] ? number_format($g['min_order_value'], 2, ',', '.') : '-' ?></td>
                                    <td><?= $g['max_order_value'] ? number_format($g['max_order_value'], 2, ',', '.') : '-' ?></td>
                                    <td>
                                        <?= $g['is_default'] ? '<span class="badge bg-primary w-100">Sim</span>' : '<span class="badge bg-secondary w-100">Não</span>' ?>
                                    </td>
                                    <td>
                                        <?= $g['status'] === 'active'
                                                ? '<span class="badge bg-success w-100">Ativo</span>'
                                                : '<span class="badge bg-danger w-100">Inativo</span>' ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('admin/customers/groups/edit/' . $g['id']) ?>"
                                           class="btn btn-sm btn-primary">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<div id="formSupplier" class="d-none">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Criar Fornecedor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body"
             x-data="{
                ...formHandler('/admin/catalog/suppliers/store',
                  {
                    id: '',
                    name: '',
                    legal_number: '',
                    email: '',
                    status: 'active',
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                  },
                  { resetOnSuccess: true })
             }"
             x-init="
                $el.addEventListener('fill-form', e => {
                  Object.entries(e.detail).forEach(([k,v]) => { if (k in form) form[k] = v })
                });
                $el.addEventListener('reset-form', () => {
                  Object.keys(form).forEach(k => {
                    if (k !== '<?= csrf_token() ?>') form[k] = ''
                  })
                });
                document.addEventListener('csrf-update', e => {
                  form[e.detail.token] = e.detail.hash
                });
             ">

            <form @submit.prevent="submit()">
                <!-- Nome -->
                <div class="mb-3">
                    <label class="form-label">Nome *</label>
                    <input type="text" class="form-control" name="name" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>

                <!-- Número Legal -->
                <div class="mb-3">
                    <label class="form-label">Número Legal *</label>
                    <input type="text" class="form-control" name="legal_number" x-model="form.legal_number">
                    <div class="text-danger small" x-text="errors.legal_number"></div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" class="form-control" name="email" x-model="form.email">
                    <div class="text-danger small" x-text="errors.email"></div>
                </div>

                <div class="modal-footer mt-3">
                    <button type="submit" class="btn btn-primary" :disabled="loading">
                        <span x-show="!loading">Guardar</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A guardar...</span>
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
