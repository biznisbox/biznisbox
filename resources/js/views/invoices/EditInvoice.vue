<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('invoice.edit_invoice', 3)" />

            <form>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                    <TextInput
                        id="number_input"
                        v-model="v$.invoice.number.$model"
                        disabled
                        :label="$t('form.number')"
                        :validate="v$.invoice.number"
                    />
                    <SelectInput
                        id="status_input"
                        v-model="v$.invoice.status.$model"
                        :label="$t('form.status')"
                        :options="[
                            { label: $t('status.draft'), value: 'draft' },
                            { label: $t('status.sent'), value: 'sent' },
                            { label: $t('status.paid'), value: 'paid' },
                            { label: $t('status.cancelled'), value: 'cancelled' },
                            { label: $t('status.partial'), value: 'partial' },
                            { label: $t('status.overdue'), value: 'overdue' },
                            { label: $t('status.refunded'), value: 'refunded' },
                            { label: $t('status.unpaid'), value: 'unpaid' },
                        ]"
                        :validate="v$.invoice.status"
                    />
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                    <SelectInput
                        id="customer_input"
                        v-model="invoice.customer_id"
                        :label="$t('form.customer')"
                        :options="partners"
                        filter
                        show-clear
                        option-value="id"
                        option-label="name"
                    />

                    <SelectInput
                        id="payer_input"
                        v-model="invoice.payer_id"
                        class="col-12 md:col-6"
                        :label="$t('form.payer')"
                        filter
                        show-clear
                        :options="partners"
                        option-value="id"
                        option-label="name"
                    />
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                    <SelectInput
                        v-model="invoice.customer_address_id"
                        :label="$t('form.customer_address')"
                        :options="customerAddresses"
                        data-key="id"
                        option-label="addressText"
                        option-value="id"
                        :disabled="!invoice.customer_id"
                    />

                    <SelectInput
                        v-model="invoice.payer_address_id"
                        :label="$t('form.payer_address')"
                        :options="payerAddresses"
                        data-key="id"
                        option-label="addressText"
                        option-value="id"
                        :disabled="!invoice.payer_id"
                    />
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                    <DateInput id="date_input" v-model="v$.invoice.date.$model" :label="$t('form.date')" :validate="v$.invoice.date" />
                    <DateInput
                        id="due_date_input"
                        v-model="v$.invoice.due_date.$model"
                        :label="$t('form.due_date')"
                        :validate="v$.invoice.due_date"
                    />
                    <SelectInput
                        id="currency_input"
                        v-model="v$.invoice.currency.$model"
                        :label="$t('form.currency')"
                        :options="currencies"
                        option-value="code"
                        option-label="name"
                        :validate="v$.invoice.currency"
                    />
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                    <SelectInput
                        id="sales_person_input"
                        v-model="invoice.sales_person_id"
                        :label="$t('form.sales_person')"
                        :options="employees"
                        option-value="id"
                        option-label="label"
                    />
                    <SelectInput
                        id="payment_method_input"
                        v-model="v$.invoice.payment_method.$model"
                        :label="$t('form.payment_method')"
                        :options="[
                            { label: $t('payment_methods.bank_transfer'), value: 'bank_transfer' },
                            { label: $t('payment_methods.cash'), value: 'cash' },
                            { label: $t('payment_methods.check'), value: 'check' },
                            { label: $t('payment_methods.credit_card'), value: 'credit_card' },
                            { label: $t('payment_methods.paypal'), value: 'paypal' },
                            { label: $t('payment_methods.stripe'), value: 'stripe' },
                            { label: $t('payment_methods.other'), value: 'other' },
                        ]"
                        :validate="v$.invoice.payment_method"
                    />
                </div>

                <div id="item_section" class="grid">
                    <div>
                        <Button id="add_item_button" :label="$t('basic.add_item')" icon="fa fa-plus" @click="addItem" />
                    </div>
                    <DataTable class="overflow-x-auto" :value="invoice.items">
                        <template #empty>
                            <div class="p-4 pl-0 text-center">{{ $t('invoice.no_items') }}</div>
                        </template>

                        <Column field="name" :header="$t('form.name')">
                            <template #body="slotProps">
                                <Select
                                    v-if="slotProps.data.added"
                                    v-model="slotProps.data.item"
                                    :options="products"
                                    data-key="id"
                                    :placeholder="$t('invoice.select_item')"
                                    @change="selectItem(slotProps.index, slotProps.data)"
                                >
                                    <template #value="slotProps">
                                        <span v-if="slotProps.value">{{ slotProps.value.name }}</span>
                                        <span v-else>{{ slotProps.placeholder }}</span>
                                    </template>
                                    <template #option="slotProps">
                                        <span v-if="slotProps.option">{{ slotProps.option.name }}</span>
                                    </template>
                                </Select>
                                <span v-else>{{ slotProps.data.name }}</span>
                            </template>
                        </Column>

                        <Column field="description" :header="$t('form.description')">
                            <template #body="slotProps">
                                <TextAreaInput :id="`description_input_${slotProps.index}`" v-model="slotProps.data.description" />
                            </template>
                        </Column>

                        <Column :header="$t('invoice.quantity_and_discount')">
                            <template #body="slotProps">
                                <InputNumber
                                    :id="`quantity_input_${slotProps.index}`"
                                    v-model="slotProps.data.quantity"
                                    show-buttons
                                    :min="1"
                                    mode="decimal"
                                    @input="calculateItemTotal(slotProps.index)"
                                />
                                <InputNumber
                                    :id="`discount_input_${slotProps.index}`"
                                    v-model="slotProps.data.discount"
                                    class="mt-0 md:mt-2"
                                    suffix="%"
                                    :max="100"
                                    @blur="calculateItemTotal(slotProps.index)"
                                />
                            </template>
                        </Column>
                        <Column :header="$t('invoice.price_and_tax')">
                            <template #body="slotProps">
                                <InputNumber
                                    :id="`price_input_${slotProps.index}`"
                                    v-model="slotProps.data.price"
                                    :currency="$settings.default_currency"
                                    mode="currency"
                                    @focus="calculateItemTotal(slotProps.index)"
                                />

                                <Select
                                    v-model="slotProps.data.tax"
                                    :options="taxes"
                                    class="mt-0 md:mt-2"
                                    option-value="value"
                                    option-label="name"
                                    :placeholder="$t('invoice.select_tax')"
                                    :show-clear="true"
                                    @change="calculateItemTotal(slotProps.index)"
                                />
                            </template>
                        </Column>
                        <Column :header="$t('form.total')">
                            <template #body="slotProps">
                                <InputNumber
                                    :id="`total_input_${slotProps.index}`"
                                    v-model="slotProps.data.total"
                                    :currency="$settings.default_currency"
                                    :disabled="true"
                                    mode="currency"
                                    @focus="calculateItemTotal(slotProps.index)"
                                />
                            </template>
                        </Column>

                        <Column :header="$t('basic.actions')">
                            <template #body="slotProps">
                                <Button
                                    icon="fa fa-trash"
                                    @click="removeItem(slotProps.index)"
                                    severity="danger"
                                    :id="`remove_item_button_${slotProps.index}`"
                                />
                            </template>
                        </Column>
                    </DataTable>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                    <div>
                        <TextAreaInput id="notes_input" v-model="invoice.notes" :label="$t('form.notes')" />
                        <TinyMceEditor
                            id="footer_input"
                            v-model="invoice.footer"
                            :label="$t('form.footer')"
                            toolbar="bold italic underline | alignleft aligncenter alignright alignjustify | forecolor backcolor | bullist numlist | link"
                            style="height: 250px"
                        />
                    </div>
                    <div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                            <NumberInput
                                id="discount_input"
                                v-model="invoice.discount"
                                :label="$t('form.discount')"
                                @blur="calculateTotal"
                            />

                            <SelectInput
                                id="discount_type_input"
                                v-model="invoice.discount_type"
                                :label="$t('form.discount_type')"
                                :options="[
                                    { label: $t('discount_type.percent'), value: 'percent' },
                                    { label: $t('discount_type.fixed'), value: 'fixed' },
                                ]"
                                @change="calculateTotal"
                            />
                        </div>

                        <NumberInput
                            v-if="invoice.currency_rate !== 1"
                            id="currency_rate_input"
                            v-model="invoice.currency_rate"
                            disabled
                            :label="$t('form.currency_rate')"
                        />
                        <NumberInput
                            id="final_total_input"
                            v-model="v$.invoice.total.$model"
                            :label="$t('form.final_total')"
                            disabled
                            mode="currency"
                            :currency="invoice.currency"
                            :validate="v$.invoice.total"
                        />
                    </div>
                </div>
            </form>
            <div id="function_buttons" class="flex justify-end gap-2">
                <Button id="cancel_button" :label="$t('basic.cancel')" icon="fa fa-times" @click="goTo('/invoices')" severity="secondary" />
                <Button
                    id="save_button"
                    :label="$t('basic.save')"
                    :disabled="loadingData"
                    icon="fa fa-floppy-disk"
                    @click="validateForm"
                    severity="success"
                />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
