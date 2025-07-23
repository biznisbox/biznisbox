<template>
    <DefaultLayout menu_type="admin">
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('admin.integrations.title')" />

            <div class="card">
                <Tabs value="online_payments">
                    <TabList>
                        <Tab value="online_payments">{{ $t('admin.integrations.online_payments') }}</Tab>
                        <Tab value="open_banking">{{ $t('admin.integrations.open_banking') }}</Tab>
                    </TabList>

                    <TabPanels>
                        <!-- Online Payments -->
                        <TabPanel value="online_payments" class="p-2">
                            <div id="stripe_integration">
                                <h2 class="mb-4 font-bold dark:text-surface-200">{{ $t('admin.integrations.stripe') }}</h2>
                                <div class="flex flex-col gap-2 mb-2">
                                    <label class="dark:text-surface-200">{{ $t('admin.integrations.stripe_available') }} </label>
                                    <ToggleSwitch v-model="settings.stripe_available" id="stripe_available" />
                                </div>
                                <PasswordInput
                                    id="stripe_api_key"
                                    v-model="settings.stripe_key"
                                    :label="$t('admin.integrations.stripe_key')"
                                    :disabled="!settings.stripe_available"
                                />

                                <SelectInput
                                    id="stripe_account_input"
                                    v-model="settings.stripe_account_id"
                                    :label="$t('admin.integrations.stripe_account_id')"
                                    :options="accounts"
                                    option-label="name"
                                    option-value="id"
                                    :disabled="!settings.stripe_available"
                                />
                            </div>

                            <div id="paypal_integration">
                                <h2 class="mb-4 font-bold dark:text-surface-200">{{ $t('admin.integrations.paypal') }}</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    <div class="flex flex-col gap-2 mb-2">
                                        <label class="dark:text-surface-200">{{ $t('admin.integrations.paypal_available') }} </label>
                                        <ToggleSwitch v-model="settings.paypal_available" />
                                    </div>

                                    <div class="flex flex-col gap-2 mb-2">
                                        <label class="dark:text-surface-200">{{ $t('admin.integrations.paypal_test_mode') }} </label>
                                        <ToggleSwitch v-model="settings.paypal_test_mode" :disabled="!settings.paypal_available" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    <TextInput
                                        id="paypal_client_id"
                                        v-model="settings.paypal_client_id"
                                        :label="$t('admin.integrations.paypal_client_id')"
                                        :disabled="!settings.paypal_available"
                                    />

                                    <PasswordInput
                                        id="paypal_client_secret"
                                        v-model="settings.paypal_secret"
                                        :label="$t('admin.integrations.paypal_secret')"
                                        :disabled="!settings.paypal_available"
                                    />
                                </div>
                                <SelectInput
                                    id="paypal_account_input"
                                    v-model="settings.paypal_account_id"
                                    :label="$t('admin.integrations.paypal_account_id')"
                                    :options="accounts"
                                    option-label="name"
                                    option-value="id"
                                    :disabled="!settings.paypal_available"
                                />
                            </div>
                        </TabPanel>

                        <!-- Open Banking -->
                        <TabPanel value="open_banking" class="p-2">
                            <div id="open_banking_integration">
                                <h2 class="font-bold mb-4 dark:text-surface-200">{{ $t('admin.integrations.open_banking') }}</h2>
                                <div class="flex flex-col gap-2 mb-2">
                                    <label class="dark:text-surface-200">
                                        {{ $t('admin.integrations.open_banking_available') }}
                                    </label>
                                    <ToggleSwitch v-model="settings.open_banking_available" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    <TextInput
                                        id="open_banking_client_id"
                                        v-model="settings.open_banking_id"
                                        :label="$t('admin.integrations.open_banking_client_id')"
                                        :disabled="!settings.open_banking_available"
                                    />

                                    <PasswordInput
                                        id="open_banking_client_secret"
                                        v-model="settings.open_banking_secret"
                                        :label="$t('admin.integrations.open_banking_secret')"
                                        :disabled="!settings.open_banking_available"
                                    />
                                </div>
                            </div>
                        </TabPanel>
                    </TabPanels>
                </Tabs>
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
    name: 'AdminIntegrationsPage',
    mixins: [SettingsMixin],
    data() {
        return {
            stripe_disabled_input: true,
            paypal_disabled_input: true,
            accounts: [],
        }
    },

    created() {
        this.getAccounts()
        this.getSettings()
    },

    methods: {
        /**
         * Get all accounts
         * @return {void} return accounts
         **/
        getAccounts() {
            this.makeHttpRequest('GET', '/api/accounts').then((response) => {
                this.accounts = response.data.data
            })
        },
    },
}
</script>

<style></style>
