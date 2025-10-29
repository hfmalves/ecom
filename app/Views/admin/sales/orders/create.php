<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div id="orderApp"
     x-data="orderApp()"
     x-init="init()"
     class="row">
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex align-items-center">
                <div class="ms-3 flex-grow-1">
                    <h5 class="mb-2 card-title">Detalhes da Encomenda</h5>
                    <p class="text-muted mb-0">Consulta e gere todas as informações associadas a esta encomenda.</p>
                </div>
                <button type="button"
                        class="btn btn-success"
                        :disabled="loading"
                        @click="submitOrder">
                <span x-show="!loading">
                    <i class="mdi mdi-content-save-outline me-1"></i> Criar Encomenda
                </span>
                    <span x-show="loading">
                    <i class="fa fa-spinner fa-spin me-2"></i> A criar...
                </span>
                </button>
            </div>
        </div>
    </div>
    <div class="col-8">
        <div class="card" id="productCard">
            <div class="card-body">
                <!-- SELECT DE PRODUTOS -->
                <div class="row mb-3 align-items-center">
                    <div class="col-md-8">
                        <select name="product_id" id="product_id" class="form-control">
                            <option value="">-- Selecione um produto --</option>
                            <?php foreach ($productsByType as $type => $products): ?>
                                <?php if (!empty($products)): ?>
                                    <optgroup label="<?= ucfirst($type) ?>">
                                        <?php foreach ($products as $product): ?>
                                            <?php if ($type === 'configurable' && !empty($product['variants'])): ?>
                                                <?php foreach ($product['variants'] as $variant): ?>
                                                    <option value="<?= $variant['id'] ?>">
                                                        <?= esc($variant['sku']) ?> — <?= esc($variant['name'] ?? 'Sem nome') ?>
                                                    </option>
                                                <?php endforeach; ?>
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
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="button" class="btn btn-primary w-100" @click="addProduct">
                            <i class="bx bx-plus me-1"></i> Adicionar
                        </button>
                    </div>
                </div>
                <!-- TABELA DE PRODUTOS -->
                <!-- TABELA DE PRODUTOS -->
                <table class="table table-sm table-striped align-middle mt-3">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>SKU</th>
                            <th>Nome</th>
                            <th style="width: 100px;">Qtd</th>
                            <th style="width: 120px;">Preço (€)</th>
                            <th style="width: 140px;">Taxa de Imposto</th>
                            <th style="width: 120px;">Total (€)</th>
                            <th style="width: 40px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, idx) in orderItems" :key="item.id">
                            <tr>
                                <td x-text="item.type"></td>
                                <td x-text="item.sku"></td>
                                <td x-text="item.name"></td>
                                <td>
                                    <input type="number"
                                           class="form-control form-control-sm"
                                           min="1"
                                           step="1"
                                           x-model.number="item.qty"
                                           @input="updateLine(item)">
                                </td>
                                <td x-text="item.price.toFixed(2) + ' €'"></td>
                                <td>
                                    <select class="form-select form-select-sm tax-select"
                                            :id="'tax_'+item.id"
                                            x-model="item.tax_id">
                                        <option value="">-- Selecione --</option>
                                        <?php foreach ($taxRates as $tax): ?>
                                            <option value="<?= $tax['id'] ?>" data-rate="<?= $tax['rate'] ?>">
                                                <?= esc($tax['name']) ?> (<?= $tax['rate'] ?>%)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td x-text="item.total.toFixed(2) + ' €'"></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger" @click="removeItem(item.id)">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                        <template x-if="orderItems.length === 0">
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <p class="text-muted mt-3 mb-0">Ainda não adicionou nenhum produto à encomenda.</p>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" class="text-end">Subtotal:</th>
                            <th x-text="subtotal + ' €'"></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-end">IVA Total:</th>
                            <th x-text="ivaTotal + ' €'"></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-end">Total da Encomenda:</th>
                            <th x-text="totalComIva + ' €'"></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
        <!-- Moradas -->
        <div class="row" id="addressCard">
            <!-- ==================== MORADA DE ENVIO ==================== -->
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Morada de Envio</h4>
                        <p class="card-title-desc">Endereço do cliente para envio</p>
                        <template x-if="!selectedCustomer && !shipping.locked && !createNewMode">
                            <p class="text-muted mb-0">Selecione um cliente para carregar moradas.</p>
                        </template>
                        <template x-if="selectedCustomer || shipping.locked || createNewMode">
                            <div>
                                <template x-if="filteredAddresses.length > 0 && !shipping.newMode">
                                    <div x-init="
                                            $nextTick(() => {
                                                const el = $('#shipping_address_id');
                                                el.select2();
                                                el.on('change', e => {
                                                    shipping.selected = e.target.value;
                                                    fillForm('shipping', e.target.value);
                                                });
                                                $watch('shipping.selected', val => {
                                                    el.val(val).trigger('change.select2');
                                                });
                                            });
                                        ">
                                        <select id="shipping_address_id" class="form-control mb-3">
                                            <option value=''>-- Selecione --</option>
                                            <template x-for="addr in filteredAddresses" :key="'ship-'+addr.id">
                                                <option :value="addr.id" x-text="addr.street"></option>
                                            </template>
                                        </select>
                                    </div>
                                </template>
                                <template x-if="shipping.newMode || shipping.selected">
                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="mb-2">
                                                    <label class="form-label">Rua</label>
                                                    <input type="text" class="form-control" x-model="shipping.form.street">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label class="form-label">Código Postal</label>
                                                    <input type="text" class="form-control" x-model="shipping.form.postcode">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="mb-2">
                                                    <label class="form-label">Cidade</label>
                                                    <input type="text" class="form-control" x-model="shipping.form.city">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label class="form-label">País</label>
                                                    <input type="text" class="form-control" x-model="shipping.form.country">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div class="form-check mb-2">
                                    <input type="checkbox" id="newShippingCheck" class="form-check-input"
                                           x-model="shipping.newMode"
                                           :disabled="shipping.locked"
                                           @change="shipping.selected=''; shipping.form={street:'',city:'',postcode:'',country:''}">
                                    <label for="newShippingCheck" class="form-check-label">Criar nova morada</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input type="checkbox" id="sameAddressCheck" class="form-check-input" x-model="useSameBilling">
                                    <label for="sameAddressCheck" class="form-check-label">Usar mesma morada para faturação</label>
                                </div>
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
                        <template x-if="!selectedCustomer && !billing.locked && !createNewMode">
                            <p class="text-muted mb-0">Selecione um cliente para carregar moradas.</p>
                        </template>
                        <template x-if="(selectedCustomer || billing.locked || createNewMode) && !useSameBilling">
                            <div>
                                <template x-if="filteredAddresses.length > 0 && !billing.newMode">
                                    <div x-init="
                                        $nextTick(() => {
                                            const el = $('#billing_address_id');
                                            el.select2();
                                            el.on('change', e => {
                                                billing.selected = e.target.value;
                                                fillForm('billing', e.target.value);
                                            });
                                            $watch('billing.selected', val => {
                                                el.val(val).trigger('change.select2');
                                            });
                                        });
                                    ">
                                        <select id="billing_address_id" class="form-control mb-3">
                                            <option value=''>-- Selecione --</option>
                                            <template x-for="addr in filteredAddresses" :key="'bill-'+addr.id">
                                                <option :value="addr.id" x-text="addr.street"></option>
                                            </template>
                                        </select>
                                    </div>
                                </template>
                                <template x-if="billing.newMode || billing.selected">
                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="mb-2">
                                                    <label class="form-label">Rua</label>
                                                    <input type="text" class="form-control" x-model="billing.form.street">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label class="form-label">Código Postal</label>
                                                    <input type="text" class="form-control" x-model="billing.form.postcode">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="mb-2">
                                                    <label class="form-label">Cidade</label>
                                                    <input type="text" class="form-control" x-model="billing.form.city">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label class="form-label">País</label>
                                                    <input type="text" class="form-control" x-model="billing.form.country">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div class="form-check mb-2">
                                    <input type="checkbox" id="newBillingCheck" class="form-check-input"
                                           x-model="billing.newMode"
                                           :disabled="billing.locked"
                                           @change="billing.selected=''; billing.form={street:'',city:'',postcode:'',country:''}">
                                    <label for="newBillingCheck" class="form-check-label">Criar nova morada</label>
                                </div>
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
        <!-- ==================== MÉTODOS DE ENVIO E PAGAMENTO ==================== -->
        <div class="row" id="shippingPaymentCard">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Método de Envio</h4>
                        <p class="card-title-desc">Escolha o método de entrega da encomenda.</p>
                        <select id="shipping_method_id" class="form-control">
                            <option value="">-- Selecione --</option>
                            <?php if (!empty($shippingMethods)): ?>
                                <?php foreach ($shippingMethods as $method): ?>
                                    <option value="<?= esc($method['id']) ?>">
                                        <?= esc($method['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option disabled>Sem métodos disponíveis</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Método de Pagamento</h4>
                        <p class="card-title-desc">Escolha como o cliente irá pagar a encomenda.</p>
                        <select id="payment_method_id" class="form-control">
                            <option value="">-- Selecione --</option>
                            <?php if (!empty($paymentMethods)): ?>
                                <?php foreach ($paymentMethods as $method): ?>
                                    <option value="<?= esc($method['id']) ?>">
                                        <?= esc($method['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option disabled>Sem métodos disponíveis</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Coluna lateral -->
    <div class="col-4">
        <div class="card" id="customerCard">
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
                    <input class="form-check-input"
                           type="checkbox"
                           id="createNewCustomer"
                           x-model="createNew">
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
                                <input type="text"
                                       class="form-control"
                                       :value="customer.gender === 'M' ? 'Masculino' : customer.gender === 'F' ? 'Feminino' : (customer.gender === 'O' ? 'Outro' : '')"
                                       readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Grupo do Cliente</label>
                                <input type="text"
                                       class="form-control"
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
    </div>
</div>
<script>
    function orderApp() {
        return {
            // ==================== PRODUTOS ====================
            products: <?= json_encode($productsByType, JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
            flatProducts: [],
            selectedProduct: "",
            orderItems: [],
            subtotal: 0,
            ivaTotal: 0,
            totalComIva: 0,
            taxCountryId: null,

            init() {
                console.log("✅ Alpine iniciado");
                this.initCustomer();
                this.initProducts();
                this.initAddresses();
                this.initShippingPayment();
            },
            // === Inicialização dos produtos ===
            initProducts() {
                const self = this;
                this.flatProducts = Object.values(this.products)
                    .flat()
                    .map(p => {
                        if (p.type === "configurable" && p.variants) {
                            return p.variants.map(v => ({
                                id: v.id,
                                sku: v.sku,
                                name: v.name ?? "",
                                type: "variant",
                                price: parseFloat(v.price ?? 0),
                                country_id: v.country_id ?? null
                            }));
                        }
                        return {
                            id: p.id,
                            sku: p.sku,
                            name: p.name ?? "",
                            type: p.type,
                            price: parseFloat(p.price ?? 0),
                            country_id: p.country_id ?? null
                        };
                    })
                    .flat();

                // Inicia Select2
                $("#product_id").select2({ width: "100%" })
                    .on("change", function (e) {
                        self.selectedProduct = e.target.value;
                    });

                // Observa alterações nas linhas
                this.$watch("orderItems", () => {
                    setTimeout(() => {
                        $(".tax-select").select2({
                            width: "100%",
                            minimumResultsForSearch: Infinity,
                            placeholder: "-- Selecione --"
                        })
                            .off("change")
                            .on("change", function () {
                                const id = $(this).attr("id").replace("tax_", "");
                                const sel = $(this).find(":selected");
                                const rate = parseFloat(sel.data("rate") || 0);
                                const item = self.orderItems.find(i => i.id == id);
                                if (item) {
                                    item.tax_id = $(this).val();
                                    item.tax_rate = rate;
                                    self.updateLine(item);
                                }
                            });
                    }, 10);
                });
            },

            // === Funções de produto ===
            addProduct() {
                const prod = this.flatProducts.find(p => p.id == this.selectedProduct);
                if (!prod) return;

                const existing = this.orderItems.find(i => i.id == prod.id);
                if (existing) {
                    existing.qty++;
                    existing.total = (existing.qty * existing.price).toFixed(2);
                } else {
                    if (this.orderItems.length === 0 && prod.country_id)
                        this.taxCountryId = prod.country_id;

                    if (this.taxCountryId && prod.country_id && prod.country_id !== this.taxCountryId) {
                        showToast("As taxas de imposto devem pertencer ao mesmo país.", "error");
                        $("#product_id").val(null).trigger("change");
                        this.selectedProduct = "";
                        return;
                    }

                    this.orderItems.push({
                        ...prod,
                        qty: 1,
                        tax_id: "",
                        tax_rate: 0,
                        total: prod.price
                    });
                }

                this.calculateTotals();
                $("#product_id").val(null).trigger("change");
                this.selectedProduct = "";
            },

            updateLine(item) {
                const rate = parseFloat(item.tax_rate || 0);
                const lineTotal = item.qty * item.price * (1 + rate / 100);
                item.total = parseFloat(lineTotal);
                this.calculateTotals();
            },

            removeItem(id) {
                this.orderItems = this.orderItems.filter(i => i.id != id);
                if (this.orderItems.length === 0) this.taxCountryId = null;
                this.calculateTotals();
            },

            calculateTotals() {
                let subtotal = 0, ivaTotal = 0;
                this.orderItems.forEach(i => {
                    const base = i.qty * i.price;
                    const iva = base * (i.tax_rate || 0) / 100;
                    subtotal += base;
                    ivaTotal += iva;
                });
                this.subtotal = subtotal.toFixed(2);
                this.ivaTotal = ivaTotal.toFixed(2);
                this.totalComIva = (subtotal + ivaTotal).toFixed(2);
            },
            // ==================== MORADAS ====================
            selectedCustomer: null,
            addresses: <?= json_encode($customerAddresses, JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
            shipping: { selected: "", form: { street: "", city: "", postcode: "", country: "" }, newMode: false, locked: false },
            billing:  { selected: "", form: { street: "", city: "", postcode: "", country: "" }, newMode: false, locked: false },
            useSameBilling: false,
            createNewMode: false,

            get filteredAddresses() {
                return this.selectedCustomer
                    ? this.addresses.filter(a => a.customer_id == this.selectedCustomer)
                    : [];
            },

            initAddresses() {
                const self = this;
                $("#customer_id").select2({ width: "100%" })
                    .on("change", function (e) {
                        self.selectedCustomer = e.target.value;
                        self.resetAddresses();
                    });

                window.addEventListener("customer-cleared", () => {
                    self.selectedCustomer = null;
                    self.createNewMode = true;
                    self.forceNewAddresses();
                });

                window.addEventListener("customer-reset", () => {
                    self.createNewMode = false;
                    self.selectedCustomer = null;
                    self.resetAddresses();
                });
            },

            resetAddresses() {
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
                const addr = this.filteredAddresses.find(a => a.id == addrId);
                if (addr) {
                    ref.form.street   = addr.street   ?? "";
                    ref.form.city     = addr.city     ?? "";
                    ref.form.postcode = addr.postcode ?? "";
                    ref.form.country  = addr.country  ?? "";
                }
            },
            // ==================== MÉTODOS DE ENVIO E PAGAMENTO ====================
            shippingMethods: <?= json_encode($shippingMethods ?? [], JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
            paymentMethods: <?= json_encode($paymentMethods ?? [], JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
            selectedShipping: "",
            selectedPayment: "",

            initShippingPayment() {
                const self = this;

                // Select2 - Métodos de Envio
                $("#shipping_method_id").select2({
                    width: "100%",
                    placeholder: "-- Selecione o método de envio --"
                }).on("change", function(e) {
                    self.selectedShipping = e.target.value;
                });

                // Select2 - Métodos de Pagamento
                $("#payment_method_id").select2({
                    width: "100%",
                    placeholder: "-- Selecione o método de pagamento --"
                }).on("change", function(e) {
                    self.selectedPayment = e.target.value;
                });
            },
            customers: <?= json_encode($customers, JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
            groups: <?= json_encode($customerGroups, JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
            selectedCustomer: null,
            createNew: false,
            customer: { name: "", email: "", phone: "", gender: "", group_id: "", notes: "" },
            initCustomer() {
                const self = this;
                const $select = $("#customer_id").select2({
                    width: "100%",
                    placeholder: "-- Selecione --",
                    matcher: function (params, data) {
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
                $select.on("change", function (e) {
                    if (suppressChange) return;
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
                        self.customer.name = c.name ?? "";
                        self.customer.email = c.email ?? "";
                        self.customer.phone = c.phone ?? "";
                        self.customer.gender = c.gender ?? "";
                        self.customer.group_id = c.group_id ?? "";
                        self.customer.notes = c.notes ?? "";
                    } else {
                        self.resetCustomer();
                    }
                });

                this.$watch("createNew", value => {
                    if (value) {
                        $select.prop("disabled", true);
                        suppressChange = true;
                        $select.val(null).trigger("change");
                        suppressChange = false;
                        self.resetCustomer();
                        window.dispatchEvent(new CustomEvent("customer-cleared"));
                    } else {
                        $select.prop("disabled", false);
                        window.dispatchEvent(new CustomEvent("customer-reset"));
                    }
                });
            },

            resetCustomer() {
                this.customer = { name: "", email: "", phone: "", gender: "", group_id: "", notes: "" };
            },

// ==================== SUBMISSÃO FINAL ====================
            loading: false,

            async submitOrder() {
                if (!this._formHandler) {
                    this._formHandler = formHandler('<?= base_url('admin/sales/orders/store') ?>', {}, { resetOnSuccess: true });
                }
                const payload = {
                    customer: this.customer ?? {},
                    createNew: this.createNew ?? false,
                    selectedCustomer: this.selectedCustomer ?? null,
                    shipping: this.shipping ?? {},
                    billing: this.billing ?? {},
                    useSameBilling: this.useSameBilling ?? false,
                    orderItems: this.orderItems ?? [],
                    subtotal: this.subtotal ?? 0,
                    ivaTotal: this.ivaTotal ?? 0,
                    orderTotal: this.totalComIva ?? 0,
                    shipping_method_id: this.selectedShipping ?? '',
                    payment_method_id: this.selectedPayment ?? ''
                };

                // ✅ injeta o payload no formHandler e usa o submit dele
                this._formHandler.form = payload;

                try {
                    this.loading = true;
                    await this._formHandler.submit();
                    this.loading = false;
                } catch (err) {
                    this.loading = false;
                    showToast('Erro de comunicação com o servidor.', 'error');
                }
            }
        };
    }
</script>
<?= $this->endSection() ?>

