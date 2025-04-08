<template>
    <DefaultLayout menu_type="admin">
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('admin.data_collection.title')">
                <template #actions>
                    <Button
                        id="add_category_button"
                        icon="fa fa-plus"
                        :label="$t('basic.add')"
                        @click="openNewEditCategoryDialog('create')"
                    />
                </template>
            </PageHeader>

            <Tabs v-model:value="activeTab" class="mb-4">
                <TabList>
                    <Tab value="transaction">{{ $t('admin.data_collection.transaction_categories') }}</Tab>
                    <Tab value="document_type">{{ $t('admin.data_collection.document_types') }}</Tab>
                    <Tab value="payment_method">{{ $t('admin.data_collection.payment_methods') }}</Tab>
                    <Tab value="contract_type">{{ $t('admin.data_collection.contract_types') }}</Tab>
                </TabList>

                <TabPanels>
                    <TabPanel value="transaction">
                        <DataTable :value="transaction" data-key="id">
                            <template #empty>
                                <div class="p-4 pl-0 text-center w-full">
                                    <i class="fa fa-info-circle empty-icon"></i>
                                    <p>{{ $t('transaction.no_categories') }}</p>
                                </div>
                            </template>

                            <Column field="name" :header="$t('form.name')">
                                <template #body="{ data }">
                                    <span>{{ data.name ? data.name : '-' }}</span>
                                </template>
                            </Column>

                            <Column field="description" :header="$t('form.type')">
                                <template #body="{ data }">
                                    <span v-if="data.description === 'income'">
                                        <i class="fa fa-arrow-up text-green-500 mr-2"></i>
                                        <span>{{ $t('transaction_type.income') }}</span>
                                    </span>
                                    <span v-if="data.description === 'expense'">
                                        <i class="fa fa-arrow-down text-red-500 mr-2"></i>
                                        <span>{{ $t('transaction_type.expense') }}</span>
                                    </span>
                                    <span v-if="data.description === 'transfer'">
                                        <i class="fa fa-exchange-alt text-blue-500 mr-2"></i>
                                        <span>{{ $t('transaction_type.transfer') }}</span>
                                    </span>
                                </template>
                            </Column>

                            <Column :header="$t('basic.actions')">
                                <template #body="{ data }">
                                    <Button
                                        id="category_edit_button"
                                        icon="fa fa-edit"
                                        severity="success"
                                        @click="openNewEditCategoryDialog('edit', data.id)"
                                    />
                                    <Button
                                        id="category_delete_button"
                                        icon="fa fa-trash"
                                        class="ml-2"
                                        severity="danger"
                                        @click="deleteCategoryAsk(data.id)"
                                    />
                                </template>
                            </Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel value="document_type">
                        <DataTable :value="document_types" data-key="id">
                            <template #empty>
                                <div class="p-4 pl-0 text-center w-full">
                                    <i class="fa fa-info-circle empty-icon"></i>
                                    <p>{{ $t('admin.data_collection.no_document_types') }}</p>
                                </div>
                            </template>

                            <Column field="name" :header="$t('form.name')">
                                <template #body="{ data }">
                                    <span>{{ data.name ? data.name : '-' }}</span>
                                </template>
                            </Column>

                            <Column field="description" :header="$t('form.description')" />

                            <Column :header="$t('form.icon')">
                                <template #body="{ data }">
                                    <i :class="data.icon"></i>
                                </template>
                            </Column>

                            <Column :header="$t('form.color')">
                                <template #body="{ data }">
                                    <div class="w-4 h-4 rounded-full" :style="{ backgroundColor: '#' + data.color }"></div>
                                </template>
                            </Column>
                            <Column field="additional_info" :header="$t('form.additional_info')">
                                <template #body="{ data }">
                                    <span>{{ data.additional_info ? data.additional_info : '-' }}</span>
                                </template>
                            </Column>

                            <Column :header="$t('basic.actions')">
                                <template #body="{ data }">
                                    <Button
                                        id="category_edit_button"
                                        icon="fa fa-edit"
                                        severity="success"
                                        @click="openNewEditCategoryDialog('edit', data.id)"
                                    />
                                    <Button
                                        id="category_delete_button"
                                        icon="fa fa-trash"
                                        class="ml-2"
                                        severity="danger"
                                        @click="deleteCategoryAsk(data.id)"
                                    />
                                </template>
                            </Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel value="payment_method">
                        <DataTable :value="payment_methods" data-key="id">
                            <template #empty>
                                <div class="p-4 pl-0 text-center w-full">
                                    <i class="fa fa-info-circle empty-icon"></i>
                                    <p>{{ $t('admin.data_collection.no_payment_methods') }}</p>
                                </div>
                            </template>

                            <Column field="name" :header="$t('form.name')">
                                <template #body="{ data }">
                                    <i :class="data.icon"></i>
                                    <span class="ml-2">{{ data.name ? data.name : '-' }}</span>
                                </template>
                            </Column>

                            <Column field="description" :header="$t('form.description')" />

                            <Column field="additional_info" :header="$t('form.additional_info')">
                                <template #body="{ data }">
                                    <span>{{ data.additional_info ? $t(`payment_methods.${data.additional_info}`) : '-' }}</span>
                                </template>
                            </Column>

                            <Column :header="$t('basic.actions')">
                                <template #body="{ data }">
                                    <Button
                                        id="category_edit_button"
                                        icon="fa fa-edit"
                                        severity="success"
                                        @click="openNewEditCategoryDialog('edit', data.id)"
                                    />
                                    <Button
                                        id="category_delete_button"
                                        icon="fa fa-trash"
                                        class="ml-2"
                                        severity="danger"
                                        @click="deleteCategoryAsk(data.id)"
                                    />
                                </template>
                            </Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel value="contract_type">
                        <DataTable :value="contract_types" data-key="id">
                            <template #empty>
                                <div class="p-4 pl-0 text-center w-full">
                                    <i class="fa fa-info-circle empty-icon"></i>
                                    <p>{{ $t('admin.data_collection.no_contract_types') }}</p>
                                </div>
                            </template>

                            <Column field="name" :header="$t('form.name')">
                                <template #body="{ data }">
                                    <span>{{ data.name ? data.name : '-' }}</span>
                                </template>
                            </Column>

                            <Column field="description" :header="$t('form.description')" />

                            <Column :header="$t('form.icon')">
                                <template #body="{ data }">
                                    <i :class="data.icon"></i>
                                </template>
                            </Column>

                            <Column :header="$t('form.color')">
                                <template #body="{ data }">
                                    <div class="w-4 h-4 rounded-full" :style="{ backgroundColor: '#' + data.color }"></div>
                                </template>
                            </Column>
                            <Column field="additional_info" :header="$t('form.additional_info')">
                                <template #body="{ data }">
                                    <span>{{ data.additional_info ? data.additional_info : '-' }}</span>
                                </template>
                            </Column>

                            <Column :header="$t('basic.actions')">
                                <template #body="{ data }">
                                    <Button
                                        id="category_edit_button"
                                        icon="fa fa-edit"
                                        severity="success"
                                        @click="openNewEditCategoryDialog('edit', data.id)"
                                    />
                                    <Button
                                        id="category_delete_button"
                                        icon="fa fa-trash"
                                        class="ml-2"
                                        severity="danger"
                                        @click="deleteCategoryAsk(data.id)"
                                    />
                                </template>
                            </Column>
                        </DataTable>
                    </TabPanel>
                </TabPanels>
            </Tabs>

            <!-- Create and Edit Category Dialog -->
            <Dialog
                v-model:visible="showNewEditCategoryDialog"
                :header="
                    categoryFormMethod === 'create'
                        ? $t('admin.data_collection.new_data_collection_item')
                        : $t('admin.data_collection.edit_data_collection_item')
                "
                modal
            >
                <LoadingScreen :blocked="loadingData">
                    <form id="category_form">
                        <TextInput id="name_input" v-model="category.name" :label="$t('form.name')"></TextInput>
                        <SelectInput
                            id="category_module_input"
                            v-model="category.module"
                            :options="[
                                { label: $t('admin.data_collection.transaction_categories'), value: 'transaction' },
                                { label: $t('admin.data_collection.document_types'), value: 'document_type' },
                                { label: $t('admin.data_collection.payment_methods'), value: 'payment_method' },
                                { label: $t('admin.data_collection.contract_types'), value: 'contract_type' },
                            ]"
                            option-label="label"
                            option-value="value"
                            placeholder="Select module"
                            :label="$t('form.module')"
                            :disabled="categoryFormMethod === 'edit'"
                        />
                        <SelectInput
                            v-if="category.module === 'transaction'"
                            id="category_type_input"
                            v-model="category.description"
                            :options="[
                                { label: $t('transaction_type.income'), value: 'income' },
                                { label: $t('transaction_type.expense'), value: 'expense' },
                                { label: $t('transaction_type.transfer'), value: 'transfer' },
                            ]"
                            option-label="label"
                            option-value="value"
                            placeholder="Select type"
                            :label="$t('form.type')"
                        />

                        <div v-if="category.module !== 'transaction'" class="flex flex-col gap-2 mb-2">
                            <label for="category_color_input" class="dark:text-surface-200">Color</label>
                            <ColorPicker id="category_color_input" v-model="category.color" />
                        </div>

                        <TextInput
                            v-if="category.module !== 'transaction'"
                            id="category_icon_input"
                            v-model="category.icon"
                            :label="$t('form.icon')"
                            placeholder="Icon class"
                            :v-tooltip="$t('admin.data_collection.icon_tooltip')"
                        />

                        <TextInput
                            v-if="category.module !== 'transaction' && category.module !== 'payment_method'"
                            id="category_additional_info_input"
                            v-model="category.additional_info"
                            :label="$t('form.additional_info')"
                            placeholder="Additional info"
                        />

                        <SelectInput
                            v-if="category.module == 'payment_method'"
                            id="category_additional_info_input"
                            v-model="category.additional_info"
                            :options="[
                                { label: $t('payment_methods.stripe'), value: 'stripe' },
                                { label: $t('payment_methods.paypal'), value: 'paypal' },
                                { label: $t('payment_methods.bank_transfer'), value: 'bank_transfer' },
                                { label: $t('payment_methods.cash'), value: 'cash' },
                                { label: $t('payment_methods.other'), value: 'other' },
                            ]"
                            option-label="label"
                            option-value="value"
                            :label="$t('form.type')"
                        />

                        <TextInput
                            v-if="category.module !== 'transaction'"
                            id="category_description_input"
                            v-model="category.description"
                            :label="$t('form.description')"
                            placeholder="Description"
                        />
                        <SelectInput
                            v-if="category.module !== 'transaction' && category.module !== 'payment_method'"
                            id="category_parent_id_input"
                            v-model="category.parent_id"
                            :options="availableParentCategories"
                            option-label="name"
                            option-value="id"
                            :filter="true"
                            placeholder="Select parent category"
                            :label="$t('form.parent_category')"
                        />
                    </form>
                </LoadingScreen>

                <template #footer>
                    <div id="function_buttons" class="flex justify-end gap-2">
                        <Button
                            id="category_cancel_button"
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            severity="secondary"
                            @click="showNewEditCategoryDialog = false"
                        />
                        <Button
                            id="category_save_button"
                            :label="categoryFormMethod === 'create' ? $t('basic.save') : $t('basic.update')"
                            icon="fa fa-floppy-disk"
                            :disabled="loadingData || !category.name || !category.module"
                            severity="success"
                            @click="saveEditCategory"
                        />
                    </div>
                </template>
            </Dialog>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
