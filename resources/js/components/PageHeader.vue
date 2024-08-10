<template>
    <div id="header" class="mb-3">
        <div class="flex place-items-center">
            <div class="flex font-semibold text-xl">
                <h3>{{ title }}</h3>
            </div>
            <div class="grow"></div>
            <div class="flex gap-2 flex-wrap">
                <slot name="actions"></slot>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'PageHeader',
    props: {
        title: {
            type: String,
            required: true,
        },
    },
}
</script>
