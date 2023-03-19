<template>
    <user-layout>
        <div id="new_product_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('product.new_product')" />
                <div class="card">
                    <form class="formgrid">
                        <!-- Product basic -->
                        <div class="grid">
                            <TextInput id="name_input" v-model="product.name" class="field col-12 md:col-8" label="Name"></TextInput>
                            <SelectButtonInput
                                id="select_product_type"
                                v-model="product.type"
                                class="field col-12 md:col-4"
                                :label="$t('product.product_type')"
                                :options="[
                                    { label: $t('product.product'), value: 'product' },
                                    { label: $t('product.service'), value: 'service' },
                                ]"
                            />
                        </div>

                        <!-- Product price -->
                        <div class="grid">
                            <NumberInput
                                id="sell_price_input"
                                v-model="product.sell_price"
                                class="field col-12 md:col-4"
                                :label="$t('product.sell_price')"
                                type="currency"
                            ></NumberInput>

                            <NumberInput
                                id="buy_price_input"
                                v-model="product.buy_price"
                                class="field col-12 md:col-4"
                                :label="$t('product.buy_price')"
                                type="currency"
                            ></NumberInput>

                            <SelectInput
                                id="select_unit"
                                v-model="product.unit"
                                class="field col-12 md:col-4"
                                :options="units"
                                :label="$t('product.unit')"
                                option-value="name"
                                option-label="name"
                            />
                        </div>

                        <!-- Product taxes -->

                        <SelectInput
                            id="select_product_tax"
                            v-model="product.tax"
                            class="field"
                            :label="$t('product.tax')"
                            :options="taxes"
                            option-label="name"
                            option-value="value"
                        />

                        <!-- Stock -->
                        <div v-if="product.type == 'product'" class="grid">
                            <NumberInput
                                id="stock_input"
                                v-model="product.stock"
                                class="field col-12 md:col-4"
                                :label="$t('product.stock')"
                                type="items"
                            ></NumberInput>

                            <NumberInput
                                id="min_stock_input"
                                v-model="product.stock_min"
                                class="field col-12 md:col-4"
                                :label="$t('product.min_stock')"
                                type="items"
                            ></NumberInput>

                            <NumberInput
                                id="max_stock_input"
                                v-model="product.stock_max"
                                class="field col-12 md:col-4"
                                :label="$t('product.max_stock')"
                                type="items"
                            ></NumberInput>
                        </div>

                        <!-- Barcode input -->
                        <TextInput id="barcode_input" v-model="product.barcode" :label="$t('product.barcode')"></TextInput>

                        <!-- Product description -->
                        <EditorInput
                            id="description_editor"
                            v-model="product.description"
                            :label="$t('product.description')"
                            class="product-text-editor"
                        />
                    </form>

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="goTo('/products')" />
                        <Button
                            :label="$t('basic.save')"
                            :disabled="loadingData"
                            icon="fa fa-floppy-disk"
                            class="p-button-success"
                            @click="saveProduct"
                        />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import ProductMixin from '@/mixins/products'
export default {
    name: 'NewProductPage',
    mixins: [ProductMixin],
}
</script>

<style></style>
