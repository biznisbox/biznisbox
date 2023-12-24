<template>
    <user-layout>
        <div id="new_document_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('document.new_document')" />

                <div class="card">
                    <form class="formgrid">
                        <div class="grid">
                            <TextInput
                                v-model="v$.document.number.$model"
                                :label="$t('form.number')"
                                class="col-12 md:col-6"
                                disabled
                                :validate="v$.document.number"
                            />
                            <TextInput
                                v-model="v$.document.name.$model"
                                :label="$t('form.name')"
                                class="col-12 md:col-6"
                                :validate="v$.document.name"
                            />
                        </div>

                        <div class="grid">
                            <SelectInput
                                v-model="v$.document.type.$model"
                                :label="$t('form.type')"
                                :options="[
                                    { label: $t('document_types.document'), value: 'document' },
                                    { label: $t('document_types.agreement'), value: 'agreement' },
                                    { label: $t('document_types.contract'), value: 'contract' },
                                    { label: $t('document_types.letter'), value: 'letter' },
                                    { label: $t('document_types.email'), value: 'email' },
                                    { label: $t('document_types.policy'), value: 'policy' },
                                    { label: $t('basic.other'), value: 'other' },
                                ]"
                                class="col-12"
                                :validate="v$.document.type"
                            />
                        </div>

                        <div class="grid">
                            <DateInput v-model="document.date" :label="$t('form.date')" class="col-12 md:col-6" />
                            <DateInput v-model="document.due_date" :label="$t('form.due_date')" class="col-12 md:col-6" />
                        </div>

                        <div class="grid">
                            <SelectInput
                                v-model="document.status"
                                :label="$t('form.status')"
                                :options="[
                                    { label: $t('status.draft'), value: 'draft' },
                                    { label: $t('status.pending'), value: 'pending' },
                                    { label: $t('status.accepted'), value: 'accepted' },
                                    { label: $t('status.rejected'), value: 'rejected' },
                                ]"
                                class="col-12 md:col-4"
                            />

                            <SelectInput
                                v-model="document.access"
                                :label="$t('form.access')"
                                :options="[
                                    { label: $t('basic.private'), value: 'private' },
                                    { label: $t('basic.public'), value: 'public' },
                                    { label: $t('basic.internal'), value: 'internal' },
                                ]"
                                class="col-12 md:col-4"
                            />

                            <TextInput v-model="document.version" disabled :label="$t('form.version')" class="col-12 md:col-4" />
                        </div>

                        <div class="grid">
                            <TinyMceEditor v-model="document.content" :label="$t('form.content')" class="col-12" />
                        </div>

                        <div class="grid">
                            <TextAreaInput v-model="document.notes" :label="$t('form.notes')" class="col-12" />
                        </div>
                    </form>
                </div>

                <div id="function_buttons" class="flex gap-2 justify-content-end">
                    <Button
                        id="cancel_button"
                        :label="$t('basic.cancel')"
                        icon="fa fa-times"
                        class="p-button-danger"
                        @click="goTo('/documents')"
                    />
                    <Button
                        id="save_button"
                        :label="$t('basic.save')"
                        :disabled="loadingData"
                        icon="fa fa-floppy-disk"
                        class="p-button-success"
                        @click="validateForm"
                    />
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import { required } from '@vuelidate/validators'
import { useVuelidate } from '@vuelidate/core'
import DocumentMixin from '@/mixins/documents'
export default {
    name: 'NewDocumentPage',
    mixins: [DocumentMixin],

    setup: () => ({ v$: useVuelidate() }),
    created() {
        this.getDocumentNumber()
    },

    validations() {
        return {
            document: {
                number: { required },
                name: { required },
                type: { required },
            },
        }
    },

    methods: {
        validateForm() {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }
            return this.saveDocument()
        },
    },
}
</script>
