<template>
    <div class="flex flex-column mb-1">
        <label :for="id" class="block text-900 font-medium mb-1"> {{ label }} </label>
        <TextArea
            :id="id"
            :name="id"
            :value="modelValue"
            :validate="validate"
            :disabled="disabled"
            :placeholder="placeholder"
            :class="{ 'p-invalid': validate?.$invalid && validate?.$dirty, 'resizable-none': !resizable, resizable: resizable }"
            @input="updateValue"
            @blur="validate?.$touch()"
        />
        <div v-if="validate && validate?.$dirty" class="flex flex-column">
            <div v-for="error in validate.$errors" v-if="validate.$invalid" class="p-error">{{ error.$message }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'TextAreaInput',
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
        resizable: {
            type: Boolean,
            default: false,
        },
    },
    methods: {
        updateValue(event) {
            this.$emit('update:modelValue', event.target.value)
        },
    },
}
</script>

<style>
.resizable-none {
    resize: none;
}
.resizable {
    resize: both;
}
</style>
