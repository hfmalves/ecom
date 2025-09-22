<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <div class="search-box me-2 mb-2 d-inline-block">
                            <div class="position-relative">
                                <h4 class="card-title">Default Datatable</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <button type="button" x-data="systemModal()"
                                    @click="open('#formProduct', 'md')"
                                    class="btn btn-primary">
                                <i class="fa-solid fa-plus me-1"></i> Adicionar
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>

                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                    <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>SKU</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Promoção</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Tipo</th>
                        <th>Atualizado em</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= $product['id'] ?></td>
                                <td><?= $product['sku'] ?></td>
                                <td><?= $product['name'] ?></td>
                                <td><?= $product['price'] ?></td>
                                <td><?= $product['promo'] ?></td>
                                <td><?= $product['stock'] ?></td>
                                <td><?= $product['status'] ?></td>
                                <td><?= $product['type'] ?></td>
                                <td><?= $product['updated'] ?></td>
                                <td><?= $product['actions'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted">Nenhum produto encontrado</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<div id="formProduct" class="d-none">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Criar Produto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"
             x-data="{
                ...formHandler('/api/products/create',
                  { sku: '', name: '', type: 'simple' },
                  { resetOnSuccess: true }),
                loading: true
             }"
             x-init="
                $el.addEventListener('fill-form', e => {
                    loading = true
                    Object.entries(e.detail).forEach(([k,v]) => { if (k in form) form[k] = v })
                    $nextTick(() => loading = false)
                });
                $el.addEventListener('reset-form', () => {
                    loading = true
                    Object.keys(form).forEach(k => form[k] = '')
                    $nextTick(() => loading = false)
                });
             ">
            <div x-show="loading" x-cloak class="p-4 text-center">
                <div class="spinner-border text-primary"></div>
                <p>A carregar…</p>
            </div>
            <form x-show="!loading" @submit.prevent="submit()">
                <div class="mb-3">
                    <label class="form-label">SKU</label>
                    <input type="text" class="form-control" name="sku" x-model="form.sku" required>
                    <div class="text-danger small" x-text="errors.sku"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control" name="name" x-model="form.name" required>
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipo</label>
                    <select class="form-select" name="type" x-model="form.type">
                        <option value="">-- Selecionar --</option>
                        <option value="simple">Simples</option>
                        <option value="configurable">Configurable</option>
                        <option value="virtual">Virtual</option>
                        <option value="pack">Pack</option>
                    </select>
                    <div class="text-danger small" x-text="errors.type"></div>
                </div>
                <div class="modal-footer mt-3">
                    <button type="submit" class="btn btn-primary" :disabled="loading">
                        <span x-show="!loading">Criar Produto</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A enviar...</span>
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
