<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row mb-1">
    <!-- Total de Marcas -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Total de Marcas</h6>
                    <i class="mdi mdi-tag-multiple text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['total'] ?? 0 ?></h3>
                <small class="text-muted">registadas no sistema</small>
            </div>
        </div>
    </div>

    <!-- Marcas Ativas -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Ativas</h6>
                    <i class="mdi mdi-check-decagram text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['active'] ?? 0 ?></h3>
                <small class="text-muted">marcas visíveis no catálogo</small>
            </div>
        </div>
    </div>

    <!-- Em Destaque -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Em Destaque</h6>
                    <i class="mdi mdi-star text-warning fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['featured'] ?? 0 ?></h3>
                <small class="text-muted">marcas promovidas</small>
            </div>
        </div>
    </div>

    <!-- Total de Produtos -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Produtos</h6>
                    <i class="mdi mdi-package-variant-closed text-info fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['products'] ?? 0 ?></h3>
                <small class="text-muted">total de artigos registados</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <div class="search-box me-2 mb-2 d-inline-block">
                            <div class="position-relative">
                                <h4 class="card-title">Lista de Marcas</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <button type="button" x-data="systemModal()"
                                    @click="open('#formBrand', 'md')"
                                    class="btn btn-primary">
                                <i class="bx bx-plus-circle me-1"></i> Adicionar
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100 align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>Logo</th>
                                <th>Nome</th>
                                <th>Fornecedor</th>
                                <th>País</th>
                                <th>Website</th>
                                <th>Artigos</th>
                                <th>Status</th>
                                <th>Destaque</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($brands as $brand): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($brand['logo']) && file_exists(FCPATH . 'uploads/brands/' . $brand['logo'])): ?>
                                            <img src="<?= base_url('uploads/brands/' . $brand['logo']) ?>"
                                                 alt="<?= esc($brand['name']) ?>"
                                                 class="rounded border bg-light"
                                                 width="40" height="40">
                                        <?php else: ?>
                                            <div class="bg-light text-muted text-center rounded"
                                                 style="width:40px;height:40px;line-height:40px;">
                                                <i class="mdi mdi-image-off"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?= esc($brand['name']) ?></strong></td>
                                    <td><?= esc($brand['supplier_name'] ?? '—') ?></td>
                                    <td><?= esc($brand['country'] ?? '—') ?></td>
                                    <td>
                                        <?php if (!empty($brand['website'])): ?>
                                            <a href="<?= esc($brand['website']) ?>" target="_blank">
                                                <?= parse_url($brand['website'], PHP_URL_HOST) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark"><?= $brand['product_count'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($brand['is_active']): ?>
                                            <span class="badge bg-success">Ativa</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inativa</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($brand['featured']): ?>
                                            <i class="mdi mdi-star text-warning fs-5" title="Marca em destaque"></i>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="<?= base_url('admin/catalog/brands/edit/' . $brand['id']) ?>"
                                               class="btn btn-sm btn-light text-info" title="Editar marca">
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </a>
                                        </div>
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
<div id="formBrand" class="d-none">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Criar Marca</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body"
             x-data="{
                ...formHandler('/admin/catalog/brands/store',
                  {
                    name: '',
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
