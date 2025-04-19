<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('support.view_ticket')">
                <template #actions>
                    <Button
                        id="delete_button"
                        :label="$t('basic.delete')"
                        icon="fa fa-trash"
                        severity="danger"
                        @click="deleteSupportTicketAsk(supportTicket.id)"
                    />
                    <Button
                        id="share_ticket_button"
                        :label="$t('basic.share')"
                        icon="fa fa-share"
                        @click="shareSupportTicket(supportTicket.id)"
                    />
                    <SplitButton
                        v-if="supportTicket.status !== 'closed' && supportTicket.status !== 'resolved'"
                        id="more_options_button"
                        :label="$t('support.mark_as_resolved')"
                        icon="fa fa-check"
                        severity="secondary"
                        :model="[
                            {
                                label: $t('support.mark_as_resolved'),
                                icon: 'fa fa-check',
                                command: () => markSupportTicketAsResolved(),
                            },
                            { label: $t('support.mark_as_closed'), icon: 'fa fa-times', command: () => markSupportTicketAsClosed() },
                            {
                                label: $t('basic.send'),
                                icon: 'fa fa-paper-plane',
                                command: () => sendTicketNotificationToContact(supportTicket.id),
                            },
                        ]"
                        @click="markSupportTicketAsResolved"
                    />

                    <Button
                        v-if="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                        id="reopen_button"
                        :label="$t('support.reopen_ticket')"
                        icon="fa fa-undo"
                        @click="markSupportTicketAsReopened"
                    />
                </template>
            </PageHeader>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-2">
                <!-- Metadata view -->
                <div class="col-span-1 md:col-span-5">
                    <div class="formgrid card">
                        <h1 class="text-xl font-bold mb-4">{{ $t('support.ticket_details') }}</h1>
                        <TextInput
                            id="number_input"
                            v-model="v$.supportTicket.number.$model"
                            disabled
                            :label="$t('form.number')"
                            :validate="v$.supportTicket.number"
                        />
                        <TextInput
                            id="subject_input"
                            v-model="v$.supportTicket.subject.$model"
                            :label="$t('form.subject')"
                            :validate="v$.supportTicket.subject"
                            :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                        />
                        <SelectInput
                            id="department_input"
                            v-model="supportTicket.department_id"
                            :label="$t('form.department')"
                            :options="departments"
                            optionLabel="name"
                            optionValue="id"
                            showClear
                            filter
                            :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                        />
                        <SelectInput
                            id="employee_input"
                            v-model="supportTicket.assignee_id"
                            :label="$t('form.assigned_to')"
                            :options="employees"
                            optionLabel="label"
                            optionValue="id"
                            showClear
                            filter
                            :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                        />

                        <div class="flex flex-col gap-2 mb-2">
                            <label for="is_internal_switch" class="dark:text-surface-200">{{ $t('form.is_internal') }}</label>
                            <ToggleSwitch
                                id="is_internal_switch"
                                v-model="supportTicket.is_internal"
                                :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                            />
                        </div>

                        <div id="partner_input">
                            <div class="flex flex-col gap-2 mb-2">
                                <label for="custom_partner_switch" class="dark:text-surface-200">{{ $t('form.custom_contact') }}</label>
                                <ToggleSwitch
                                    id="custom_partner_switch"
                                    v-model="supportTicket.custom_contact"
                                    :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                                />
                            </div>
                            <SelectInput
                                id="partner_input"
                                v-if="!supportTicket.custom_contact"
                                v-model="v$.supportTicket.partner_id.$model"
                                :label="$t('form.partner')"
                                :options="partners"
                                optionLabel="name"
                                optionValue="id"
                                showClear
                                filter
                                :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                                :validate="v$.supportTicket.partner_id"
                            />

                            <SelectInput
                                id="partner_contact_input"
                                v-if="!supportTicket.custom_contact"
                                v-model="supportTicket.contact_id"
                                :label="$t('form.partner_contact')"
                                :options="partnerContacts"
                                optionLabel="name"
                                optionValue="id"
                                showClear
                                filter
                                :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                            />

                            <div v-if="supportTicket.custom_contact">
                                <TextInput
                                    id="contact_name_input"
                                    v-model="v$.supportTicket.contact_name.$model"
                                    :label="$t('form.contact_name')"
                                    :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                                    :validate="v$.supportTicket.contact_name"
                                />
                                <TextInput
                                    id="contact_email_input"
                                    v-model="v$.supportTicket.contact_email.$model"
                                    :label="$t('form.contact_email')"
                                    :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                                    :validate="v$.supportTicket.contact_email"
                                />
                                <TextInput
                                    id="contact_phone_input"
                                    v-model="supportTicket.contact_phone_number"
                                    :label="$t('form.contact_phone')"
                                    :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                                />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <SelectInput
                                id="status_input"
                                v-model="v$.supportTicket.status.$model"
                                :label="$t('form.status')"
                                :options="[
                                    { label: $t('status.open'), value: 'open' },
                                    { label: $t('status.in_progress'), value: 'in_progress' },
                                    { label: $t('status.closed'), value: 'closed' },
                                    { label: $t('status.reopened'), value: 'reopened' },
                                    { label: $t('status.resolved'), value: 'resolved' },
                                    { label: $t('status.spam'), value: 'spam' },
                                ]"
                                :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                                :validate="v$.supportTicket.status"
                            />
                            <SelectInput
                                id="priority_input"
                                v-model="v$.supportTicket.priority.$model"
                                :label="$t('form.priority')"
                                :options="[
                                    { label: $t('support_priority.none'), value: 'none' },
                                    { label: $t('support_priority.low'), value: 'low' },
                                    { label: $t('support_priority.medium'), value: 'medium' },
                                    { label: $t('support_priority.normal'), value: 'normal' },
                                    { label: $t('support_priority.high'), value: 'high' },
                                    { label: $t('support_priority.urgent'), value: 'urgent' },
                                ]"
                                :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                                :validate="v$.supportTicket.priority"
                            />
                        </div>
                        <TextAreaInput
                            id="notes_input"
                            v-model="supportTicket.notes"
                            :label="$t('form.notes')"
                            :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                        />

                        <Button
                            id="save_button"
                            :label="$t('basic.update')"
                            :disabled="loadingData"
                            icon="fa fa-floppy-disk"
                            severity="success"
                            @click="validateForm"
                        />
                    </div>
                </div>
                <!-- Content view -->
                <div class="col-span-1 md:col-span-7">
                    <div class="card">
                        <h1 class="text-2xl font-bold mb-4">{{ $t('form.message') }}</h1>

                        <div v-for="(content, index) in supportTicket.content" :key="index">
                            <div id="content_{{ index }}" class="card p-4 mb-4">
                                <div class="flex justify-between items-center">
                                    <div id="content_{{ index }}_from" v-if="content.from !== null">
                                        <div v-if="content.from === 'system'">
                                            <b>{{ $t('form.from') }}: </b>
                                            <Tag :value="$t('support.system')" />
                                        </div>
                                        <div v-else>
                                            <b>{{ $t('form.from') }}: </b>
                                            <Tag :value="content.from" />
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <Button
                                            v-if="supportTicket.status !== 'closed' && supportTicket.status !== 'resolved'"
                                            icon="fa fa-trash"
                                            severity="danger"
                                            @click="deleteSupportTicketMessageAsk(content.id)"
                                        />
                                    </div>
                                </div>

                                <div id="content_{{ index }}_message" class="mt-4">
                                    <span v-if="content.type === 'text' && content.message" v-html="formatHtml(content.message)"></span>
                                </div>

                                <!-- Footer - date -->
                                <Tag v-if="content.created_at" :value="formatDateTime(content.created_at)" severity="primary" />
                            </div>
                        </div>

                        <div>
                            <div
                                id="new_replay"
                                class="card p-4 mb-4"
                                v-if="supportTicket.status !== 'closed' && supportTicket.status !== 'resolved'"
                            >
                                <TinyMceEditor id="content_input" v-model="supportTicketMessage.message" :label="$t('form.new_replay')" />
                                <Button
                                    id="add_content_button"
                                    :label="$t('basic.send')"
                                    icon="fa fa-paper-plane"
                                    @click="createTicketMessage"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button id="cancel_button" :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="goTo('/support')" />
            </div>
        </LoadingScreen>

        <!-- Share dialog -->
        <Dialog ref="shareDialog" v-model:visible="shareDialog" :header="$t('support.share_dialog')" modal>
            <div id="share_dialog_content" class="text-center">
                <div>{{ $t('support.share_dialog_text') }}</div>

                <div class="flex justify-center my-2">
                    <qrcode-vue :value="shareUrl" :size="140" level="H" />
                </div>

                <div class="flex gap-2 w-full">
                    <InputText v-model="shareUrl" class="w-full" />
                    <Button :label="$t('basic.copy')" icon="fa fa-copy" @click="copyToClipboard(shareUrl)" />
                </div>
            </div>
            <template #footer>
                <Button :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="shareDialog = false" />
            </template>
        </Dialog>
    </DefaultLayout>
