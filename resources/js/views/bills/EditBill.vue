<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('bill.edit_bill')" />

            <div class="card">
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <TextInput v-model="v$.bill.number.$model" :label="$t('form.number')" :validate="v$.bill.number" disabled />
                        <SelectInput
                            v-model="v$.bill.status.$model"
                            :label="$t('form.status')"
                            :options="[
                                { label: $t('status.draft'), value: 'draft' },
                                { label: $t('status.paid'), value: 'paid' },
                                { label: $t('status.unpaid'), value: 'unpaid' },
                                { label: $t('status.overdue'), value: 'overdue' },
                                { label: $t('status.cancelled'), value: 'cancelled' },
                            ]"
                            :validate="v$.bill.status"
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <DateInput v-model="v$.bill.date.$model" :label="$t('form.date')" :validate="v$.bill.date" />
                        <DateInput v-model="v$.bill.due_date.$model" :label="$t('form.due_date')" :validate="v$.bill.due_date" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <SelectInput
                            v-model="bill.supplier_id"
                            :label="$t('form.supplier')"
                            :options="suppliers"
                            data-key="id"
                            filter
                            show-clear
                            option-label="name"
                            option-value="id"
                        />

                        <SelectInput
                            v-model="bill.supplier_address_id"
                            :label="$t('form.supplier_address')"
                            :options="supplierAddresses"
                            data-key="id"
                            option-label="addressText"
                            option-value="id"
                        />
                    </div>
                    <div id="items_table" class="grid">
                        <div class="py-2">
                            <Button :label="$t('basic.add_item')" icon="fa fa-plus" @click="addItem" />
                        </div>
                        <DataTable class="overflow-x-auto" :value="bill.items">
                            <template #empty>
                                <div class="p-4 pl-0 text-center">{{ $t('bill.no_items') }}</div>
                            </template>

                            <Column field="name" :header="$t('form.name')">
                                <template #body="slotProps">
                                    <Select
                                        :id="`item_select_${slotProps.index}`"
                                        v-model="slotProps.data.item"
                                        :options="products"
                                        data-key="id"
                                        filter
                                        placeholder="Select item"
                                        v-if="slotProps.data.added"
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
                            <Column field="quantity" :header="$t('form.quantity')">
                                <template #body="slotProps">
                                    <InputNumber
                                        :id="`quantity_input_${slotProps.index}`"
                                        v-model="slotProps.data.quantity"
                                        :show-buttons="true"
                                        :min="1"
                                        mode="decimal"
                                        @input="calculateItemTotal(slotProps.index)"
                                    />
                                </template>
                            </Column>
                            <Column field="price" :header="$t('form.price')">
                                <template #body="slotProps">
                                    <InputNumber
                                        :id="`price_input_${slotProps.index}`"
                                        v-model="slotProps.data.price"
                                        :currency="$settings.default_currency"
                                        mode="currency"
                                        @focus="calculateItemTotal(slotProps.index)"
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
                                    <Button severity="danger" icon="fa fa-trash" @click="removeItem(slotProps.index)" />
                                </template>
                            </Column>
                        </DataTable>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                        <div>
                            <TextAreaInput id="notes_input" v-model="bill.notes" :label="$t('form.notes')" />
                            <TinyMceEditor
                                id="footer_input"
                                v-model="bill.footer"
                                :label="$t('form.footer')"
                                toolbar="bold italic underline | alignleft aligncenter alignright alignjustify | forecolor backcolor | bullist numlist | link"
                                style="height: 250px"
                            />
                        </div>

                        <div>
                            <NumberInput
                                id="discount_input"
                                v-model="bill.discount"
                                :label="$t('form.discount')"
                                suffix="%"
                                @blur="calculateTotal"
                            />
                            <NumberInput
                                id="total_input"
                                v-model="bill.total"
                                :label="$t('form.final_total')"
                                disabled
                                mode="currency"
                                :currency="$settings.default_currency"
                            />
                        </div>
                    </div>
                </form>
            </div>
            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button id="cancel_button" :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="$router.go(-1)" />
                <Button
                    id="save_button"
                    :label="$t('basic.save')"
                    :disabled="loadingData"
                    icon="fa fa-floppy-disk"
                    severity="success"
                    @click="validateForm"
                />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
import BillMixin from '@/mixins/bills'
export default {
    name: 'EditBillPage',
    mixins: [BillMixin],
    setup() {
        return { v$: useVuelidate() }
    },
    created() {
        this.getSuppliers()
        this.getProducts()
        this.getBill(this.$route.params.id)
    },

    validations() {
        return {
            bill: {
                number: { required },
                status: { required },
                date: { required },
                due_date: { required },
            },
        }
    },

    methods: {
        addItem() {
            this.bill.items.push({
                name: '',
                description: '',
                quantity: 1,
                price: 0,
                added: true,
                discount: 0,
                discount_type: 'percent',
                tax: 0,
                total: 0,
            })
        },

        selectItem(index) {
            let item = this.bill.items[index].item
            this.bill.items[index].product_id = item.id
            this.bill.items[index].name = item.name
            this.bill.items[index].unit = item.unit
            this.bill.items[index].price = item.sell_price
            this.bill.items[index].tax = item.tax
            this.bill.items[index].discount = 0
            this.bill.items[index].discount_type = 'percent'
            this.bill.items[index].total = this.bill.items[index].price * this.bill.items[index].quantity
            this.calculateItemTotal(index)
        },

        calculateItemTotal(index) {
            this.bill.items[index].total = this.bill.items[index].price * this.bill.items[index].quantity
            this.calculateTotal()
        },

        calculateTotal() {
            this.bill.total = 0
            this.bill.items.forEach((item) => {
                this.bill.total += item.total
            })
            this.bill.total = this.bill.total - (this.bill.total * this.bill.discount) / 100
        },

        removeItem(index) {
            this.bill.items.splice(index, 1)
        },

        getSupplierAddresses() {
            if (!this.bill.supplier_id) {
                this.supplierAddresses = []
                return
            }
            this.supplierAddresses = this.formatAddresses(this.suppliers, this.bill.supplier_id)
            if (this.supplierAddresses.length === 1) {
                this.bill.supplier_address_id = this.supplierAddresses[0].id
            }
        },

        validateForm() {
            this.v$.bill.$touch()
            if (this.v$.bill.$error) {
                return this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
            }
            return this.updateBill()
        },
    },

    watch: {
        'bill.supplier_id': function () {
            if (!this.bill.supplier_id) {
                this.supplierAddresses = []
                return
            }
            this.getSupplierAddresses()
        },
    },
}
</script>
<style></style>
