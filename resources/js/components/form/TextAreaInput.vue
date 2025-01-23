<template>
    <div class="flex flex-col gap-2 mb-2">
        <label :for="id" class="dark:text-surface-200">{{ label }}</label>
        <Textarea
            :id="id"
            :name="id"
            :value="modelValue"
            :validate="validate"
            :disabled="disabled"
            :placeholder="placeholder"
            :invalid="validate?.$dirty && validate?.$invalid"
            :class="{ 'resizable-none': !resizable, resizable: resizable }"
            @input="updateValue"
            @blur="validate?.$touch()"
        />
        <div v-if="validate && validate?.$dirty && validate?.$invalid" class="flex flex-column">
            <div v-for="error in validate.$errors" v-bind:key="error?.$propertyPath" class="dark:text-red-400 text-red-500 text-sm">
                {{ error.$message }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'TextAreaInput',
    props: {
        id: {
            type: String,
            default: () => 'input_' + Math.random().toString(36).substring(2, 11),
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
