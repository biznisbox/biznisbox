<template>
    <DefaultLayout menu_type="admin">
        <LoadingScreen :blocked="loadingData">
            <user-header :title="$t('admin.numbering.title')" />

            <div class="card">
                <Tabs value="invoice">
                    <TabList>
                        <Tab value="invoice">{{ $t('admin.numbering.invoice') }}</Tab>
                        <Tab value="quote">{{ $t('admin.numbering.quote') }}</Tab>
                        <Tab value="transaction">{{ $t('admin.numbering.transaction') }}</Tab>
                        <Tab value="payment">{{ $t('admin.numbering.payment') }}</Tab>
                        <Tab value="partner">{{ $t('admin.numbering.partner') }}</Tab>
                        <Tab value="bill">{{ $t('admin.numbering.bill') }}</Tab>
                        <Tab value="document">{{ $t('admin.numbering.document') }}</Tab>
                        <Tab value="product">{{ $t('admin.numbering.product') }}</Tab>
                        <Tab value="employee">{{ $t('admin.numbering.employee') }}</Tab>
                        <Tab value="archive">{{ $t('admin.numbering.archive') }}</Tab>
                        <Tab value="project">{{ $t('admin.numbering.project') }}</Tab>
                        <Tab value="contract">{{ $t('admin.numbering.contract') }}</Tab>
                    </TabList>

                    <TabPanels>
                        <!-- Invoice -->
                        <TabPanel value="invoice">
                            <NumberingInput v-model="settings.invoice_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <!-- Quote -->
                        <TabPanel value="quote">
                            <NumberingInput v-model="settings.quote_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <!-- Transaction -->
                        <TabPanel value="transaction">
                            <NumberingInput v-model="settings.transaction_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <!-- Payment -->
                        <TabPanel value="payment">
                            <NumberingInput v-model="settings.payment_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <!-- Partner -->
                        <TabPanel value="partner">
                            <NumberingInput v-model="settings.partner_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <!-- Bill -->
                        <TabPanel value="bill">
                            <NumberingInput v-model="settings.bill_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <!-- Document -->
                        <TabPanel value="document">
                            <NumberingInput v-model="settings.document_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <!-- Product -->
                        <TabPanel value="product">
                            <NumberingInput v-model="settings.product_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <!-- Employee -->
                        <TabPanel value="employee">
                            <NumberingInput v-model="settings.employee_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <!-- Archive -->
                        <TabPanel value="archive">
                            <NumberingInput v-model="settings.archive_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <!-- Project -->
                        <TabPanel value="project">
                            <NumberingInput v-model="settings.project_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <!-- Contract -->
                        <TabPanel value="contract">
                            <NumberingInput v-model="settings.contract_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                    </TabPanels>
                </Tabs>
            </div>
            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button
                    id="save_button"
                    :label="$t('basic.save')"
                    icon="fa fa-floppy-disk"
                    severity="success"
                    @click="updateNumberingSettings"
                />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
import SettingsMixin from '@/mixins/admin/settings'
export default {
    name: 'AdminSettingsNumberingPage',
    mixins: [SettingsMixin],
    created() {
        this.getNumberingSettings()
    },

    methods: {
        updateNumberingModel(newModelValue) {
            // Update the shared data when NumberingInput emits an update
            this.numberingModel = newModelValue
        },
    },
}
</script>
