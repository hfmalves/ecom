<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="d-flex align-items-center">
            <div class="ms-3 flex-grow-1">
                <h5 class="mb-2 card-title">Detalhes da Encomenda</h5>
                <p class="text-muted mb-0">Consulta e gere todas as informações associadas a esta encomenda.</p>
            </div>
        </div>
    </div><!--end col-->
</div><!--end row-->
<div class="row">
    <div class="col-8">
        <!-- Informação Geral -->
        <div class="card">
            <div class="card-body" >


                <table class="table table-sm table-striped align-middle mt-3">
                    <thead>
                    <tr>
                        <th>Artigo</th>
                        <th>SKU</th>
                        <th>Qtd</th>
                        <th>Preço</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody x-ref="tbody"></tbody>
                </table>
            </div>
        </div>





        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Morada de Envio</h4>
                        <p class="card-title-desc">Dados do cliente para faturação</p>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Morada de Faturação</h4>
                        <p class="card-title-desc">Dados do cliente para faturação</p>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Coluna lateral -->
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informação do Cliente</h4>
                <p class="card-title-desc">Dados principais da conta do cliente</p>
                <div class="row">
                    <!-- Nome -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control"
                               value="" readonly>
                    </div>
                </div>
                <div class="row">
                    <!-- Telefone -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" class="form-control"
                               value="" readonly>
                    </div>
                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control"
                               value="" readonly>
                    </div>
                </div>
                <div class="row">
                    <!-- Estado -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado</label>
                        <input type="text" class="form-control"
                               value="" readonly>
                    </div>
                    <!-- Verificado -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Verificado</label>
                        <input type="text" class="form-control"
                               value="" readonly>
                    </div>
                </div>
                <div class="row">
                    <!-- Grupo -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Grupo de Cliente</label>
                        <input type="text" class="form-control" value="<?= esc($order['user']['group_name'] ?? '-') ?>" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
