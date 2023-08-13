<template>
    <RouterLink :to="to" class="link-none-style">
        <Button :label="label" :icon="icon" :class="style" />
    </RouterLink>
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
            default: '',
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
