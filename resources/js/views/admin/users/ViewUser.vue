<template>
    <DefaultLayout menu_type="admin">
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="user.first_name + ' ' + user.last_name">
                <template #actions>
                    <Button
                        icon="fa fa-pencil"
                        :label="$t('basic.edit')"
                        severity="success"
                        @click="$router.push({ name: 'admin-user-edit', params: { id: $route.params.id } })"
                    />
                    <Button icon="fa fa-trash" :label="$t('basic.delete')" severity="danger" @click="deleteUserAsk($route.params.id)" />
                    <Button icon="fa fa-lock" :label="$t('admin.user.reset_password')" @click="showPasswordDialog = true" />
                    <Button icon="fa fa-history" :label="$t('audit_log.audit_log')" @click="showAuditLogDialog = true" />
                    <Button
                        v-if="user.two_factor_auth"
                        icon="fa fa-key"
                        :label="$t('admin.user.disable_2fa')"
                        @click="disable2fa($route.params.id)"
                    />
                </template>
            </PageHeader>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="col-span-1 md:col-span-4 card">
                    <DisplayData :input="$t('form.first_name')" :value="user.first_name" />
                    <DisplayData :input="$t('form.last_name')" :value="user.last_name" />
                    <DisplayData :input="$t('form.email')" :value="user.email" is-link :link="`mailto:${user.email}`" />
                    <DisplayData :input="$t('form.active')" custom-value>
                        <Tag v-if="user.active" severity="success" :value="$t('basic.yes')" />
                        <Tag v-else severity="danger" :value="$t('basic.no')" />
                    </DisplayData>
                    <DisplayData :input="$t('form.language')" :value="$t(`lang.${user.language}`)" />
                    <DisplayData :input="$t('admin.user.last_login_at')" custom-value>
                        <span v-if="user.last_login_at">
                            {{ formatDateTime(user.last_login_at) }}
                        </span>
                        <span v-else>
                            <Tag severity="danger" :value="$t('admin.user.never_logged_in')" />
                        </span>
                    </DisplayData>
                    <DisplayData :input="$t('form.roles')" custom-value>
                        <div v-if="user.roles.length > 0">
                            <Tag v-for="role in user.roles" :key="role.id" :value="role.display_name" />
                        </div>
                        <div v-else>
                            <Tag severity="danger" :value="$t('admin.user.no_roles')" />
                        </div>
                    </DisplayData>

                    <DisplayData :input="$t('form.two_factor_auth')" custom-value>
                        <Tag v-if="user.two_factor_auth" severity="success" :value="$t('basic.yes')" />
                        <Tag v-else severity="danger" :value="$t('basic.no')" />
                    </DisplayData>
                </div>

                <div class="col-span-1 md:col-span-8 card">
                    <Tabs value="sessions_tab">
                        <TabList>
                            <Tab value="sessions_tab">{{ $t('login_history.login_history') }}</Tab>
                        </TabList>
                        <TabPanels>
                            <TabPanel value="sessions_tab">
                                <DataTable :value="user.sessions" paginator :rows="10" :rows-per-page-options="[10, 20, 50]">
                                    <template #empty>
                                        <div class="p-4 pl-0 text-center w-full">
                                            <i class="fa fa-info-circle empty-icon"></i>
                                            <p>{{ $t('login_history.no_login_history') }}</p>
                                        </div>
                                    </template>

                                    <Column field="created_at" :header="$t('login_history.login_time')">
                                        <template #body="{ data }">
                                            {{ formatDateTime(data.created_at) }}
                                        </template>
                                    </Column>
                                    <Column field="ip" :header="$t('login_history.ip_address')" />
                                    <Column field="device_type" :header="$t('login_history.device_type')">
                                        <template #body="{ data }">
                                            <span v-if="data.device_type == 'desktop'">
                                                <i class="fa fa-desktop text-blue-500"></i>
                                            </span>

                                            <span v-else-if="data.device_type == 'mobile'">
                                                <i class="fa fa-mobile text-blue-500"></i>
                                            </span>

                                            <span v-else-if="data.device_type == 'tablet'">
                                                <i class="fa fa-tablet text-blue-500"></i>
                                            </span>
                                            <Tag v-else severity="danger" :value="$t('status.unknown')" />
                                        </template>
                                    </Column>
                                    <Column field="os" :header="$t('login_history.os')" />
                                    <Column field="location" :header="$t('login_history.location')">
                                        <template #body="{ data }">
                                            <div v-if="data.location">
                                                <div>{{ data.location }}</div>
                                                <div>{{ formatCountry(data.country) }}</div>
                                            </div>
                                        </template>
                                    </Column>
                                </DataTable>
                            </TabPanel>
                        </TabPanels>
                    </Tabs>
                </div>
            </div>
            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button
                    id="cancel_button"
                    :label="$t('basic.cancel')"
                    icon="fa fa-times"
                    severity="secondary"
                    @click="goTo('/admin/users')"
                />
            </div>

            <!-- Password Dialog -->
            <Dialog v-model:visible="showPasswordDialog" :header="$t('admin.user.reset_password')" modal>
                <form class="mt-3">
                    <div class="flex items-center gap-2">
                        <Checkbox v-model="user.auto_generated_password" binary @change="generatePasswordEdit" />
                        <label>{{ $t('admin.user.auto_generate_password') }}</label>
                    </div>

                    <TextInput
                        id="input_password"
                        v-model="password.password"
                        :label="$t('form.password')"
                        class="col-12"
                        :placeholder="$t('form.password')"
                        :disabled="user.auto_generated_password"
                    />
                    <div class="flex flex-col gap-2 mb-2">
                        <label for="input_send_details_to" class="dark:text-surface-200">
                            {{ $t('admin.user.send_details_to') }}
                        </label>
                        <AutoComplete
                            id="input_send_details_to"
                            v-model="password.send_details_to"
                            multiple
                            :typeahead="false"
                            :label="$t('admin.user.send_details_to')"
                        />
                    </div>
                </form>

                <template #footer>
                    <Button :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="showPasswordDialog = false" />
                    <Button
                        :label="$t('admin.user.reset_password')"
                        icon="fa fa-floppy-disk"
                        severity="success"
                        :disabled="loadingData || !password.password"
                        @click="resetPasswordForm"
                    />
                </template>
            </Dialog>
        </LoadingScreen>

        <!-- Audit log dialog -->
        <Dialog
            v-model:visible="showAuditLogDialog"
            modal
            maximizable
            class="w-full m-2 lg:w-1/2"
            :header="$t('audit_log.audit_log')"
            :draggable="false"
        >
            <AuditLog :item_id="$route.params.id" item_type="User" :hiddenFields="['password']" />
        </Dialog>
    </DefaultLayout>
</template>

<script>
import AdminUserMixin from '@/mixins/admin/users'
export default {
    name: 'AdminViewUserPage',
    mixins: [AdminUserMixin],
    data() {
        return {
            showPasswordDialog: false,
            password: {
                password: '',
                send_details_to: [],
            },
            showAuditLogDialog: false,
        }
    },
    created() {
        this.getUser(this.$route.params.id)
    },

    methods: {
        generatePasswordEdit() {
            if (this.user.auto_generated_password) {
                this.password.password = Math.random().toString(36).slice(-8)
            } else {
                this.password.password = ''
            }
        },

        resetPasswordForm() {
            this.resetPassword(this.$route.params.id, this.password)
            this.showPasswordDialog = false
            ;(this.user.auto_generated_password = false),
                (this.password = {
                    password: '',
                    send_details_to: [],
                })
        },

        userEditNavigation(id) {
            this.$router.push({ name: 'admin-edit-user', params: { id } })
        },
    },
}
</script>
<style></style>
