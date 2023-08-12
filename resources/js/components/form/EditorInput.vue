<template>
    <div class="flex flex-column mb-1">
        <label :for="id" class="block text-900 font-medium mb-1"> {{ label }} </label>
        <Editor
            :id="id"
            :name="id"
            :class="{ 'p-invalid': validate?.$invalid && validate?.$dirty }"
            :validate="validate"
            :model-value="modelValue"
            :readonly="readonly"
            editor-style="height: 150px"
            @text-change="updateValue"
        >
            <template #toolbar>
                <span class="ql-formats">
                    <button v-tooltip.bottom="'Bold'" class="ql-bold"></button>
                    <button v-tooltip.bottom="'Italic'" class="ql-italic"></button>
                    <button v-tooltip.bottom="'Underline'" class="ql-underline"></button>
                </span>
            </template>
        </Editor>
        <div v-if="validate && validate?.$dirty" class="flex flex-column">
            <div v-for="error in validate.$errors" v-if="validate.$invalid" class="p-error">{{ error.$message }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'EditorInputComponent',
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
            default: null,
        },
        validate: {
            type: Object,
            required: false,
            default: null,
        },
        readonly: {
            type: Boolean,
            required: false,
            default: false,
        },
    },
    methods: {
        updateValue(event) {
            this.$emit('update:modelValue', event.htmlValue)
        },
    },
}
</script>
