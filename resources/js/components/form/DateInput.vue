<template>
    <div class="flex flex-column mb-1">
        <label :for="id" class="block text-900 font-medium mb-1"> {{ label }} </label>
        <Calendar
            :id="id"
            :model-value="modelValue"
            :validate="validate"
            :show-errors="showErrors"
            :disabled="disabled"
            :placeholder="placeholder"
            :min-date="minDate"
            :max-date="maxDate"
            :show-time="showTime"
            :hour-format="hourFormat"
            :date-format="dateFormat"
            @date-select="updateValue"
        />
        <div v-if="validate && showErrors">
            <div v-if="validate.$invalid" class="p-error">{{ validate.$errors[0].$message }}</div>
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

<style></style>
