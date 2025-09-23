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
               onclick="document.getElementById('supplierForm').dispatchEvent(new Event('submit', { bubbles:true, cancelable:true }))">
                Guardar
            </a>

        </div>
    </div><!--end col-->
</div><!--end row-->
<form id="supplierForm"
      x-ref="form"
      x-data="formHandler(
          '<?= base_url('admin/catalog/suppliers/update') ?>',
          {
              id: '<?= esc($supplier['id']) ?>',
              name: '<?= esc($supplier['name']) ?>',
              contact_person: '<?= esc($supplier['contact_person']) ?>',
              legal_number: '<?= esc($supplier['legal_number']) ?>',
              vat: '<?= esc($supplier['vat']) ?>',
              email: '<?= esc($supplier['email']) ?>',
              phone: '<?= esc($supplier['phone']) ?>',
              website: '<?= esc($supplier['website']) ?>',
              address: '<?= esc($supplier['address']) ?>',
              country: '<?= esc($supplier['country']) ?>',
              iban: '<?= esc($supplier['iban']) ?>',
              payment_terms: '<?= esc($supplier['payment_terms']) ?>',
              currency: '<?= esc($supplier['currency']) ?>',
              image: '<?= esc($supplier['image']) ?>',
              api_key: '<?= esc($supplier['api_key']) ?>',
              api_url: '<?= esc($supplier['api_url']) ?>',
              status: '<?= esc($supplier['status']) ?>',
              created_at: '<?= esc($supplier['created_at']) ?>',
              updated_at: '<?= esc($supplier['updated_at']) ?>',
              <?= csrf_token() ?>: '<?= csrf_hash() ?>'
          }
      )"
      @submit.prevent="submit">
    <div class="row">
        <div class="col-8">
            <!-- Informação Geral -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informação Geral</h4>
                    <p class="card-title-desc">Dados do Fornecedor</p>
                    <div class="row">
                        <div class="col-8" x-data="{ field: 'name' }">
                            <label class="form-label" :for="field">Nome</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Nome do fornecedor"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-4" x-data="{ field: 'contact_person' }">
                            <label :for="field">Pessoa de Contato</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Pessoa responsável"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4" x-data="{ field: 'legal_number' }">
                            <label :for="field">Número Legal</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Número legal da empresa"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-4" x-data="{ field: 'vat' }">
                            <label :for="field">NIF / VAT</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Número de contribuinte (VAT)"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4" x-data="{ field: 'phone' }">
                            <label :for="field">Telefone</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Telefone de contato"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-4" x-data="{ field: 'website' }">
                            <label :for="field">Website</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="URL do website"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-4" x-data="{ field: 'email' }">
                            <label :for="field">Email</label>
                            <input type="email" class="form-control" :id="field" :name="field"
                                   placeholder="ex: fornecedor@exemplo.com"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-8" x-data="{ field: 'address' }">
                            <label :for="field">Endereço</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Rua, nº, cidade"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-4" x-data="{ field: 'country' }">
                            <label :for="field">País</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="País"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
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
                    <h4 class="card-title">Estado</h4>
                    <p class="card-title-desc">Defina se o fornecedor está ativo ou inativo</p>
                    <div class="row">
                        <div class="col-md-6" x-data="{ field: 'status' }">
                            <label class="form-label" :for="field">Estado</label>
                            <select class="form-select" :name="field"
                                    x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <option value="active">Ativo</option>
                                <option value="inactive">Inativo</option>
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
<script>
    $(document).ready(function() {
        $('#description, #short_description').summernote({
            height: 200,
            minHeight: 150,
            maxHeight: null,
            focus: true,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['codeview']]
            ]
        });
    });
</script>
<?= $this->endSection() ?>
