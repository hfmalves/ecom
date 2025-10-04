<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <form id="settingsForm"
              x-ref="form"
              x-data="formHandler(
                  '<?= base_url('dashboard/update') ?>',
                  {
                      id: '<?= esc($settings['id'] ?? '') ?>',
                      site_name: '<?= esc($settings['site_name'] ?? '') ?>',
                      contact_email: '<?= esc($settings['contact_email'] ?? '') ?>',
                      contact_phone: '<?= esc($settings['contact_phone'] ?? '') ?>',
                      timezone: '<?= esc($settings['timezone'] ?? '') ?>',
                      default_currency: '<?= esc($settings['default_currency'] ?? '') ?>',
                      status: '<?= esc($settings['status'] ?? 1) ?>',
                      <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                  }
              )"
              enctype="multipart/form-data"
              @submit.prevent="submit">

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informações Básicas</h4>
                    <p class="card-title-desc">Preencha todas as informações abaixo</p>

                    <div class="row">
                        <div class="col-sm-6" x-data="{ field: 'site_name' }">
                            <label class="form-label" :for="field">Nome do Site</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Nome do Site"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>

                        <div class="col-sm-6" x-data="{ field: 'logo' }">
                            <label class="form-label" :for="field">Logo (Upload)</label>
                            <input type="file" class="form-control" :id="field" :name="field"
                                   accept="image/*"
                                   @change="form.logo = $event.target.files[0]"
                                   :class="{ 'is-invalid': errors[field] }">

                            <template x-if="form.logo">
                                <div class="mt-2">
                                    <img :src="URL.createObjectURL(form.logo)" alt="Preview" class="img-thumbnail" style="max-height: 120px;">
                                </div>
                            </template>

                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-6" x-data="{ field: 'contact_email' }">
                            <label class="form-label" :for="field">Email de Contato</label>
                            <input type="email" class="form-control" :id="field" :name="field"
                                   placeholder="Email de Contato"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>

                        <div class="col-sm-6" x-data="{ field: 'contact_phone' }">
                            <label class="form-label" :for="field">Telefone de Contato</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Telefone de Contato"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-6" x-data="{ field: 'timezone' }">
                            <label class="form-label" :for="field">Fuso Horário</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Europe/Lisbon"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>

                        <div class="col-sm-6" x-data="{ field: 'default_currency' }">
                            <label class="form-label" :for="field">Moeda Padrão</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="EUR"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-6" x-data="{ field: 'status' }">
                            <label class="form-label" :for="field">Estado</label>
                            <select class="form-control select2" :id="field" :name="field" x-model="form[field]" >
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar Alterações</button>
                        <button type="reset" class="btn btn-secondary waves-effect waves-light">Cancelar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
<?= $this->endSection() ?>
