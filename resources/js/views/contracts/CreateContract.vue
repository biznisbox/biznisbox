<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('contract.create_contract')" />

            <div class="card">
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <TextInput v-model="v$.contract.number.$model" :label="$t('form.number')" :validate="v$.contract.number" disabled />
                        <SelectInput
                            v-model="v$.contract.status.$model"
                            :label="$t('form.status')"
                            :options="[
                                { label: $t('status.draft'), value: 'draft' },
                                { label: $t('status.waiting_signers'), value: 'waiting_signers' },
                                { label: $t('status.signed'), value: 'signed' },
                                { label: $t('status.rejected'), value: 'rejected' },
                                { label: $t('status.cancelled'), value: 'cancelled' },
                                { label: $t('status.expired'), value: 'expired' },
                            ]"
                            :validate="v$.contract.status"
                        />
                    </div>

                    <div>
                        <TextInput v-model="v$.contract.title.$model" :label="$t('form.title')" :validate="v$.contract.title" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <SelectInput
                            v-model="contract.partner_id"
                            :label="$t('form.partner')"
                            :options="partners"
                            option-value="id"
                            option-label="name"
                            filter
                            showClear
                        />
                        <SelectInput
                            v-model="contract.category_id"
                            :label="$t('form.contract_type')"
                            filter
                            :options="contractTypes"
                            option-value="id"
                            option-label="name"
                            showClear
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <DateInput v-model="contract.start_date" :label="$t('form.date')" />
                        <DateInput v-model="contract.end_date" :label="$t('form.end_date')" />
                        <DateInput v-model="contract.date_for_signature" :label="$t('form.date_for_signature')" />
                    </div>

                    <div id="signers_table" class="overflow-x-auto">
                        <div class="py-2">
                            <Button :label="$t('basic.add_signer')" icon="fa fa-plus" @click="addSigner" />
                        </div>
                        <DataTable class="overflow-x-auto" :value="contract.signers" @row-reorder="reorderSigners">
                            <template #empty>
                                <div class="p-4 pl-0 text-center">{{ $t('contract.no_signers') }}</div>
                            </template>

                            <Column rowReorder :reorderable-column="false" />
                            <Column :header="$t('form.user')">
                                <template #body="slotProps">
                                    <Select
                                        v-model="slotProps.data.user_id"
                                        :id="`user_id_${slotProps.index}`"
                                        :options="users"
                                        data-key="id"
                                        option-value="id"
                                        option-label="full_name"
                                        filter
                                        showClear
                                        class="w-full"
                                        @change="setSignerData(slotProps.data.user_id, slotProps.index)"
                                    />
                                </template>
                            </Column>
                            <Column field="signer_name" :header="$t('form.signer_name')">
                                <template #body="slotProps">
                                    <TextInput
                                        v-model="slotProps.data.signer_name"
                                        :id="`signer_name_${slotProps.index}`"
                                        :disabled="slotProps.data.user_id !== null"
                                        style="min-width: 20rem"
                                    />
                                </template>
                            </Column>

                            <Column field="signer_email" :header="$t('form.signer_email')">
                                <template #body="slotProps">
                                    <TextInput
                                        v-model="slotProps.data.signer_email"
                                        :id="`signer_email_${slotProps.index}`"
                                        :disabled="slotProps.data.user_id !== null"
                                        style="min-width: 20rem"
                                    />
                                </template>
                            </Column>

                            <Column field="signer_phone" :header="$t('form.signer_phone')">
                                <template #body="slotProps">
                                    <TextInput
                                        v-model="slotProps.data.signer_phone"
                                        :id="`signer_phone_${slotProps.index}`"
                                        :disabled="slotProps.data.user_id !== null"
                                        style="min-width: 20rem"
                                    />
                                </template>
                            </Column>

                            <Column field="signer_notes" :header="$t('form.notes')">
                                <template #body="slotProps">
                                    <TextInput
                                        v-model="slotProps.data.signer_notes"
                                        :id="`signer_notes_${slotProps.index}`"
                                        style="min-width: 20rem"
                                    />
                                </template>
                            </Column>

                            <Column field="status" :header="$t('form.status')">
                                <template #body="slotProps">
                                    <SelectInput
                                        v-model="slotProps.data.status"
                                        :id="`status_${slotProps.index}`"
                                        :options="[
                                            { label: $t('status.waiting_signature'), value: 'waiting_signature' },
                                            { label: $t('status.signed'), value: 'signed' },
                                            { label: $t('status.rejected'), value: 'rejected' },
                                            { label: $t('status.cancelled'), value: 'cancelled' },
                                        ]"
                                    />
                                </template>
                            </Column>

                            <Column :header="$t('basic.actions')">
                                <template #body="slotProps">
                                    <Button
                                        severity="danger"
                                        icon="fa fa-trash"
                                        @click="removeItem(slotProps.index)"
                                        :id="`remove_signer_${slotProps.index}`"
                                    />
                                </template>
                            </Column>
                        </DataTable>
                    </div>

                    <div>
                        <TextAreaInput id="notes_input" v-model="contract.notes" :label="$t('form.notes')" />
                        <TinyMceEditor id="footer_input" v-model="contract.content" :label="$t('form.content')" />
                    </div>
                </form>
            </div>
            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button
                    id="cancel_button"
                    :label="$t('basic.cancel')"
                    icon="fa fa-times"
                    severity="secondary"
                    @click="goTo('/contracts')"
                />
                <Button
                    id="save_button"
                    :label="$t('basic.save')"
                    :disabled="loadingData"
                    icon="fa fa-floppy-disk"
                    severity="success"
                    @click="validateForm"
                />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
import ContractMixin from '@/mixins/contracts'
export default {
    name: 'CreateContractPage',
    mixins: [ContractMixin],
    setup() {
        return { v$: useVuelidate() }
    },
    created() {
        this.getPartners()
        this.getUsers()
        this.getContractNumber()
        this.getContractTypes()
    },

    validations() {
        return {
            contract: {
                number: { required },
                title: { required },
                status: { required },
            },
        }
    },

    methods: {
        addSigner() {
            this.contract.signers.push({
                user_id: null,
                custom_signer: '',
                signer_name: '',
                signer_email: '',
                signer_phone: '',
                signer_notes: '',
                status: 'waiting_signature',
            })
        },

        removeItem(index) {
            this.contract.signers.splice(index, 1)
        },

        validateForm() {
            this.v$.contract.$touch()
            if (this.v$.contract.$error) {
                return this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
            }
            return this.createContract()
        },

        reorderSigners(e) {
            this.contract.signers = e.value
        },

        setSignerData(signer_id, index) {
            this.users.forEach((element) => {
                if (element.id == signer_id) {
                    this.contract.signers[index].signer_email = element.email
                    this.contract.signers[index].signer_name = element.full_name
                }
            })
        },
    },
}
</script>
<style></style>
