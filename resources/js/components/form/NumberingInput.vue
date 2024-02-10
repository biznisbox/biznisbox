<template>
    <Button :label="$t('basic.add')" icon="fa fa-plus" @click="addNumbering" />
    <div v-for="(format, index) in modelValue" :key="index">
        <div :id="`modelValue_${index}`" class="flex gap-2 py-2">
            <Button icon="fa fa-arrows" class="p-button-info" @click="moveNumbering(index, 'up')" />
            <SelectInput
                v-model="format.type"
                :options="[
                    { label: $t('form.text'), value: 'TEXT' },
                    { label: $t('form.number'), value: 'NUMBER' },
                    { label: $t('form.delimiter'), value: 'DELIMITER' },
                    { label: $t('form.date'), value: 'DATE' },
                ]"
            />
            <TextInput v-if="format.type !== 'DELIMITER'" v-model="format.value" />
            <Button icon="fa fa-trash" class="p-button-danger" @click="deleteNumbering(index)" />
        </div>

        <div v-if="index === modelValue.length - 1">
            <TextInput v-model="previewText" aria-disabled="true" disabled />
        </div>
    </div>
</template>
<script>
import moment from 'moment'
export default {
    name: 'NumberingInput',
    props: {
        modelValue: {
            default: null,
            type: Array,
        },
        id: {
            type: String,
            default: 'input_' + Math.random().toString(36).substr(2, 9), // random generated
        },
    },

    data() {
        return {
            previewText: '',
        }
    },
    watch: {
        modelValue: {
            handler() {
                this.updateValue()
            },
            deep: true,
        },
    },

    methods: {
        updateValue() {
            this.previewText = ''
            this.generatePreview()
            // Emit the update event with the modified modelValue
            this.$emit('update:modelValue', this.modelValue)
        },

        moveNumbering(index, direction) {
            if (direction === 'up') {
                if (index === 0) {
                    return
                }
                const temp = this.modelValue[index]
                this.modelValue[index] = this.modelValue[index - 1]
                this.modelValue[index - 1] = temp
            } else {
                if (index === this.modelValue.length - 1) {
                    return
                }
                const temp = this.modelValue[index]
                this.modelValue[index] = this.modelValue[index + 1]
                this.modelValue[index + 1] = temp
            }
            this.updateValue()
        },

        addNumbering() {
            this.modelValue.push({
                type: 'TEXT',
                value: '',
            })
            this.updateValue()
        },

        deleteNumbering(index) {
            this.modelValue.splice(index, 1)
            this.updateValue()
        },

        generatePreview() {
            let preview = ''
            for (const format of this.modelValue) {
                if (format.type === 'TEXT') {
                    preview += format.value
                } else if (format.type === 'NUMBER') {
                    const number = '45'
                    preview += number.padStart(format.value, '0')
                } else if (format.type === 'DELIMITER') {
                    preview += '-'
                } else if (format.type === 'DATE') {
                    preview += moment().format(format.value)
                }
            }
            return (this.previewText = preview)
        },
    },
}
</script>
