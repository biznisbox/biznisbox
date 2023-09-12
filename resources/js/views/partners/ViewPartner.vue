<template>
    <user-layout>
        <div id="view_partner_page"></div>
    </user-layout>
</template>

<script>
import PartnerMixin from '@/mixins/partners'
export default {
    name: 'ViewPartnerPage',
    mixins: [PartnerMixin],
    created() {
        this.getPartner(this.$route.params.id)
    },
}
</script>
