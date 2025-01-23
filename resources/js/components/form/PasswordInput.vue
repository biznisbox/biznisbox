<template>
    <div class="flex flex-col gap-2 mb-2">
        <label :for="id" class="dark:text-surface-200">{{ label }}</label>
        <Password
            :id="id"
            :name="id"
            :model-value="modelValue"
            :validate="validate"
            :disabled="disabled"
            :placeholder="placeholder"
            input-class="w-full"
            :feedback="feedback"
            :toggle-mask="true"
            :input-id="id"
            :invalid="validate?.$dirty && validate?.$invalid"
            @input="updateValue"
            @blur="validate?.$touch()"
            :inputProps="{ autocomplete: autocomplete }"
        />
        <div v-if="validate && validate?.$dirty && validate?.$invalid" class="flex flex-column">
            <div v-for="error in validate.$errors" v-bind:key="error?.$propertyPath" class="dark:text-red-400 text-red-500 text-sm">
                {{ error?.$message }}
            </div>
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
        autocomplete: {
            type: String,
            default: 'current-password',
        },
    },
    methods: {
        updateValue(event) {
            this.$emit('update:modelValue', event.target.value)
        },
    },
}
</script>
