<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row g-3 mb-4">

    <!-- Total de Fornecedores -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Total de Fornecedores</h6>
                    <i class="mdi mdi-factory text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['total'] ?? 0 ?></h3>
                <small class="text-muted">registados no sistema</small>
            </div>
        </div>
    </div>

    <!-- Fornecedores Ativos -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Ativos</h6>
                    <i class="mdi mdi-check-decagram text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['active'] ?? 0 ?></h3>
                <small class="text-muted">disponíveis para compras</small>
            </div>
        </div>
    </div>

    <!-- Fornecedores Inativos -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Inativos</h6>
                    <i class="mdi mdi-minus-circle-outline text-secondary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['inactive'] ?? 0 ?></h3>
                <small class="text-muted">não operacionais</small>
            </div>
        </div>
    </div>

    <!-- Percentagem Ativos -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">% Ativos</h6>
                    <i class="mdi mdi-chart-pie text-info fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['activePct'] ?? 0 ?>%</h3>
                <small class="text-muted">taxa de atividade</small>
            </div>
        </div>
    </div>

    <!-- Países -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Países</h6>
                    <i class="mdi mdi-earth text-warning fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['countries'] ?? 0 ?></h3>
                <small class="text-muted">origens distintas</small>
            </div>
        </div>
    </div>

    <!-- Moedas -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Moedas</h6>
                    <i class="mdi mdi-currency-eur text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['currencies'] ?? 0 ?></h3>
                <small class="text-muted">moedas distintas</small>
            </div>
        </div>
    </div>

    <!-- Termos de Pagamento -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Termos de Pagamento</h6>
                    <i class="mdi mdi-calendar-clock text-secondary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['terms'] ?? 0 ?></h3>
                <small class="text-muted">condições disponíveis</small>
            </div>
        </div>
    </div>

    <!-- IBAN válidos -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">IBAN Válidos</h6>
                    <i class="mdi mdi-bank-outline text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['ibanPct'] ?? 0 ?>%</h3>
                <small class="text-muted">com dados bancários completos</small>
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
                                <h4 class="card-title">Lista de Fornecedores</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <button type="button" x-data="systemModal()"
                                    @click="open('#formSupplier', 'md')"
                                    class="btn btn-primary">
                                <i class="bx bx-plus-circle me-1"></i> Adicionar
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                            <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Pessoa de Contacto</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Website</th>
                                <th>Morada</th>
                                <th>Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($suppliers as $supplier): ?>
                                <tr>
                                    <td><strong><?= esc($supplier['name']) ?></strong></td>
                                    <td>
                                        <?php
                                        $parts = explode(' ', trim($supplier['contact_person']));
                                        $shortName = $parts[0] ?? '';
                                        if (count($parts) > 1) {
                                            $shortName .= ' ' . end($parts);
                                        }
                                        ?>
                                        <?= esc($shortName) ?>
                                    </td>
                                    <td><?= esc($supplier['email']) ?></td>
                                    <td><?= esc($supplier['phone']) ?></td>
                                    <td>
                                        <?php if (!empty($supplier['website'])): ?>
                                            <a href="<?= esc($supplier['website']) ?>" target="_blank">
                                                <?= esc($supplier['website']) ?>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= esc($supplier['address']) ?><br>
                                        <small class="text-muted"><?= esc($supplier['country']) ?></small>
                                    </td>
                                    <td>
                                        <?php if ($supplier['status'] === 'active'): ?>
                                            <span class="badge bg-success w-100">Ativo</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary w-100">Inativo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <ul class="list-unstyled hstack gap-1 mb-0">
                                                <li>
                                                    <a href="<?= base_url('admin/catalog/suppliers/edit/' . $supplier['id']) ?>"
                                                       class="btn btn-sm btn-light text-info"
                                                       title="Editar fornecedor">
                                                        <i class="mdi mdi-pencil-outline"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button"
                                                            class="btn btn-sm btn-light text-danger"
                                                            title="Eliminar fornecedor"
                                                            onclick="confirmDelete(<?= $supplier['id'] ?>)">
                                                        <i class="mdi mdi-trash-can-outline"></i>
                                                    </button>
                                                </li>
                                            </ul>
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
