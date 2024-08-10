<template>
    <div v-if="value !== null" class="mb-2" :id="`display_data_${input.toLowerCase()}`">
        <div class="font-bold mb-1">
            {{ input }}
        </div>
        <div v-if="customValue">
            <slot></slot>
        </div>
        <div v-else-if="isLink">
            <a :href="!link ? value : link" target="_blank" class="text-blue-500 break-word">
                {{ value }}
            </a>
        </div>
        <div v-else class="break-word">
            {{ value }}
        </div>
    </div>
</template>
<script>
export default {
    name: 'DisplayDataComponent',
    props: {
        input: {
            type: String,
        },
        value: '',
        isLink: {
            type: Boolean,
            default: false,
        },
        link: {
            type: String,
        },
        customValue: {
            type: Boolean,
            default: false,
        },
    },
}
</script>
