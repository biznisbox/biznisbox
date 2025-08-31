<template>
    <DefaultLayout menu_type="admin">
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('admin.mail.title')" />

            <div class="card">
                <form>
                    <SelectInput
                        id="available_mail_mailer"
                        v-model="mail_settings.mail_mailer"
                        :label="$t('admin.mail.mail_mailer')"
                        :options="[
                            { value: 'smtp', label: 'SMTP' },
                            { value: 'sendmail', label: 'Sendmail' },
                            { value: 'log', label: 'Log' },
                        ]"
                    />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <TextInput
                            v-if="mail_settings.mail_mailer === 'smtp'"
                            id="mail_host"
                            v-model="mail_settings.mail_host"
                            :label="$t('admin.mail.mail_host')"
                            :disabled="mail_settings.mail_mailer !== 'smtp'"
                        />
                        <TextInput
                            v-if="mail_settings.mail_mailer === 'smtp'"
                            id="mail_port"
                            v-model="mail_settings.mail_port"
                            :label="$t('admin.mail.mail_port')"
                            :disabled="mail_settings.mail_mailer !== 'smtp'"
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <TextInput
                            v-if="mail_settings.mail_mailer === 'smtp'"
                            id="mail_username"
                            v-model="mail_settings.mail_username"
                            :label="$t('admin.mail.mail_username')"
                            :disabled="mail_settings.mail_mailer !== 'smtp'"
                        />
                        <TextInput
                            v-if="mail_settings.mail_mailer === 'smtp'"
                            id="mail_password"
                            v-model="mail_settings.mail_password"
                            :label="$t('admin.mail.mail_password')"
                            :disabled="mail_settings.mail_mailer !== 'smtp'"
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <SelectInput
                            v-if="mail_settings.mail_mailer === 'smtp'"
                            id="mail_encryption"
                            v-model="mail_settings.mail_encryption"
                            :label="$t('admin.mail.mail_encryption')"
                            :disabled="mail_settings.mail_mailer !== 'smtp'"
                            :options="[
                                { value: 'tls', label: 'TLS' },
                                { value: 'starttls', label: 'STARTTLS' },
                                { value: 'plain', label: 'PLAIN' },
                                { value: 'ssl', label: 'SSL' },
                                { value: null, label: 'None' },
                            ]"
                        />
                        <TextInput
                            id="mail_from_address"
                            v-model="mail_settings.mail_from_address"
                            :label="$t('admin.mail.mail_from_address')"
                        />
                    </div>

                    <TextInput id="mail_from_name" v-model="mail_settings.mail_from_name" :label="$t('admin.mail.mail_from_name')" />

                    <TextInput
                        v-if="mail_settings.mail_mailer === 'sendmail'"
                        id="sendmail_path"
                        v-model="mail_settings.mail_sendmail_path"
                        :label="$t('admin.mail.sendmail_path')"
                        :disabled="mail_settings.mail_mailer !== 'sendmail'"
                    />
                </form>
            </div>
            <div id="function_buttons" class="flex justify-end mt-4 gap-2 mb-5">
                <Button
                    id="save_button"
                    :label="$t('basic.save')"
                    icon="fa fa-floppy-disk"
                    severity="success"
                    @click="updateEmailSettings"
                />
            </div>

            <div class="card">
                <div id="test_email_header" class="flex justify-between">
                    <h2 class="text-xl dark:text-surface-200">{{ $t('admin.mail.send_test_email') }}</h2>
                </div>

                <div class="flex flex-col gap-2 mb-2">
                    <label for="input_send_details_to" class="dark:text-surface-200">
                        {{ $t('admin.mail.send_test_email_to') }}
                    </label>
                    <AutoComplete
                        id="input_send_details_to"
                        v-model="test_mail.emails"
                        multiple
                        :typeahead="false"
                        :label="$t('admin.email.email_address')"
                    />
                </div>
            </div>

            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button
                    id="send_test_email_button"
                    :label="$t('admin.mail.send_test_email')"
                    icon="fa fa-envelope"
                    severity="success"
                    @click="sentTestEmail"
                />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
export default {
    name: 'AdminSettingsEmailPage',

    data() {
        return {
            mail_settings: {
                mail_mailer: '',
                mail_host: '',
                mail_port: '',
                mail_username: '',
                mail_password: '',
                mail_encryption: '',
                mail_from_address: '',
                mail_from_name: '',
                mail_sendmail_path: '',
            },
            test_mail: {
                emails: [],
            },
        }
    },
    created() {
        this.getEmailSettings()
    },

    methods: {
        updateEmailSettings() {
            this.makeHttpRequest('PUT', '/api/admin/settings/email', this.mail_settings).then((response) => {
                this.showToast(response.data.message)
            })
        },

        getEmailSettings() {
            this.makeHttpRequest('GET', '/api/admin/settings/email').then((response) => {
                this.mail_settings = response.data.data
            })
        },

        sentTestEmail() {
            if (this.test_mail.emails.length === 0) {
                return this.showToast(this.$t('admin.mail.no_email_selected'), this.$t('basic.error'), 'error')
            }
            this.makeHttpRequest('POST', '/api/admin/settings/email/test', this.test_mail).then((response) => {
                this.showToast(response.data.message)
                this.test_mail.emails = []
            })
        },

        preventDefault(event) {
            event.preventDefault()
        },
    },
}
</script>

<style></style>
