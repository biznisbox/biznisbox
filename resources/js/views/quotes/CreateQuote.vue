<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('quote.new_quote')" />

            <div class="card">
                <form>
                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-2">
                        <TextInput
                            id="number_input"
                            v-model="v$.quote.number.$model"
                            disabled
                            :label="$t('form.number')"
                            :validate="v$.quote.number"
                        />
                        <SelectInput
                            id="status_input"
                            v-model="v$.quote.status.$model"
                            :label="$t('form.status')"
                            :options="[
                                { label: $t('status.draft'), value: 'draft' },
                                { label: $t('status.sent'), value: 'sent' },
                                { label: $t('status.viewed'), value: 'viewed' },
                                { label: $t('status.accepted'), value: 'accepted' },
                                { label: $t('status.cancelled'), value: 'cancelled' },
                                { label: $t('status.rejected'), value: 'rejected' },
                                { label: $t('status.converted'), value: 'converted' },
                                { label: $t('status.expired'), value: 'expired' },
                            ]"
                            :validate="v$.quote.status"
                        />
                    </div>

                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-2">
                        <SelectInput
                            id="customer_input"
                            v-model="quote.customer_id"
                            :label="$t('form.customer')"
                            :options="partners"
                            filter
                            show-clear
                            option-value="id"
                            option-label="name"
                        />

                        <SelectInput
                            id="payer_input"
                            v-model="quote.payer_id"
                            :label="$t('form.payer')"
                            filter
                            show-clear
                            :options="partners"
                            option-value="id"
                            option-label="name"
                        />
                    </div>

                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-2">
                        <SelectInput
                            v-model="quote.customer_address_id"
                            :label="$t('form.customer_address')"
                            :options="customerAddresses"
                            data-key="id"
                            option-label="addressText"
                            option-value="id"
                            :disabled="!quote.customer_id"
                        />

                        <SelectInput
                            v-model="quote.payer_address_id"
                            :label="$t('form.payer_address')"
                            :options="payerAddresses"
                            data-key="id"
                            option-label="addressText"
                            option-value="id"
                            :disabled="!quote.payer_id"
                        />
                    </div>

                    <div class="grid lg:grid-cols-3 grid-cols-1 gap-2">
                        <DateInput id="date_input" :label="$t('form.date')" v-model="v$.quote.date.$model" :validate="v$.quote.date" />
                        <DateInput
                            id="valid_until_input"
                            v-model="v$.quote.valid_until.$model"
                            :label="$t('form.valid_until')"
                            :validate="v$.quote.valid_until"
                        />
                        <SelectInput
                            id="currency_input"
                            v-model="v$.quote.currency.$model"
                            :label="$t('form.currency')"
                            :options="currencies"
                            option-value="code"
                            option-label="name"
                            :validate="v$.quote.currency"
                        />
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                        <SelectInput
                            id="sales_person_input"
                            v-model="quote.sales_person_id"
                            :label="$t('form.sales_person')"
                            :options="employees"
                            option-value="id"
                            option-label="label"
                        />
                        <SelectInput
                            id="payment_method_input"
                            v-model="v$.quote.payment_method.$model"
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
                            :validate="v$.quote.payment_method"
                        />
                    </div>

                    <div id="item_section" class="grid">
                        <div class="my-2">
                            <Button id="add_item_button" :label="$t('basic.add_item')" icon="fa fa-plus" @click="addItem" />
                        </div>
                        <DataTable class="overflow-x-auto" :value="quote.items">
                            <template #empty>
                                <div class="p-4 pl-0 text-center">{{ $t('quote.no_items') }}</div>
                            </template>

                            <Column field="name" :header="$t('form.name')">
                                <template #body="slotProps">
                                    <Select
                                        :id="`product_select_${slotProps.index}`"
                                        v-model="slotProps.data.item"
                                        :options="products"
                                        data-key="id"
                                        :placeholder="$t('quote.select_item')"
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

                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-2">
                        <div>
                            <TextAreaInput id="notes_input" v-model="quote.notes" :label="$t('form.notes')" />
                            <TinyMceEditor
                                id="footer_input"
                                v-model="quote.footer"
                                :label="$t('form.footer')"
                                style="height: 200px"
                                toolbar="bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link"
                            />
                        </div>

                        <div>
                            <SelectInput
                                id="discount_type_input"
                                v-model="quote.discount_type"
                                :label="$t('form.discount_type')"
                                :options="[
                                    { label: $t('discount_type.percent'), value: 'percent' },
                                    { label: $t('discount_type.fixed'), value: 'fixed' },
                                ]"
                                @change="calculateTotal"
                            />

                            <NumberInput
                                id="discount_input"
                                v-model="quote.discount"
                                :label="$t('form.discount')"
                                suffix="%"
                                @blur="calculateTotal"
                            />
                            <NumberInput
                                v-if="quote.currency_rate !== 1"
                                id="currency_rate_input"
                                v-model="quote.currency_rate"
                                disabled
                                :label="$t('form.currency_rate')"
                            />
                            <NumberInput
                                id="total_input"
                                v-model="v$.quote.total.$model"
                                :label="$t('form.final_total')"
                                :disabled="true"
                                mode="currency"
                                :currency="quote.currency"
                                :validate="v$.quote.total"
                            />
                        </div>
                    </div>
                </form>
            </div>
            <div id="function_buttons" class="flex justify-end gap-2 mt-4">
                <Button id="cancel_button" :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="goTo('/quotes')" />
                <Button
                    id="save_button"
                    :label="$t('basic.save')"
                    :disabled="loadingData"
                    severity="success"
                    icon="fa fa-floppy-disk"
                    @click="validateForm"
                />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
