<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Campanhas
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div
        x-data="{
        form: {
            id: <?= (int) $campaign['id'] ?>,
            name: '<?= addslashes($campaign['name']) ?>',
            description: `<?= addslashes($campaign['description'] ?? '') ?>`,
            discount_type: '<?= $campaign['discount_type'] ?>',
            discount_value: '<?= $campaign['discount_value'] ?>',
            start_date: '<?= $campaign['start_date'] ?>',
            end_date: '<?= $campaign['end_date'] ?>',
            status: '<?= $campaign['status'] ?>',
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        },
        loading: false,
        async submit() {
            if (!this._formHandler) {
                this._formHandler = formHandler(
                    '<?= base_url('admin/marketing/campaigns/update') ?>',
                    {},
                    { resetOnSuccess: false }
                );
            }
            this._formHandler.form = JSON.parse(JSON.stringify(this.form));
            this._formHandler.form.id = this.form.id ?? <?= (int) $campaign['id'] ?>;
            this.loading = true;
            try {
                await this._formHandler.submit();
            } catch (e) {
                console.error(e);
                showToast('Falha de comunicação com o servidor.', 'error');
            } finally {
                this.loading = false;
            }
        }
    }"
>
    <div class="row mb-4">
        <div class="col-lg-12 d-flex align-items-center justify-content-between">
            <div>
                <h5 class="mb-2 card-title">Editar Campanha</h5>
                <p class="text-muted mb-0">Atualiza as informações desta campanha de desconto.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= base_url('admin/marketing/campaigns') ?>" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left"></i> Voltar à Lista
                </a>

                <button type="button"
                        class="btn btn-primary"
                        @click="submit()"
                        :disabled="loading">
                    <template x-if="!loading">
                        <span><i class="mdi mdi-content-save-outline me-1"></i> Guardar</span>
                    </template>
                    <template x-if="loading">
                        <span><i class="fa fa-spinner fa-spin me-1"></i> A guardar...</span>
                    </template>
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Coluna Principal -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-3">Informação Geral</h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome da Campanha</label>
                            <input type="text" class="form-control" x-model="form.name" placeholder="Ex: Black Friday 2025">
                        </div>

                        <div class="col-md-6 mb-3"
                             x-data="{ field: 'discount_type' }"
                             x-init="
                                $nextTick(() => {
                                    const el = $refs.select;
                                    $(el).select2({
                                        width: '100%',
                                        placeholder: '-- Tipo de Desconto --',
                                        minimumResultsForSearch: Infinity
                                    });
                                    $(el).val(form[field]).trigger('change');
                                    $(el).on('change', () => form[field] = $(el).val());
                                    $watch('form[field]', val => $(el).val(val).trigger('change'));
                                });
                             ">
                            <label class="form-label" :for="field">Tipo de Desconto</label>
                            <select class="form-select" x-ref="select" :id="field">
                                <option value="percent">Percentagem</option>
                                <option value="fixed">Valor Fixo</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Valor do Desconto</label>
                            <input type="number" step="0.01" class="form-control" x-model="form.discount_value" placeholder="Ex: 10.00">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Início</label>
                            <input type="datetime-local" class="form-control" x-model="form.start_date">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Fim</label>
                            <input type="datetime-local" class="form-control" x-model="form.end_date">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea class="form-control" rows="3" x-model="form.description" placeholder="Descrição da campanha..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Lateral -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Estado</h4>
                    <p class="card-title-desc">Defina o estado atual da campanha</p>

                    <div class="row align-items-center">
                        <div class="col-6"
                             x-init="
                                $nextTick(() => {
                                    const el = $refs.estadoSelect;
                                    $(el).select2({
                                        width: '100%',
                                        minimumResultsForSearch: Infinity
                                    }).on('change', function() {
                                        form.status = $(this).val();
                                    });
                                    $(el).val(form.status).trigger('change');
                                });
                             ">
                            <label class="form-label">Estado</label>
                            <select class="form-select select2" x-ref="estadoSelect" x-model="form.status">
                                <option value="active">Ativa</option>
                                <option value="inactive">Inativa</option>
                            </select>
                        </div>
                        <div class="col-6 text-center mt-4">
                            <span class="badge w-100 fs-6 py-2"
                                  :class="form.status == 'active' ? 'bg-success' : 'bg-secondary'"
                                  x-text="form.status == 'active' ? 'Ativa' : 'Inativa'">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
