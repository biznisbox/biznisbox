<template>
    <DefaultLayout menu_type="admin">
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('admin.status.title')" />

            <Message severity="success" v-if="!version_info?.is_up_to_date">
                <div class="flex items-center justify-end">
                    <p>{{ $t('admin.status.new_version_available') }}</p>

                    <Button @click="showChangelogDialog" type="primary" icon class="ml-2 end-0">
                        <i class="fas fa-info-circle"></i>
                    </Button>
                </div>
            </Message>
            <div id="version_data_card" class="card">
                <DisplayData :value="version_info?.current_version" :input="$t('admin.status.app_version')" />

                <DisplayData :value="version_info?.latest_version" :input="$t('admin.status.latest_version')" />
            </div>

            <div id="storage_used_card" class="card mt-4">
                <DisplayData :value="status_info?.php_version" :input="$t('admin.status.php_version')" />

                <DisplayData :value="status_info?.server_software" :input="$t('admin.status.server_software')" />

                <DisplayData :value="status_info?.database_connection" :input="$t('admin.status.database_connection')" />

                <DisplayData :value="status_info?.database_version" :input="$t('admin.status.database_version')" />

                <DisplayData
                    :value="status_info?.storage_limit == -1 ? $t('admin.status.unlimited') : formatFileSize(status_info?.storage_limit)"
                    :input="$t('admin.status.storage_limit')"
                />

                <DisplayData :value="formatFileSize(status_info?.storage_used)" :input="$t('admin.status.storage_used')" />

                <DisplayData
                    v-if="status_info?.storage_limit != -1"
                    :value="formatFileSize(status_info?.storage_free)"
                    :input="$t('admin.status.storage_free')"
                />

                <DisplayData
                    v-if="status_info?.storage_limit != -1"
                    :value="status_info?.storage_usage_percentage + '%'"
                    :input="$t('admin.status.storage_usage_percentage')"
                />
            </div>
        </LoadingScreen>

        <!-- Changelog dialog -->
        <Dialog v-model:visible="showChangelog" @close="showChangelog = false" modal :header="$t('admin.status.changelog')">
            <div class="changelog" v-html="version_info?.changelog"></div>
        </Dialog>
    </DefaultLayout>
</template>

<script>
import StatusPageMixin from '@/mixins/admin/status'
export default {
    name: 'AdminStatusPage',
    mixins: [StatusPageMixin],

    data() {
        return {
            showChangelog: false,
        }
    },

    created() {
        this.getVersion()
        this.getStatus()
    },
    methods: {
        showChangelogDialog() {
            this.showChangelog = true
        },
    },
}
</script>

<style>
.changelog {
    font-size: 14px;
    line-height: 1.5;
}

.dark .changelog {
    color: var(--surface-200);
}

.changelog h1 {
    font-size: 18px;
    margin-bottom: 10px;
}

.changelog h2 {
    font-size: 16px;
    margin-bottom: 10px;
}

.changelog h3 {
    font-size: 14px;
    margin-bottom: 10px;
}

.changelog p {
    margin-bottom: 10px;
}

.changelog ul {
    padding: 0 20px;
    margin-bottom: 10px;
}

.changelog ul li {
    list-style: circle;
    margin-bottom: 5px;
}

.changelog a {
    color: var(--blue-500);
}

.changelog a:hover {
    color: var(--blue-400);
}
</style>
