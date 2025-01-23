<template>
    <button type="button" :class="{ 'text-yellow-500': modelValue }" @click="toggleStar" :id="inputId">
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

    data() {
        return {
            inputId: 'star_button_' + Math.random().toString(36).substring(2, 11),
        }
    },
}
</script>
