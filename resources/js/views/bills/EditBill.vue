<template>
    <user-layout>
        <div id="edit_bill_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('bill.edit_bill')" />

                <div class="card">
                    <form class="formgrid">
                        <div class="grid">
                            <TextInput
                                v-model="v$.bill.number.$model"
                                disabled
                                :label="$t('form.number')"
                                :validate="v$.bill.number"
                                class="col-12 md:col-6"
                            />
                            <SelectInput
                                v-model="v$.bill.status.$model"
                                :label="$t('form.status')"
                                class="col-12 md:col-6"
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

                        <div class="grid">
                            <DateInput
                                v-model="v$.bill.date.$model"
                                :label="$t('form.date')"
                                :validate="v$.bill.date"
                                class="col-12 md:col-6"
                            />
                            <DateInput
                                v-model="v$.bill.due_date.$model"
                                :label="$t('form.due_date')"
                                :validate="v$.bill.due_date"
                                class="col-12 md:col-6"
                            />
                        </div>
                        <div class="grid">
                            <SelectInput
                                v-model="bill.supplier_id"
                                :label="$t('form.supplier')"
                                class="col-12 md:col-6"
                                :options="suppliers"
                                data-key="id"
                                filter
                                show-clear
                                option-label="name"
                                option-value="id"
                                @change="getSupplierAddresses"
                            />

                            <SelectInput
                                v-model="bill.supplier_address_id"
                                :label="$t('form.supplier_address')"
                                class="col-12 md:col-6"
                                :options="supplierAddresses"
                                data-key="id"
                                option-label="addressText"
                                option-value="id"
                            />
                        </div>

                        <div id="items_table" class="grid">
                            <div class="col-12">
                                <Button :label="$t('basic.add_item')" icon="fa fa-plus" @click="addItem" />
                            </div>
                            <DataTable class="col-12" :value="bill.items">
                                <template #empty>
                                    <div class="p-4 pl-0 text-center text-gray-500">{{ $t('bill.no_items') }}</div>
                                </template>

                                <Column field="name" :header="$t('form.name')">
                                    <template #body="slotProps">
                                        <Dropdown
                                            v-if="slotProps.data.added"
                                            v-model="slotProps.data.item"
                                            :options="products"
                                            data-key="id"
                                            :placeholder="$t('bill.select_item')"
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
                                        <Button class="p-button-danger" icon="fa fa-trash" @click="removeItem(slotProps.index)" />
                                    </template>
                                </Column>
                            </DataTable>
                        </div>

                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <InputNumber
                                    id="discount_input"
                                    v-model="bill.discount"
                                    class="col-12"
                                    :label="$t('form.discount')"
                                    suffix="%"
                                    @blur="calculateTotal"
                                />
                                <InputNumber
                                    id="total_input"
                                    v-model="v$.bill.total.$model"
                                    class="col-12"
                                    :label="$t('bill.total')"
                                    disabled
                                    mode="currency"
                                    :currency="$settings.default_currency"
                                    :validate="v$.bill.total"
                                />
                            </div>
                        </div>
                    </form>

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            class="p-button-danger"
                            @click="goTo('/bills/' + $route.params.id)"
                        />
                        <Button
                            :label="$t('basic.save')"
                            :disabled="loadingData"
                            icon="fa fa-floppy-disk"
                            class="p-button-success"
                            @click="validateForm"
                        />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import { required } from '@vuelidate/validators'
import { useVuelidate } from '@vuelidate/core'
import BillsMixin from '@/mixins/bills'
export default {
    name: 'EditBillPage',
    mixins: [BillsMixin],
    setup: () => ({ v$: useVuelidate() }),
    watch: {
        'bill.supplier_id': function () {
            if (!this.bill.supplier_id) {
                this.supplierAddresses = []
                return
            }
            this.getSupplierAddresses()
        },
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

            return this.updateBill()
        },

        addItem() {
            this.bill.items.push({
                name: '',
                quantity: 1,
                price: 0,
                tax: 0,
                added: true,
                total: 0,
            })
        },

        selectItem(index) {
            this.bill.items[index].product_id = this.bill.items[index].item.id
            this.bill.items[index].name = this.bill.items[index].item.name
            this.bill.items[index].unit = this.bill.items[index].item.unit
            this.bill.items[index].price = this.bill.items[index].item.sell_price
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
                this.bill.supplier_address_id = this.bill.supplier_address_id || this.supplierAddresses[0].id
            }
        },
    },
}
</script>

<style></style>
