<template>
    <user-layout>
        <div id="edit_document_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="document.name" />

                <div class="card">
                    <form class="formgrid">
                        <div class="grid">
                            <TextInput
                                v-model="v$.document.number.$model"
                                :label="$t('document.number')"
                                class="col-12 md:col-6"
                                :validate="v$.document.number"
                                disabled
                            />
                            <TextInput
                                v-model="v$.document.name.$model"
                                :label="$t('document.name')"
                                class="col-12 md:col-6"
                                :validate="v$.document.name"
                            />
                        </div>

                        <div class="grid">
                            <SelectInput
                                v-model="v$.document.type.$model"
                                :label="$t('document.type')"
                                :options="[
                                    { label: $t('document.document'), value: 'document' },
                                    { label: $t('document.agreement'), value: 'agreement' },
                                    { label: $t('document.contract'), value: 'contract' },
                                    { label: $t('document.letter'), value: 'letter' },
                                    { label: $t('document.email'), value: 'email' },
                                    { label: $t('document.policy'), value: 'policy' },
                                    { label: $t('document.other'), value: 'other' },
                                ]"
                                class="col-12"
                                :validate="v$.document.type"
                            />
                        </div>

                        <div class="grid">
                            <DateInput v-model="document.date" :label="$t('document.date')" class="col-12 md:col-6" />
                            <DateInput v-model="document.due_date" :label="$t('document.due_date')" class="col-12 md:col-6" />
                        </div>

                        <div class="grid">
                            <SelectInput
                                v-model="document.status"
                                :label="$t('document.status')"
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
                                :label="$t('document.access')"
                                :options="[
                                    { label: $t('basic.private'), value: 'private' },
                                    { label: $t('basic.public'), value: 'public' },
                                    { label: $t('basic.shared'), value: 'shared' },
                                    { label: $t('basic.internal'), value: 'internal' },
                                ]"
                                class="col-12 md:col-4"
                            />

                            <TextInput v-model="document.version" :label="$t('document.version')" class="col-12 md:col-4" />
                        </div>

                        <div class="grid">
                            <TinyMceEditor v-model="document.content" :label="$t('document.content')" class="col-12" />
                        </div>

                        <div class="grid">
                            <TextAreaInput v-model="document.notes" :label="$t('document.notes')" class="col-12" />
                        </div>
                    </form>
                </div>

                <div id="function_buttons" class="flex gap-2 justify-content-end">
                    <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="goTo('/documents')" />
                    <Button
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
    name: 'EditDocument',
    mixins: [DocumentMixin],
    setup: () => ({ v$: useVuelidate() }),
    created() {
        this.getDocument(this.$route.params.id)
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

            return this.updateDocument(this.$route.params.id)
        },
    },
}
</script>

<style></style>
