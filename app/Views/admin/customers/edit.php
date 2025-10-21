<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Gestão de Cliente
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-lg-12">
        <div class="d-flex align-items-center">
            <div class="ms-3 flex-grow-1">
                <h5 class="mb-2 card-title">Gestão de Cliente</h5>
                <p class="text-muted mb-0">Editar informações e preferências do cliente</p>
            </div>
            <a href="javascript:void(0);"
               class="btn btn-primary"
               onclick="document.getElementById('customerForm').dispatchEvent(new Event('submit', { bubbles:true, cancelable:true }))">
                Guardar
            </a>
        </div>
    </div>
</div>

<form id="customerForm"
      x-ref="form"
      x-data="formHandler(
          '<?= base_url('admin/customers/update') ?>',
          {
              id: '<?= $customer['id'] ?>',
              name: '<?= esc($customer['name']) ?>',
              email: '<?= esc($customer['email']) ?>',
              phone: '<?= esc($customer['phone']) ?>',
              is_active: '<?= $customer['is_active'] ?>',
              is_verified: '<?= $customer['is_verified'] ?>',
              login_2step: '<?= $customer['login_2step'] ?>',
              group_id: '<?= $customer['group_id'] ?>',
              date_of_birth: '<?= $customer['date_of_birth'] ?>',
              preferred_language: '<?= $customer['preferred_language'] ?>',
              preferred_currency: '<?= $customer['preferred_currency'] ?>',
              loyalty_points: '<?= $customer['loyalty_points'] ?>',
              newsletter_optin: '<?= $customer['newsletter_optin'] ?>',
              <?= csrf_token() ?>: '<?= csrf_hash() ?>'
          }
      )"
      @submit.prevent="submit">

    <div class="row">
        <!-- Coluna Principal -->
        <div class="col-8">

            <?php foreach (['Compras', 'Pagamentos', 'Faturas', 'Devoluções', 'Análises'] as $titulo): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="card-title"><?= esc($titulo) ?></h4>
                        <p class="card-title-desc">Últimos registos de <?= strtolower($titulo) ?></p>

                        <div class="table-responsive">
                            <table class="table table-sm table-striped align-middle mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Descrição</th>
                                    <th>Data</th>
                                    <th class="text-end">Valor</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Sem registos</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <!-- Coluna Lateral -->
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informação de Conta</h4>
                    <p class="card-title-desc">Defina o estado e preferências do cliente</p>

                    <div class="row">
                        <!-- Nome -->
                        <div class="col-md-12 mb-3" x-data="{ field: 'name' }">
                            <label class="form-label" :for="field">Nome</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Nome completo" x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>

                        <!-- Email -->
                        <div class="col-md-12 mb-3" x-data="{ field: 'email' }">
                            <label class="form-label" :for="field">Email</label>
                            <input type="email" class="form-control" :id="field" :name="field"
                                   placeholder="Email do cliente" x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>

                        <!-- Telefone -->
                        <div class="col-md-12 mb-3" x-data="{ field: 'phone' }">
                            <label class="form-label" :for="field">Telefone</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Telefone / Telemóvel" x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'is_active' }">
                            <label class="form-label" :for="field">Estado</label>
                            <select class="form-select select2" data-minimum-results-for-search="Infinity"
                                    :id="field" :name="field" x-model="form[field]" x-init="initSelect2($el)">
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>

                        <!-- Verificado -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'is_verified' }">
                            <label class="form-label" :for="field">Verificado</label>
                            <select class="form-select select2" data-minimum-results-for-search="Infinity"
                                    :id="field" :name="field" x-model="form[field]" x-init="initSelect2($el)">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>

                        <!-- Login 2FA -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'login_2step' }">
                            <label class="form-label" :for="field">2FA</label>
                            <select class="form-select select2" data-minimum-results-for-search="Infinity"
                                    :id="field" :name="field" x-model="form[field]" x-init="initSelect2($el)">
                                <option value="1">Ativo</option>
                                <option value="0">Desativado</option>
                            </select>
                        </div>

                        <!-- Grupo -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'group_id' }">
                            <label class="form-label" :for="field">Grupo</label>
                            <select class="form-select select2" :id="field" :name="field"
                                    x-model="form[field]" x-init="initSelect2($el)">
                                <?php foreach ($costumers_group ?? [] as $cg): ?>
                                    <option value="<?= $cg['id'] ?>"><?= esc($cg['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Data Nascimento -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'date_of_birth' }">
                            <label class="form-label" :for="field">Data de Nascimento</label>
                            <input type="date" class="form-control" :id="field" :name="field"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                        </div>

                        <!-- Newsletter -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'newsletter_optin' }">
                            <label class="form-label" :for="field">Newsletter</label>
                            <select class="form-select select2" :id="field" :name="field"
                                    x-model="form[field]" x-init="initSelect2($el)">
                                <option value="1">Subscrito</option>
                                <option value="0">Não Subscrito</option>
                            </select>
                        </div>

                        <!-- Pontos de Fidelização -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'loyalty_points' }">
                            <label class="form-label" :for="field">Pontos</label>
                            <input type="number" min="0" class="form-control" :id="field" :name="field"
                                   x-model="form[field]" placeholder="0" :class="{ 'is-invalid': errors[field] }">
                        </div>

                        <!-- Idioma -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'preferred_language' }">
                            <label class="form-label" :for="field">Idioma</label>
                            <select class="form-select select2" :id="field" :name="field"
                                    x-model="form[field]" x-init="initSelect2($el)">
                                <option value="pt_PT">Português</option>
                                <option value="en_US">Inglês</option>
                                <option value="es_ES">Espanhol</option>
                            </select>
                        </div>

                        <!-- Moeda -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'preferred_currency' }">
                            <label class="form-label" :for="field">Moeda</label>
                            <select class="form-select select2" :id="field" :name="field"
                                    x-model="form[field]" x-init="initSelect2($el)">
                                <option value="EUR">Euro (EUR)</option>
                                <option value="USD">Dólar (USD)</option>
                                <option value="GBP">Libra (GBP)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('content-script') ?>
<script>
    function initSelect2(el) {
        $(el).select2({
            width: '100%',
            minimumResultsForSearch: Infinity
        }).on('change', function () {
            let event = new Event('input', { bubbles: true });
            event.simulated = true;
            this.dispatchEvent(event);
        });
    }
</script>
<?= $this->endSection() ?>
