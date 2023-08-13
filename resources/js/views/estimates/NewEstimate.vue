<template>
    <user-layout>
        <div id="new_estimate_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('estimate.new_estimate')"></user-header>

                <div class="card">
                    <form class="formgrid">
                        <div class="grid">
                            <TextInput
                                id="number_input"
                                v-model="v$.estimate.number.$model"
                                class="field col-12 md:col-6"
                                :validate="v$.estimate.number"
                                :label="$t('estimate.number')"
                            />
                            <SelectInput
                                id="status_input"
                                v-model="v$.estimate.status.$model"
                                class="field col-12 md:col-6"
                                :label="$t('estimate.status')"
                                :options="[
                                    { label: $t('status.draft'), value: 'draft' },
                                    { label: $t('status.sent'), value: 'sent' },
                                    { label: $t('status.viewed'), value: 'viewed' },
                                    { label: $t('status.accepted'), value: 'accepted' },
                                    { label: $t('status.rejected'), value: 'rejected' },
                                    { label: $t('status.expired'), value: 'expired' },
                                    { label: $t('status.cancelled'), value: 'cancelled' },
                                ]"
                                :validate="v$.estimate.status"
                            />
                        </div>

                        <div class="grid">
                            <SelectInput
                                id="customer_input"
                                v-model="estimate.customer_id"
                                class="field col-12 md:col-6"
                                :label="$t('estimate.customer')"
                                :options="customers"
                                option-value="id"
                                filter
                                show-clear
                                option-label="name"
                            />
                            <SelectInput
                                id="payer_input"
                                v-model="estimate.payer_id"
                                class="field col-12 md:col-6"
                                :label="$t('estimate.payer')"
                                :options="customers"
                                filter
                                show-clear
                                option-value="id"
                                option-label="name"
                            />
                        </div>

                        <div class="grid">
                            <DateInput
                                id="date_input"
                                v-model="v$.estimate.date.$model"
                                class="field col-12 md:col-4"
                                :validate="v$.estimate.date"
                                :label="$t('estimate.date')"
                            />
                            <DateInput
                                id="valid_until_input"
                                v-model="v$.estimate.valid_until.$model"
                                class="field col-12 md:col-4"
                                :label="$t('estimate.valid_until')"
                                :validate="v$.estimate.valid_until"
                            />
                            <SelectInput
                                id="currency_input"
                                v-model="estimate.currency"
                                class="field col-12 md:col-4"
                                :label="$t('estimate.currency')"
                                :options="currencies"
                                option-value="code"
                                option-label="name"
                            />
                        </div>

                        <div class="grid">
                            <div class="col-12">
                                <Button :label="$t('estimate.add_item')" icon="fa fa-plus" @click="addItem" />
                            </div>
                            <DataTable class="col-12" :value="estimate.items">
                                <template #empty>
                                    <div class="p-4 pl-0 text-center text-gray-500">{{ $t('estimate.no_items') }}</div>
                                </template>

                                <Column field="name" header="Name">
                                    <template #body="slotProps">
                                        <Dropdown
                                            v-model="slotProps.data.item"
                                            :options="products"
                                            data-key="id"
                                            :placeholder="$t('estimate.select_item')"
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
                                <Column field="description" :header="$t('estimate.description')">
                                    <template #body="slotProps">
                                        <TextAreaInput :id="`description_input_${slotProps.index}`" v-model="slotProps.data.description" />
                                    </template>
                                </Column>
                                <Column :header="$t('estimate.quantity_and_discount')">
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
                                <Column :header="$t('estimate.price_and_tax')">
                                    <template #body="slotProps">
                                        <InputNumber
                                            :id="`price_input_${slotProps.index}`"
                                            v-model="slotProps.data.price"
                                            :currency="estimate.currency"
                                            mode="currency"
                                            @focus="calculateItemTotal(slotProps.index)"
                                        />
                                        <Dropdown
                                            v-model="slotProps.data.tax"
                                            :options="taxes"
                                            class="mt-0 md:mt-2"
                                            option-value="value"
                                            option-label="name"
                                            :placeholder="$t('estimate.select_tax')"
                                            :show-clear="true"
                                            @change="calculateItemTotal(slotProps.index)"
                                        />
                                    </template>
                                </Column>
                                <Column :header="$t('estimate.total')">
                                    <template #body="slotProps">
                                        <InputNumber
                                            :id="`total_input_${slotProps.index}`"
                                            v-model="slotProps.data.total"
                                            :currency="estimate.currency"
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
                            <div class="field col-12 md:col-6">
                                <TinyMceEditor
                                    id="notes_input"
                                    v-model="estimate.notes"
                                    :label="$t('estimate.notes')"
                                    toolbar=" bold italic underline"
                                    style="height: 200px"
                                />
                            </div>
                            <div class="field col-12 md:col-6">
                                <InputNumber
                                    id="discount_input"
                                    v-model="estimate.discount"
                                    class="field col-12"
                                    :label="$t('estimate.discount')"
                                    suffix="%"
                                    @blur="calculateTotal"
                                />
                                <InputNumber
                                    id="total_input"
                                    v-model="v$.estimate.total.$model"
                                    class="field col-12"
                                    :label="$t('estimate.total')"
                                    :disabled="true"
                                    mode="currency"
                                    :currency="estimate.currency"
                                    :validate="v$.estimate.total"
                                />
                            </div>
                        </div>
                    </form>

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="goTo('/estimates')" />
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
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import EstimateMixin from '@/mixins/estimates'
export default {
    name: 'NewEstimatePage',
    mixins: [EstimateMixin],
    setup: () => ({ v$: useVuelidate() }),
    created() {
        this.getCustomers()
        this.getProducts()
        this.getEstimateNumber()
    },

    validations() {
        return {
            estimate: {
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
            this.v$.$validate()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }
            return this.createEstimate()
        },

        selectItem(index) {
            this.estimate.items[index].product_id = this.estimate.items[index].item.id
            this.estimate.items[index].type = this.estimate.items[index].item.type
            this.estimate.items[index].name = this.estimate.items[index].item.name
            this.estimate.items[index].unit = this.estimate.items[index].item.unit
            this.estimate.items[index].price = this.estimate.items[index].item.sell_price
            this.estimate.items[index].tax = this.estimate.items[index].item.tax
            this.estimate.items[index].total = this.estimate.items[index].price * this.estimate.items[index].quantity
            this.calculateItemTotal(index)
        },

        addItem() {
            this.estimate.items.push({
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
            this.estimate.items.splice(index, 1)
        },

        calculateItemTotal(index) {
            let item = this.estimate.items[index]
            item.total = item.price * item.quantity
            item.total = item.total - (item.total * item.discount) / 100
            item.total = item.total + (item.total * item.tax) / 100
            this.estimate.items[index].total = item.total
            this.calculateTotal()
        },

        calculateTotal() {
            this.estimate.total = 0
            this.estimate.items.forEach((item) => {
                this.estimate.total += item.total
            })
            this.estimate.total = this.estimate.total - (this.estimate.total * this.estimate.discount) / 100
        },
    },
}
</script>

<style></style>
