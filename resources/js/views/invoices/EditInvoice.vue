<template>
    <user-layout>
        <div id="edit_invoice_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('invoice.edit_invoice')" />
                <div class="card">
                    <form class="formgrid">
                        <div class="grid">
                            <TextInput
                                id="number_input"
                                v-model="v$.invoice.number.$model"
                                class="col-12 md:col-6"
                                :label="$t('invoice.invoice_number')"
                                :validate="v$.invoice.number"
                            />
                            <SelectInput
                                id="status_input"
                                v-model="v$.invoice.status.$model"
                                class="col-12 md:col-6"
                                label="Status"
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

                        <div class="grid">
                            <SelectInput
                                id="customer_input"
                                v-model="invoice.customer_id"
                                class="col-12 md:col-6"
                                :label="$t('invoice.customer')"
                                :options="customers"
                                filter
                                show-clear
                                option-value="id"
                                option-label="name"
                            />
                            <SelectInput
                                id="payer_input"
                                v-model="invoice.payer_id"
                                class="col-12 md:col-6"
                                :label="$t('invoice.payer')"
                                filter
                                show-clear
                                :options="customers"
                                option-value="id"
                                option-label="name"
                            />
                        </div>

                        <div class="grid">
                            <DateInput
                                id="date_input"
                                v-model="v$.invoice.date.$model"
                                class="col-12 md:col-4"
                                :label="$t('invoice.date')"
                                :validate="v$.invoice.date"
                            />
                            <DateInput
                                id="due_date_input"
                                v-model="v$.invoice.due_date.$model"
                                class="col-12 md:col-4"
                                :label="$t('invoice.due_date')"
                                :validate="v$.invoice.due_date"
                            />
                            <SelectInput
                                id="currency_input"
                                v-model="invoice.currency"
                                class="col-12 md:col-4"
                                :label="$t('invoice.currency')"
                                :options="currencies"
                                option-value="code"
                                option-label="name"
                            />
                        </div>

                        <div class="grid">
                            <div class="col-12">
                                <Button :label="$t('invoice.add_item')" icon="fa fa-plus" @click="addItem" />
                            </div>
                            <DataTable class="col-12" :value="invoice.items">
                                <template #empty>
                                    <div class="p-4 pl-0 text-center text-gray-500">{{ $t('invoice.no_items') }}</div>
                                </template>

                                <Column field="name" :header="$t('invoice.name')">
                                    <template #body="slotProps">
                                        <Dropdown
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
                                        </Dropdown>
                                        <span v-else>{{ slotProps.data.name }}</span>
                                    </template>
                                </Column>
                                <Column field="description" :header="$t('invoice.description')">
                                    <template #body="slotProps">
                                        <TextAreaInput :id="`description_input_${slotProps.index}`" v-model="slotProps.data.description" />
                                    </template>
                                </Column>
                                <Column :header="$t('invoice.quantity_and_discount')">
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
                                <Column :header="$t('invoice.price_and_tax')">
                                    <template #body="slotProps">
                                        <InputNumber
                                            :id="`price_input_${slotProps.index}`"
                                            v-model="slotProps.data.price"
                                            :currency="invoice.currency"
                                            mode="currency"
                                            @focus="calculateItemTotal(slotProps.index)"
                                        />
                                        <Dropdown
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
                                <Column :header="$t('invoice.total')">
                                    <template #body="slotProps">
                                        <InputNumber
                                            :id="`total_input_${slotProps.index}`"
                                            v-model="slotProps.data.total"
                                            :currency="invoice.currency"
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
                                <TinyMceEditor
                                    id="notes_input"
                                    v-model="invoice.notes"
                                    :label="$t('invoice.notes')"
                                    toolbar=" bold italic underline"
                                    style="height: 200px"
                                />
                            </div>
                            <div class="col-12 md:col-6">
                                <InputNumber
                                    id="discount_input"
                                    v-model="invoice.discount"
                                    class="col-12"
                                    :label="$t('invoice.discount')"
                                    suffix="%"
                                    @blur="calculateTotal"
                                />
                                <InputNumber
                                    id="total_input"
                                    v-model="v$.invoice.total.$model"
                                    class="col-12"
                                    :label="$t('invoice.total')"
                                    disabled
                                    :validate="v$.invoice.total"
                                    mode="currency"
                                    :currency="invoice.currency"
                                />
                            </div>
                        </div>
                    </form>

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            class="p-button-danger"
                            @click="goTo('/invoices/' + invoice.id)"
                        />
                        <Button
                            :label="$t('basic.update')"
                            icon="fa fa-floppy-disk"
                            class="p-button-success"
                            :disabled="loadingData"
                            @click="validateForm"
                        />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required, helpers } from '@vuelidate/validators'
import InvoiceMixin from '@/mixins/invoices'
export default {
    name: 'EditInvoicePage',
    mixins: [InvoiceMixin],
    setup: () => ({ v$: useVuelidate() }),
    created() {
        this.getCustomers()
        this.getProducts()
        this.getInvoice(this.$route.params.id)
    },

    validations() {
        return {
            invoice: {
                number: { required },
                date: { required },
                due_date: { required },
                status: { required },
                total: { required },
            },
        }
    },

    methods: {
        selectItem(index, item) {
            this.invoice.items[index].product_id = this.invoice.items[index].item.id
            this.invoice.items[index].type = this.invoice.items[index].item.type
            this.invoice.items[index].name = this.invoice.items[index].item.name
            this.invoice.items[index].unit = this.invoice.items[index].item.unit
            this.invoice.items[index].price = this.invoice.items[index].item.sell_price
            this.invoice.items[index].tax = this.invoice.items[index].item.tax
            this.invoice.items[index].total = this.invoice.items[index].price * this.invoice.items[index].quantity
            this.calculateItemTotal(index)
        },

        validateForm() {
            this.v$.$validate()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }
            return this.updateInvoice(this.$route.params.id)
        },

        addItem() {
            this.invoice.items.push({
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
            this.invoice.items.forEach((item) => {
                this.invoice.total += item.total
            })
            this.invoice.total = this.invoice.total - (this.invoice.total * this.invoice.discount) / 100
        },
    },
}
</script>

<style></style>
