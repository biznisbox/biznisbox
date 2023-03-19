<template>
    <user-layout>
        <div id="view_estimate_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('estimate.estimate') + ' ' + estimate.number">
                    <template #actions>
                        <Button
                            v-if="estimate.status != 'accepted' && estimate.status != 'converted'"
                            :label="$t('basic.edit')"
                            icon="fa fa-pen"
                            class="p-button-success"
                            @click="editEstimateRoute"
                        />
                        <Button
                            v-if="estimate.status != 'accepted' && estimate.status != 'converted'"
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            class="p-button-danger"
                            @click="deleteEstimateAsk(estimate.id)"
                        />
                        <Button
                            v-if="estimate.status != 'converted' && estimate.status != 'paid'"
                            :label="$t('estimate.convert_to_invoice')"
                            icon="fa fa-file-invoice-dollar"
                            class="p-button-success"
                            @click="convertEstimateToInvoice(estimate.id)"
                        />

                        <Button
                            v-if="estimate.status != 'accepted' && estimate.status != 'converted'"
                            :label="$t('basic.send')"
                            icon="fa fa-paper-plane"
                            class="p-button-info"
                            @click="sendEstimate(estimate.id)"
                        />

                        <Button
                            :label="$t('basic.share')"
                            icon="fa fa-share"
                            class="p-button-info"
                            @click="shareEstimate($route.params.id)"
                        />
                        <Button :label="$t('basic.download')" icon="fa fa-download" class="p-button-info" @click="downloadEstimate" />
                    </template>
                </user-header>

                <div class="card">
                    <div id="payer_customer_data" class="grid">
                        <div v-if="!loadingData" id="customer_data" class="col-12 md:col-6">
                            <DisplayData :input="$t('estimate.customer')" custom-value>
                                <div v-if="estimate.customer_id">
                                    <span class="text-gray-700">{{ formatText(estimate.customer_name) }}</span>
                                    <br />
                                    <span class="text-gray-700">{{ formatText(estimate.customer_address) }}</span>
                                    <br />
                                    <span class="text-gray-700">{{
                                        formatText(estimate.customer_zip_code) + ' ' + formatText(estimate.customer_city)
                                    }}</span>
                                    <br />
                                    <span class="text-gray-700">{{ formatCountry(estimate.customer_country) }}</span>
                                    <br />
                                </div>
                                <div v-else>
                                    <span class="text-gray-700"> {{ $t('estimate.no_customer') }}</span>
                                </div>
                            </DisplayData>
                        </div>

                        <div v-if="!loadingData" id="payer_data" class="col-12 md:col-6">
                            <DisplayData :input="$t('estimate.payer')" custom-value>
                                <div v-if="estimate.payer">
                                    <span class="text-gray-700">{{ formatText(estimate.payer_name) }}</span> <br />
                                    <span class="text-gray-700">{{ formatText(estimate.payer_address) }}</span>
                                    <br />
                                    <span class="text-gray-700">{{
                                        formatText(estimate.payer_zip_code) + ' ' + formatText(estimate.payer_city)
                                    }}</span>
                                    <br />
                                    <span class="text-gray-700">{{ formatText(estimate.payer_country) }}</span>
                                    <br />
                                </div>
                                <div v-else>
                                    <span class="text-gray-700">{{ $t('estimate.no_payer') }}</span>
                                </div>
                            </DisplayData>
                        </div>
                    </div>

                    <div id="estimate_data" class="grid">
                        <div class="col-6 md:col-3">
                            <DisplayData :input="$t('estimate.date')" :value="formatDate(formatText(estimate.date))" />
                        </div>

                        <div class="col-6 md:col-3">
                            <DisplayData :input="$t('estimate.valid_until')" :value="formatDate(formatText(estimate.valid_until))" />
                        </div>

                        <div class="col-6 md:col-3">
                            <DisplayData :input="$t('estimate.status')" custom-value>
                                <Tag v-if="estimate.status === 'accepted'" severity="success">{{ $t('status.accepted') }}</Tag>
                                <Tag v-if="estimate.status === 'rejected'" severity="danger">{{ $t('status.rejected') }}</Tag>
                                <Tag v-if="estimate.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                                <Tag v-if="estimate.status === 'sent'" severity="warning">{{ $t('status.sent') }}</Tag>
                                <Tag v-if="estimate.status === 'viewed'" severity="warning">{{ $t('status.viewed') }}</Tag>
                                <Tag v-if="estimate.status === 'expired'" severity="danger">{{ $t('status.expired') }}</Tag>
                                <Tag v-if="estimate.status === 'cancelled'" severity="">{{ $t('status.cancelled') }}</Tag>
                                <Tag v-if="estimate.status === 'converted'" severity="success">{{ $t('status.converted') }}</Tag>
                            </DisplayData>
                        </div>

                        <div class="col-6 md:col-3">
                            <DisplayData :input="$t('estimate.currency')" :value="formatText(estimate.currency)" />
                        </div>
                    </div>

                    <div id="estimate_items">
                        <DataTable :value="estimate.items">
                            <template #empty>
                                <div class="p-3 text-center w-full text-gray-500">
                                    <i class="fa fa-info-circle empty-icon"></i>
                                    <p>
                                        {{ $t('estimate.no_items') }}
                                    </p>
                                </div>
                            </template>

                            <Column field="name" :header="$t('estimate.name')" />
                            <Column field="description" :header="$t('estimate.description')" />
                            <Column field="quantity" :header="$t('estimate.quantity')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.quantity + ' ' + slotProps.data.unit }}</span>
                                </template>
                            </Column>
                            <Column field="price" :header="$t('estimate.price')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.price + ' ' + estimate.currency }}</span>
                                </template>
                            </Column>
                            <Column field="tax" :header="$t('estimate.tax')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.tax + ' %' }}</span>
                                </template>
                            </Column>
                            <Column field="discount" :header="$t('estimate.discount')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.discount + ' %' }}</span>
                                </template>
                            </Column>
                            <Column field="total" :header="$t('estimate.total')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.total + ' ' + estimate.currency }}</span>
                                </template>
                            </Column>
                        </DataTable>
                    </div>

                    <div id="estimate_calculations" class="grid mt-5">
                        <div id="estimate_notes" class="col-12 md:col-6">
                            <DisplayData :input="$t('estimate.notes')" custom-value>
                                <span v-if="estimate.notes && !loadingData" class="text-gray-700" v-html="estimate.notes"></span>
                            </DisplayData>
                        </div>

                        <div class="col-12 md:col-6">
                            <table class="w-full">
                                <tr>
                                    <td class="w-6 font-bold">{{ $t('estimate.discount') }}</td>
                                    <td class="text-gray-700 text-right">{{ estimate.discount }} %</td>
                                </tr>

                                <tr>
                                    <td class="w-6 font-bold">{{ $t('estimate.total') }}</td>
                                    <td class="text-gray-700 text-right">{{ estimate.total }} {{ estimate.currency }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.close')" icon="fa fa-times" class="p-button-danger" @click="goTo('/estimates')" />
                    </div>
                </div>
            </LoadingScreen>

            <Dialog ref="shareDialog" v-model:visible="shareDialog" :header="$t('estimate.share_dialog')" modal>
                <div id="share_dialog_content">
                    <div class="text-center">{{ $t('estimate.share_dialog_text') }}</div>

                    <div class="text-center py-2">
                        <qrcode-vue :value="shareUrl" :size="140" level="H" />
                    </div>

                    <div class="flex gap-2 w-full">
                        <InputText v-model="shareUrl" class="w-full" />
                        <Button :label="$t('basic.copy')" icon="fa fa-copy" @click="copyToClipboard(shareUrl)" />
                    </div>
                </div>
                <template #footer>
                    <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="shareDialog = false" />
                </template>
            </Dialog>
        </div>
    </user-layout>
</template>

<script>
import EstimateMixin from '@/mixins/estimates'
import QrcodeVue from 'qrcode.vue'
export default {
    name: 'ViewEstimatePage',
    components: {
        QrcodeVue,
    },
    mixins: [EstimateMixin],

    data() {
        return {
            shareDialog: false,
        }
    },
    created() {
        this.getEstimate(this.$route.params.id)
    },

    methods: {
        editEstimateRoute() {
            this.$router.push({ name: 'edit-estimate', params: { id: this.estimate.id } })
        },

        downloadEstimate() {
            window.open(this.estimate.download, '_blank')
        },
    },
}
</script>

<style></style>
