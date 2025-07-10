<template>
    <VuePdfApp style="height: 100vh" :pdf="pdf" v-model:theme="theme" :fileName="fileName" :config="config" />
</template>

<script>
import VuePdfApp from 'vue3-pdf-app'
import 'vue3-pdf-app/dist/icons/main.css'

export default {
    components: {
        VuePdfApp,
    },
    props: {
        pdf: {
            type: String,
            required: true,
        },
        fileName: {
            type: String,
            default: 'document.pdf',
        },
        config: {
            type: Object,
            default: () => ({
                sidebar: false,
                secondaryToolbar: false,
                toolbar: {
                    toolbarViewerLeft: {
                        findbar: false,
                        previous: true,
                        next: true,
                        pageNumber: true,
                    },
                    toolbarViewerRight: {
                        presentationMode: false,
                        openFile: false,
                        print: false,
                        download: true,
                        viewBookmark: false,
                    },
                    toolbarViewerMiddle: {
                        zoomOut: true,
                        zoomIn: true,
                        scaleSelectContainer: true,
                    },
                },
                errorWrapper: true,
            }),
        },
    },
}
</script>
