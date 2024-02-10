<template>
    <admin-layout>
        <div id="admin_settings_numbering_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('admin.numbering.title')" />

                <div class="card">
                    <TabView>
                        <TabPanel :header="$t('admin.numbering.invoice')">
                            <NumberingInput v-model="settings.invoice_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <TabPanel :header="$t('admin.numbering.quote')">
                            <NumberingInput v-model="settings.quote_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <TabPanel :header="$t('admin.numbering.transaction')">
                            <NumberingInput v-model="settings.transaction_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <TabPanel :header="$t('admin.numbering.payment')">
                            <NumberingInput v-model="settings.payment_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <TabPanel :header="$t('admin.numbering.partner')">
                            <NumberingInput v-model="settings.partner_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <TabPanel :header="$t('admin.numbering.bill')">
                            <NumberingInput v-model="settings.bill_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <TabPanel :header="$t('admin.numbering.document')">
                            <NumberingInput v-model="settings.document_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <TabPanel :header="$t('admin.numbering.product')">
                            <NumberingInput v-model="settings.product_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                        <TabPanel :header="$t('admin.numbering.employee')">
                            <NumberingInput v-model="settings.employee_number_format" @update:model-value="updateNumberingModel" />
                        </TabPanel>
                    </TabView>
                </div>
                <div id="function_buttons" class="flex gap-2 justify-content-end">
                    <Button
                        id="save_button"
                        :label="$t('basic.save')"
                        icon="fa fa-floppy-disk"
                        class="p-button-success"
                        @click="updateNumberingSettings"
                    />
                </div>
            </LoadingScreen>
        </div>
    </admin-layout>
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

<style></style>
