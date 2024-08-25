<template>
    <div class="flex flex-col gap-2 mb-2">
        <label :for="id" class="dark:text-surface-200">{{ label }}</label>
        <DatePicker
            :id="id"
            :name="id"
            :model-value="modelValue"
            :validate="validate"
            :disabled="disabled"
            :placeholder="placeholder"
            :min-date="minDate"
            :max-date="maxDate"
            :show-time="showTime"
            :hour-format="hourFormat"
            :date-format="dateFormat"
            :invalid="validate?.$dirty && validate?.$invalid"
            @date-select="updateValue"
            @blur="validate?.$touch()"
        />
        <div v-if="validate && validate?.$dirty && validate.$invalid" class="flex flex-column">
            <div v-for="error in validate.$errors" v-bind:key="error?.$propertyPath" class="text-red-500 text-sm">
                {{ error.$message }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'DateInputComponent',
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
        disabled: {
            type: Boolean,
            default: false,
        },
        placeholder: {
            type: String,
            default: '',
        },
        minDate: {
            type: [String, Date],
            default: null,
        },
        maxDate: {
            type: [String, Date],
            default: null,
        },
        showTime: {
            type: Boolean,
            default: false,
        },
        hourFormat: {
            type: String,
            default: '24',
        },
        dateFormat: {
            type: String,
            default: 'dd.mm.yy',
        },
    },
    methods: {
        updateValue(event) {
            this.$emit('update:modelValue', event)
        },
    },
}
</script>
