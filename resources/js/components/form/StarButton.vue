<template>
    <button
        type="button"
        class="p-button p-button-rounded p-button-text p-button-icon-only p-button-sm p-mr-2 p-button-outlined"
        :class="{ 'text-yellow-500': modelValue }"
        @click="toggleStar"
    >
        <i class="pi pi-star"></i>
    </button>
</template>

<script>
export default {
    props: ['modelValue'],
    methods: {
        toggleStar() {
            this.$emit('update:modelValue', !this.modelValue)
        },
    },
}
</script>
