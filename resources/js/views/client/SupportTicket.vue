<template>
    <div id="client_view_support_ticket" class="p-2">
        <LoadingScreen :blocked="loadingData">
            <div id="company_data" class="mb-2 d-block p-3">
                <span class="font-bold">{{ formatText($settings.company_name) }}</span
                ><br />
                <span>{{ formatText($settings.company_address) }}</span> <br />
                <span>{{ formatText($settings.company_zip) + ' ' + formatText($settings.company_city) }}</span> <br />
                <span>{{ formatCountry($settings.company_country) }}</span> <br />
                <span v-if="$settings.company_vat">{{ $t('form.tax_id') + ': ' + $settings.company_vat }}</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-2" v-if="displayTicket">
                <!-- Metadata view -->
                <div class="col-span-1 md:col-span-5">
                    <div class="card">
                        <DisplayData :input="$t('form.number')" :value="supportTicket.number" />
                        <DisplayData :input="$t('form.subject')" :value="supportTicket.subject" />

                        <div id="custom_contact" v-if="supportTicket.custom_contact">
                            <DisplayData :input="$t('form.contact_name')" :value="supportTicket.contact_name" />
                            <DisplayData :input="$t('form.contact_email')" :value="supportTicket.contact_email" />
                            <DisplayData :input="$t('form.contact_phone')" :value="supportTicket.contact_phone_number" />
                        </div>

                        <DisplayData
                            :input="$t('form.partner')"
                            :value="supportTicket.partner?.name"
                            v-if="!supportTicket.custom_contact"
                        />

                        <DisplayData :input="$t('form.department')" :value="supportTicket.department?.name" />

                        <DisplayData :input="$t('form.status')" custom-value>
                            <Tag v-if="supportTicket.status === 'open'" :value="$t('status.open')" severity="success" />
                            <Tag v-else-if="supportTicket.status === 'closed'" :value="$t('status.closed')" severity="danger" />
                            <Tag v-else-if="supportTicket.status === 'in_progress'" :value="$t('status.in_progress')" severity="warn" />
                            <Tag v-else-if="supportTicket.status === 'resolved'" :value="$t('status.resolved')" severity="info" />
                            <Tag v-else-if="supportTicket.status === 'reopened'" :value="$t('status.reopened')" severity="secondary" />
                        </DisplayData>
                        <DisplayData :input="$t('form.priority')" custom-value>
                            <Tag v-if="supportTicket.priority === 'none'" :value="$t('support_priority.none')" severity="secondary" />
                            <Tag v-else-if="supportTicket.priority === 'low'" :value="$t('support_priority.low')" severity="info" />
                            <Tag v-else-if="supportTicket.priority === 'medium'" :value="$t('support_priority.medium')" severity="warn" />
                            <Tag
                                v-else-if="supportTicket.priority === 'normal'"
                                :value="$t('support_priority.normal')"
                                severity="success"
                            />
                            <Tag v-else-if="supportTicket.priority === 'high'" :value="$t('support_priority.high')" severity="danger" />
                            <Tag v-else-if="supportTicket.priority === 'urgent'" :value="$t('support_priority.urgent')" severity="danger" />
                        </DisplayData>
                    </div>
                </div>
                <!-- Content view -->
                <div class="col-span-1 md:col-span-7">
                    <div class="card">
                        <h1 class="text-2xl font-bold mb-4">{{ $t('form.message') }}</h1>
                        <div v-for="(content, index) in supportTicket.content" :key="index">
                            <div id="content_{{ index }}" class="card p-4 mb-4">
                                <div id="content_{{ index }}_from" class="mt-4" v-if="content.from !== null">
                                    <div v-if="content.from === 'system'">
                                        <b>{{ $t('form.from') }}: </b>
                                        <Tag :value="$t('support.system')" severity="secondary" />
                                    </div>
                                    <div v-else>
                                        <b>{{ $t('form.from') }}: </b>
                                        <Tag :value="content.from" severity="info" />
                                    </div>
                                </div>

                                <div id="content_{{ index }}_message" class="mt-4">
                                    <span v-if="content.type === 'text' && content.message" v-html="formatHtml(content.message)"></span>
                                </div>

                                <!-- Footer - date -->
                                <Tag v-if="content.created_at" :value="formatDateTime(content.created_at)" />
                            </div>
                        </div>

                        <div>
                            <div
                                id="new_replay"
                                class="card p-4 mb-4"
                                v-if="supportTicket.status !== 'closed' && supportTicket.status !== 'resolved'"
                            >
                                <TinyMceEditor id="content_input" v-model="supportTicketMessage.message" :label="$t('form.new_replay')" />
                                <Button
                                    id="add_content_button"
                                    :label="$t('basic.send')"
                                    icon="fa fa-paper-plane"
                                    @click="clientSendReply"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <p class="text-center text-xl font-bold">
                    {{ $t('errors.not_found') }}
                </p>
            </div>
        </LoadingScreen>
    </div>
</template>

<script>
import SupportMixin from '@/mixins/support'
export default {
    name: 'ClientSupportTicket',
    mixins: [SupportMixin],
    created() {
        this.getClientSupportTicket(this.$route.params.id)
    },

    data() {
        return {
            displayTicket: false,
        }
    },

    methods: {
        /**
         * Get client support tickets
         * @returns {void}
         */
        getClientSupportTicket() {
            this.makeHttpRequest('GET', '/api/client/support-ticket?key=' + this.$route.query.key).then((response) => {
                this.displayTicket = true
                this.supportTicket = response.data.data
            })
        },

        /**
         * Function to send reply to client support ticket
         * @returns {void}
         */
        clientSendReply() {
            if (this.supportTicketMessage.message === '') {
                return this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
            }
            this.makeHttpRequest('POST', '/api/client/support-ticket?key=' + this.$route.query.key, this.supportTicketMessage).then(
                (response) => {
                    this.supportTicketMessage = {
                        id: '',
                        message: '',
                        attachment: '',
                        type: 'message',
                        status: null,
                    }
                    this.showToast(response.data.message)
                    this.supportTicket = response.data.data
                }
            )
        },
    },
}
</script>
