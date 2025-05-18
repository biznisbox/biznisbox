<template>
    <DefaultLayout menu_type="client">
        <PageHeader :title="$t('client_portal.partner_details')" />

        
    </DefaultLayout>
</template>
<script>
export default {
    name: 'ClientPortalPartnerDetails',
    data() {
        return {
            partner: null,
        }
    },

    methods: {
        getPartnerData() {
            this.makeHttpRequest('GET', '/api/client-portal/partner-details').then((response) => {
                this.partner = response.data.data
            })
        },
    },

    created() {
        this.getPartnerData()
    },
}
</script>
