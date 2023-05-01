<template>
    <user-layout>
        <div id="view_document_page"></div>
    </user-layout>
</template>

<script>
import DocumentsMixin from '@/mixins/documents'
export default {
    name: 'ViewDocumentPage',
    mixins: [DocumentsMixin],

    data() {
        return {
            document_id: this.$route.params.id,
            document: null,
        }
    },

    created() {
        this.getDocument(this.document_id)
    },
}
</script>

<style></style>
