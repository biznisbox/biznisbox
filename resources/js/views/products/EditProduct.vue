<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('product.edit_product', { name: product.name })" />
            <div class="card">
                <form>
                    <div class="grid lg:grid-cols-3 grid-cols-1 gap-2">
                        <TextInput
                            id="number_input"
                            v-model="v$.product.number.$model"
                            :label="$t('form.number')"
                            disabled
                            :validate="v$.product.number"
                        />
                        <TextInput id="name_input" v-model="v$.product.name.$model" :label="$t('form.name')" :validate="v$.product.name" />
                        <SelectButtonInput
                            id="select_product_type"
                            v-model="v$.product.type.$model"
                            :label="$t('form.type')"
                            :options="[
                                { label: $t('product_type.product'), value: 'product' },
                                { label: $t('product_type.service'), value: 'service' },
                            ]"
                            :validate="v$.product.type"
                        />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        <NumberInput
                            id="sell_price_input"
                            v-model="v$.product.sell_price.$model"
                            :label="$t('form.sell_price')"
                            type="currency"
                            :validate="v$.product.sell_price"
                        />
                        <NumberInput
                            id="buy_price_input"
                            v-model="v$.product.buy_price.$model"
                            :label="$t('form.buy_price')"
                            type="currency"
                            :validate="v$.product.buy_price"
                        />
                        <SelectInput
                            id="select_unit"
                            v-model="v$.product.unit.$model"
                            :options="units"
                            :label="$t('form.unit')"
                            option-value="name"
                            option-label="name"
                            :validate="v$.product.unit"
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <SelectInput
                            id="select_product_tax"
                            v-model="product.tax"
                            :label="$t('form.tax')"
                            :options="taxes"
                            option-label="name"
                            option-value="value"
                        />

                        <SelectInput
                            id="select_product_category_id"
                            v-model="product.category_id"
                            :label="$t('form.category')"
                            :options="product_categories"
                            option-label="name"
                            filter
                            option-value="id"
                        />
                    </div>

                    <div v-if="product.type == 'product'" class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        <NumberInput id="stock_input" v-model="product.stock" :label="$t('form.stock')" type="items" />
                        <NumberInput id="min_stock_input" v-model="product.stock_min" :label="$t('form.min_stock')" type="items" />
                        <NumberInput id="max_stock_input" v-model="product.stock_max" :label="$t('form.max_stock')" type="items" />
                    </div>
                    <TextInput id="barcode_input" v-model="product.barcode" :label="$t('form.barcode')" />
                    <TinyMceEditor
                        id="description_editor"
                        v-model="product.description"
                        :label="$t('form.description')"
                        toolbar="bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link"
                        style="height: 200px"
                    />
                </form>
            </div>

            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button :label="$t('basic.cancel')" @click="goTo('/products')" severity="secondary" id="cancel_button" icon="fa fa-times" />
                <Button :label="$t('basic.update')" @click="validateForm" severity="success" id="update_button" icon="fa fa-save" />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
import ProductMixin from '@/mixins/products'
export default {
    name: 'ProductEditPage',
    mixins: [ProductMixin],
    setup() {
        return { v$: useVuelidate() }
    },
    created() {
        this.getUnits()
        this.getTaxes()
        this.getProductCategories()
        this.getProduct(this.$route.params.id)
    },

    validations() {
        return {
            product: {
                number: { required },
                name: { required },
                type: { required },
                sell_price: { required },
                buy_price: { required },
                unit: { required },
            },
        }
    },

    methods: {
        validateForm() {
            this.v$.product.$touch()
            if (this.v$.product.$invalid) {
                return this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
            }

            this.updateProduct(this.$route.params.id)
        },
    },
}
</script>
