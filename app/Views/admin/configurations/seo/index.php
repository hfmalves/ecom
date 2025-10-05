<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Configurações SEO
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <form id="seoForm"
              x-ref="form"
              x-data="formHandler(
                  '<?= base_url('admin/settings/seo/update') ?>',
                  {
                      id: '<?= esc($settings['id'] ?? '') ?>',
                      meta_title: '<?= esc($settings['meta_title'] ?? '') ?>',
                      meta_description: '<?= esc($settings['meta_description'] ?? '') ?>',
                      sitemap_enabled: '<?= esc($settings['sitemap_enabled'] ?? 1) ?>',
                      robots_txt: `<?= esc($settings['robots_txt'] ?? '') ?>`,
                      <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                  }
              )"
              @submit.prevent="submit"
              class="card">

            <div class="card-body">
                <h4 class="card-title">Configurações SEO</h4>
                <p class="card-title-desc">Ajuste os parâmetros SEO do site</p>

                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" class="form-control" x-model="form.meta_title" :class="{ 'is-invalid': errors.meta_title }">
                    <template x-if="errors.meta_title"><small class="text-danger" x-text="errors.meta_title"></small></template>
                </div>

                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea class="form-control" rows="3" x-model="form.meta_description" :class="{ 'is-invalid': errors.meta_description }"></textarea>
                    <template x-if="errors.meta_description"><small class="text-danger" x-text="errors.meta_description"></small></template>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="sitemap_enabled"
                           x-model="form.sitemap_enabled" true-value="1" false-value="0">
                    <label class="form-check-label" for="sitemap_enabled">Sitemap habilitado</label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Robots.txt</label>
                    <textarea class="form-control font-monospace" rows="6" x-model="form.robots_txt" :class="{ 'is-invalid': errors.robots_txt }"></textarea>
                    <template x-if="errors.robots_txt"><small class="text-danger" x-text="errors.robots_txt"></small></template>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Guardar Alterações</button>
                    <button type="reset" class="btn btn-secondary">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
