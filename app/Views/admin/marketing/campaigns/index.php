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
                                    @click="open('#formCustomer', 'md')"
                                    class="btn btn-primary">
                                <i class="fa-solid fa-plus me-1"></i> Adicionar
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Tipo Desconto</th>
                                <th>Valor</th>
                                <th>Início</th>
                                <th>Fim</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($campaigns)): ?>
                                <?php foreach ($campaigns as $c): ?>
                                    <tr>
                                        <td><?= esc($c['id']) ?></td>
                                        <td><?= esc($c['name']) ?></td>
                                        <td><?= esc($c['discount_type']) ?></td>
                                        <td><?= esc($c['discount_value']) ?></td>
                                        <td><?= esc($c['start_date']) ?></td>
                                        <td><?= esc($c['end_date']) ?></td>
                                        <td>
                            <span class="badge <?= $c['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                <?= esc(ucfirst($c['status'])) ?>
                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Nenhuma campanha encontrada.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<?= $this->endSection() ?>
