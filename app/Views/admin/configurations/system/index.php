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

                            <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nível</th>
                                <th>Mensagem</th>
                                <th>Contexto</th>
                                <th>Criado em</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($logs)): ?>
                                <?php foreach($logs as $log): ?>
                                    <tr>
                                        <td><?= esc($log['id']) ?></td>
                                        <td>
                                            <?php
                                            $levelColors = [
                                                'info' => 'badge bg-info',
                                                'warning' => 'badge bg-warning',
                                                'error' => 'badge bg-danger',
                                                'critical' => 'badge bg-dark'
                                            ];
                                            $class = $levelColors[$log['level']] ?? 'badge bg-secondary';
                                            ?>
                                            <span class="<?= $class ?>"><?= esc(strtoupper($log['level'])) ?></span>
                                        </td>
                                        <td><?= esc($log['message']) ?></td>
                                        <td><pre class="small"><?= esc($log['context']) ?></pre></td>
                                        <td><?= esc($log['created_at']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center">Nenhum registo encontrado.</td></tr>
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
