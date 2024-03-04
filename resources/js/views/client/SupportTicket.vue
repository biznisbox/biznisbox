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

            <div class="grid">
                <!-- Metadata view -->
                <div class="col-12 md:col-5">
                    <div class="card">
                        <DisplayData :input="$t('form.number')" :value="supportTicket.number" />
                        <DisplayData :input="$t('form.subject')" :value="supportTicket.subject" />
                        <DisplayData :input="$t('form.department')" :value="supportTicket.department?.name" v-if="supportTicket.department_id" />
                        <DisplayData :input="$t('form.status')" custom-value>
                            <Badge v-if="supportTicket.status === 'open'" :value="$t('status.open')" class="p-badge-success" />
                            <Badge v-else-if="supportTicket.status === 'closed'" :value="$t('status.closed')" class="p-badge-danger" />
                            <Badge
                                v-else-if="supportTicket.status === 'in_progress'"
                                :value="$t('status.in_progress')"
                                class="p-badge-warning"
                            />
                            <Badge v-else-if="supportTicket.status === 'resolved'" :value="$t('status.resolved')" class="p-badge-info" />
                            <Badge
                                v-else-if="supportTicket.status === 'reopened'"
                                :value="$t('status.reopened')"
                                class="p-badge-secondary"
                            />
                        </DisplayData>
                        <DisplayData :input="$t('form.priority')" custom-value>
                            <Badge
                                v-if="supportTicket.priority === 'none'"
                                :value="$t('support_priority.none')"
                                class="p-badge-secondary"
                            />
                            <Badge
                                v-else-if="supportTicket.priority === 'low'"
                                :value="$t('support_priority.low')"
                                class="p-badge-info"
                            />
                            <Badge
                                v-else-if="supportTicket.priority === 'medium'"
                                :value="$t('support_priority.medium')"
                                class="p-badge-warning"
                            />
                            <Badge
                                v-else-if="supportTicket.priority === 'normal'"
                                :value="$t('support_priority.normal')"
                                class="p-badge-success"
                            />
                            <Badge
                                v-else-if="supportTicket.priority === 'high'"
                                :value="$t('support_priority.high')"
                                class="p-badge-danger"
                            />
                            <Badge
                                v-else-if="supportTicket.priority === 'urgent'"
                                :value="$t('support_priority.urgent')"
                                class="p-badge-danger"
                            />
                        </DisplayData>
                    </div>
                </div>
                <!-- Content view -->
                <div class="col-12 md:col-7">
                    <div class="card">
                        <h1 class="text-2xl font-bold mb-4">{{ $t('form.message') }}</h1>
                        <div v-for="(content, index) in supportTicket.content" :key="index">
                            <div id="content_{{ index }}" class="card p-4 mb-4">
                                <div id="content_{{ index }}_from" class="mt-4" v-if="content.from !== null">
                                    <div v-if="content.from === 'system'">
                                        <b>{{ $t('form.from') }}: </b>
                                        <span class="p-badge p-badge-secondary">{{ $t('support.system') }}</span>
                                    </div>
                                    <div v-else>
                                        <b>{{ $t('form.from') }}: </b>
                                        <span class="p-badge p-badge-info">{{ content.from }}</span>
                                    </div>
                                </div>

                                <div id="content_{{ index }}_message" class="mt-4">
                                    <span v-if="content.type === 'text' && content.message" v-html="content.message"></span>
                                </div>

                                <!-- Footer - date -->
                                <Badge
                                    v-if="content.created_at"
                                    :value="formatDateTime(content.created_at)"
                                    class="p-badge-secondary mt-2"
                                />
                            </div>
                        </div>

                        <div>
                            <div id="new_replay" class="card p-4 mb-4" v-if="supportTicket.status !== 'closed' && supportTicket.status !== 'resolved'">
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
}
</script>
<style></style>
