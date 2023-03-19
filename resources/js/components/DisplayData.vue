<template>
    <div v-if="value !== null" class="mb-2">
        <div class="font-bold mb-1">
            {{ input }}
        </div>
        <div v-if="customValue">
            <slot></slot>
        </div>
        <div v-else-if="isLink">
            <a :href="!link ? value : link" target="_blank" class="text-blue-500 break_word">
                {{ value }}
            </a>
        </div>
        <div v-else class="text-gray-700 break_word">
            {{ value }}
        </div>
    </div>
</template>
<script>
// This component is used to display data from input fields
export default {
    name: 'DisplayData',
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
