<template>
    <user-layout>
        <div id="new_support_ticket">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('support.new_ticket')" />

                <div class="grid">
                    <!-- Metadata view -->
                    <div class="col-12 md:col-5">
                        <div class="formgrid card">
                            <TextInput id="number_input" v-model="supportTicket.number" disabled :label="$t('form.number')" />
                            <TextInput id="subject_input" v-model="supportTicket.subject" :label="$t('form.subject')" />
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
                            <SelectInput
                                id="partner_input"
                                v-model="supportTicket.partner_id"
                                :label="$t('form.partner')"
                                :options="partners"
                                optionLabel="name"
                                optionValue="id"
                                showClear
                                filter
                            />
                            <div class="grid">
                                <SelectInput
                                    id="status_input"
                                    v-model="supportTicket.status"
                                    class="col-12 md:col-6"
                                    :label="$t('form.status')"
                                    :options="[
                                        { label: $t('status.open'), value: 'open' },
                                        { label: $t('status.in_progress'), value: 'in_progress' },
                                        { label: $t('status.closed'), value: 'closed' },
                                        { label: $t('status.reopened'), value: 'reopened' },
                                        { label: $t('status.resolved'), value: 'resolved' },
                                    ]"
                                />
                                <SelectInput
                                    id="priority_input"
                                    v-model="supportTicket.priority"
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
                                />
                            </div>
                            <div class="grid">
                                <TextAreaInput id="notes_input" v-model="supportTicket.notes" class="col-12" :label="$t('form.notes')" />
                            </div>
                        </div>
                    </div>
                    <!-- Content view -->
                    <div class="col-12 md:col-7">
                        <div class="card">
                            <TinyMceEditor
                                id="message_input0'Đ
                            /7*"
                                v-model="supportTicket.content[0].message"
                                :label="$t('form.message')"
                            />
                        </div>
                    </div>
                </div>
                <div id="function_buttons" class="flex gap-2 justify-content-end ml-2">
                    <Button
                        id="cancel_button"
                        :label="$t('basic.cancel')"
                        icon="fa fa-times"
                        class="p-button-danger"
                        @click="goTo('/support')"
                    />
                    <Button
                        id="save_button"
                        :label="$t('basic.save')"
                        :disabled="loadingData"
                        icon="fa fa-floppy-disk"
                        class="p-button-success"
                        @click="createSupportTicket"
                    />
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import SupportMixin from '@/mixins/support'
export default {
    name: 'SupportTickets',
    mixins: [SupportMixin],
    created() {
        this.getSupportTicketNumber()
        this.getDepartments()
        this.getEmployees()
        this.getPartners()
    },
    methods: {},
}
</script>
<style></style>
