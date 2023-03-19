<template>
    <div class="flex flex-column mb-1">
        <label :for="id" class="block text-900 font-medium mb-1"> {{ label }} </label>
        <InputNumber
            v-if="type == 'number'"
            :id="id"
            :model-value="modelValue"
            :validate="validate"
            :show-errors="showErrors"
            :disabled="disabled"
            @input="updateValue"
        />

        <InputNumber
            v-if="type == 'float'"
            :id="id"
            :model-value="modelValue"
            mode="decimal"
            :min-fraction-digits="minFraction"
            :max-fraction-digits="maxFraction"
            :validate="validate"
            :show-errors="showErrors"
            :disabled="disabled"
            @input="updateValue"
        />

        <InputNumber
            v-if="type == 'currency'"
            :id="id"
            :model-value="modelValue"
            mode="currency"
            :currency="currency"
            :locale="locale"
            :validate="validate"
            :show-errors="showErrors"
            :disabled="disabled"
            @input="updateValue"
        />

        <InputNumber
            v-if="type == 'percentage'"
            :id="id"
            :model-value="modelValue"
            mode="decimal"
            :min-fraction-digits="0"
            :max-fraction-digits="2"
            :validate="validate"
            :show-errors="showErrors"
            :disabled="disabled"
            @input="updateValue"
        />

        <InputNumber
            v-if="type == 'items'"
            :id="id"
            :model-value="modelValue"
            :validate="validate"
            :show-errors="showErrors"
            show-buttons
            :disabled="disabled"
            @input="updateValue"
        />

        <div v-if="validate && showErrors">
            <div v-if="validate.$invalid" class="p-error">{{ validate.$errors[0].$message }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'NumberInputComponent',
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
        type: {
            type: String,
            default: 'number', // currency, number, integer, percent, item
        },
        maxFraction: {
            type: Number,
            default: 0,
        },
        minFraction: {
            type: Number,
            default: 0,
        },
        locale: {
            type: String,
            default: 'en-US', // "fi-FI" or "fi"
        },
        currency: {
            type: String,
            default: 'EUR', // Integer or “XOF” for CFA Franc BCEAO (West African CFA franc)
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    },
    methods: {
        updateValue(event) {
            this.$emit('update:modelValue', event.value)
        },
    },
}
</script>

<style></style>
