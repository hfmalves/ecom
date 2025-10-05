<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Registos de Segurança
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">Registos do Sistema</h4>

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
</div>
<?= $this->endSection() ?>
