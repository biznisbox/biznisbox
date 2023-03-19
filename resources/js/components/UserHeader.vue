<template>
    <div id="header" class="mb-3">
        <div class="flex card-container">
            <div class="flex align-items-center">
                <h3>{{ title }}</h3>
            </div>
            <div class="flex-grow-1"></div>
            <div class="flex gap-2 flex-wrap">
                <slot name="actions"></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UserHeader',
    props: {
        title: {
            type: String,
            default: '',
        },
    },
}
</script>

<style></style>
