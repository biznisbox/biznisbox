<template>
    <div id="client_view_contract_page" class="p-2">
        <LoadingScreen :blocked="loadingData">
            <div>
                <div id="company_data" class="p-3">
                    <span class="font-bold">{{ formatText($settings.company_name) }}</span
                    ><br />
                    <span>{{ formatText($settings.company_address) }}</span> <br />
                    <span>{{ formatText($settings.company_zip) + ' ' + formatText($settings.company_city) }}</span> <br />
                    <span>{{ formatCountry($settings.company_country) }}</span> <br />
                    <span v-if="$settings.company_vat">{{ $t('form.tax_id') + ': ' + $settings.company_vat }}</span>
                </div>

                <div v-if="!no_found" class="card m-2">
                    <PageHeader :title="contract.title">
                        <template #actions>
                            <Button
                                id="download_button"
                                v-tooltip:top="$t('basic.click_for_download')"
                                class="mr-2 no-print"
                                :disabled="!contract.download"
                                icon="fa fa-download"
                                @click="downloadContract"
                            />
                            <Button
                                v-if="contract.must_sign && !contract.is_signed"
                                class="no-print"
                                icon="fa fa-signature"
                                @click="openSignDialog"
                            />
                        </template>
                    </PageHeader>

                    <div id="contract_data">
                        <div class="grid md:grid-cols-3 grid-cols-1 gap-2">
                            <DisplayData :input="$t('form.number')" :value="contract.number" />
                            <DisplayData :input="$t('form.name')" :value="contract.title" />
                            <DisplayData :input="$t('form.type')" customValue v-if="contract.type">
                                <Tag :value="contract.type" severity="info" />
                            </DisplayData>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                            <DisplayData :input="$t('form.status')" customValue>
                                <Tag v-if="contract.status === 'draft'" severity="info" :value="$t('status.draft')" />
                                <Tag
                                    v-else-if="contract.status === 'waiting_signers'"
                                    severity="warn"
                                    :value="$t('status.waiting_signers')"
                                />
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
                            <DisplayData :input="$t('form.start_date')" :value="formatDate(contract.start_date)" />
                            <DisplayData :input="$t('form.end_date')" :value="formatDate(contract.end_date)" />
                            <DisplayData :input="$t('form.date_for_signature')" :value="formatDate(contract.date_for_signature)" />
                        </div>

                        <div v-if="!loadingData && contract.signers.length > 0" id="partner_data">
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
                                <div v-html="contract.content"></div>
                            </div>
                            <div v-else>
                                <span>{{ $t('contract.no_content') }}</span>
                            </div>
                        </DisplayData>

                        <DisplayData :input="$t('form.signers')" customValue>
                            <ul id="signers-list">
                                <li v-for="(signer, index) in contract.signers" :key="index">
                                    <div>
                                        <span class="font-bold">{{ signer.signer_name }}</span>
                                        <div class="">
                                            <img v-if="signer.signature" :src="signer.signature" alt="Signature" class="w-56 h-16" />
                                            <span v-else class="text-red-400">{{ $t('contract.not_signed') }}</span>
                                        </div>
                                    </div>
                                    <div v-if="signer.notes">
                                        <strong>{{ $t('form.notes') }}:</strong>
                                        <span>{{ signer.notes }}</span>
                                    </div>
                                </li>
                            </ul>
                        </DisplayData>
                    </div>
                </div>
            </div>

            <!-- Sign dialog -->
            <Dialog
                ref="sign_dialog"
                v-model:visible="show_sign_dialog"
                :header="$t('contract.sign_contract')"
                modal
                style="max-width: 540px"
                :draggable="false"
            >
                <div id="show_sign_dialog_content">
                    <div class="relative bg-gray-100 rounded-md">
                        <VueSignaturePad
                            ref="signature"
                            :maxWidth="2"
                            :minWidth="2"
                            :height="200"
                            :width="500"
                            :options="{
                                backgroundColor: '#f8f9fa',
                                penColor: '#141414',
                            }"
                        />

                        <div class="absolute flex flex-col space-y-2 top-3 right-4">
                            <Button type="button" class="grid p-2 rounded-md shadow-md place-items-center" @click="handleUndo">
                                <i class="fa fa-undo"></i>
                            </Button>
                            <Button
                                type="button"
                                class="grid p-2 rounded-md shadow-md place-items-center"
                                @click="handleClearCanvas"
                                icon="fa fa-eraser"
                            >
                                <i class="fa fa-eraser"></i>
                            </Button>
                        </div>
                    </div>
                    <div class="flex items-center mt-2">
                        <Checkbox v-model="sign_dialog_data.accept_terms" binary />
                        <span class="ml-2">{{ $t('contract.accept_sign_terms') }}</span>
                    </div>
                </div>

                <template #footer>
                    <div class="flex justify-end gap-2">
                        <Button :label="$t('basic.cancel')" severity="secondary" @click="show_sign_dialog = false" />
                        <Button :label="$t('basic.sign')" severity="success" icon="fa fa-signature" @click="signContract" />
                    </div>
                </template>
            </Dialog>
        </LoadingScreen>
    </div>
</template>

<script>
import { VueSignaturePad } from '@selemondev/vue3-signature-pad'
export default {
    name: 'ClientViewContractPage',
    data() {
        return {
            no_found: false,
            show_sign_dialog: false,
            contract: {
                title: '',
                content: '',
                status: '',
                version: '',
                start_date: '',
                end_date: '',
                date_for_signature: '',
                partner: null,
                signers: [],
                notes: '',
            },

            sign_dialog_data: {
                accept_terms: false,
                signature: '',
                notes: '',
            },
        }
    },
    components: {
        VueSignaturePad,
    },
    mounted() {
        this.getContract()
    },
    methods: {
        getContract() {
            this.makeHttpRequest('GET', '/api/client/contract', null, { key: this.$route.query.key })
                .then((response) => {
                    this.contract = response.data.data
                })
                .catch((error) => {
                    if (error.response.status == 404) {
                        this.no_found = true
                    }
                })
        },

        resetSignDialog() {
            this.sign_dialog_data = {
                accept_terms: false,
                signature: '',
                notes: '',
            }
        },

        downloadContract() {
            window.open(this.contract.download, '_blank')
        },

        openSignDialog() {
            this.show_sign_dialog = true
        },

        handleUndo() {
            this.$refs.signature.undo()
        },
        handleClearCanvas() {
            this.$refs.signature.clearCanvas()
        },

        signContract() {
            if (!this.sign_dialog_data.accept_terms) {
                this.showToast(this.$t('contract.accept_terms_required'), this.$t('basic.error'), 'error')
                return
            }
            this.sign_dialog_data.signature = this.$refs.signature.saveSignature()

            this.makeHttpRequest('POST', '/api/client/contract/sign', this.sign_dialog_data, { key: this.$route.query.key })
                .then(() => {
                    this.showToast(this.$t('contract.signed'), this.$t('basic.success'), 'success')
                    this.getContract()
                    this.resetSignDialog()
                    this.show_sign_dialog = false
                })
                .catch(() => {
                    this.resetSignDialog()
                    this.show_sign_dialog = false
                })
        },
    },
}
</script>

<style>
@media print {
    .no-print,
    .no-print * {
        display: none !important;
    }
}
#show_sign_dialog_content canvas {
    background-color: #f8f9fa;
    border: 1px solid #141414;
}
</style>
