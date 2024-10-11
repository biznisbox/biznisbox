<template>
    <div class="flex flex-col gap-2 mb-2">
        <label :for="id" class="dark:text-surface-200">{{ label }}</label>
        <Editor :id="id" ref="editor" v-model="contentValue" :init="init" model-events="change keydown blur focus paste" />
        <div v-if="validate && validate?.$dirty && validate?.$invalid" class="flex flex-column">
            <div v-for="error in validate.$errors" v-bind:key="error?.$propertyPath" class="text-red-500 text-sm">
                {{ error.$message }}
            </div>
        </div>
    </div>
</template>

<script>
// TinyMCE
import tinymce from 'tinymce/tinymce'
import 'tinymce/icons/default/icons'
import 'tinymce/themes/silver/theme'
import 'tinymce/models/dom/model'
import 'tinymce/skins/ui/oxide/skin.css'
import contentUiCss from 'tinymce/skins/ui/oxide/content.css?inline'

// TinyMCE plugins
// https://www.tiny.cloud/docs/tinymce/6/plugins/
import 'tinymce/plugins/lists/plugin'
import 'tinymce/plugins/link/plugin'
import 'tinymce/plugins/image/plugin'
import 'tinymce/plugins/table/plugin'
import 'tinymce/plugins/wordcount/plugin'
import 'tinymce/plugins/advlist/plugin'
import 'tinymce/plugins/autolink/plugin'
import 'tinymce/plugins/lists/plugin'
import 'tinymce/plugins/link/plugin'
import 'tinymce/plugins/anchor/plugin'
import 'tinymce/plugins/charmap/plugin'
import 'tinymce/plugins/insertdatetime/plugin'

// TinyMCE Vue component
import Editor from '@tinymce/tinymce-vue'

export default {
    name: 'TinyMceEditorComponent',
    components: {
        Editor,
    },

    props: {
        id: {
            type: String,
            default: 'input_' + Math.random().toString(36).substr(2, 9), // random generated
        },
        label: {
            type: String,
            default: '',
        },
        modelValue: {
            default: '',
        },
        validate: {
            type: Object,
            required: false,
            default: null,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        toolbar: {
            type: String,
            default:
                'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | fontselect fontsizeselect formatselect |forecolor backcolor removeformat | charmap |  bullist numlist outdent indent | link image table | wordcount | charmap insertdatetime',
        },
    },

    data() {
        return {
            contentValue: this.modelValue,
            init: {
                skin: false,
                content_css: false,
                content_style: contentUiCss,
                branding: false,
                plugins: 'lists link image table wordcount advlist autolink lists link anchor charmap insertdatetime',
                toolbar: this.toolbar,
                menubar: false,
                license_key: 'gpl',
                statusbar: false,
                paste_data_images: true,
                images_upload_handler: function (blobInfo, success, failure) {
                    let image = 'data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64()
                    success({ location: image })
                    failure('Error uploading image')
                },
            },
        }
    },

    watch: {
        modelValue: function (value) {
            this.contentValue = value
        },
        contentValue: function (value) {
            this.$emit('update:modelValue', value)
        },
    },

    mounted() {
        tinymce.init(this.init)
    },
}
</script>
