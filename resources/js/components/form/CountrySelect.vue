<template>
    <div class="flex flex-column mb-1">
        <label :for="id" class="block text-900 font-medium mb-1"> {{ label }} </label>
        <Dropdown
            :id="id"
            :model-value="modelValue"
            :options="countries"
            option-value="name"
            option-label="name"
            :validate="validate"
            :show-errors="showErrors"
            :multiple="multiple"
            :disabled="disabled"
            :filter="filter"
            :placeholder="placeholder"
            :editable="editable"
            :show-clear="showClear"
            @change="updateValue"
        >
            <template #value="slotProps">
                <div v-if="slotProps.value">
                    <span>{{ $t('countries.' + slotProps.value) }}</span>
                </div>
                <span v-else>
                    {{ slotProps.placeholder }}
                </span>
            </template>
            <template #option="slotProps">
                <div>
                    <span :class="'fi fi-' + slotProps.option.code.toLowerCase()"></span>
                    <span class="ml-2">{{ $t('countries.' + slotProps.option.name) }}</span>
                </div>
            </template>
        </Dropdown>
        <div v-if="validate && showErrors">
            <div v-if="validate.$invalid" class="p-error">{{ validate.$errors[0].$message }}</div>
        </div>
    </div>
</template>

<script>
import countries from '@/data/country.json'
export default {
    name: 'TextInputComponent',
    props: {
        id: {
            type: String,
            default: 'country_input_' + Math.random().toString(36).substr(2, 9), // random generated
        },
        label: {
            type: String,
            default: 'Country',
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
        multiple: {
            type: Boolean,
            default: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        filter: {
            type: Boolean,
            default: true,
        },
        placeholder: {
            type: String,
            default: 'Select a country',
        },
        editable: {
            type: Boolean,
            default: false,
        },
        showClear: {
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
