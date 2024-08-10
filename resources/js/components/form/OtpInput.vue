<template>
    <div class="flex flex-col gap-2 mb-2">
        <label :for="id" class="dark:text-surface-200">{{ label }}</label>
        <InputOtp
            :id="id"
            :name="id"
            :v-model="modelValue"
            :validate="validate"
            :disabled="disabled"
            :invalid="validate?.$dirty && validate?.$invalid"
            @change="updateValue"
            @blur="validate?.$touch()"
            :length="length"
        />
        <div v-if="validate && validate?.$dirty" class="flex flex-column">
            <div v-if="validate.$invalid" v-for="error in validate.$errors" class="text-red-500 text-sm">
                {{ error.$message }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'OtpInputComponent',
    props: {
        id: {
            type: String,
            default: 'input_' + Math.random().toString(36).substr(2, 9), // random generated
        },
        type: {
            type: String,
            default: 'text',
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
        disabled: {
            type: Boolean,
            default: false,
        },
        length: {
            type: Number,
            default: 6,
        },
    },
    methods: {
        updateValue(event) {
            this.$emit('update:modelValue', event.value)
        },
    },
}
</script>
