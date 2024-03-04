<template>
    <user-layout>
        <div id="view_support_ticket">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('support.view_ticket')">
                    <template #actions>
                        <Button
                            id="delete_button"
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            class="p-button-danger"
                            @click="deleteSupportTicketAsk(supportTicket.id)"
                        />
                        <Button
                            id="share_ticket_button"
                            :label="$t('basic.share')"
                            icon="fa fa-share"
                            @click="shareSupportTicket(supportTicket.id)"
                        />
                        <SplitButton
                            id="more_options_button"
                            :label="$t('support.mark_as_resolved')"
                            icon="fa fa-check"
                            :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                            class="p-button-success"
                            :model="[
                                {
                                    label: $t('support.mark_as_resolved'),
                                    icon: 'fa fa-check',
                                    command: () => markSupportTicketAsResolved(),
                                },
                                { label: $t('support.mark_as_closed'), icon: 'fa fa-times', command: () => markSupportTicketAsClosed() },
                            ]"
                            @click="markSupportTicketAsResolved"
                        />

                        <Button
                            id="reopen_button"
                            :label="$t('support.reopen_ticket')"
                            icon="fa fa-undo"
                            :disabled="supportTicket.status !== 'closed' && supportTicket.status !== 'resolved'"
                            @click="markSupportTicketAsReopened"
                        />
                    </template>
                </user-header>

                <div class="grid">
                    <!-- Metadata view -->
                    <div class="col-12 md:col-5">
                        <div class="formgrid card">
                            <h1 class="text-xl font-bold mb-4">{{ $t('support.ticket_details') }}</h1>
                            <TextInput
                                id="number_input"
                                v-model="supportTicket.number"
                                disabled
                                :label="$t('form.number')"
                                :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                            />
                            <TextInput
                                id="subject_input"
                                v-model="supportTicket.subject"
                                :label="$t('form.subject')"
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
                            <SelectInput
                                id="partner_input"
                                v-model="supportTicket.partner_id"
                                :label="$t('form.partner')"
                                :options="partners"
                                optionLabel="name"
                                optionValue="id"
                                showClear
                                filter
                                :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
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
                                    :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
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
                                    :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                                />
                            </div>
                            <div class="grid">
                                <TextAreaInput
                                    id="notes_input"
                                    v-model="supportTicket.notes"
                                    class="col-12"
                                    :label="$t('form.notes')"
                                    :disabled="supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                                />
                            </div>

                            <div class="grid">
                                <Button
                                    id="save_button"
                                    :label="$t('basic.update')"
                                    :disabled="loadingData || supportTicket.status === 'closed' || supportTicket.status === 'resolved'"
                                    icon="fa fa-floppy-disk"
                                    class="p-button-success ml-2"
                                    @click="updateSupportTicket"
                                />
                            </div>
                        </div>
                    </div>
                    <!-- Content view -->
                    <div class="col-12 md:col-7">
                        <div class="card">
                            <h1 class="text-2xl font-bold mb-4">{{ $t('form.message') }}</h1>

                            <div v-for="(content, index) in supportTicket.content" :key="index">
                                <div id="content_{{ index }}" class="card p-4 mb-4">
                                    <!-- Header - menu (delete, edit) -->
                                    <div>
                                        <div class="flex justify-between">
                                            <div class="flex gap-2">
                                                <Button
                                                    v-if="supportTicket.status !== 'closed' && supportTicket.status !== 'resolved'"
                                                    icon="fa fa-trash"
                                                    class="p-button-danger p-button-outlined"
                                                    @click="deleteSupportTicketMessageAsk(content.id)"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div id="content_{{ index }}_from" class="mt-4" v-if="content.from !== null">
                                        <div v-if="content.from === 'system'">
                                            <b>{{ $t('form.from') }}: </b>
                                            <span class="p-badge p-badge-secondary">{{ $t('support.system') }}</span>
                                        </div>
                                        <div v-else>
                                            <b>{{ $t('form.from') }}: </b>
                                            <span class="p-badge p-badge-info">{{ content.from }}</span>
                                        </div>
                                    </div>

                                    <div id="content_{{ index }}_message" class="mt-4">
                                        <span v-if="content.type === 'text' && content.message" v-html="content.message"></span>
                                    </div>

                                    <!-- Footer - date -->
                                    <Badge
                                        v-if="content.created_at"
                                        :value="formatDateTime(content.created_at)"
                                        class="p-badge-secondary mt-2"
                                    />
                                </div>
                            </div>

                            <div>
                                <div
                                    id="new_replay"
                                    class="card p-4 mb-4"
                                    v-if="supportTicket.status !== 'closed' && supportTicket.status !== 'resolved'"
                                >
                                    <TinyMceEditor
                                        id="content_input"
                                        v-model="supportTicketMessage.message"
                                        :label="$t('form.new_replay')"
                                    />
                                    <Button
                                        id="add_content_button"
                                        :label="$t('basic.send')"
                                        icon="fa fa-paper-plane"
                                        @click="createSupportTicketMessage"
                                    />
                                </div>
                            </div>
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
                </div>
            </LoadingScreen>

            <!-- Share dialog -->
            <Dialog ref="shareDialog" v-model:visible="shareDialog" :header="$t('support.share_dialog')" modal>
                <div id="share_dialog_content">
                    <div class="text-center">{{ $t('support.share_dialog_text') }}</div>

                    <div class="text-center py-2">
                        <qrcode-vue :value="shareUrl" :size="140" level="H" />
                    </div>

                    <div class="flex gap-2 w-full">
                        <InputText v-model="shareUrl" class="w-full" />
                        <Button :label="$t('basic.copy')" icon="fa fa-copy" @click="copyToClipboard(shareUrl)" />
                    </div>
                </div>
                <template #footer>
                    <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="shareDialog = false" />
                </template>
            </Dialog>
        </div>
    </user-layout>
</template>

<script>
import SupportMixin from '@/mixins/support'
import QrcodeVue from 'qrcode.vue'
export default {
    name: 'SupportTickets',
    mixins: [SupportMixin],
    components: {
        QrcodeVue,
    },
    created() {
        this.getDepartments()
        this.getEmployees()
        this.getPartners()
        this.getSupportTicket(this.$route.params.id)
    },
    methods: {},
    data() {
        return {
            shareDialog: false,
        }
    },
}
</script>
<style></style>