</template>

<script>
import SupportMixin from '@/mixins/support'
import QrcodeVue from 'qrcode.vue'
import { required, requiredIf } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
import { icon } from 'leaflet'
export default {
    name: 'ViewSupportTicketPage',
    mixins: [SupportMixin],
    components: {
        QrcodeVue,
    },
    setup() {
        return { v$: useVuelidate() }
    },
    created() {
        this.getDepartments()
        this.getEmployees()
        this.getPartners()
        this.getSupportTicket(this.$route.params.id)
    },
    data() {
        return {
            shareDialog: false,
            partnerContacts: [],
            shareUrl: '',
        }
    },

    validations() {
        return {
            supportTicket: {
                number: { required },
                subject: { required },
                status: { required },
                priority: { required },
                partner_id: { requiredIfNotCustomContact: requiredIf(!this.supportTicket.custom_contact) },
                contact_id: { requiredIfNotCustomContact: requiredIf(!this.supportTicket.custom_contact) },
                contact_name: { requiredIfCustomContact: requiredIf(this.supportTicket.custom_contact) },
                contact_email: { requiredIfCustomContact: requiredIf(this.supportTicket.custom_contact) },
            },
        }
    },

    watch: {
        'supportTicket.partner_id': function () {
            if (!this.supportTicket.custom_contact) {
                if (!this.supportTicket.partner_id) {
                    this.contact_id = null
                    return (this.partnerContacts = [])
                }
                this.partners.forEach((partner) => {
                    if (partner.id === this.supportTicket.partner_id) {
                        partner.contacts.forEach((contact) => {
                            this.partnerContacts.push({
                                id: contact.id,
                                name: `${contact.name} ${contact.email ? `(${contact.email})` : ''}`,
                            })
                        })
                    }
                })
            }
        },
    },

    methods: {
        validateForm() {
            this.v$.supportTicket.$touch()
            if (this.v$.supportTicket.$invalid) {
                this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
                return
            }

            return this.updateSupportTicket()
        },
    },
}
</script>
<style></style>
