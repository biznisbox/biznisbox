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
    },
}
</script>

<style>
.spinner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1100;
}
</style>
