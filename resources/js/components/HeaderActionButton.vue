<template>
    <router-link :to="to" class="link-none-style">
        <Button :label="label" :icon="icon" :class="style" />
    </router-link>
</template>

<script>
export default {
    name: 'HeaderActionButton',

    props: {
        label: {
            type: String,
            default: '',
        },
        icon: {
            type: String,
        },
        to: {
            type: String,
            default: '/',
        },
        style: {
            type: String,
            default: '',
        },
    },
}
</script>

<style></style>
