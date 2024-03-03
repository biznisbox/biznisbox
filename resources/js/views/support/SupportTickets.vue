<template>
    <user-layout>
        <div id="support_tickets">
            <user-header :title="$t('support.support_tickets')">
                <template #actions>
                    <HeaderActionButton :label="$t('support.new_ticket')" icon="fa fa-plus" to="/support/new" />
                </template>
            </user-header>

            <div id="support_tickets_table" class="card">
                <DataTable
                    :value="supportTickets"
                    :loading="loadingData"
                    paginator
                    data-key="id"
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    @row-dblclick="viewSupportTicketNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('support.no_support_tickets') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('support.create_first_support_ticket')"
                                icon="fa fa-plus"
                                @click="$router.push('/support/new')"
                            />
                        </div>
                    </template>
                    <Column field="number" :header="$t('form.number')" />
                    <Column field="subject" :header="$t('form.subject')" />
                    <Column field="status" :header="$t('form.status')">
                        <template #body="{ data }">
                            <Badge v-if="data.status === 'open'" :value="$t('status.open')" class="p-badge-success" />
                            <Badge v-else-if="data.status === 'closed'" :value="$t('status.closed')" class="p-badge-danger" />
                            <Badge v-else-if="data.status === 'in_progress'" :value="$t('status.in_progress')" class="p-badge-warning" />
                            <Badge v-else-if="data.status === 'resolved'" :value="$t('status.resolved')" class="p-badge-info" />
                            <Badge v-else-if="data.status === 'reopened'" :value="$t('status.reopened')" class="p-badge-secondary" />
                        </template>
                    </Column>
                    <Column :header="$t('form.assigned_to')">
                        <template #body="{ data }">
                            <span v-if="data.assignee_id">{{ `${data.assignee.first_name} ${data.assignee.last_name}` }}</span>
                            <span v-else>-</span>
                        </template>
                    </Column>
                    <template #paginatorstart>
                        <Button
                            class="p-button-rounded p-button-text p-button-plain"
                            id="refresh_button"
                            icon="fa fa-sync"
                            @click="getSupportTickets"
                        />
                    </template>
                </DataTable>
            </div>
        </div>
    </user-layout>
</template>

<script>
import SupportMixin from '@/mixins/support'
export default {
    name: 'SupportTickets',
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
