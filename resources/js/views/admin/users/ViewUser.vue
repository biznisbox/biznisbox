<template>
    <admin-layout>
        <div id="admin_view_user_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="user.first_name + ' ' + user.last_name">
                    <template #actions>
                        <Button
                            icon="fa fa-pencil"
                            :label="$t('basic.edit')"
                            class="p-button-success"
                            @click="userEditNavigation($route.params.id)"
                        />
                        <Button
                            icon="fa fa-trash"
                            :label="$t('basic.delete')"
                            class="p-button-danger"
                            @click="deleteUserAsk($route.params.id)"
                        />
                        <Button
                            icon="fa fa-lock"
                            :label="$t('admin.user.reset_password')"
                            class="p-button-default"
                            @click="showPasswordDialog = true"
                        />
                    </template>
                </user-header>

                <div class="grid">
                    <div class="col-12 md:col-4">
                        <div class="card">
                            <DisplayData :input="$t('admin.user.first_name')" :value="user.first_name" />
                            <DisplayData :input="$t('admin.user.last_name')" :value="user.last_name" />
                            <DisplayData :input="$t('admin.user.email')" :value="user.email" is-link :link="`mailto:${user.email}`" />
                            <DisplayData :input="$t('admin.user.active')" custom-value>
                                <Tag v-if="user.active" severity="success" :value="$t('basic.yes')" />
                                <Tag v-else severity="danger" :value="$t('basic.no')" />
                            </DisplayData>
                            <DisplayData :input="$t('admin.user.language')" :value="$t(`lang.${user.language}`)" />
                            <DisplayData :input="$t('admin.user.last_login_at')" custom-value>
                                <span v-if="user.last_login_at">
                                    {{ formatDateTime(user.last_login_at) }}
                                </span>
                                <span v-else>
                                    <Tag severity="danger" :value="$t('admin.user.never_logged_in')" />
                                </span>
                            </DisplayData>
                            <DisplayData :input="$t('admin.user.roles')" custom-value>
                                <div v-if="user.roles.length > 0">
                                    <Tag v-for="role in user.roles" :key="role.id" :value="role.display_name" />
                                </div>
                                <div v-else>
                                    <Tag severity="danger" :value="$t('admin.user.no_roles')" />
                                </div>
                            </DisplayData>
                        </div>
                    </div>

                    <div class="col-12 md:col-8">
                        <div class="card">
                            <TabView>
                                <TabPanel :header="$t('admin.user.login_history')">
                                    <DataTable :value="user.sessions" paginator :rows="10" :rows-per-page-options="[10, 20, 50]">
                                        <template #empty>
                                            <div class="p-4 pl-0 text-center w-full text-gray-500">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                                <p>{{ $t('admin.user.no_login_history') }}</p>
                                            </div>
                                        </template>

                                        <Column field="created_at" :header="$t('admin.user.login_time')">
                                            <template #body="slotProps">
                                                {{ formatDateTime(slotProps.data.created_at) }}
                                            </template>
                                        </Column>
                                        <Column field="ip" :header="$t('admin.user.ip_address')" />
                                        <Column field="device_type" :header="$t('admin.user.device_type')">
                                            <template #body="slotProps">
                                                <span v-if="slotProps.data.device_type === 'desktop'">
                                                    <i class="fa fa-desktop text-blue-500"></i>
                                                </span>

                                                <span v-else-if="slotProps.data.device_type === 'mobile'">
                                                    <i class="fa fa-mobile text-blue-500"></i>
                                                </span>

                                                <span v-else-if="slotProps.data.device_type === 'tablet'">
                                                    <i class="fa fa-tablet text-blue-500"></i>
                                                </span>
                                                <Tag v-else severity="danger" :value="$t('admin.user.unknown')" />
                                            </template>
                                        </Column>
                                        <Column field="os" :header="$t('admin.user.os')" />
                                        <Column field="location" :header="$t('admin.user.location')">
                                            <template #body="slotProps">
                                                <div v-if="slotProps.data.location">
                                                    <div>{{ slotProps.data.location }}</div>
                                                    <div>{{ formatCountry(slotProps.data.country) }}</div>
                                                </div>
                                            </template>
                                        </Column>

                                        <template #paginatorstart>
                                            <div class="p-d-flex p-ai-center p-mr-2">
                                                <Button
                                                    class="p-button-rounded p-button-text p-button-plain"
                                                    icon="fa fa-sync"
                                                    @click="getUsers"
                                                />
                                            </div>
                                        </template>
                                    </DataTable>
                                </TabPanel>
                            </TabView>
                        </div>
                    </div>
                </div>

                <Dialog v-model:visible="showPasswordDialog" :header="$t('admin.user.reset_password')" modal>
                    <form class="formgrid">
                        <div class="grid">
                            <div class="col-3 field-checkbox">
                                <Checkbox v-model="user.auto_generated_password" binary @change="generatePasswordEdit" />
                                <label>{{ $t('admin.user.auto_generate_password') }}</label>
                            </div>
                            <TextInput
                                id="input_password"
                                v-model="v$.password.password.$model"
                                :label="$t('admin.user.password')"
                                class="col-8"
                                :placeholder="$t('admin.user.password')"
                                :disabled="user.auto_generated_password"
                                :validate="v$.password.password"
                                :show-errors="formShowErrors"
                            />
                        </div>
                        <div class="grid">
                            <div class="flex flex-column mb-3">
                                <label for="input_send_details_to" class="block text-900 font-medium mb-2">
                                    {{ $t('admin.user.send_details_to') }}</label
                                >
                                <Chips
                                    id="input_send_details_to"
                                    v-model="password.send_details_to"
                                    :allow-duplicates="false"
                                    separator=","
                                    :label="$t('admin.user.send_details_to')"
                                />
                            </div>
                        </div>
                    </form>
                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            class="p-button-danger"
                            @click="showPasswordDialog = false"
                        />
                        <Button
                            :label="$t('admin.user.reset_password')"
                            icon="fa fa-floppy-disk"
                            class="p-button-success"
                            @click="resetPassword($route.params.id, password)"
                        />
                    </div>
                </Dialog>
            </LoadingScreen>
        </div>
    </admin-layout>
</template>

<script>
import AdminUserMixin from '@/mixins/admin/users'
import { required } from '@vuelidate/validators'
import { useVuelidate } from '@vuelidate/core'
export default {
    name: 'AdminViewUserPage',
    mixins: [AdminUserMixin],
    setup: () => ({ v$: useVuelidate() }),
    data() {
        return {
            showPasswordDialog: false,
            password: {
                password: '',
                send_details_to: [],
            },
        }
    },
    validations() {
        return {
            password: {
                password: { required },
            },
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

        userEditNavigation(id) {
            this.$router.push({ name: 'admin-edit-user', params: { id } })
        },
    },
}
</script>

<style></style>
