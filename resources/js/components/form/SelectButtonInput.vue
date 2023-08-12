<template>
    <div class="flex flex-column mb-1">
        <label :for="id" class="block text-900 font-medium mb-1"> {{ label }} </label>
        <SelectButton
            :id="id"
            :name="id"
            :model-value="modelValue"
            :options="options"
            :option-value="optionValue"
            :option-label="optionLabel"
            :validate="validate"
            :multiple="multiple"
            :disabled="disabled"
            :class="{ 'p-invalid': validate?.$invalid && validate?.$dirty }"
            @change="updateValue"
            @blur="validate?.$touch()"
        />
        <div v-if="validate && validate?.$dirty" class="flex flex-column">
            <div v-for="error in validate.$errors" v-if="validate.$invalid" class="p-error">{{ error.$message }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SelectButtonInputComponent',
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
