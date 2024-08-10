<template>
    <button type="button" :class="{ 'text-yellow-500': modelValue }" @click="toggleStar">
        <i class="fa fa-star"></i>
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
