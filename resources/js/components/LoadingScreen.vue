<template>
    <BlockUI :blocked="blocked">
        <ProgressSpinner v-if="blocked" class="spinner" />
        <slot></slot>
    </BlockUI>
</template>

<script>
export default {
    name: 'LoadingScreenComponent',
    props: {
        blocked: {
            type: Boolean,
            default: false,
        },
        modelValue: {
            type: Boolean,
            default: false,
        },
    },
}
</script>

<style>
.spinner {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    width: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
</style>