import TextInput from '@/components/form/TextInput.vue'
import CategoryMixin from '@/mixins/categories'
export default {
    name: 'AdminDataCollectionPage',
    mixins: [CategoryMixin],

    data() {
        return {
            showNewEditCategoryDialog: false,
            categoryFormMethod: 'create',
            activeTab: 'transaction_categories',
            availableParentCategories: [],
            transaction: [],
            document_types: [],
            payment_methods: [],
            contract_types: [],
            category: {
                id: null,
                parent_id: null,
                name: '',
                description: '',
                module: '',
                color: '346bb4',
                icon: 'fa fa-tag',
                additional_info: '',
            },
        }
    },
    created() {
        this.getCategoryItems('transaction')
        this.getCategoryItems('document_type')
        this.getCategoryItems('payment_method')
        this.getCategoryItems('contract_type')
    },

    methods: {
        getCategoryItems(category) {
            this.getCategories(category).then((response) => {
                if (category === 'transaction') {
                    this.transaction = response
                } else if (category === 'document_type') {
                    this.document_types = response
                } else if (category === 'payment_method') {
                    this.payment_methods = response
                } else if (category === 'contract_type') {
                    this.contract_types = response
                }
            })
        },

        resetCategory() {
            this.category = {
                id: null,
                parent_id: null,
                name: '',
                description: '',
                module: '',
                color: '346bb4',
                icon: 'fa fa-tag',
                additional_info: '',
            }
        },

        openNewEditCategoryDialog(method, id = null) {
            this.categoryFormMethod = method
            this.resetCategory()
            if (method === 'edit') {
                this.getCategory(id).then((response) => {
                    this.category = response
                    this.setAvailableParentCategories(this.category.module)
                    this.showNewEditCategoryDialog = true
                })
            } else {
                this.category.module = this.activeTab
                this.setAvailableParentCategories(this.activeTab)
                this.parent
                this.showNewEditCategoryDialog = true
            }
        },

        setAvailableParentCategories(currentCategory) {
            this.getCategories(currentCategory).then((response) => {
                this.availableParentCategories = response
            })
        },

        saveEditCategory() {
            this.loadingData = true
            if (this.category.module === 'transaction') {
                this.setDataForTransaction()
            }
            if (this.categoryFormMethod === 'create') {
                this.createCategory(this.category).then((response) => {
                    this.showNewEditCategoryDialog = false
                    this.getCategoryItems(this.category.module)
                    this.loadingData = false
                })
            } else {
                this.updateCategory(this.category.id, this.category).then((response) => {
                    this.showNewEditCategoryDialog = false
                    this.getCategoryItems(this.category.module)
                    this.loadingData = false
                })
            }
        },
        deleteCategoryAsk(id) {
            this.confirmDeleteDialog(this.$t('admin.data_collection.delete_category_ask'), this.$t('basic.confirmation'), () => {
                this.deleteCategory(id).then((response) => {
                    this.getCategoryItems(this.category.module)
                })
            })
        },

        setDataForTransaction() {
            switch (this.category.description) {
                case 'income':
                    this.category.icon = 'fa fa-arrow-up'
                    this.category.color = '#4caf50'
                    break
                case 'expense':
                    this.category.icon = 'fa fa-arrow-down'
                    this.category.color = '#f44336'
                    break
                case 'transfer':
                    this.category.icon = 'fa fa-exchange-alt'
                    this.category.color = '#2196f3'
                    break
            }
        },
    },
}
</script>

<style></style>
