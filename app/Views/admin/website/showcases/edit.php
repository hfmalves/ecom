<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Módulos
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-8">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0 fw-bold">Gestão de Blocos</h4>
                    <small class="text-muted">Visualize, edite ou remova blocos</small>
                </div>
                <button type="button"
                        class="btn btn-primary btn-sm"
                        x-data="systemModal()"
                        @click="
                            close();
                            setTimeout(() => {
                                new bootstrap.Modal(document.getElementById('formShowcase')).show();
                            }, 300);
                        "
                >
                    <i class="bx bx-plus-circle me-1"></i> Novo Bloco
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php foreach ($blocks as $block): ?>
                        <div class="mb-0">
                            <div class="d-flex gap-2 mt-2">
                                <?php foreach ($images[$block['id']] as $img): ?>
                                    <img style="width: 100%" src="<?= $img ?>">
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php endforeach ?>

                </div>
            </div>
        </div>
    </div>
    <div class="col-4"
         x-data="{
        form: {
            id: <?= (int) $showcase['id'] ?>,
            name: `<?= addslashes($showcase['name'] ?? '') ?>`,
            is_active: <?= $showcase['is_active'] ? 1 : 0 ?>,
            is_default: <?= $showcase['is_default'] ? 1 : 0 ?>,
            active_start: `<?= $showcase['active_start'] ?? '' ?>`,
            active_end: `<?= $showcase['active_end'] ?? '' ?>`,
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        },
        loading: false,
        async submit() {
            if (!this._formHandler) {
                this._formHandler = formHandler(
                    '<?= base_url('admin/website/showcases/update') ?>',
                    {},
                    { resetOnSuccess: false }
                );
            }

            this._formHandler.form = JSON.parse(JSON.stringify(this.form));
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
        <form class="card shadow-sm border-0">
            <div class="card-header">
                <h4 class="card-title mb-0 fw-bold">Definições</h4>
                <small class="text-muted">Gestão de definições da Vitrine</small>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">Nome</label>
                        <input type="text"
                               class="form-control"
                               x-model="form.name">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Home Code</label>
                        <input type="text"
                               class="form-control"
                               value="<?= esc($showcase['home_code']) ?>"
                               disabled>
                    </div>
                    <div class="col-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   :checked="form.is_active == 1"
                                   @change="form.is_active = $event.target.checked ? 1 : 0">
                            <label class="form-check-label">Ativo</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   :checked="form.is_default == 1"
                                   @change="form.is_default = $event.target.checked ? 1 : 0">
                            <label class="form-check-label">Default</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Ativo desde</label>
                        <input type="datetime-local"
                               class="form-control"
                               x-model="form.active_start">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Ativo até</label>
                        <input type="datetime-local"
                               class="form-control"
                               x-model="form.active_end">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Criado em</label>
                        <input type="text"
                               class="form-control"
                               value="<?= esc($showcase['created_at']) ?>"
                               disabled>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Atualizado em</label>
                        <input type="text"
                               class="form-control"
                               value="<?= esc($showcase['updated_at']) ?>"
                               disabled>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="button"
                        class="btn btn-primary"
                        @click="submit()"
                        :disabled="loading">
                    <template x-if="!loading">
                        <span><i class="mdi mdi-content-save-outline me-1"></i> Guardar</span>
                    </template>
                    <template x-if="loading">
                        <span><i class="fa fa-spinner fa-spin me-1"></i> A guardar…</span>
                    </template>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
