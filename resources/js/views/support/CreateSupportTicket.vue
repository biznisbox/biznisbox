<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('support.new_ticket')" />

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <!-- Metadata view -->
                <div class="col-span-1 md:col-span-4">
                    <div class="formgrid card">
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
                        />

                        <div id="partner_input">
                            <div class="flex flex-col gap-2 mb-2">
                                <label for="custom_partner_switch" class="dark:text-surface-200">{{ $t('form.custom_contact') }}</label>
                                <ToggleSwitch id="custom_partner_switch" v-model="supportTicket.custom_contact" />
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
                            />

                            <div v-if="supportTicket.custom_contact">
                                <TextInput
                                    id="contact_name_input"
                                    v-model="v$.supportTicket.contact_name.$model"
                                    :label="$t('form.contact_name')"
                                    :validate="v$.supportTicket.contact_name"
                                />
                                <TextInput
                                    id="contact_email_input"
                                    v-model="v$.supportTicket.contact_email.$model"
                                    :label="$t('form.contact_email')"
                                    :validate="v$.supportTicket.contact_email"
                                />
                                <TextInput
                                    id="contact_phone_input"
                                    v-model="supportTicket.contact_phone_number"
                                    :label="$t('form.contact_phone')"
                                />
                            </div>
                        </div>

                        <div class="grid">
                            <SelectInput
                                id="status_input"
                                v-model="v$.supportTicket.status.$model"
                                class="col-12 md:col-6"
                                :label="$t('form.status')"
                                :options="[
                                    { label: $t('status.open'), value: 'open' },
                                    { label: $t('status.in_progress'), value: 'in_progress' },
                                    { label: $t('status.closed'), value: 'closed' },
                                    { label: $t('status.reopened'), value: 'reopened' },
                                    { label: $t('status.resolved'), value: 'resolved' },
                                ]"
                                :validate="v$.supportTicket.status"
                            />
                            <SelectInput
                                id="priority_input"
                                v-model="v$.supportTicket.priority.$model"
                                class="col-12 md:col-6"
                                :label="$t('form.priority')"
                                :options="[
                                    { label: $t('support_priority.none'), value: 'none' },
                                    { label: $t('support_priority.low'), value: 'low' },
                                    { label: $t('support_priority.medium'), value: 'medium' },
                                    { label: $t('support_priority.normal'), value: 'normal' },
                                    { label: $t('support_priority.high'), value: 'high' },
                                    { label: $t('support_priority.urgent'), value: 'urgent' },
                                ]"
                                :validate="v$.supportTicket.priority"
                            />
                        </div>
                        <div class="grid">
                            <TextAreaInput id="notes_input" v-model="supportTicket.notes" class="col-12" :label="$t('form.notes')" />
                        </div>
                    </div>
                </div>
                <!-- Content view -->
                <div class="cols-span-1 md:col-span-8">
                    <div class="card">
                        <TinyMceEditor id="message_input" v-model="supportTicket.content[0].message" :label="$t('form.message')" />
                    </div>
                </div>
            </div>
            <div id="function_buttons" class="flex gap-2 justify-end ml-2">
                <Button id="cancel_button" :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="goTo('/support')" />
                <Button
                    id="save_button"
                    :label="$t('basic.save')"
                    :disabled="loadingData"
                    icon="fa fa-floppy-disk"
                    severity="success"
                    @click="validateForm"
                />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
import SupportMixin from '@/mixins/support'
import { required, requiredIf } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
export default {
    name: 'CreateSupportTicketPage',
    mixins: [SupportMixin],
    setup() {
        return { v$: useVuelidate() }
    },
    created() {
        this.getSupportTicketNumber()
        this.getDepartments()
        this.getEmployees()
        this.getPartners()
    },
    data() {
        return {
            partnerContacts: [],
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
            if (!this.supportTicket.partner_id) {
                this.contact_id = null
                return (this.partnerContacts = [])
            }
            this.partners.forEach((partner) => {
                if (partner.id === this.supportTicket.partner_id) {
                    partner.contacts.forEach((contact) => {
                        this.partnerContacts.push({
                            id: contact.id,
                            name: `${contact.name} ${contact.email}`,
                        })
                    })
                }
            })
        },
    },

    methods: {
        validateForm() {
            this.v$.supportTicket.$touch()
            if (this.v$.supportTicket.$invalid) {
                this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
                return
            }

            return this.createSupportTicket()
        },
    },
}
</script>
<style></style>