import QuotesMixin from '@/mixins/quotes'
export default {
    name: 'CreateQuotePage',
    mixins: [QuotesMixin],
    setup() {
        return { v$: useVuelidate() }
    },
    created() {
        this.getPartners()
        this.getProducts()
        this.getTaxes()
        this.getQuoteNumber()
        this.getEmployees()
        this.getCurrencies()
    },
    validations() {
        return {
            quote: {
                number: { required },
                status: { required },
                date: { required },
                valid_until: { required },
                currency: { required },
                total: { required },
                payment_method: { required },
            },
        }
    },
    methods: {
        selectItem(index) {
            let item = this.quote.items[index].item
            this.quote.items[index].product_id = item.id
            this.quote.items[index].name = item.name
            this.quote.items[index].unit = item.unit
            this.quote.items[index].price = item.sell_price
            this.quote.items[index].tax = item.tax
            this.quote.items[index].total = item.sell_price
            this.calculateItemTotal(index)
        },
        validateForm() {
            this.v$.quote.$touch()
            if (this.v$.quote.$error) {
                return this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
            }
            return this.createQuote()
        },

        addItem() {
            this.quote.items.push({
                product_id: '',
                item: '',
                name: '',
                description: '',
                quantity: 1,
                unit: '',
                price: 0,
                tax: 0,
                discount: 0,
                total: 0,
            })
        },
        removeItem(index) {
            this.quote.items.splice(index, 1)
        },
        calculateItemTotal(index) {
            let item = this.quote.items[index]
            item.total = item.price * item.quantity
            item.total = item.total - (item.total * item.discount) / 100
            item.total = item.total + (item.total * item.tax) / 100
            this.quote.items[index].total = item.total
            this.calculateTotal()
        },
        calculateTotal() {
            this.quote.total = 0
            this.quote.items.forEach((item) => {
                this.quote.total += item.total
            })
            if (this.quote.currency_rate !== 1) {
                this.quote.total = this.quote.total * this.quote.currency_rate
            }
            this.quote.total = this.quote.total - (this.quote.total * this.quote.discount) / 100
        },

        getCustomerAddresses() {
            if (!this.quote.customer_id) {
                this.customerAddresses = []
                return
            }
            this.customerAddresses = this.formatAddresses(this.partners, this.quote.customer_id)
            if (this.customerAddresses.length) {
                this.quote.customer_address_id = this.customerAddresses[0].id
            }
        },
        getPayerAddresses() {
            if (!this.quote.payer_id) {
                this.payerAddresses = []
                return
            }
            this.payerAddresses = this.formatAddresses(this.partners, this.quote.payer_id)
            if (this.payerAddresses.length) {
                this.quote.payer_address_id = this.payerAddresses[0].id
            }
        },
    },
    data() {
        return {}
    },

    watch: {
        'quote.customer_id': function (val) {
            this.getCustomerAddresses(val)
        },
        'quote.payer_id': function (val) {
            this.getPayerAddresses(val)
        },
        'quote.currency': function (val) {
            if (!val) {
                return
            }
            this.quote.currency_rate = this.currencies.find((currency) => currency.code === val).exchange_rate
            this.calculateTotal()
        },
    },
}
</script>
<style></style>
