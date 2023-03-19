<template>
    <div class="flex flex-column mb-1">
        <label :for="id" class="block text-900 font-medium mb-1"> {{ label }} </label>
        <TextArea
            :id="id"
            :value="modelValue"
            :validate="validate"
            :show-errors="showErrors"
            :disabled="disabled"
            :placeholder="placeholder"
            :class="resizable == false ? 'resizable-none' : 'resizable'"
            @input="updateValue"
        />
        <div v-if="validate && showErrors">
            <div v-if="validate.$invalid" class="p-error">{{ validate.$errors[0].$message }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'TextAreaInput',
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
        showErrors: {
            type: Boolean,
            required: false,
            default: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        placeholder: {
            type: String,
            default: '',
        },
        resizable: {
            type: Boolean,
            default: false,
        },
    },
    methods: {
        updateValue(event) {
            this.$emit('update:modelValue', event.target.value)
        },
    },
}
</script>

<style>
.resizable-none {
    resize: none;
}
.resizable {
    resize: both;
}
</style>
