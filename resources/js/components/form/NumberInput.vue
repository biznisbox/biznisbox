<template>
    <div class="flex flex-col gap-2 mb-2">
        <label :for="id" class="dark:text-surface-200">{{ label }}</label>
        <InputNumber
            v-if="type == 'number'"
            :id="id"
            :name="id"
            :model-value="modelValue"
            :validate="validate"
            :disabled="disabled"
            :invalid="validate?.$dirty && validate?.$invalid"
            @input="updateValue"
            @blur="validate?.$touch()"
            inputClass="w-full"
        />

        <InputNumber
            v-if="type == 'float'"
            :id="id"
            :name="id"
            :model-value="modelValue"
            mode="decimal"
            :min-fraction-digits="minFraction"
            :max-fraction-digits="maxFraction"
            :validate="validate"
            :disabled="disabled"
            :invalid="validate?.$dirty && validate?.$invalid"
            @input="updateValue"
            @blur="validate?.$touch()"
            inputClass="w-full"
        />

        <InputNumber
            v-if="type == 'currency'"
            :id="id"
            :name="id"
            :model-value="modelValue"
            mode="currency"
            :currency="currency"
            :locale="locale"
            :validate="validate"
            :disabled="disabled"
            :invalid="validate?.$dirty && validate?.$invalid"
            @input="updateValue"
            @blur="validate?.$touch()"
            inputClass="w-full"
        />

        <InputNumber
            v-if="type == 'percentage'"
            :id="id"
            :name="id"
            :model-value="modelValue"
            mode="decimal"
            :min-fraction-digits="0"
            :max-fraction-digits="2"
            :validate="validate"
            :disabled="disabled"
            :invalid="validate?.$dirty && validate?.$invalid"
            @input="updateValue"
            @blur="validate?.$touch()"
            inputClass="w-full"
        />

        <InputNumber
            v-if="type == 'items'"
            :id="id"
            :name="id"
            :model-value="modelValue"
            :validate="validate"
            show-buttons
            :disabled="disabled"
            :invalid="validate?.$dirty && validate?.$invalid"
            @blur="validate?.$touch()"
            @input="updateValue"
            inputClass="w-full"
        />

        <div v-if="validate && validate?.$dirty && validate?.$invalid" class="flex flex-column">
            <div v-for="error in validate.$errors" v-bind:key="error?.$propertyPath" class="text-red-500 text-sm">
                {{ error.$message }}
            </div>
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
            default: 'en-US', // "fi-FI" or "fi" or "en-US" or "en"
        },
        currency: {
            type: String,
            default: 'EUR', // Integer or String (EUR, USD, etc.)
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
