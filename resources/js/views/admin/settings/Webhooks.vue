<template>
    <DefaultLayout menu_type="admin">
        <PageHeader :title="$t('admin.webhook.title')">
            <template #actions>
                <Button :label="$t('admin.webhook.new_webhook_subscription')" icon="fa fa-plus" @click="openNewWebhookSubscriptionDialog" />
            </template>
        </PageHeader>

        <div id="webhook_subscriptions_table" class="card">
            <DataTable
                :value="webhook_subscriptions"
                :loading="loadingData"
                column-resize-mode="expand"
                @row-dblclick="openEditWebhookSubscriptionDialog"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50]"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('admin.webhook.no_webhook_subscriptions') }}</p>
                    </div>
                </template>

                <Column field="name" :header="$t('form.name')" />
                <Column field="url" :header="$t('form.url')" />
                <Column field="http_verb" :header="$t('form.http_verb')">
                    <template #body="{ data }">
                        <Tag :value="data.http_verb.toUpperCase()" />
                    </template>
                </Column>
                <Column field="listen_events" :header="$t('form.listen_events')">
                    <template #body="{ data }">
                        <Tag v-for="event in data.listen_events" :key="event" :value="event" class="mr-1" />
                    </template>
                </Column>
                <Column field="is_active" :header="$t('form.active')">
                    <template #body="{ data }">
                        <Tag :value="data.is_active ? $t('basic.yes') : $t('basic.no')" :severity="data.is_active ? 'success' : 'danger'" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <!-- New / Edit Webhook Subscription Dialog -->
        <Dialog
            v-model:visible="showNewEditWebhookSubscriptionDialog"
            :header="modalMode === 'edit' ? $t('admin.webhook.edit_webhook_subscription') : $t('admin.webhook.new_webhook_subscription')"
            modal
            class="w-full m-2 lg:w-1/2"
            :draggable="false"
        >
            <LoadingScreen :blocked="loadingData">
                <form>
                    <TextInput
                        v-model="v$.webhook_subscription.name.$model"
                        :label="$t('form.name')"
                        :validate="v$.webhook_subscription.name"
                        :disabled="!webhook_subscription.can_be_edited"
                    />
                    <TextInput
                        v-model="v$.webhook_subscription.url.$model"
                        :label="$t('form.url')"
                        :validate="v$.webhook_subscription.url"
                        :disabled="!webhook_subscription.can_be_edited"
                    />
                    <TextInput
                        v-model="v$.webhook_subscription.signature_secret_key.$model"
                        :label="$t('form.signature_secret_key')"
                        :validate="v$.webhook_subscription.signature_secret_key"
                    />
                    <SelectInput
                        v-model="v$.webhook_subscription.http_verb.$model"
                        :label="$t('form.http_verb')"
                        :options="[
                            { label: 'POST', value: 'post' },
                            { label: 'GET', value: 'get' },
                            { label: 'PUT', value: 'put' },
                            { label: 'PATCH', value: 'patch' },
                            { label: 'DELETE', value: 'delete' },
                        ]"
                        :validate="v$.webhook_subscription.http_verb"
                        :disabled="!webhook_subscription.can_be_edited"
                    />
                    <MultiSelectInput
                        v-model="v$.webhook_subscription.listen_events.$model"
                        :label="$t('form.listen_events')"
                        :options="webhookEvents"
                        optionLabel="name"
                        optionValue="name"
                        :validate="v$.webhook_subscription.listen_events"
                        :disabled="!webhook_subscription.can_be_edited"
                    />

                    <div class="flex gap-2 my-4">
                        <Button
                            :label="$t('admin.webhook.add_header')"
                            icon="fa fa-plus"
                            @click="addHeader"
                            :disabled="!webhook_subscription.can_be_edited"
                        />
                    </div>

                    <div v-for="(header, index) in webhook_subscription.headers" :key="index" class="flex gap-2 objects-center">
                        <TextInput
                            v-model="header.key"
                            :label="$t('form.key')"
                            class="w-1/2"
                            :disabled="header.default || !webhook_subscription.can_be_edited"
                        />
                        <TextInput
                            v-model="header.value"
                            :label="$t('form.value')"
                            class="w-1/2"
                            :disabled="header.default || !webhook_subscription.can_be_edited"
                        />
                        <Button
                            icon="fa fa-trash"
                            :disabled="header.default || header.key == 'Content-Type' || !webhook_subscription.can_be_edited"
                            @click="removeHeader(index)"
                            severity="danger"
                            class="h-10 mt-9"
                        />
                    </div>
                </form>
            </LoadingScreen>

            <template #footer>
                <div id="function_buttons" class="flex gap-2 flex-wrap">
                    <div class="flex justify-content-end">
                        <Button
                            v-if="modalMode === 'edit'"
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            severity="danger"
                            @click="deleteWebhookSubscription(webhook_subscription.id)"
                        />
                    </div>
                    <div class="flex-grow"></div>
                    <div class="flex justify-content-end gap-2 flex-wrap">
                        <Button
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            severity="secondary"
                            @click="showNewEditWebhookSubscriptionDialog = false"
                        />
                        <Button
                            :label="formMode === 'edit' ? $t('basic.update') : $t('basic.save')"
                            icon="fa fa-floppy-disk"
                            @click="validateForm"
                            severity="success"
                            :disabled="!webhook_subscription.can_be_edited"
                        />
                    </div>
                </div>
            </template>
        </Dialog>
    </DefaultLayout>
