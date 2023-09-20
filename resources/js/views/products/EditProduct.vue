<template>
    <user-layout>
        <div id="edit_product_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('product.edit_product')" />
                <div class="card">
                    <form class="formgrid">
                        <!-- Product basic -->
                        <div class="grid">
                            <TextInput
                                id="number_input"
                                v-model="v$.product.number.$model"
                                :validate="v$.product.number"
                                class="col-12 md:col-3"
                                :label="$t('form.number')"
                                disabled
                            />
                            <TextInput
                                id="name_input"
                                v-model="v$.product.name.$model"
                                :validate="v$.product.name"
                                class="field col-12 md:col-6"
                                :label="$t('form.name')"
                            ></TextInput>
                            <SelectButtonInput
                                id="select_product_type"
                                v-model="v$.product.type.$model"
                                class="col-12 md:col-3"
                                :label="$t('form.type')"
                                :options="[
                                    { label: $t('product_type.product'), value: 'product' },
                                    { label: $t('product_type.service'), value: 'service' },
                                ]"
                                :validate="v$.product.type"
                            />
                        </div>

                        <!-- Product price -->
                        <div class="grid">
                            <NumberInput
                                id="sell_price_input"
                                v-model="v$.product.sell_price.$model"
                                class="col-12 md:col-4"
                                :label="$t('form.sell_price')"
                                type="currency"
                                :validate="v$.product.sell_price"
                            ></NumberInput>

                            <NumberInput
                                id="buy_price_input"
                                v-model="v$.product.buy_price.$model"
                                class="col-12 md:col-4"
                                :label="$t('form.buy_price')"
                                type="currency"
                                :validate="v$.product.buy_price"
                            ></NumberInput>

                            <SelectInput
                                id="select_unit"
                                v-model="product.unit"
                                class="field col-12 md:col-4"
                                :options="units"
                                :label="$t('form.unit')"
                                option-value="name"
                                option-label="name"
                            />
                        </div>

                        <!-- Product taxes -->
                        <SelectInput
                            id="select_product_tax"
                            v-model="product.tax"
                            :label="$t('form.tax')"
                            :options="taxes"
                            option-label="name"
                            option-value="value"
                        />

                        <!-- Stock -->
                        <div v-if="product.type == 'product'" class="grid">
                            <NumberInput
                                id="stock_input"
                                v-model="product.stock"
                                class="col-12 md:col-4"
                                :label="$t('form.stock')"
                                type="items"
                            ></NumberInput>

                            <NumberInput
                                id="min_stock_input"
                                v-model="product.stock_min"
                                class="col-12 md:col-4"
                                :label="$t('form.min_stock')"
                                type="items"
                            ></NumberInput>

                            <NumberInput
                                id="max_stock_input"
                                v-model="product.stock_max"
                                class="col-12 md:col-4"
                                :label="$t('form.max_stock')"
                                type="items"
                            ></NumberInput>
                        </div>

                        <!-- Barcode input -->
                        <TextInput id="barcode_input" v-model="product.barcode" :label="$t('form.barcode')"></TextInput>

                        <!-- Product description -->
                        <TinyMceEditor
                            id="description_editor"
                            v-model="product.description"
                            :label="$t('form.description')"
                            toolbar="bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link"
                            style="height: 200px"
                        />
                    </form>

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button
                            id="cancel_button"
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            class="p-button-danger"
                            @click="goTo('/products/' + $route.params.id)"
                        />
                        <Button
                            id="save_button"
                            :label="$t('basic.update')"
                            icon="fa fa-floppy-disk"
                            :disabled="loadingData"
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
import { required, decimal } from '@vuelidate/validators'
import ProductMixin from '@/mixins/products'
export default {
    name: 'EditProductPage',
    mixins: [ProductMixin],

    setup: () => ({ v$: useVuelidate() }),

    created() {
        this.getProduct(this.$route.params.id)
    },
    validations: {
        product: {
            number: { required },
            name: { required },
            type: { required },
            sell_price: { decimal },
            buy_price: { decimal },
        },
    },

    methods: {
        validateForm() {
            this.v$.product.$touch()
            if (this.v$.product.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }
            return this.updateProduct(this.$route.params.id)
        },
    },
}
</script>

<style></style>
