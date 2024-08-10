<template>
    <DataTable
        :value="auditLogs"
        paginator
        dataKey="id"
        :rows="20"
        :rowsPerPageOptions="[5, 10, 20, 50, 100]"
        :loading="loadingData"
        filter-display="menu"
        size="small"
        v-model:expandedRows="expandedRows"
    >
        <template #empty>
            <div class="p-4 pl-0 text-center w-full">
                <i class="fa fa-info-circle empty-icon"></i>
                <p>{{ $t('audit_log.no_audit_logs') }}</p>
            </div>
        </template>

        <Column expander />
        <Column field="event" :header="$t('audit_log.event')">
            <template #body="{ data }">
                <Tag v-if="data.event === 'created'" :value="$t('audit_log_event.created')" severity="success" />
                <Tag v-else-if="data.event === 'updated'" :value="$t('audit_log_event.updated')" severity="warning" />
                <Tag v-else-if="data.event === 'deleted'" :value="$t('audit_log_event.deleted')" severity="danger" />
                <Tag v-else-if="data.event === 'retrieve'" :value="$t('audit_log_event.retrieved')" severity="info" />
                <Tag v-else-if="data.event === 'restored'" :value="$t('audit_log_event.restored')" severity="info" />
                <Tag v-else :value="data.event" />
            </template>
        </Column>

        <Column field="user" :header="$t('audit_log.user')">
            <template #body="{ data }">
                {{ data?.user?.full_name }}
            </template>
        </Column>

        <Column field="type" :header="$t('audit_log.type')">
            <template #body="{ data }">
                <Tag v-if="data.type === 'internal'" :value="$t('audit_log_type.internal')" severity="info" />
                <Tag v-else-if="data.type === 'external'" :value="$t('audit_log_type.external')" severity="warning" />
                <Tag v-else-if="data.type === 'system'" :value="$t('audit_log_type.system')" severity="success" />
                <Tag v-else-if="data.type === 'external_key'" :value="$t('audit_log_type.external_key')" severity="danger" />
                <Tag v-else :value="data.type" />
            </template>
        </Column>

        <Column field="created_at" :header="$t('audit_log.date_time')">
            <template #body="{ data }">
                {{ `${formatDateTime(data.created_at)} (${data.humanized_event_time})` }}
            </template>
        </Column>

        <template #expansion="slotProps">
            <div
                class="p-4"
                v-if="
                    slotProps.data.event === 'updated' ||
                    slotProps.data.event === 'deleted' ||
                    slotProps.data.event === 'restored' ||
                    slotProps.data.event === 'created'
                "
            >
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $t('audit_log.changes') }}</h3>
                    </div>
                </div>
                <div class="mt-4">
                    <h4 v-if="slotProps.data.event !== 'created'" class="text-base font-semibold">{{ $t('audit_log.old_values') }}</h4>
                    <ul>
                        <li v-for="(value, key) in slotProps.data.old_values" :key="key">
                            <div v-if="!hiddenFields.includes(key)">
                                <span class="font-semibold">{{ $t(`form.${key}`) }}:</span> <span v-html="value"></span> <br />
                            </div>
                        </li>
                    </ul>

                    <h4 class="text-base font-semibold mt-4">{{ $t('audit_log.new_values') }}</h4>
                    <ul>
                        <li v-for="(value, key) in slotProps.data.new_values" :key="key">
                            <div v-if="!hiddenFields.includes(key)">
                                <span class="font-semibold">{{ $t(`form.${key}`) }}:</span> <span v-html="value"></span> <br />
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </template>

        <template #paginatorstart>
            <Button icon="fa fa-sync" @click="getAuditLogs" id="refresh_button" />
        </template>
    </DataTable>
</template>
<script>
export default {
    name: 'AuditLogViewComponent',
    data() {
        return {
            auditLogs: [],
            expandedRows: [],
        }
    },

    props: {
        item_id: {
            type: String,
            required: true,
        },
        item_type: {
            type: String,
            required: true,
        },
        hiddenFields: {
            type: Array,
            default: [],
        },
    },

    mounted() {
        this.getAuditLogs()
    },
    methods: {
        getAuditLogs() {
            this.makeHttpRequest('GET', `/api/logs?item_id=${this.item_id}&item_type=${this.item_type}`).then((response) => {
                this.auditLogs = response.data.data
            })
        },
    },

    watch: {
        visible(val) {
            this.$emit('update:visible', val)
        },
    },
}
</script>
