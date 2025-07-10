<template>
    <DefaultLayout menu_type="client">
        <PageHeader :title="contract.title">
            <template #actions>
                <Button
                    id="download_button"
                    :label="$t('basic.download')"
                    icon="fa fa-download"
                    severity="secondary"
                    @click="downloadContractPdf"
                />
            </template>
        </PageHeader>

        <LoadingScreen :loading="loadingData">
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
                <Button
                    id="close_button"
                    :label="$t('basic.close')"
                    icon="fa fa-times"
                    severity="secondary"
                    @click="goTo('/client-portal/contracts')"
                />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>
<script>
export default {
    name: 'ClientPortalPartnerDetails',
    data() {
        return {
            contract: {
                number: '',
                title: '',
                category: null,
                status: '',
                version: '',
                created_at: '',
                start_date: null,
                end_date: null,
                date_for_signature: null,
                partner_id: null,
                content: '',
                signers: [],
            },
        }
    },

    methods: {
        getContract(id) {
            this.makeHttpRequest('GET', '/api/client-portal/contracts/' + id).then((response) => {
                this.contract = response.data.data
            })
        },

        viewContractPdf() {
            window.open(this.contract.preview, '_blank')
        },
        downloadContractPdf() {
            window.open(this.contract.download, '_blank')
        },
    },

    created() {
        this.getContract(this.$route.params.id)
    },
}
</script>
