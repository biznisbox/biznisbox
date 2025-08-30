<template>
    <DefaultLayout menu_type="admin">
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('admin.general.title')" />

            <div class="card">
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <SelectInput
                            id="available_lang_select"
                            v-model="settings.default_lang"
                            :label="$t('admin.general.default_language')"
                            :options="locales"
                            option-value="code"
                            option-label="locale"
                        />
                        <SelectInput
                            id="input_timezone"
                            v-model="settings.default_timezone"
                            :label="$t('admin.general.default_timezone')"
                            :options="timezones"
                            :disabled="loadingData"
                            option-label="name"
                            option-value="name"
                            filter
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <SelectInput
                            id="available_currency_select"
                            v-model="settings.default_currency"
                            :label="$t('admin.general.default_currency')"
                            :options="currencies"
                            option-value="code"
                            option-label="name"
                        />

                        <SelectInput
                            id="week_start_select"
                            v-model="settings.week_start"
                            :label="$t('admin.general.week_start')"
                            :options="[
                                { value: 0, label: $t('day.sunday') },
                                { value: 1, label: $t('day.monday') },
                                { value: 2, label: $t('day.tuesday') },
                                { value: 3, label: $t('day.wednesday') },
                                { value: 4, label: $t('day.thursday') },
                                { value: 5, label: $t('day.friday') },
                                { value: 6, label: $t('day.saturday') },
                            ]"
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
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
                        />
                        <SelectInput
                            id="time_format_select"
                            v-model="settings.time_format"
                            :label="$t('admin.general.default_time_format')"
                            :options="[
                                { value: 'HH:mm', label: 'HH:mm' },
                                { value: 'HH:mm:ss', label: 'HH:mm:ss' },
                            ]"
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
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        <div class="flex flex-col gap-2 mb-2">
                            <label for="show_barcode_on_documents" class="dark:text-surface-200"
                                >{{ $t('admin.general.show_barcode_on_documents') }}
                            </label>
                            <ToggleSwitch id="show_barcode_on_documents_switch" v-model="settings.show_barcode_on_documents" />
                        </div>

                        <div class="flex flex-col gap-2 mb-2">
                            <label for="save_document_into_archive" class="dark:text-surface-200"
                                >{{ $t('admin.general.save_document_into_archive') }}
                            </label>
                            <ToggleSwitch id="save_document_into_archive_switch" v-model="settings.save_document_into_archive" />
                        </div>

                        <SelectInput
                            id="exchange_rate_provider_select"
                            v-model="settings.exchange_rate_provider"
                            :label="$t('admin.general.exchange_rate_provider')"
                            :options="[
                                { value: 'ecb', label: 'European Central Bank (ECB)' },
                                { value: 'exchange-api', label: 'ExchangeRate-API' },
                            ]"
                            option-value="value"
                            option-label="label"
                        />
                    </div>
                </form>
            </div>
            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button id="save_button" :label="$t('basic.save')" icon="fa fa-floppy-disk" severity="success" @click="updateSettings" />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
import SettingsMixin from '@/mixins/admin/settings'
export default {
    name: 'AdminSettingsGeneralPage',
    mixins: [SettingsMixin],

    data() {},
    created() {
        this.getSettings()
        this.getLocales()
        this.getTimezones()
        this.getCurrencies()
    },
}
</script>

<style></style>
