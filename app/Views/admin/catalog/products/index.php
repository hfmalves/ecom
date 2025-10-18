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
                                    <h4 class="card-title">Lista de Artigos</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 offset-sm-6">
                        <div class="text-sm-end">
                                <button type="button" x-data="systemModal()"
                                        @click="open('#formProduct', 'md')"
                                        class="btn btn-primary w-100">
                                    <i class="bx bx-plus-circle me-1"></i> Adicionar
                                </button>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                        <thead class="table-light">
                        <tr>
                            <th>Estado</th>
                            <th>SKU</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Promoção</th>
                            <th>Stock</th>
                            <th>Gerir Stock</th>
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
                                    <td><?= $product['status'] ?></td>
                                    <td><?= $product['sku'] ?></td>
                                    <td><?= $product['name'] ?></td>
                                    <td><?= $product['price'] ?></td>
                                    <td><?= $product['promo'] ?></td>
                                    <td><?= $product['stock'] ?></td>
                                    <td><?= $product['manage_stock'] ?></td>
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
                ...formHandler('/admin/catalog/products/store',
                  {
                    sku: '',
                    name: '',
                    type: 'simple',
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                  },
                  { resetOnSuccess: true })
             }"
                 x-init="
                $el.addEventListener('fill-form', e => {
                  Object.entries(e.detail).forEach(([k,v]) => { if (k in form) form[k] = v })
                });
                $el.addEventListener('reset-form', () => {
                  Object.keys(form).forEach(k => {
                    if (k !== '<?= csrf_token() ?>') {
                      form[k] = ''
                    }
                  })
                });
                document.addEventListener('csrf-update', e => {
                  form[e.detail.token] = e.detail.hash
                });
             ">

                <form @submit.prevent="submit()">
                    <div class="mb-3">
                        <label class="form-label">SKU</label>
                        <input type="text" class="form-control" name="sku" x-model="form.sku">
                        <div class="text-danger small" x-text="errors.sku"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="name" x-model="form.name">
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
    <div class="modal fade" id="disableProduct" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content"
                 x-data="{
                    form: { id: '', sku: '', reason: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                    loading: false,
                    submit() {
                        this.loading = true;
                        fetch('/admin/catalog/products/disable', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(this.form)
                        })
                        .then(r => r.json())
                        .then(data => {
                            this.loading = false;
                            const modal = bootstrap.Modal.getInstance(document.getElementById('disableProduct'));
                            if (modal) modal.hide();
                             if (data.message) {
                                const type = data.status === 'success' ? 'success' : 'error';
                                showToast(data.message, type);
                            }
                        })
                        .catch(err => {
                            this.loading = false;
                        });
                    }
                 }"
                         x-init="
                    window.addEventListener('fill-form', e => {
                        Object.entries(e.detail).forEach(([k, v]) => {
                            if (k in form) form[k] = v;
                        });
                        $nextTick(() => {
                            form.id = form.id;
                            form.sku = form.sku;
                        });
                    });
                 ">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title text-warning">Desativar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="mdi mdi-alert-outline text-warning" style="font-size: 48px;"></i>
                    <p class="mt-2">Tem a certeza que quer desativar este produto?</p>

                    <p><strong>ID:</strong> <span x-text="form.id"></span></p>
                    <p><strong>SKU:</strong> <span x-text="form.sku"></span></p>
                </div>

                <div class="modal-footer">
                    <button @click="submit" type="button" class="btn btn-warning" :disabled="loading">
                        <span x-show="!loading">Confirmar</span>
                        <span x-show="loading"><i class='fa fa-spinner fa-spin'></i> A processar...</span>
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="enabledProduct" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content"
                 x-data="{
                    form: { id: '', sku: '', reason: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                    loading: false,
                    submit() {
                        this.loading = true;
                        fetch('/admin/catalog/products/enabled', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(this.form)
                        })
                        .then(r => r.json())
                        .then(data => {
                            this.loading = false;
                            const modal = bootstrap.Modal.getInstance(document.getElementById('disableProduct'));
                            if (modal) modal.hide();
                             if (data.message) {
                                const type = data.status === 'success' ? 'success' : 'error';
                                showToast(data.message, type);
                            }
                        })
                        .catch(err => {
                            this.loading = false;
                        });
                    }
                 }"
                 x-init="
                    window.addEventListener('fill-form', e => {
                        Object.entries(e.detail).forEach(([k, v]) => {
                            if (k in form) form[k] = v;
                        });
                        $nextTick(() => {
                            form.id = form.id;
                            form.sku = form.sku;
                        });
                    });
                 ">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title text-warning">Desativar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="mdi mdi-alert-outline text-warning" style="font-size: 48px;"></i>
                    <p class="mt-2">Tem a certeza que quer desativar este produto?</p>

                    <p><strong>ID:</strong> <span x-text="form.id"></span></p>
                    <p><strong>SKU:</strong> <span x-text="form.sku"></span></p>
                </div>

                <div class="modal-footer">
                    <button @click="submit" type="button" class="btn btn-warning" :disabled="loading">
                        <span x-show="!loading">Confirmar</span>
                        <span x-show="loading"><i class='fa fa-spinner fa-spin'></i> A processar...</span>
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>

            </div>
        </div>
    </div>
    <?= $this->endSection() ?>
