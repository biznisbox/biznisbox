<template>
    <user-layout>
        <div id="transactions_page">
            <user-header :title="$t('transaction.transaction', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('transaction.new_transaction')" icon="fa fa-plus" to="/transactions/new" />
                    <Button
                        id="categories_button"
                        icon="fa fa-folder-tree"
                        :label="$t('transaction.categories')"
                        @click="showCategoriesDialog = true"
                    />
                </template>
            </user-header>

            <div id="transactions_table" class="card">
                <DataTable
                    v-model:filters="filters"
                    :value="transactions"
                    :loading="loadingData"
                    paginator
                    data-key="id"
                    filter-display="menu"
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    @row-dblclick="viewTransactionNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('transaction.no_transactions') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('transaction.create_first_transaction')"
                                icon="fa fa-plus"
                                @click="$router.push('/transactions/new')"
                            />
                        </div>
                    </template>

                    <Column field="name" :header="$t('transaction.name')">
                        <template #body="{ data }">
                            <span>{{ data.name ? data.name : '-' }}</span>
                        </template>

                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by name" />
                        </template>
                    </Column>

                    <Column field="date" :header="$t('transaction.date_and_number')">
                        <template #body="{ data }">
                            <span>{{ data.date ? formatDate(data.date) : '-' }}</span
                            ><br />
                            <span>{{ data.number }}</span>
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by date" />
                            </div>
                        </template>
                    </Column>

                    <Column field="amount" :header="$t('form.amount')">
                        <template #body="{ data }">
                            <span>{{ formatMoney(data.amount, data.currency) }}</span> <br />
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by amount" />
                            </div>
                        </template>
                    </Column>

                    <Column field="type" :header="$t('form.type')">
                        <template #body="{ data }">
                            <span v-if="data.type === 'income'">
                                <i class="fa fa-arrow-up text-green-500 mr-2"></i>
                                <span>{{ $t('transaction_type.income') }}</span>
                            </span>
                            <span v-if="data.type === 'expense'">
                                <i class="fa fa-arrow-down text-red-500 mr-2"></i>
                                <span>{{ $t('transaction_type.expense') }}</span>
                            </span>
                            <span v-if="data.type === 'transfer'">
                                <i class="fa fa-exchange-alt text-blue-500 mr-2"></i>
                                <span>{{ $t('transaction_type.transfer') }}</span>
                            </span>
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <Dropdown
                                    v-model="filterModel.value"
                                    :options="[
                                        { label: $t('transaction_type.income'), value: 'income' },
                                        { label: $t('transaction_type.expense'), value: 'expense' },
                                        { label: $t('transaction_type.transfer'), value: 'transfer' },
                                    ]"
                                    option-label="label"
                                    option-value="value"
                                    class="p-column-filter"
                                    placeholder="Search by type"
                                />
                            </div>
                        </template>
                    </Column>

                    <Column field="account" :header="$t('form.account')">
                        <template #body="{ data }">
                            {{ data.account ? data.account?.name : '-' }}
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText
                                    v-model="filterModel.value"
                                    type="text"
                                    class="p-column-filter"
                                    placeholder="Search by account"
                                />
                            </div>
                        </template>
                    </Column>

                    <template #paginatorstart>
                        <div class="p-d-flex p-ai-center p-mr-2">
                            <Button class="p-button-rounded p-button-text p-button-plain" icon="fa fa-sync" @click="getTransactions()" />
                        </div>
                    </template>
                </DataTable>

                <!-- Categories list -->
                <Dialog v-model:visible="showCategoriesDialog" :header="$t('transaction.categories')" modal>
                    <DataTable :value="categories" data-key="id">
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
                                <Button id="category_edit_button" icon="fa fa-edit" @click="editCategoryDialog(data.id)" />
                                <Button
                                    id="category_delete_button"
                                    icon="fa fa-trash"
                                    class="p-button-danger ml-2"
                                    @click="deleteCategory(data.id)"
                                />
                            </template>
                        </Column>
                    </DataTable>

                    <template #footer>
                        <div id="function_buttons" class="grid gap-2 justify-content-end">
                            <Button
                                id="new_category"
                                :label="$t('transaction.new_category')"
                                icon="fa fa-plus"
                                @click="showNewCategory = true"
                            />
                            <Button
                                id="categories_close_button"
                                :label="$t('basic.close')"
                                icon="fa fa-times"
                                class="p-button-danger"
                                @click="showCategoriesDialog = false"
                            />
                        </div>
                    </template>
                </Dialog>

                <!-- New category dialog -->
                <Dialog v-model:visible="showNewCategoryDialog" :header="$t('transaction.new_category')" modal>
                    <form id="new_category_form" class="formgrid">
                        <div class="grid">
                            <TextInput
                                id="name_input"
                                v-model="category.name"
                                class="field col-12"
                                :label="$t('transaction.category_name')"
                            ></TextInput>
                        </div>

                        <div class="grid">
                            <SelectInput
                                v-model="category.description"
                                :options="[
                                    { label: $t('transaction_type.income'), value: 'income' },
                                    { label: $t('transaction_type.expense'), value: 'expense' },
                                    { label: $t('transaction_type.transfer'), value: 'transfer' },
                                ]"
                                option-label="label"
                                option-value="value"
                                placeholder="Select type"
                                class="col-12"
                                :label="$t('form.type')"
                            />
                        </div>
                    </form>

                    <template #footer>
                        <div id="function_buttons" class="grid gap-2 justify-content-end">
                            <Button
                                id="new_category_cancel_button"
                                :label="$t('basic.cancel')"
                                icon="fa fa-times"
                                class="p-button-danger"
                                @click="showNewCategoryDialog = false"
                            />
                            <Button
                                id="new_category_save_button"
                                :label="$t('basic.save')"
                                icon="fa fa-floppy-disk"
                                :disabled="loadingData"
                                class="p-button-success"
                                @click="saveCategory"
                            />
                        </div>
                    </template>
                </Dialog>

                <!-- Edit category dialog -->
                <Dialog v-model:visible="showEditCategoryDialog" :header="$t('transaction.edit_category')" modal>
                    <form id="edit_category_form" class="formgrid">
                        <div class="grid">
                            <TextInput
                                id="name_input"
                                v-model="category.name"
                                class="field col-12"
                                :label="$t('transaction.category_name')"
                            ></TextInput>
                        </div>

                        <div class="grid">
                            <SelectInput
                                v-model="category.description"
                                :options="[
                                    { label: $t('transaction_type.income'), value: 'income' },
                                    { label: $t('transaction_type.expense'), value: 'expense' },
                                    { label: $t('transaction_type.transfer'), value: 'transfer' },
                                ]"
                                option-label="label"
                                option-value="value"
                                placeholder="Select type"
                                class="col-12"
                                :label="$t('form.type')"
                            />
                        </div>
                    </form>

                    <template #footer>
                        <div id="function_buttons" class="grid gap-2 justify-content-end">
                            <Button
                                id="edit_category_cancel_button"
                                :label="$t('basic.cancel')"
                                icon="fa fa-times"
                                class="p-button-danger"
                                @click="showEditCategoryDialog = false"
                            />
                            <Button
                                id="edit_category_save_button"
                                :label="$t('basic.save')"
                                icon="fa fa-floppy-disk"
                                :disabled="loadingData"
                                class="p-button-success"
                                @click="updateCategory"
                            />
                        </div>
                    </template>
                </Dialog>
            </div>
        </div>
    </user-layout>
