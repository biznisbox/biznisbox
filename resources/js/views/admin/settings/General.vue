<template>
    <admin-layout>
        <div id="admin_settings_general_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('admin.general.title')" />

                <div class="card">
                    <form class="formgrid">
                        <div class="grid">
                            <SelectInput
                                id="available_lang_select"
                                v-model="settings.default_lang"
                                :label="$t('admin.general.default_language')"
                                :options="available_languages"
                                class="col-12 md:col-6"
                                option-value="locale"
                                option-label="name"
                            />
                            <SelectInput
                                id="input_timezone"
                                v-model="settings.default_timezone"
                                :label="$t('admin.general.default_timezone')"
                                class="col-12 md:col-6"
                                :options="timezones"
                                :disabled="loadingData"
                                option-label="text"
                                option-value="value"
                            />
                        </div>

                        <div class="grid">
                            <SelectInput
                                id="available_currency_select"
                                v-model="settings.default_currency"
                                :label="$t('admin.general.default_currency')"
                                :options="currencies"
                                class="col-12"
                                option-value="code"
                                option-label="name"
                            />
                        </div>

                        <div class="grid">
                            <SelectInput
                                id="date_format_select"
                                v-model="settings.date_format"
                                :label="$t('admin.general.default_date_format')"
                                :options="[
                                    { value: 'DD/MM/YYYY', label: 'DD/MM/YYYY' },
                                    { value: 'MM/DD/YYYY', label: 'MM/DD/YYYY' },
                                    { value: 'YYYY/MM/DD', label: 'YYYY/MM/DD' },
                                    { value: 'DD.MM.YYYY', label: 'DD.MM.YYYY' },
                                    { value: 'DD-MM-YYYY', label: 'DD-MM-YYYY' },
                                ]"
                                class="col-4"
                            />
                            <SelectInput
                                id="time_format_select"
                                v-model="settings.time_format"
                                :label="$t('admin.general.default_time_format')"
                                :options="[
                                    { value: 'HH:mm', label: 'HH:mm' },
                                    { value: 'HH:mm:ss', label: 'HH:mm:ss' },
                                ]"
                                class="col-4"
                            />

                            <SelectInput
                                id="datetime_format_select"
                                v-model="settings.datetime_format"
                                :label="$t('admin.general.default_datetime_format')"
                                :options="[
                                    { value: 'DD/MM/YYYY HH:mm', label: 'DD/MM/YYYY HH:mm' },
                                    { value: 'MM/DD/YYYY HH:mm', label: 'MM/DD/YYYY HH:mm' },
                                    { value: 'YYYY/MM/DD HH:mm', label: 'YYYY/MM/DD HH:mm' },
                                    { value: 'DD.MM.YYYY HH:mm', label: 'DD.MM.YYYY HH:mm' },
                                    { value: 'DD-MM-YYYY HH:mm', label: 'DD-MM-YYYY HH:mm' },
                                ]"
                                class="col-4"
                            />
                        </div>

                        <div class="grid">
                            <div class="flex flex-column mb-1 col-12">
                                <label class="block text-900 font-medium mb-1"> {{ $t('admin.general.show_barcode_on_documents') }} </label>
                                <InputSwitch v-model="settings.show_barcode_on_documents" />
                            </div>
                        </div>
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
import availableLanguages from '@/data/available_locales.json'
import availableTimezones from '@/data/timezones.json'
export default {
    name: 'AdminSettingsGeneralPage',
    mixins: [SettingsMixin],

    data() {
        return {
            available_languages: availableLanguages,
            timezones: availableTimezones,
        }
    },
    created() {
        this.getCurrencies()
    },
}
</script>

<style></style>
