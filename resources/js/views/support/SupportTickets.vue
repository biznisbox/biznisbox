<template>
    <DefaultLayout>
        <PageHeader :title="$t('support.support_tickets')">
            <template #actions>
                <Button icon="fa fa-plus" @click="$router.push('/support/create')" :label="$t('support.new_ticket')" />
            </template>
        </PageHeader>

        <div id="support_tickets_table" class="card">
            <DataTable
                :value="supportTickets"
                :loading="loadingData"
                paginator
                data-key="id"
                :rows="10"
                :rows-per-page-options="[10, 20, 50]"
                @row-dblclick="viewSupportTicketNavigation"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('support.no_support_tickets') }}</p>
                        <Button
                            class="mt-3"
                            :label="$t('support.create_first_support_ticket')"
                            icon="fa fa-plus"
                            @click="$router.push('/support/create')"
                        />
                    </div>
                </template>
                <Column field="number" :header="$t('support.ticket_number_and_subject')">
                    <template #body="{ data }">
                        <span>{{ data.number }}</span>
                        <br />
                        <span
                            ><b>{{ data.subject }}</b></span
                        >
                    </template>
                </Column>
                <Column field="status" :header="$t('support.status_and_priority')">
                    <template #body="{ data }">
                        <div class="flex items-center my-2">
                            <Tag v-if="data.status === 'open'" :value="$t('status.open')" severity="success" />
                            <Tag v-else-if="data.status === 'closed'" :value="$t('status.closed')" severity="danger" />
                            <Tag v-else-if="data.status === 'in_progress'" :value="$t('status.in_progress')" severity="warning" />
                            <Tag v-else-if="data.status === 'resolved'" :value="$t('status.resolved')" severity="info" />
                            <Tag v-else-if="data.status === 'reopened'" :value="$t('status.reopened')" severity="secondary" />
                        </div>

                        <div class="flex items-center my-2">
                            <Tag v-if="data.priority === 'none'" :value="$t('support_priority.none')" severity="secondary" />
                            <Tag v-else-if="data.priority === 'low'" :value="$t('support_priority.low')" severity="info" />
                            <Tag v-else-if="data.priority === 'medium'" :value="$t('support_priority.medium')" severity="warning" />
                            <Tag v-else-if="data.priority === 'normal'" :value="$t('support_priority.normal')" severity="success" />
                            <Tag v-else-if="data.priority === 'high'" :value="$t('support_priority.high')" severity="danger" />
                            <Tag v-else-if="data.priority === 'urgent'" :value="$t('support_priority.urgent')" severity="danger" />
                        </div>
                    </template>
                </Column>
                <Column :header="$t('form.contact')">
                    <template #body="{ data }">
                        <!-- Partner  is in system -->
                        <span v-if="data.partner_id">{{ data.partner?.name }}</span>
                        <!-- Custom partner -->
                        <span v-else-if="data.custom_contact">{{ `${data.contact_name}` }}</span>
                        <span v-else>-</span>
                    </template>
                </Column>
                <Column :header="$t('form.assigned_to')">
                    <template #body="{ data }">
                        <span v-if="data.assignee_id">{{ `${data.assignee?.first_name} ${data.assignee?.last_name}` }}</span>
                        <span v-else>-</span>
                    </template>
                </Column>
                <template #paginatorstart>
                    <Button id="refresh_button" icon="fa fa-sync" @click="getSupportTickets" />
                </template>
            </DataTable>
        </div>
    </DefaultLayout>
</template>

<script>
import SupportMixin from '@/mixins/support'
export default {
    name: 'SupportTicketsPage',
    mixins: [SupportMixin],
    created() {
        this.getSupportTickets()
    },
    methods: {
        viewSupportTicketNavigation(rowData) {
            this.$router.push(`/support/${rowData.data.id}`)
        },
    },
}
</script>
<style></style>
