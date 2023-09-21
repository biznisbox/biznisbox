<template>
    <admin-layout>
        <div id="admin_settings_numbering_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('admin.numbering.title')" />

                <div class="card">
                    <form class="formgrid">
                        <TextInput v-model="settings.invoice_number_format" :label="$t('admin.numbering.invoice')" />
                        <TextInput v-model="settings.quote_number_format" :label="$t('admin.numbering.quote')" />
                        <TextInput v-model="settings.transaction_number_format" :label="$t('admin.numbering.transaction')" />
                        <TextInput v-model="settings.payment_number_format" :label="$t('admin.numbering.payment')" />
                        <TextInput v-model="settings.partner_number_format" :label="$t('admin.numbering.partner')" />
                        <TextInput v-model="settings.bill_number_format" :label="$t('admin.numbering.bill')" />
                        <TextInput v-model="settings.document_number_format" :label="$t('admin.numbering.document')" />
                        <TextInput v-model="settings.product_number_format" :label="$t('admin.numbering.product')" />
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
    name: 'AdminSettingsNumberingPage',
    mixins: [SettingsMixin],
    created() {
        this.getSettings()
    },
}
</script>

<style></style>
