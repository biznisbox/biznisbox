<template>
    <div class="flex flex-col gap-2">
        <label :for="id" class="dark:text-surface-200">{{ label }}</label>
        <Select
            :id="id"
            :name="id"
            :model-value="modelValue"
            :options="countries"
            option-value="name"
            option-label="name"
            :validate="validate"
            :multiple="multiple"
            :disabled="disabled"
            :filter="filter"
            :placeholder="placeholder"
            :editable="editable"
            :show-clear="showClear"
            :invalid="validate?.$dirty && validate?.$invalid"
            @change="updateValue"
            @blur="validate?.$touch()"
        >
            <template #value="slotProps">
                <div v-if="slotProps.value">
                    {{ $t(`countries.${slotProps.value}`) }}
                </div>
                <span v-else>
                    {{ slotProps.placeholder }}
                </span>
            </template>
            <template #option="slotProps">
                <span :class="`fi fi-${slotProps.option.iso2.toLowerCase()}`"></span>
                <span class="ml-2">{{ $t(`countries.${slotProps.option.name}`) }}</span>
            </template>
        </Select>
        <div v-if="validate && validate?.$dirty && validate.$invalid" class="flex flex-column">
            <div v-for="error in validate.$errors" v-bind:key="error?.$propertyPath" class="dark:text-red-400 text-red-500 text-sm">
                {{ error?.$message }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CountrySelectComponent',
    data() {
        return {
            countries: [],
        }
    },
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

    created() {
        this.makeHttpRequest('GET', '/api/countries?fields=iso2,iso3,region').then((response) => {
            this.countries = response.data.data
        })
    },
}
</script>

<style></style>
