<template>
    <div class="flex flex-column mb-1">
        <label :for="id" class="block text-900 font-medium mb-1"> {{ label }} </label>
        <Password
            :id="id"
            :model-value="modelValue"
            :validate="validate"
            :show-errors="showErrors"
            :disabled="disabled"
            :placeholder="placeholder"
            input-class="w-full"
            :feedback="feedback"
            :toggle-mask="true"
            :input-id="id"
            @input="updateValue"
        />
        <div v-if="validate && showErrors">
            <div v-if="validate.$invalid" class="p-error">{{ validate.$errors[0]?.$message }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PasswordInputComponent',
    props: {
        id: {
            type: String,
            default: 'input_' + Math.random().toString(36).substr(2, 9), // random generated
        },
        label: {
            type: String,
            default: '',
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
        feedback: {
            type: Boolean,
            default: false,
        },
        toggleMask: {
            type: Boolean,
            default: false,
        },
        modelValue: {
            type: String,
            default: '',
        },
    },
    methods: {
        updateValue(event) {
            this.$emit('update:modelValue', event.target.value)
        },
    },
}
</script>

<style></style>
