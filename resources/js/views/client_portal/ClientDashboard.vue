<template>
    <DefaultLayout menu_type="client">
        <PageHeader :title="$t('client_portal.dashboard')" />
    </DefaultLayout>
</template>
<script>
export default {
    name: 'ClientPortalDashboard',
    data() {
        return {
            partner: null,
        }
    },

    methods: {
        getPartnerData() {
            this.makeHttpRequest('GET', '/api/client-portal/dashboard').then((response) => {
                this.partner = response.data.data
            })
        },
    },

    created() {
        this.getPartnerData()
    },
}
</script>
