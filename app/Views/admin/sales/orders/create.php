<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="d-flex align-items-center">
            <div class="ms-3 flex-grow-1">
                <h5 class="mb-2 card-title">Detalhes da Encomenda</h5>
                <p class="text-muted mb-0">Consulta e gere todas as informações associadas a esta encomenda.</p>
            </div>
        </div>
    </div><!--end col-->
</div><!--end row-->
<div class="row">
    <div class="col-8">
        <!-- Informação Geral -->
        <div class="card"
             id="productCard"
             x-data='{
        products: <?= json_encode($productsByType, JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
        flatProducts: [],
        selectedProduct: "",
        orderItems: [],
        orderTotal: 0,

        init() {
            // Achata os produtos e variantes
            this.flatProducts = Object.values(this.products)
                .flat()
                .map(p => {
                    if (p.type === "configurable" && p.variants) {
                        return p.variants.map(v => ({
                            id: v.id,
                            sku: v.sku,
                            name: v.name ?? "",
                            type: "variant",
                            price: parseFloat(v.price ?? 0)
                        }));
                    }
                    return {
                        id: p.id,
                        sku: p.sku,
                        name: p.name ?? "",
                        type: p.type,
                        price: parseFloat(p.price ?? 0)
                    };
                })
                .flat();

            const self = this;
            $("#product_id").select2({ width: "100%" })
                .on("change", function(e) {
                    self.selectedProduct = e.target.value;
                });
        },

        addProduct() {
            const prod = this.flatProducts.find(p => p.id == this.selectedProduct);
            if (!prod) return;

            const existing = this.orderItems.find(i => i.id == prod.id);
            if (existing) {
                existing.qty++;
                existing.total = (existing.qty * existing.price).toFixed(2);
            } else {
                this.orderItems.push({
                    ...prod,
                    qty: 1,
                    total: parseFloat(prod.price).toFixed(2)
                });
            }

            this.calculateTotals();

            // limpa o select
            $("#product_id").val(null).trigger("change");
            this.selectedProduct = "";
        },

        updateLine(item) {
            item.total = (item.qty * item.price).toFixed(2);
            this.calculateTotals();
        },

        removeItem(id) {
            this.orderItems = this.orderItems.filter(i => i.id != id);
            this.calculateTotals();
        },

        calculateTotals() {
            this.orderTotal = this.orderItems
                .reduce((sum, i) => sum + parseFloat(i.total || 0), 0)
                .toFixed(2);
        }
     }'
             x-init="init()"
        >
            <div class="card-body">
                <!-- SELECT DE PRODUTOS -->
                <div class="input-group mb-3">
                    <select name="product_id" id="product_id" class="form-control">
                        <option value="">-- Selecione um produto --</option>
                        <?php foreach ($productsByType as $type => $products): ?>
                            <?php if (!empty($products)): ?>
                                <optgroup label="<?= ucfirst($type) ?>">
                                    <?php foreach ($products as $product): ?>
                                        <?php if ($type === 'configurable'): ?>
                                            <?php if (!empty($product['variants'])): ?>
                                                <?php foreach ($product['variants'] as $variant): ?>
                                                    <option value="<?= $variant['id'] ?>">
                                                        <?= esc($variant['sku']) ?> — <?= esc($variant['name'] ?? 'Sem nome') ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <option value="<?= $product['id'] ?>">
                                                <?= esc($product['sku']) ?> — <?= esc($product['name'] ?? 'Sem nome') ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="btn btn-primary" @click="addProduct">Adicionar</button>
                </div>

                <!-- TABELA -->
                <table class="table table-sm table-striped align-middle mt-3">
                    <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>SKU</th>
                        <th>Nome</th>
                        <th style="width: 100px;">Qtd</th>
                        <th style="width: 120px;">Preço (€)</th>
                        <th style="width: 120px;">Total (€)</th>
                        <th style="width: 40px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <template x-for="item in orderItems" :key="item.id">
                        <tr>
                            <td x-text="item.type"></td>
                            <td x-text="item.sku"></td>
                            <td x-text="item.name"></td>
                            <td>
                                <input type="number" class="form-control form-control-sm"
                                       min="1" step="1"
                                       x-model.number="item.qty"
                                       @input="updateLine(item)">
                            </td>
                            <td x-text="item.price.toFixed(2) + ' €'"></td>
                            <td x-text="item.total + ' €'"></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" @click="removeItem(item.id)">
                                    <i class="bi bi-x"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Total da Encomenda:</th>
                        <th x-text="orderTotal + ' €'"></th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- Moradas -->
        <div class="row"
             id="addressCard"
             x-data='{
                selectedCustomer: null,
                addresses: <?= json_encode($customerAddresses, JSON_HEX_APOS | JSON_HEX_QUOT) ?>,

                shipping: { selected: "", form: { street: "", city: "", postcode: "", country: "" }, newMode: false, locked: false },
                billing:  { selected: "", form: { street: "", city: "", postcode: "", country: "" }, newMode: false, locked: false },
                useSameBilling: false,

                get filtered() {
                    return this.selectedCustomer
                        ? this.addresses.filter(a => a.customer_id == this.selectedCustomer)
                        : [];
                },

                createNewMode: false,
                    init() {
                        const self = this;
                        $("#customer_id").select2({ width: "100%" })
                            .on("change", function (e) {
                                self.selectedCustomer = e.target.value;
                                self.resetAll();
                            });
                        window.addEventListener("customer-cleared", () => {
                            self.selectedCustomer = null;
                            self.createNewMode = true;
                            self.forceNewAddresses();
                        });
                        window.addEventListener("customer-reset", () => {
                            self.createNewMode = false;
                            self.selectedCustomer = null;
                            self.resetAll();
                        });
                    },
                resetAll() {
                    this.shipping = { selected: "", form: { street: "", city: "", postcode: "", country: "" }, newMode: false, locked: false };
                    this.billing  = { selected: "", form: { street: "", city: "", postcode: "", country: "" }, newMode: false, locked: false };
                    this.useSameBilling = false;
                },

                forceNewAddresses() {
                    this.shipping.newMode = true;
                    this.billing.newMode  = true;
                    this.shipping.locked  = true;
                    this.billing.locked   = true;
                    this.shipping.form = { street: "", city: "", postcode: "", country: "" };
                    this.billing.form  = { street: "", city: "", postcode: "", country: "" };
                },

                fillForm(target, addrId) {
                    const ref = this[target];
                    if (!addrId) {
                        ref.form = { street: "", city: "", postcode: "", country: "" };
                        return;
                    }
                    const addr = this.filtered.find(a => a.id == addrId);
                    if (addr) {
                        ref.form.street   = addr.street   ?? "";
                        ref.form.city     = addr.city     ?? "";
                        ref.form.postcode = addr.postcode ?? "";
                        ref.form.country  = addr.country  ?? "";
                    }
                }
             }'
             x-init="init()"
        >

            <!-- ==================== MORADA DE ENVIO ==================== -->
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Morada de Envio</h4>
                        <p class="card-title-desc">Endereço do cliente para envio</p>

                        <!-- sem cliente -->
                        <template x-if="!selectedCustomer && !shipping.locked && !createNewMode">

                        <p class="text-muted mb-0">Selecione um cliente para carregar moradas.</p>
                        </template>

                        <!-- com cliente -->
                        <template x-if="selectedCustomer || shipping.locked || createNewMode">

                        <div>
                                <!-- SELECT -->
                                <template x-if="filtered.length > 0 && !shipping.newMode">
                                    <select id="shipping_address_id" class="form-control mb-3"
                                            x-model="shipping.selected"
                                            @change="fillForm('shipping', $event.target.value)">
                                        <option value="">-- Selecione --</option>
                                        <template x-for="addr in filtered" :key="'ship-'+addr.id">
                                            <option :value="addr.id" x-text="addr.street"></option>
                                        </template>
                                    </select>
                                </template>

                                <!-- CHECK Criar Nova -->
                                <div class="form-check mb-2">
                                    <input type="checkbox" id="newShippingCheck" class="form-check-input"
                                           x-model="shipping.newMode"
                                           :disabled="shipping.locked"
                                           @change="shipping.selected=''; shipping.form={street:'',city:'',postcode:'',country:''}">
                                    <label for="newShippingCheck" class="form-check-label">Criar nova morada</label>
                                </div>

                                <!-- CHECK Usar mesma morada -->
                                <div class="form-check mb-3">
                                    <input type="checkbox" id="sameAddressCheck" class="form-check-input" x-model="useSameBilling">
                                    <label for="sameAddressCheck" class="form-check-label">Usar mesma morada para faturação</label>
                                </div>

                                <!-- CAMPOS -->
                                <template x-if="shipping.newMode || shipping.selected">
                                    <div class="mt-3">
                                        <div class="mb-2">
                                            <label class="form-label">Rua</label>
                                            <input type="text" class="form-control" x-model="shipping.form.street">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Cidade</label>
                                            <input type="text" class="form-control" x-model="shipping.form.city">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Código Postal</label>
                                            <input type="text" class="form-control" x-model="shipping.form.postcode">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">País</label>
                                            <input type="text" class="form-control" x-model="shipping.form.country">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- ==================== MORADA DE FATURAÇÃO ==================== -->
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Morada de Faturação</h4>
                        <p class="card-title-desc">Dados do cliente para faturação</p>

                        <!-- sem cliente -->
                        <template x-if="!selectedCustomer && !billing.locked && !createNewMode">
                            <p class="text-muted mb-0">Selecione um cliente para carregar moradas.</p>
                        </template>

                        <!-- com cliente -->
                        <template x-if="(selectedCustomer || billing.locked || createNewMode) && !useSameBilling">

                        <div>
                                <!-- SELECT -->
                                <template x-if="filtered.length > 0 && !billing.newMode">
                                    <select id="billing_address_id" class="form-control mb-3"
                                            x-model="billing.selected"
                                            @change="fillForm('billing', $event.target.value)">
                                        <option value="">-- Selecione --</option>
                                        <template x-for="addr in filtered" :key="'bill-'+addr.id">
                                            <option :value="addr.id" x-text="addr.street"></option>
                                        </template>
                                    </select>
                                </template>

                                <!-- CHECK Criar Nova -->
                                <div class="form-check mb-2">
                                    <input type="checkbox" id="newBillingCheck" class="form-check-input"
                                           x-model="billing.newMode"
                                           :disabled="billing.locked"
                                           @change="billing.selected=''; billing.form={street:'',city:'',postcode:'',country:''}">
                                    <label for="newBillingCheck" class="form-check-label">Criar nova morada</label>
                                </div>

                                <!-- CAMPOS -->
                                <template x-if="billing.newMode || billing.selected">
                                    <div class="mt-3">
                                        <div class="mb-2">
                                            <label class="form-label">Rua</label>
                                            <input type="text" class="form-control" x-model="billing.form.street">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Cidade</label>
                                            <input type="text" class="form-control" x-model="billing.form.city">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Código Postal</label>
                                            <input type="text" class="form-control" x-model="billing.form.postcode">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">País</label>
                                            <input type="text" class="form-control" x-model="billing.form.country">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <template x-if="(selectedCustomer || createNewMode) && useSameBilling">
                            <div class="alert alert-info mt-3 p-2">
                                A morada de faturação será igual à morada de envio.
                            </div>
                        </template>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Coluna lateral -->
    <div class="col-4">
        <div class="card"
             id="customerCard"
             x-data='{
                customers: <?= json_encode($customers, JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
                groups: <?= json_encode($customerGroups, JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
                selectedCustomer: null,
                createNew: false,
                customer: { name: "", email: "", phone: "", gender: "", group_id: "", notes: "" },

                init() {
                    const self = this;
                    const $select = $("#customer_id").select2({
                        width: "100%",
                        placeholder: "-- Selecione --",
                        matcher: function(params, data) {
                            if ($.trim(params.term) === "") return data;
                            const term = params.term.toLowerCase();
                            const text = (data.text || "").toLowerCase();
                            const email = ($(data.element).data("email") || "").toLowerCase();
                            const nif = ($(data.element).data("nif") || "").toLowerCase();
                            if (text.includes(term) || email.includes(term) || nif.includes(term)) return data;
                            return null;
                        }
                    });
                    let suppressChange = false;
                    $select.on("change", function(e) {
                        if (suppressChange) return; // evita loop
                        if (self.createNew) {
                            suppressChange = true;
                            $select.val(null).trigger("change");
                            suppressChange = false;
                            return;
                        }
                        const id = e.target.value;
                        self.selectedCustomer = id;
                        const c = self.customers.find(c => c.id == id);
                        if (c) {
                            self.customer.name     = c.name ?? "";
                            self.customer.email    = c.email ?? "";
                            self.customer.phone    = c.phone ?? "";
                            self.customer.gender   = c.gender ?? "";
                            self.customer.group_id = c.group_id ?? "";
                            self.customer.notes    = c.notes ?? "";
                        } else {
                            self.resetForm();
                        }
                    });
                    this.$watch("createNew", value => {
                        if (value) {
                            $select.prop("disabled", true);
                            suppressChange = true; // evita recursão
                            $select.val(null).trigger("change");
                            suppressChange = false;

                            self.resetForm();
                            window.dispatchEvent(new CustomEvent("customer-cleared"));
                        } else {
                            $select.prop("disabled", false);
                            window.dispatchEvent(new CustomEvent("customer-reset"));
                        }
                    });
                },
                resetForm() {
                    this.customer = { name: "", email: "", phone: "", gender: "", group_id: "", notes: "" };
                }
             }'
             x-init="init()"
        >


        <div class="card-body">
                <h4 class="card-title">Informação do Cliente</h4>
                <p class="card-title-desc">Dados principais da conta do cliente</p>

                <!-- CLIENTE -->
                <div class="mb-3">
                    <label for="customer_id" class="form-label">Cliente</label>
                    <select name="customer_id" id="customer_id" class="form-control">
                        <option value="">-- Selecione --</option>
                        <?php foreach ($customers as $customer): ?>
                            <option
                                    value="<?= $customer['id'] ?>"
                                    data-email="<?= $customer['email'] ?>"
                                    data-nif="<?= $customer['nif'] ?? '' ?>"
                            >
                                <?= esc($customer['name']) ?> (<?= esc($customer['email']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            <!-- CHECKBOX CRIAR NOVO -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="createNewCustomer" x-model="createNew"
                       @change="
       if (createNew) {
           resetForm();
           $('#customer_id').val(null).trigger('change');
           window.dispatchEvent(new CustomEvent('customer-cleared')); // 🔥 dispara evento global
       } else {
           window.dispatchEvent(new CustomEvent('customer-reset')); // 🔥 evento inverso
       }
   ">

                <label class="form-check-label" for="createNewCustomer">
                    Criar novo cliente
                </label>
            </div>

                <!-- CLIENTE EXISTENTE -->
                <template x-if="!createNew">
                    <div>
                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" class="form-control" x-model="customer.name" readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="text" class="form-control" x-model="customer.phone" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" x-model="customer.email" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Género</label>
                                <input type="text" class="form-control"
                                       :value="customer.gender === 'M' ? 'Masculino' : customer.gender === 'F' ? 'Feminino' : (customer.gender === 'O' ? 'Outro' : '')"
                                       readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Grupo do Cliente</label>
                                <input type="text" class="form-control"
                                       :value="groups.find(g => g.id == customer.group_id)?.name ?? ''"
                                       readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notas</label>
                            <textarea class="form-control" rows="2" x-model="customer.notes" readonly></textarea>
                        </div>
                    </div>
                </template>

                <!-- NOVO CLIENTE -->
                <template x-if="createNew">
                    <div>
                        <div class="mb-3">
                            <label class="form-label">Nome *</label>
                            <input type="text" class="form-control" x-model="customer.name" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" x-model="customer.email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contacto *</label>
                                <input type="text" class="form-control" x-model="customer.phone" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Género</label>
                                <select class="form-control" x-model="customer.gender">
                                    <option value="">-- Selecionar --</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                    <option value="O">Outro</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Grupo do Cliente</label>
                                <select class="form-control" x-model="customer.group_id">
                                    <option value="">-- Selecionar --</option>
                                    <template x-for="g in groups" :key="g.id">
                                        <option :value="g.id" x-text="g.name"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notas</label>
                            <textarea class="form-control" rows="2" x-model="customer.notes"></textarea>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <!-- ================= BOTÃO FINAL DE SUBMISSÃO ================= -->
        <div class="card mt-4"
             x-data="{
                 async submitOrder() {
                     const customerEl = document.querySelector('#customerCard');
                     const addressEl  = document.querySelector('#addressCard');
                     const productEl  = document.querySelector('#productCard');

                     const customer = customerEl?._x?.$data ?? {};
                     const address  = addressEl?._x?.$data ?? {};
                     const products = productEl?._x?.$data ?? {};

                     const payload = {
                         <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                         customer: customer.customer ?? {},
                         createNew: customer.createNew ?? false,
                         shipping: address.shipping ?? {},
                         billing: address.billing ?? {},
                         useSameBilling: address.useSameBilling ?? false,
                         orderItems: products.orderItems ?? [],
                         orderTotal: products.orderTotal ?? 0
                     };

                     try {
                         this.loading = true;
                         const res = await fetch('<?= base_url('admin/sales/orders/store') ?>', {
                             method: 'POST',
                             headers: { 'Content-Type': 'application/json' },
                             body: JSON.stringify(payload)
                         });

                         const data = await res.json();
                         this.loading = false;

                         if (data.status === 'success') {
                             showToast('Encomenda criada com sucesso.', 'success');
                             setTimeout(() => window.location.href = data.redirect ?? '<?= base_url('admin/sales/orders') ?>', 800);
                         } else {
                             showToast(data.message || 'Erro ao criar encomenda.', 'error');
                         }
                     } catch (err) {
                         this.loading = false;
                         showToast('Erro de comunicação com o servidor.', 'error');
                     }
                 },
                 loading: false
            }">

            <div class="card-body text-end">
                <button type="button"
                        class="btn btn-success btn-lg px-5"
                        :disabled="loading"
                        @click="submitOrder">
                    <span x-show="!loading"><i class="mdi mdi-content-save-outline me-1"></i> Criar Encomenda</span>
                    <span x-show="loading"><i class="fa fa-spinner fa-spin me-2"></i> A criar...</span>
                </button>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>
