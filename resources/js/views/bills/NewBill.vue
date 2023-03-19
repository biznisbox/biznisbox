<template>
    <user-layout>
        <div id="new_bill_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('bill.new_bill')" />

                <div class="card">
                    <form class="formgrid">
                        <div class="grid">
                            <TextInput v-model="bill.number" :label="$t('bill.bill_number')" class="col-12 md:col-6" />
                            <SelectInput
                                v-model="bill.status"
                                label="Status"
                                class="col-12 md:col-6"
                                :options="[
                                    { label: $t('status.draft'), value: 'draft' },
                                    { label: $t('status.paid'), value: 'paid' },
                                    { label: $t('status.unpaid'), value: 'unpaid' },
                                    { label: $t('status.overdue'), value: 'overdue' },
                                    { label: $t('status.cancelled'), value: 'cancelled' },
                                ]"
                            />
                        </div>

                        <div class="grid">
                            <DateInput v-model="bill.date" :label="$t('bill.date')" class="col-12 md:col-6" />
                            <DateInput v-model="bill.due_date" :label="$t('bill.due_date')" class="col-12 md:col-6" />
                        </div>

                        <div class="grid">
                            <SelectInput
                                v-model="bill.vendor_id"
                                :label="$t('bill.vendor')"
                                class="col-12"
                                :options="vendors"
                                data-key="id"
                                option-label="name"
                                option-value="id"
                                placeholder="Select vendor"
                            />
                        </div>

                        <div id="items_table">
                            <Button :label="$t('bill.add_item')" icon="fa fa-plus" class="mb-4" @click="addItem" />
                            <DataTable class="col-12" :value="bill.items">
                                <template #empty>
                                    <div class="p-4 pl-0 text-center text-gray-500">{{ $t('bill.no_items') }}</div>
                                </template>

                                <Column field="name" :header="$t('bill.name')">
                                    <template #body="slotProps">
                                        <Dropdown
                                            :id="`item_dropdown_${slotProps.index}`"
                                            v-model="slotProps.data.item"
                                            :options="products"
                                            data-key="id"
                                            placeholder="Select item"
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
                                    </template>
                                </Column>
                                <Column field="description" :header="$t('bill.description')">
                                    <template #body="slotProps">
                                        <TextAreaInput :id="`description_input_${slotProps.index}`" v-model="slotProps.data.description" />
                                    </template>
                                </Column>
                                <Column field="quantity" :header="$t('bill.quantity')">
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
                                <Column field="price" :header="$t('bill.price')">
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
                                <Column field="total" :header="$t('bill.total')">
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
                                        <Button class="field p-button-danger" icon="fa fa-trash" @click="removeItem(slotProps.index)" />
                                    </template>
                                </Column>
                            </DataTable>
                        </div>

                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <InputNumber
                                    id="discount_input"
                                    v-model="bill.discount"
                                    class="field col-12"
                                    :label="$t('bill.discount')"
                                    suffix="%"
                                    @blur="calculateTotal"
                                />
                                <InputNumber
                                    id="total_input"
                                    v-model="bill.total"
                                    class="field col-12"
                                    :label="$t('bill.total')"
                                    :disabled="true"
                                    mode="currency"
                                    :currency="$settings.default_currency"
                                />
                            </div>
                        </div>
                    </form>

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="goTo('/bills')" />
                        <Button
                            :label="$t('basic.save')"
                            :disabled="loadingData"
                            icon="fa fa-floppy-disk"
                            class="p-button-success"
                            @click="createBill"
                        />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import BillsMixin from '@/mixins/bills'
export default {
    name: 'NewBillPage',
    mixins: [BillsMixin],

    created() {
        this.getVendors()
        this.getProducts()
        this.getBillNumber()
    },

    methods: {
        addItem() {
            this.bill.items.push({
                name: '',
                quantity: 1,
                price: 0,
                tax: 0,
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
    },
}
</script>

<style></style>
