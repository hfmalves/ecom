<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="d-flex align-items-center">
            <div class="ms-3 flex-grow-1">
                <h5 class="mb-2 card-title">Hello, Henry Franklin</h5>
                <p class="text-muted mb-0">Ready to jump back in?</p>
            </div>

            <a href="javascript:void(0);"
               class="btn btn-primary"
               onclick="document.getElementById('customerForm').dispatchEvent(new Event('submit', { bubbles:true, cancelable:true }))">
                Guardar
            </a>

        </div>
    </div><!--end col-->
</div><!--end row-->
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
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            }
        )"
      @submit.prevent="submit">
    <div class="row">
        <div class="col-8">
            <!-- Informação Geral -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Compras</h4>
                    <p class="card-title-desc">Ultimas Compras</p>
                    <div class="row">
                        <div class="col-8" x-data="{ field: 'name' }">

                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pagamentos</h4>
                    <p class="card-title-desc">Ultimas Compras</p>
                    <div class="row">
                        <div class="col-8" x-data="{ field: 'name' }">

                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Faturas</h4>
                    <p class="card-title-desc">Ultimas Compras</p>
                    <div class="row">
                        <div class="col-8" x-data="{ field: 'name' }">

                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Devoluções</h4>
                    <p class="card-title-desc">Ultimas Compras</p>
                    <div class="row">
                        <div class="col-8" x-data="{ field: 'name' }">

                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Analises</h4>
                    <p class="card-title-desc">Ultimas Compras</p>
                    <div class="row">
                        <div class="col-8" x-data="{ field: 'name' }">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Coluna lateral -->
        <div class="col-4">
            <!-- Estado -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informação de Conta</h4>
                    <p class="card-title-desc">Defina se o fornecedor está ativo ou inativo</p>
                    <div class="row">
                        <!-- Nome -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'name' }">
                            <label class="form-label" :for="field">Nome</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Nome do cliente"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Contato -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'phone' }">
                            <label class="form-label" :for="field">Contato</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Telefone ou telemóvel"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'email' }">
                            <label class="form-label" :for="field">Email</label>
                            <input type="email" class="form-control" :id="field" :name="field"
                                   placeholder="Email do cliente"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Estado -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'is_active' }">
                            <label class="form-label" :for="field">Estado</label>
                            <select class="form-select" :id="field" :name="field"
                                    x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>
                        <!-- Verificado -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'is_verified' }">
                            <label class="form-label" :for="field">Verificado</label>
                            <select class="form-select" :id="field" :name="field"
                                    x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Login em 2 Passos -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'login_2step' }">
                            <label class="form-label" :for="field">Login em 2 Passos</label>
                            <select class="form-select" :id="field" :name="field"
                                    x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>
                        <!-- Grupo do Cliente -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'group_id' }">
                            <label class="form-label" :for="field">Grupo do Cliente</label>
                            <select class="form-select" :id="field" :name="field"
                                    x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <?php foreach ($costumers_group ?? [] as $costumer_group): ?>
                                    <option value="<?= $costumer_group['id'] ?>">
                                        <?= esc($costumer_group['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection() ?>
<?= $this->section('content-script') ?>

<?= $this->endSection() ?>
