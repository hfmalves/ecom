<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Editar Fornecedor<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-lg-12 d-flex align-items-center justify-content-between">
        <div>
            <h5 class="mb-1 card-title">Gestão de Fornecedor</h5>
            <p class="text-muted mb-0">Atualize os dados do fornecedor de forma segura e rápida.</p>
        </div>
        <button type="button" class="btn btn-primary px-4"
                onclick="document.getElementById('supplierForm').dispatchEvent(new Event('submit', { bubbles:true, cancelable:true }))">
            <i class="mdi mdi-content-save-outline me-1"></i> Guardar
        </button>
    </div>
</div>

<form id="supplierForm"
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
              swift: '<?= esc($supplier['swift']) ?>',
              payment_terms: '<?= esc($supplier['payment_terms']) ?>',
              currency: '<?= esc($supplier['currency']) ?>',
              type: '<?= esc($supplier['type']) ?>',
              risk_level: '<?= esc($supplier['risk_level']) ?>',
              api_key: '<?= esc($supplier['api_key']) ?>',
              api_url: '<?= esc($supplier['api_url']) ?>',
              status: '<?= esc($supplier['status']) ?>',
              created_at: '<?= esc($supplier['created_at']) ?>',
              updated_at: '<?= esc($supplier['updated_at']) ?>',
              <?= csrf_token() ?>: '<?= csrf_hash() ?>'
          }
      )"
      @submit.prevent="submit">

    <div class="row g-4">

        <!-- 🧾 Informação Geral -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Informação Geral</h5>
                    <div class="row">
                        <div class="col-md-8" x-data="{ field: 'name' }">
                            <label class="form-label">Nome</label>
                            <input type="text" class="form-control" placeholder="Nome do fornecedor"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-4" x-data="{ field: 'contact_person' }">
                            <label class="form-label">Pessoa de Contacto</label>
                            <input type="text" class="form-control" placeholder="Responsável"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4" x-data="{ field: 'legal_number' }">
                            <label class="form-label">Número Legal</label>
                            <input type="text" class="form-control" placeholder="Número legal"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                        </div>
                        <div class="col-md-4" x-data="{ field: 'vat' }">
                            <label class="form-label">NIF / VAT</label>
                            <input type="text" class="form-control" placeholder="Número de contribuinte"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                        </div>
                        <div class="col-md-4" x-data="{ field: 'phone' }">
                            <label class="form-label">Telefone</label>
                            <input type="text" class="form-control" placeholder="+351 ..."
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6" x-data="{ field: 'email' }">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="fornecedor@exemplo.com"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                        </div>
                        <div class="col-md-6" x-data="{ field: 'website' }">
                            <label class="form-label">Website</label>
                            <input type="text" class="form-control" placeholder="https://empresa.pt"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-8" x-data="{ field: 'address' }">
                            <label class="form-label">Endereço</label>
                            <input type="text" class="form-control" placeholder="Rua, nº, cidade"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                        </div>
                        <div class="col-md-4" x-data="{ field: 'country' }">
                            <label class="form-label">País</label>
                            <input type="text" class="form-control" placeholder="Portugal"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 💶 Financeiro & Integrações -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">Financeiro</h5>
                    <div class="row">
                        <div class="col-12 mb-2" x-data="{ field: 'iban' }">
                            <label class="form-label">IBAN</label>
                            <input type="text" class="form-control" placeholder="PT50 XXXX XXXX XXXX XXXX"
                                   x-model="form[field]">
                        </div>
                        <div class="col-12 mb-2" x-data="{ field: 'swift' }">
                            <label class="form-label">SWIFT / BIC</label>
                            <input type="text" class="form-control" placeholder="BICCODE123"
                                   x-model="form[field]">
                        </div>
                        <div class="col-6" x-data="{ field: 'currency' }">
                            <label class="form-label">Moeda</label>
                            <input type="text" class="form-control" placeholder="EUR"
                                   x-model="form[field]">
                        </div>
                        <div class="col-6" x-data="{ field: 'payment_terms' }">
                            <label class="form-label">Termos Pagamento</label>
                            <input type="text" class="form-control" placeholder="30 dias"
                                   x-model="form[field]">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Configuração</h5>
                    <div class="row">
                        <div class="col-md-6"
                             x-data="{ field: 'type' }"
                             x-init="$nextTick(() => { const el = $refs.select; $(el).select2({ width: '100%', dropdownParent: $(el).closest('.card-body') });
                                 $(el).val(form[field]).trigger('change.select2');
                                 $(el).on('change', () => form[field] = $(el).val());
                                 $watch('form[field]', val => setTimeout(() => $(el).val(val).trigger('change.select2'), 10));
                             })">
                            <label class="form-label">Tipo</label>
                            <select class="form-select select2" x-ref="select">
                                <option value="manufacturer">Fabricante</option>
                                <option value="distributor">Distribuidor</option>
                                <option value="service">Serviço</option>
                                <option value="other">Outro</option>
                            </select>
                        </div>

                        <div class="col-md-6"
                             x-data="{ field: 'risk_level' }"
                             x-init="$nextTick(() => { const el = $refs.select; $(el).select2({ width: '100%', dropdownParent: $(el).closest('.card-body') });
                                 $(el).val(form[field]).trigger('change.select2');
                                 $(el).on('change', () => form[field] = $(el).val());
                                 $watch('form[field]', val => setTimeout(() => $(el).val(val).trigger('change.select2'), 10));
                             })">
                            <label class="form-label">Nível de Risco</label>
                            <select class="form-select select2" x-ref="select">
                                <option value="low">Baixo</option>
                                <option value="medium">Médio</option>
                                <option value="high">Alto</option>
                            </select>
                        </div>

                        <div class="col-md-6"
                             x-data="{ field: 'status' }"
                             x-init="$nextTick(() => {
                                 const el = $refs.select;
                                 $(el).select2({
                                     width: '100%',
                                     placeholder: '-- Selecionar --',
                                     dropdownParent: $(el).closest('.card-body'),
                                 });

                                 // Inicializa com o valor atual
                                 $(el).val(form[field]).trigger('change.select2');

                                 // Atualiza o form ao mudar no Select2
                                 $(el).on('change', () => {
                                     form[field] = $(el).val();
                                 });

                                 // Mantém sincronizado quando o form é alterado por código
                                 $watch('form[field]', (val) => {
                                     setTimeout(() => $(el).val(val).trigger('change.select2'), 10);
                                 });
                             })">
                            <label class="form-label" :for="field">Estado</label>
                            <select class="form-select select2" x-ref="select" :id="field">
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
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">Integrações</h5>
                    <div class="mb-2" x-data="{ field: 'api_url' }">
                        <label class="form-label">API URL</label>
                        <input type="text" class="form-control" placeholder="https://api.fornecedor.pt"
                               x-model="form[field]">
                    </div>
                    <div class="mb-2" x-data="{ field: 'api_key' }">
                        <label class="form-label">API Key</label>
                        <input type="text" class="form-control" placeholder="Chave de integração"
                               x-model="form[field]">
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

<?= $this->endSection() ?>