</template>

<script>
import webhookEvents from '@/data/webhook_events.json'
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
export default {
    name: 'AdminSettingsWebhooksPage',
    setup() {
        return { v$: useVuelidate() }
    },
    data() {
        return {
            webhookEvents: webhookEvents,
            webhook_subscriptions: [],
            webhook_subscription: {
                id: '',
                name: '',
                url: '',
                signature_secret_key: '',
                listen_events: [],
                is_active: true,
                http_verb: 'POST',
                headers: [
                    {
                        key: 'Content-Type',
                        value: 'application/json',
                        default: true,
                    },
                ],
                can_be_edited: true,
            },
            showNewEditWebhookSubscriptionDialog: false,
            modalMode: 'new',
        }
    },

    validations() {
        return {
            webhook_subscription: {
                name: { required: required },
                url: { required: required },
                signature_secret_key: { required: required },
                listen_events: { required: required },
                http_verb: { required: required },
            },
        }
    },

    created() {
        this.getWebhookSubscriptions()
    },

    methods: {
        getWebhookSubscriptions() {
            this.makeHttpRequest('GET', '/api/admin/webhook_subscriptions').then((response) => {
                this.webhook_subscriptions = response.data.data
            })
        },

        getWebhookSubscription(id) {
            this.makeHttpRequest('GET', `/api/admin/webhook_subscriptions/${id}`).then((response) => {
                this.webhook_subscription = response.data.data
            })
        },

        updateWebhookSubscription() {
            this.makeHttpRequest('PUT', `/api/admin/webhook_subscriptions/${this.webhook_subscription.id}`, this.webhook_subscription).then(
                (response) => {
                    this.getWebhookSubscriptions()
                    this.showToast(response.data.message)
                    this.showNewEditWebhookSubscriptionDialog = false
                }
            )
        },

        deleteWebhookSubscription(id) {
            this.makeHttpRequest('DELETE', `/api/admin/webhook_subscriptions/${id}`).then((response) => {
                this.showToast(response.data.message)
                this.getWebhookSubscriptions()
                this.showNewEditWebhookSubscriptionDialog = false
            })
        },

        createWebhookSubscription() {
            this.makeHttpRequest('POST', '/api/admin/webhook_subscriptions', this.webhook_subscription).then((response) => {
                this.getWebhookSubscriptions()
                this.showToast(response.data.message)
                this.showNewEditWebhookSubscriptionDialog = false
            })
        },

        openEditWebhookSubscriptionDialog(rowData) {
            this.getWebhookSubscription(rowData.data.id)
            this.modalMode = 'edit'
            this.showNewEditWebhookSubscriptionDialog = true
        },

        openNewWebhookSubscriptionDialog() {
            this.v$.webhook_subscription.$reset()
            this.webhook_subscription = {
                id: '',
                name: '',
                url: '',
                signature_secret_key: this.generateRandomString(64),
                listen_events: [],
                is_active: true,
                http_verb: 'post',
                headers: [
                    {
                        key: 'Content-Type',
                        value: 'application/json',
                        default: true,
                    },
                ],
                can_be_edited: true,
            }
            this.modalMode = 'new'
            this.showNewEditWebhookSubscriptionDialog = true
        },

        addHeader() {
            this.webhook_subscription.headers.push({
                key: '',
                value: '',
                default: false,
            })
        },

        removeHeader(index) {
            if (this.webhook_subscription.headers[index].default || this.webhook_subscription.headers[index].key === 'Content-Type') {
                return
            }
            this.webhook_subscription.headers.splice(index, 1)
        },

        generateSignatureSecretKey() {
            this.webhook_subscription.signature_secret_key = this.generateRandomString(64)
        },

        generateRandomString(length) {
            let result = ''
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
            const charactersLength = characters.length
            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength))
            }
            return result
        },

        validateForm() {
            this.v$.webhook_subscription.$touch()
            if (this.v$.webhook_subscription.$error) {
                return this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
            }
            if (this.modalMode === 'new') {
                this.createWebhookSubscription()
            } else {
                this.updateWebhookSubscription()
            }
        },
    },
}
</script>

<style></style>
