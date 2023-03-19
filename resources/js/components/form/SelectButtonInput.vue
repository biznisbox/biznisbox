<template>
    <div class="flex flex-column mb-1">
        <label :for="id" class="block text-900 font-medium mb-1"> {{ label }} </label>
        <SelectButton
            :id="id"
            :model-value="modelValue"
            :options="options"
            :option-value="optionValue"
            :option-label="optionLabel"
            :validate="validate"
            :show-errors="showErrors"
            :multiple="multiple"
            :disabled="disabled"
            @change="updateValue"
        />
        <div v-if="validate && showErrors">
            <div v-if="validate.$invalid" class="p-error">{{ validate.$errors[0].$message }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'TextInputComponent',
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
        options: {
            type: Array,
            default: [],
        },
        optionLabel: {
            type: String,
            default: 'label',
        },
        optionValue: {
            type: String,
            default: 'value',
        },
        multiple: {
            type: Boolean,
            default: false,
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
