<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="product.name">
                <template v-slot:actions>
                    <Button
                        :label="$t('basic.edit')"
                        @click="$router.push(`/products/${product.id}/edit`)"
                        severity="success"
                        id="edit_product_button"
                        icon="fa fa-pencil"
                    />
                    <Button
                        :label="$t('basic.delete')"
                        @click="deleteProductAsk($route.params.id)"
                        severity="danger"
                        id="delete_product_button"
                        icon="fa fa-trash"
                    />
                    <Button
                        :label="$t('audit_log.audit_log')"
                        @click="showAuditLogDialog = true"
                        severity="info"
                        id="audit_log_button"
                        icon="fa fa-history"
                    />
                </template>
            </PageHeader>
            <div class="card">
                <form class="formgrid">
                    <div class="grid md:grid-cols-3 grid-cols-1 gap-2">
                        <DisplayData :input="$t('form.number')" :value="product.number" />
                        <DisplayData :input="$t('form.name')" :value="product.name" />
                        <DisplayData :input="$t('form.type')" customValue>
                            <Tag :value="product.type == 'product' ? $t('product_type.product') : $t('product_type.service')" />
                        </DisplayData>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        <DisplayData :input="$t('form.sell_price')" :value="formatMoney(product.sell_price)" />
                        <DisplayData :input="$t('form.buy_price')" :value="formatMoney(product.buy_price)" />
                        <DisplayData :input="$t('form.unit')" :value="product.unit" />
                    </div>
                    <div v-if="product.type == 'product'" class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        <DisplayData :input="$t('form.stock')" :value="product.stock" />
                        <DisplayData :input="$t('form.min_stock')" :value="product.stock_min" />
                        <DisplayData :input="$t('form.max_stock')" :value="product.stock_max" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        <DisplayData :input="$t('form.tax')" :value="product.tax + '%'" />
                        <DisplayData :input="$t('form.category')" custom-value v-if="product.category">
                            <div class="flex">
                                <i v-if="product.category?.icon" :class="product.category.icon"></i>
                                <span class="ml-2">{{ product.category.name }}</span>
                            </div>
                        </DisplayData>
                        <DisplayData :input="$t('form.barcode')" :value="product.barcode" />
                    </div>

                    <DisplayData :input="$t('form.description')" customValue v-if="product.description">
                        <div v-html="formatHtml(product.description)"></div>
                    </DisplayData>
                </form>
            </div>

            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button :label="$t('basic.cancel')" @click="goTo('/products')" severity="secondary" id="cancel_button" icon="fa fa-times" />
            </div>
        </LoadingScreen>

        <Dialog
            v-model:visible="showAuditLogDialog"
            modal
            maximizable
            class="w-full m-2 lg:w-1/2"
            :header="$t('audit_log.audit_log')"
            :draggable="false"
        >
            <AuditLog :item_id="$route.params.id" item_type="Product" />
        </Dialog>
    </DefaultLayout>
</template>

<script>
import ProductMixin from '@/mixins/products'
export default {
    name: 'ViewProductPage',
    mixins: [ProductMixin],

    created() {
        this.getProduct(this.$route.params.id)
    },

    data() {
        return {
            showAuditLogDialog: false,
        }
    },
}
</script>
