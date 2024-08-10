<template>
    <DefaultLayout>
        <PageHeader :title="$t('transaction.transaction', 2)">
            <template #actions>
                <Button :label="$t('transaction.new_transaction')" icon="fa fa-plus" @click="$router.push('/transactions/create')" />
                <Button
                    id="categories_button"
                    icon="fa fa-folder-tree"
                    :label="$t('transaction.categories')"
                    @click="showCategoriesDialog = true"
                />
            </template>
        </PageHeader>

        <div id="transactions_table" class="card">
            <DataTable
                :value="transactions"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                :loading="loadingData"
                @row-dblclick="viewTransactionNavigation"
                filter-display="menu"
                v-model:filters="filters"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('transaction.no_transactions') }}</p>
                        <Button
                            class="mt-3"
                            :label="$t('transaction.create_first_transaction')"
                            icon="fa fa-plus"
                            @click="$router.push('/transactions/create')"
                        />
                    </div>
                </template>

                <Column field="name" :header="$t('transaction.name')">
                    <template #body="{ data }">
                        <span>{{ data.name ? data.name : '-' }}</span>
                    </template>

                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by name" />
                    </template>
                </Column>

                <Column field="date" :header="$t('transaction.date_and_number')">
                    <template #body="{ data }">
                        <span>{{ data.date ? formatDate(data.date) : '-' }}</span
                        ><br />
                        <span>{{ data.number }}</span>
                    </template>

                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by date" />
                    </template>
                </Column>

                <Column field="amount" :header="$t('form.amount')">
                    <template #body="{ data }">
                        <span>{{ formatMoney(data.amount, data.currency) }}</span> <br />
                    </template>

                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by amount" />
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
                        <Dropdown
                            v-model="filterModel.value"
                            :options="[
                                { label: $t('transaction_type.income'), value: 'income' },
                                { label: $t('transaction_type.expense'), value: 'expense' },
                                { label: $t('transaction_type.transfer'), value: 'transfer' },
                            ]"
                            option-label="label"
                            option-value="value"
                            placeholder="Search by type"
                        />
                    </template>
                </Column>

                <Column field="account" :header="$t('form.account')">
                    <template #body="{ data }">
                        {{ data.account ? data.account?.name : '-' }}
                    </template>

                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by account" />
                    </template>
                </Column>

                <template #paginatorstart>
                    <Button icon="fa fa-sync" @click="getTransactions" />
                </template>
            </DataTable>

            <!-- Categories list -->
            <Dialog v-model:visible="showCategoriesDialog" :header="$t('transaction.categories')" modal>
                <DataTable :value="categories" data-key="id">
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

                <template #footer>
                    <div id="function_buttons" class="flex justify-end mt-2 gap-2">
                        <Button
                            id="new_category"
                            :label="$t('transaction.new_category')"
                            icon="fa fa-plus"
                            @click="openNewEditCategoryDialog('create')"
                        />
                        <Button
                            id="categories_close_button"
                            :label="$t('basic.close')"
                            icon="fa fa-times"
                            severity="secondary"
                            @click="showCategoriesDialog = false"
                        />
                    </div>
                </template>
            </Dialog>

            <!-- New/Edit category dialog -->
            <Dialog
                v-model:visible="showNewEditCategoryDialog"
                :header="categoryMethod === 'create' ? $t('transaction.new_category') : $t('transaction.edit_category')"
                modal
            >
                <LoadingScreen :blocked="loadingData">
                    <form id="category_form">
                        <TextInput id="name_input" v-model="category.name" :label="$t('transaction.category_name')"></TextInput>
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
                            :label="$t('form.type')"
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
                            :label="categoryMethod === 'create' ? $t('basic.save') : $t('basic.update')"
                            icon="fa fa-floppy-disk"
                            :disabled="loadingData || !category.name || !category.description"
                            severity="success"
                            @click="saveEditCategory"
                        />
                    </div>
                </template>
            </Dialog>
        </div>
    </DefaultLayout>
</template>

<script>
import TransactionsMixin from '@/mixins/transactions'
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
export default {
    name: 'TransactionsPage',
    mixins: [TransactionsMixin],

    data() {
        return {
            filters: null,
            categories: [],
            showCategoriesDialog: false,
            showNewEditCategoryDialog: false,
            categoryMethod: 'create', // create or edit
        }
    },

    created() {
        this.getTransactions()
        this.initFilters()
        this.getCategories('transaction').then((response) => {
            this.categories = response
        })
    },

    methods: {
        /**
         * Initialize filters
         */
        initFilters() {
            this.filters = {
                name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                amount: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                account: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                type: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
            }
        },

        saveEditCategory() {
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
            if (this.categoryMethod === 'create') {
                this.createCategory(this.category).then(() => {
                    this.showToast(this.$t('transaction.category_created'))
                    this.getCategories('transaction').then((response) => {
                        this.categories = response
                    })
                })
            } else {
                this.updateCategory(this.category.id, this.category).then(() => {
                    this.showToast(this.$t('transaction.category_updated'))
                    this.getCategories('transaction').then((response) => {
                        this.categories = response
                    })
                })
            }
            this.resetCategoryForm()
            this.showNewEditCategoryDialog = false
        },

        openNewEditCategoryDialog(method, id) {
            this.resetCategoryForm()
            this.categoryMethod = method
            if (method === 'create') {
                this.showNewEditCategoryDialog = true
            } else {
                this.getCategory(id).then((response) => {
                    this.category = response
                })
                this.showNewEditCategoryDialog = true
            }
        },

        resetCategoryForm() {
            this.category = {
                id: '',
                name: '',
                description: '',
                icon: '',
                color: '',
                module: 'transaction',
            }
        },

        /**
         * Delete category after confirmation
         * @param {UUID} id Category id
         */
        deleteCategoryAsk(id) {
            this.$confirm.require({
                message: this.$t('transaction.delete_category_confirmation'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-exclamation-triangle',
                accept: () => {
                    this.deleteCategory(id).then(() => {
                        this.showToast(this.$t('transaction.category_deleted'))
                        this.getCategories('transaction').then((response) => {
                            this.categories = response
                        })
                    })
                },
            })
        },
    },
}
</script>

<style></style>
