<template>
    <div class="flex flex-col gap-2 mb-2">
        <label :for="id" class="dark:text-surface-200">{{ label }}</label>
        <TreeSelect
            :id="id"
            :name="id"
            :model-value="modelValue"
            :options="options"
            :option-value="optionValue"
            :option-label="optionLabel"
            :validate="validate"
            :disabled="disabled"
            :filter="filter"
            :placeholder="placeholder"
            :editable="editable"
            :show-clear="showClear"
            :selection-mode="selectionMode"
            :invalid="validate?.$dirty && validate?.$invalid"
            @change="updateValue"
            @blur="validate?.$touch()"
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
    name: 'TreeSelectInputComponent',
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
        options: {
            type: Array,
            default: () => [],
        },
        optionLabel: {
            type: String,
            default: 'label',
        },
        optionValue: {
            type: String,
            default: 'value',
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        filter: {
            type: Boolean,
            default: false,
        },
        placeholder: {
            type: String,
            default: '',
        },
        editable: {
            type: Boolean,
            default: false,
        },
        showClear: {
            type: Boolean,
            default: false,
        },
        selectionMode: {
            type: String,
            default: 'single',
        },
    },
    methods: {
        updateValue(event) {
            this.$emit('update:modelValue', event)
        },
    },
}
</script>
