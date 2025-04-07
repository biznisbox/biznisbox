<template>
    <div v-if="value !== null || (value == null && customValue)" class="mb-2" :id="`display_data_${input.toLowerCase()}`">
        <!-- Display the input inline with the value -->
        <div v-if="displayInline && !customValue" class="inline-flex items-center">
            <span class="font-bold mr-2">{{ input }}</span>
            <span>{{ value }}</span>
        </div>
        <!-- Display the input inline with a custom value -->
        <div v-if="displayInline && customValue" class="inline-flex items-center">
            <span class="font-bold mr-2">{{ input }}</span>
            <slot></slot>
        </div>

        <!-- Display the input and value in a block format -->
        <div v-if="!displayInline">
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
    </div>
</template>
<script>
export default {
    name: 'DisplayDataComponent',
    props: {
        input: {
            type: String,
        },
        value: {
            type: [String, Number, Boolean],
            default: null,
        },
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
        displayInline: {
            type: Boolean,
            default: false,
        },
    },
}
</script>
