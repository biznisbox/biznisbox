<template>
    <admin-layout>
        <div id="admin_settings_general_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('admin.numbering.title')" />

                <div class="card">
                    <form class="formgrid">
                        <TextInput v-model="settings.invoice_number_format" :label="$t('admin.numbering.invoice')" />
                        <TextInput v-model="settings.estimate_number_format" :label="$t('admin.numbering.estimate')" />
                        <TextInput v-model="settings.transaction_number_format" :label="$t('admin.numbering.transaction')" />
                        <TextInput v-model="settings.payment_number_format" :label="$t('admin.numbering.payment')" />
                        <TextInput v-model="settings.customer_number_format" :label="$t('admin.numbering.customer')" />
                        <TextInput v-model="settings.vendor_number_format" :label="$t('admin.numbering.vendor')" />
                        <TextInput v-model="settings.bill_number_format" :label="$t('admin.numbering.bill')" />
                    </form>

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="goTo('/admin')" />
                        <Button :label="$t('basic.save')" icon="fa fa-floppy-disk" class="p-button-success" @click="updateSettings" />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </admin-layout>
</template>

<script>
import SettingsMixin from '@/mixins/admin/settings'
export default {
    name: 'AdminSettingsGeneral',
    mixins: [SettingsMixin],

    data() {
        return {}
    },
    created() {
        this.getSettings()
    },
}
</script>

<style></style>
