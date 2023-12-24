<template>
    <user-layout>
        <div id="edit_quote_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('quote.edit_quote')" />
                <div class="card">
                    <form class="formgrid">
                        <div class="grid">
                            <TextInput
                                id="number_input"
                                v-model="v$.quote.number.$model"
                                class="col-12 md:col-6"
                                disabled
                                :validate="v$.quote.number"
                                :label="$t('form.number')"
                            />
                            <SelectInput
                                id="status_input"
                                v-model="v$.quote.status.$model"
                                class="field col-12 md:col-6"
                                :label="$t('form.status')"
                                :options="[
                                    { label: $t('status.draft'), value: 'draft' },
                                    { label: $t('status.sent'), value: 'sent' },
                                    { label: $t('status.viewed'), value: 'viewed' },
                                    { label: $t('status.accepted'), value: 'accepted' },
                                    { label: $t('status.rejected'), value: 'rejected' },
                                    { label: $t('status.expired'), value: 'expired' },
                                    { label: $t('status.cancelled'), value: 'cancelled' },
                                ]"
                                :validate="v$.quote.status"
                            />
                        </div>

                        <div class="grid">
                            <SelectInput
                                id="customer_input"
                                v-model="quote.customer_id"
                                class="col-12 md:col-6"
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
                                class="col-12 md:col-6"
                                :label="$t('form.payer')"
                                filter
                                show-clear
                                :options="partners"
                                option-value="id"
                                option-label="name"
                            />
                        </div>

                        <div class="grid">
                            <SelectInput
                                v-model="quote.customer_address_id"
                                :label="$t('form.customer_address')"
                                class="col-12 md:col-6"
                                :options="customerAddresses"
                                data-key="id"
                                option-label="addressText"
                                option-value="id"
                                :disabled="!quote.customer_id"
                            />

                            <SelectInput
                                v-model="quote.payer_address_id"
                                :label="$t('form.payer_address')"
                                class="col-12 md:col-6"
                                :options="payerAddresses"
                                data-key="id"
                                option-label="addressText"
                                option-value="id"
                                :disabled="!quote.payer_id"
                            />
                        </div>

                        <div class="grid">
                            <DateInput
                                id="date_input"
                                v-model="v$.quote.date.$model"
                                class="col-12 md:col-4"
                                :validate="v$.quote.date"
                                :label="$t('form.date')"
                            />
                            <DateInput
                                id="valid_until_input"
                                v-model="v$.quote.valid_until.$model"
                                class="col-12 md:col-4"
                                :label="$t('form.valid_until')"
                                :validate="v$.quote.valid_until"
                            />
                            <SelectInput
                                id="currency_input"
                                v-model="quote.currency"
                                class="col-12 md:col-4"
                                :label="$t('form.currency')"
                                :options="currencies"
                                option-value="code"
                                option-label="name"
                            />
                        </div>

                        <div class="grid">
                            <div class="col-12">
                                <Button :label="$t('basic.add_item')" icon="fa fa-plus" @click="addItem" />
                            </div>
                            <DataTable class="col-12" :value="quote.items">
                                <template #empty>
                                    <div class="p-4 pl-0 text-center text-gray-500">{{ $t('quote.no_items') }}</div>
                                </template>

                                <Column field="name" :header="$t('form.name')">
                                    <template #body="slotProps">
                                        <Dropdown
                                            v-if="slotProps.data.added"
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
                                        </Dropdown>
                                        <span v-else>{{ slotProps.data.name }}</span>
                                    </template>
                                </Column>
                                <Column field="description" :header="$t('form.description')">
                                    <template #body="slotProps">
                                        <TextAreaInput :id="`description_input_${slotProps.index}`" v-model="slotProps.data.description" />
                                    </template>
                                </Column>
                                <Column :header="$t('quote.quantity_and_discount')">
                                    <template #body="slotProps">
                                        <InputNumber
                                            :id="`quantity_input_${slotProps.index}`"
                                            v-model="slotProps.data.quantity"
                                            :show-buttons="true"
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
                                <Column :header="$t('quote.price_and_tax')">
                                    <template #body="slotProps">
                                        <InputNumber
                                            :id="`price_input_${slotProps.index}`"
                                            v-model="slotProps.data.price"
                                            :currency="$settings.default_currency"
                                            mode="currency"
                                            @focus="calculateItemTotal(slotProps.index)"
                                        />
                                        <Dropdown
                                            v-model="slotProps.data.tax"
                                            :options="taxes"
                                            class="mt-0 md:mt-2"
                                            option-value="value"
                                            option-label="name"
                                            :placeholder="$t('quote.select_tax')"
                                            :show-clear="true"
                                            @change="calculateItemTotal(slotProps.index)"
                                        />
                                    </template>
                                </Column>
                                <Column field="total" :header="$t('form.total')">
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
                                        <Button class="p-button-danger" icon="fa fa-trash" @click="removeItem(slotProps.index)" />
                                    </template>
                                </Column>
                            </DataTable>
                        </div>

                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <TextAreaInput id="notes_input" v-model="quote.notes" :label="$t('form.notes')" />
                                <TinyMceEditor
                                    id="footer_input"
                                    v-model="quote.footer"
                                    :label="$t('form.footer')"
                                    style="height: 200px"
                                    toolbar=" bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link"
                                />
                            </div>
                            <div class="col-12 md:col-6">
                                <NumberInput
                                    id="discount_input"
                                    v-model="quote.discount"
                                    class="col-12"
                                    :label="$t('form.discount')"
                                    suffix="%"
                                    @blur="calculateTotal"
                                />
                                <NumberInput
                                    v-if="quote.currency_rate !== 1"
                                    id="currency_rate_input"
                                    v-model="quote.currency_rate"
                                    class="col-12"
                                    disabled
                                    :label="$t('form.currency_rate')"
                                />
                                <NumberInput
                                    id="total_input"
                                    v-model="v$.quote.total.$model"
                                    class="col-12"
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
                <div id="function_buttons" class="flex gap-2 justify-content-end">
                    <Button
                        id="cancel_button"
                        :label="$t('basic.cancel')"
                        icon="fa fa-times"
                        class="p-button-danger"
                        @click="goTo('/quotes')"
                    />
                    <Button
                        id="update_button"
                        :label="$t('basic.update')"
                        :disabled="loadingData"
                        icon="fa fa-floppy-disk"
                        class="p-button-success"
                        @click="validateForm"
                    />
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import QuoteMixin from '@/mixins/quotes'
export default {
    name: 'EditQuotePage',
    mixins: [QuoteMixin],

    setup: () => ({ v$: useVuelidate() }),

    watch: {
        'quote.currency': function () {
            if (!this.quote.currency) {
                return
            }
            this.quote.currency_rate = this.currencies.find((currency) => currency.code === val).rate
            this.calculateTotal()
        },
        'quote.currency_rate': function () {
            this.calculateTotal()
        },
        'quote.customer_id': function () {
            this.getCustomerAddresses()
        },
        'quote.payer_id': function () {
            this.getPayerAddresses()
        },
    },
    created() {
        this.getPartners()
        this.getProducts()
        this.getQuote(this.$route.params.id)
    },

    validations() {
        return {
            quote: {
                number: { required },
                status: { required },
                date: { required },
                valid_until: { required },
                total: { required },
            },
        }
    },

    methods: {
        validateForm() {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }
            this.updateQuote(this.$route.params.id)
        },

        selectItem(index, item) {
            this.quote.items[index].product_id = this.quote.items[index].item.id
            this.quote.items[index].type = this.quote.items[index].item.type
            this.quote.items[index].name = this.quote.items[index].item.name
            this.quote.items[index].unit = this.quote.items[index].item.unit
            this.quote.items[index].price = this.quote.items[index].item.sell_price
            this.quote.items[index].tax = this.quote.items[index].item.tax
            this.quote.items[index].total = this.quote.items[index].price * this.quote.items[index].quantity
            this.calculateItemTotal(index)
        },

        addItem() {
            this.quote.items.push({
                product_id: '',
                type: '',
                name: '',
                added: true,
                description: '',
                quantity: 1,
                discount: 0,
                price: 0,
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
        },
        getPayerAddresses() {
            if (!this.quote.payer_id) {
                this.payerAddresses = []
                return
            }
            this.payerAddresses = this.formatAddresses(this.partners, this.quote.payer_id)
        },
    },
}
</script>

<style></style>