import InvoicesMixin from '@/mixins/invoices'
export default {
    name: 'EditInvoicePage',
    mixins: [InvoicesMixin],
    setup() {
        return { v$: useVuelidate() }
    },
    watch: {
        'invoice.customer_id': function (val) {
            this.getCustomerAddresses(val)
        },
        'invoice.payer_id': function (val) {
            this.getPayerAddresses(val)
        },
        'invoice.currency': function (val) {
            this.invoice.currency_rate = this.currencies.find((currency) => currency.code === val).rate
            this.calculateTotal()
        },
    },
    created() {
        this.getTaxes()
        this.getPartners()
        this.getProducts()
        this.getCurrencies()
        this.getEmployees()
        this.getInvoice(this.$route.params.id)
    },
    validations() {
        return {
            invoice: {
                number: { required },
                status: { required },
                date: { required },
                due_date: { required },
                currency: { required },
                total: { required },
                payment_method: { required },
            },
        }
    },
    methods: {
        validateForm() {
            this.v$.invoice.$touch()
            if (this.v$.invoice.$error) {
                return this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
            }
            return this.updateInvoice(this.$route.params.id)
        },

        selectItem(index, item) {
            let product = item.item
            this.invoice.items[index].product_id = product.id
            this.invoice.items[index].type = product.type
            this.invoice.items[index].price = product.sell_price
            this.invoice.items[index].tax = product.tax
            this.invoice.items[index].quantity = 1
            this.invoice.items[index].discount = 0
            this.invoice.items[index].name = product.name
            this.invoice.items[index].discount_type = 'percent'
            this.invoice.items[index].total = product.sell_price
            this.invoice.items[index].tax_type = product.tax_type
            this.invoice.items[index].unit = product.unit
            this.calculateItemTotal(index)
        },
        addItem() {
            this.invoice.items.push({
                product_id: '',
                added: true,
                type: '',
                item: '',
                name: '',
                description: '',
                quantity: 1,
                price: 0,
                tax: 0,
                discount: 0,
                total: 0,
            })
        },
        removeItem(index) {
            this.invoice.items.splice(index, 1)
        },
        calculateItemTotal(index) {
            let item = this.invoice.items[index]
            item.total = item.price * item.quantity
            item.total = item.total - (item.total * item.discount) / 100
            item.total = item.total + (item.total * item.tax) / 100
            this.invoice.items[index].total = item.total
            this.calculateTotal()
        },
        calculateTotal() {
            this.invoice.total = 0
            // Calculate item totals
            this.invoice.items.forEach((item) => {
                this.invoice.total += item.total
            })

            // Calculate discount
            if (this.invoice.discount_type === 'percent') {
                this.invoice.total = this.invoice.total - (this.invoice.total * this.invoice.discount) / 100
            } else {
                this.invoice.total = this.invoice.total - this.invoice.discount
            }

            // Calculate tax
            this.invoice.total = this.invoice.total + (this.invoice.total * this.invoice.tax) / 100

            // Calculate currency rate
            this.invoice.total = this.invoice.total * this.invoice.currency_rate

            this.invoice.total = this.invoice.total.toFixed(2)
        },
        getCustomerAddresses() {
            if (!this.invoice.customer_id) {
                this.customerAddresses = []
                return
            }
            this.customerAddresses = this.formatAddresses(this.partners, this.invoice.customer_id)
            if (this.customerAddresses.length) {
                this.invoice.customer_address_id = this.customerAddresses[0].id
            }
        },
        getPayerAddresses() {
            if (!this.invoice.payer_id) {
                this.payerAddresses = []
                return
            }
            this.payerAddresses = this.formatAddresses(this.partners, this.invoice.payer_id)
            if (this.payerAddresses.length) {
                this.invoice.payer_address_id = this.payerAddresses[0].id
            }
        },
    },
}
</script>
