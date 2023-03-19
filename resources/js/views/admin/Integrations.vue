<template>
    <admin-layout>
        <div id="integrations_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('admin.integrations.title')" />

                <div class="card">
                    <form class="formgrid">
                        <div id="stripe_integration">
                            <h2>{{ $t('admin.integrations.stripe') }}</h2>
                            <div class="grid">
                                <div class="flex flex-column mb-3 col-12">
                                    <label class="block text-900 font-medium mb-2"> {{ $t('admin.integrations.stripe_available') }} </label>
                                    <InputSwitch v-model="settings.stripe_available" />
                                </div>
                            </div>
                            <div class="grid">
                                <PasswordInput
                                    id="stripe_api_key"
                                    v-model="settings.stripe_key"
                                    :label="$t('admin.integrations.stripe_key')"
                                    :disabled="!settings.stripe_available"
                                    class="col-12"
                                />
                            </div>
                        </div>

                        <div id="paypal_integration">
                            <h2>{{ $t('admin.integrations.paypal') }}</h2>
                            <div class="grid">
                                <div class="flex flex-column mb-3 col-6">
                                    <label class="block text-900 font-medium mb-2"> {{ $t('admin.integrations.paypal_available') }} </label>
                                    <InputSwitch v-model="settings.paypal_available" />
                                </div>

                                <div class="flex flex-column mb-3 col-6">
                                    <label class="block text-900 font-medium mb-2"> {{ $t('admin.integrations.paypal_test_mode') }} </label>
                                    <InputSwitch v-model="settings.paypal_test_mode" />
                                </div>
                            </div>

                            <div class="grid">
                                <TextInput
                                    id="paypal_client_id"
                                    v-model="settings.paypal_client_id"
                                    :label="$t('admin.integrations.paypal_client_id')"
                                    :disabled="!settings.paypal_available"
                                    class="col-12 md:col-6"
                                />

                                <PasswordInput
                                    id="paypal_client_secret"
                                    v-model="settings.paypal_secret"
                                    :label="$t('admin.integrations.paypal_secret')"
                                    :disabled="!settings.paypal_available"
                                    class="col-12 md:col-6"
                                />
                            </div>
                        </div>

                        <div id="open_banking_integration">
                            <h2>{{ $t('admin.integrations.open_banking') }}</h2>
                            <div class="grid">
                                <div class="flex flex-column mb-3 col-12">
                                    <label class="block text-900 font-medium mb-2">
                                        {{ $t('admin.integrations.open_banking_available') }}
                                    </label>
                                    <InputSwitch v-model="settings.open_banking_available" />
                                </div>
                            </div>

                            <div class="grid">
                                <TextInput
                                    id="open_banking_client_id"
                                    v-model="settings.open_banking_id"
                                    :label="$t('admin.integrations.open_banking_client_id')"
                                    :disabled="!settings.open_banking_available"
                                    class="col-12 md:col-6"
                                />

                                <PasswordInput
                                    id="open_banking_client_secret"
                                    v-model="settings.open_banking_secret"
                                    :label="$t('admin.integrations.open_banking_secret')"
                                    :disabled="!settings.open_banking_available"
                                    class="col-12 md:col-6"
                                />
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
export default {
    name: 'AdminIntegrationsPage',
    mixins: [SettingsMixin],
    data() {
        return {
            stripe_disabled_input: true,
        }
    },
}
</script>

<style></style>
