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
            <div id="status_page" class="card">
                <DisplayData :value="version_info?.current_version" :input="$t('admin.status.app_version')" />

                <DisplayData :value="version_info?.latest_version" :input="$t('admin.status.latest_version')" />
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
