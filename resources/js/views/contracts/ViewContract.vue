<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="contract.title">
                <template #actions>
                    <Button
                        v-if="contract.status !== 'signed' && contract.status !== 'rejected' && contract.status !== 'cancelled'"
                        id="edit_button"
                        :label="$t('basic.edit')"
                        severity="success"
                        icon="fa fa-edit"
                        @click="$router.push(`/contracts/${contract.id}/edit`)"
                    />
                    <Button
                        v-if="contract.status !== 'signed' && contract.status !== 'rejected' && contract.status !== 'cancelled'"
                        id="delete_button"
                        :label="$t('basic.delete')"
                        icon="fa fa-trash"
                        severity="danger"
                        @click="deleteContractAsk($route.params.id)"
                    />

                    <SplitButton
                        id="more_options_button"
                        icon="fa fa-list"
                        :model="[
                            { label: $t('basic.download'), icon: 'fa fa-download', command: downloadContractPdf },
                            { label: $t('basic.show_pdf'), icon: 'fa fa-file-pdf', command: viewContractPdf },
                            {
                                label: $t('basic.audit_log'),
                                icon: 'fa fa-history',
                                command: () => (showAuditLogDialog = true),
                            },
                            {
                                label: $t('basic.share'),
                                icon: 'fa fa-share',
                                command: () => {
                                    shareContract(contract.id)
                                },
                            },
                        ]"
                    />
                </template>
            </PageHeader>

            <div class="card">
                <div class="grid md:grid-cols-3 grid-cols-1 gap-2">
                    <DisplayData :input="$t('form.number')" :value="contract.number" />
                    <DisplayData :input="$t('form.name')" :value="contract.title" />
                    <DisplayData :input="$t('form.type')" customValue v-if="contract.category != null && contract.category?.name">
                        <Tag :value="contract.category?.name" severity="info" />
                    </DisplayData>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <DisplayData :input="$t('form.status')" customValue>
                        <Tag v-if="contract.status === 'draft'" severity="info" :value="$t('status.draft')" />
                        <Tag v-else-if="contract.status === 'waiting_signers'" severity="warn" :value="$t('status.waiting_signers')" />
                        <Tag v-else-if="contract.status === 'signed'" severity="success" :value="$t('status.signed')" />
                        <Tag v-else-if="contract.status === 'rejected'" severity="danger" :value="$t('status.rejected')" />
                        <Tag v-else-if="contract.status === 'cancelled'" severity="secondary" :value="$t('status.cancelled')" />
                        <Tag v-else-if="contract.status === 'expired'" severity="danger" :value="$t('status.expired')" />
                        <Tag v-else severity="info" :value="contract.status" />
                    </DisplayData>
                    <DisplayData :input="$t('form.version')" :value="contract.version" />
                    <DisplayData :input="$t('form.date')" :value="formatDate(contract.created_at)" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <DisplayData v-if="contract.start_date" :input="$t('form.start_date')" :value="formatDate(contract.start_date)" />
                    <DisplayData v-if="contract.end_date" :input="$t('form.end_date')" :value="formatDate(contract.end_date)" />
                    <DisplayData
                        v-if="contract.date_for_signature"
                        :input="$t('form.date_for_signature')"
                        :value="formatDate(contract.date_for_signature)"
                    />
                </div>

                <div v-if="!loadingData" id="partner_data">
                    <DisplayData :input="$t('form.partner')" custom-value>
                        <div v-if="contract.partner_id != null">
                            <span>{{ formatText(contract.partner?.name) }}</span>
                            <br />
                        </div>
                        <div v-else>
                            <span> {{ $t('contract.no_partner') }}</span>
                        </div>
                    </DisplayData>
                </div>

                <DisplayData :input="$t('form.content')" customValue>
                    <div v-if="contract.content">
                        <div v-html="formatHtml(contract.content)"></div>
                    </div>
                    <div v-else>
                        <span>{{ $t('contract.no_content') }}</span>
                    </div>
                </DisplayData>

                <DisplayData :input="$t('form.signers')" customValue>
                    <ul id="signers-list">
                        <li v-for="(signer, index) in contract.signers" :key="index" class="mb-4">
                            <div>
                                <span class="font-bold">{{ signer.signer_name }}</span>
                                <div v-if="signer.status == 'signed'">
                                    <img v-if="signer.signature" :src="signer.signature" alt="Signature" class="w-56 h-16" />
                                </div>

                                <div v-else-if="signer.status == 'rejected'">
                                    <span class="text-red-400">{{ $t('status.rejected') }}</span>
                                </div>
                                <span v-else class="text-red-400 block">{{ $t('contract.not_signed') }}</span>
                            </div>
                            <div v-if="signer.notes">
                                <strong>{{ $t('form.notes') }}:</strong>
                                <span>{{ signer.notes }}</span>
                            </div>
                        </li>
                        <span class="p-2" v-if="contract.signers.length === 0">{{ $t('contract.no_signers') }}</span>
                    </ul>
                </DisplayData>
            </div>

            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button id="close_button" :label="$t('basic.close')" icon="fa fa-times" severity="secondary" @click="goTo('/contracts')" />
            </div>
        </LoadingScreen>

        <!-- Shared dialog -->
        <Dialog
            ref="shareDialog"
            v-model:visible="shareDialog"
            :header="$t('contract.share_dialog')"
            modal
            class="w-full m-2 lg:w-1/2"
            :draggable="false"
        >
            <div id="share_dialog_content">
                <div class="text-center">{{ $t('contract.share_dialog_text') }}</div>

                <div class="flex justify-center my-2">
                    <qrcode-vue :value="shareUrl" :size="140" level="H" />
                </div>

                <div class="flex gap-2 w-full">
                    <InputText v-model="shareUrl" class="w-full" />
                    <Button :label="$t('basic.copy')" icon="fa fa-copy" @click="copyToClipboard(shareUrl)" />
                </div>
            </div>
            <template #footer>
                <Button :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="shareDialog = false" />
            </template>
        </Dialog>

        <!--Audit log dialog -->
        <Dialog
            v-model:visible="showAuditLogDialog"
            modal
            maximizable
            class="w-full m-2 lg:w-1/2"
            :header="$t('audit_log.audit_log')"
            :draggable="false"
        >
            <AuditLog :item_id="$route.params.id" item_type="Contract" :hiddenFields="['sha256', 'user_id']" />
        </Dialog>
    </DefaultLayout>
</template>
<script>
import ContractMixin from '@/mixins/contracts'
import QrcodeVue from 'qrcode.vue'
export default {
    name: 'EditContractPage',
    mixins: [ContractMixin],
    components: {
        QrcodeVue,
    },
    data() {
        return {
            showAuditLogDialog: false,
            shareDialog: false,
        }
    },
    created() {
        this.getContract(this.$route.params.id)
    },

    methods: {
        viewContractPdf() {
            window.open(this.contract.preview, '_blank')
        },
        downloadContractPdf() {
            window.open(this.contract.download, '_blank')
        },
    },
}
</script>