</template>

<script>
import TransactionsMixin from '@/mixins/transactions'
import { FilterMatchMode, FilterOperator } from 'primevue/api'
export default {
    name: 'TransactionsPage',
    mixins: [TransactionsMixin],

    data() {
        return {
            filters: null,
            category: {
                name: '',
                description: '',
                icon: '',
                color: '',
                module: 'transaction',
            },
            categories: [],
            showCategoriesDialog: false,
            showNewCategoryDialog: false,
            showEditCategoryDialog: false,
        }
    },

    created() {
        this.getTransactions()
        this.initFilters()
        this.getCategories()
    },

    methods: {
        viewTransactionNavigation(rowData) {
            this.$router.push(`/transactions/${rowData.data.id}`)
        },

        initFilters() {
            this.filters = {
                name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                amount: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                account: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                type: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
            }
        },

        /**
         * Save new category
         */
        saveCategory() {
            // Set icon and color based on category type
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
            this.makeHttpRequest('POST', '/api/categories', this.category).then((response) => {
                this.showToast(this.$t('transaction.category_created'))
                this.showNewCategory = false
                this.category = {
                    name: '',
                    description: '',
                    icon: '',
                    color: '',
                    module: 'transaction',
                }
                this.getCategories()
            })
        },

        /**
         * Get categories
         */
        getCategories() {
            this.makeHttpRequest('GET', '/api/categories?module=transaction').then((response) => {
                this.categories = response.data.data
            })
        },

        /**
         * Get category by id
         * @param {UUID} id Category id
         */
        getCategory(id) {
            this.makeHttpRequest('GET', `/api/categories/${id}`).then((response) => {
                this.category = response.data.data
            })
        },

        /**
         * Open edit category dialog
         * @param {UUID} id Category id
         */
        editCategoryDialog(id) {
            this.category = {
                name: '',
                description: '',
                icon: '',
                color: '',
                module: 'transaction',
            }
            this.getCategory(id)
            this.showEditCategoryDialog = true
        },

        /**
         * Delete category after confirmation
         * @param {UUID} id Category id
         */
        deleteCategory(id) {
            this.$confirm.require({
                message: this.$t('transaction.delete_category_confirmation'),
                header: this.$t('basic.confirmation'),
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                    this.makeHttpRequest('DELETE', `/api/categories/${id}`).then((response) => {
                        this.showToast(this.$t('transaction.category_deleted'))
                        this.getCategories()
                    })
                },
            })
        },

        /**
         * Update category
         */
        updateCategory() {
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
            this.makeHttpRequest('PUT', `/api/categories/${this.category.id}`, this.category).then((response) => {
                this.showToast(this.$t('transaction.category_updated'))
                this.showEditCategoryDialog = false
                this.category = {
                    name: '',
                    description: '',
                    icon: '',
                    color: '',
                    module: 'transaction',
                }
                this.getCategories()
            })
        },
    },
}
</script>

<style></style>
