<template>
    <user-layout>
        <div id="user_profile">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('profile.profile')" />
                <div class="card">
                    <div class="grid">
                        <div class="col-12 md:col-2">
                            <FileUpload
                                name="picture"
                                url="/api/my_profile/avatar"
                                auto
                                accept="image/*"
                                @before-send="beforeUploadAvatar"
                                @upload="getMyProfile"
                            >
                                <template #header="{ chooseCallback, files }">
                                    <div v-if="files.length > 0">
                                        <Avatar :image="files[0].objectURL" size="xlarge" />
                                    </div>
                                    <div v-else>
                                        <Avatar
                                            v-if="user_data.picture == null"
                                            :label="user_data.initials"
                                            size="xlarge"
                                            style="cursor: pointer"
                                            @click="chooseCallback()"
                                        />
                                        <Avatar
                                            v-if="user_data.picture != null"
                                            :image="user_data.picture"
                                            size="xlarge"
                                            style="cursor: pointer"
                                            @click="chooseCallback()"
                                            @contextmenu.prevent="removeAvatar"
                                        />
                                    </div>
                                </template>
                            </FileUpload>
                        </div>

                        <div class="col-6 md:col-5">
                            <TextInput
                                id="input_first_name"
                                v-model="v$.user_data.first_name.$model"
                                :label="$t('form.first_name')"
                                :placeholder="$t('form.first_name')"
                                :disabled="loadingData"
                                :validate="v$.user_data.first_name"
                            />
                        </div>

                        <div class="col-6 md:col-5">
                            <TextInput
                                id="input_last_name"
                                v-model="v$.user_data.last_name.$model"
                                :label="$t('form.last_name')"
                                :placeholder="$t('form.last_name')"
                                :disabled="loadingData"
                                :validate="v$.user_data.last_name"
                            />
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12">
                            <TextInput
                                id="input_email"
                                v-model="v$.user_data.email.$model"
                                :label="$t('form.email')"
                                :placeholder="$t('form.email')"
                                disabled
                                :validate="v$.user_data.email"
                            />
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12">
                            <SelectInput
                                id="input_language"
                                v-model="v$.user_data.language.$model"
                                :label="$t('form.language')"
                                :options="locales"
                                :validate="v$.user_data.language"
                                :disabled="loadingData"
                                option-label="name"
                                option-value="locale"
                            />
                        </div>
                    </div>

                    <div id="user_profile_buttons">
                        <Button :label="$t('basic.update')" :disabled="loadingData" @click="saveUser" />
                    </div>
                </div>

                <div class="card">
                    <TabView id="profile_tabs">
                        <TabPanel :header="$t('login_history.login_history')">
                            <DataTable :value="user_data.sessions" paginator :rows="10" :rows-per-page-options="[10, 20, 50]">
                                <template #empty>
                                    <div class="p-4 pl-0 text-center w-full text-gray-500">
                                        <i class="fa fa-info-circle empty-icon"></i>
                                        <p>{{ $t('login_history.no_login_history') }}</p>
                                    </div>
                                </template>

                                <Column field="created_at" :header="$t('login_history.login_time')">
                                    <template #body="slotProps">
                                        {{ formatDateTime(slotProps.data.created_at) }}
                                    </template>
                                </Column>
                                <Column field="ip" :header="$t('login_history.ip_address')" />
                                <Column field="device_type" :header="$t('login_history.device_type')">
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
                                        <Tag v-else severity="danger" :value="$t('status.unknown')" />
                                    </template>
                                </Column>
                                <Column field="os" :header="$t('login_history.os')" />
                                <Column field="location" :header="$t('login_history.location')">
                                    <template #body="slotProps">
                                        <div v-if="slotProps.data.location">
                                            <div>{{ slotProps.data.location }}</div>
                                            <div>{{ formatCountry(slotProps.data.country) }}</div>
                                        </div>
                                    </template>
                                </Column>
                            </DataTable>
                        </TabPanel>

                        <TabPanel :header="$t('profile.change_password')">
                            <div class="grid pt-2">
                                <div class="col-12 md:col-6">
                                    <PasswordInput
                                        id="input_password"
                                        v-model="v$.password.password.$model"
                                        :label="$t('form.new_password')"
                                        :placeholder="$t('form.new_password')"
                                        type="password"
                                        :disabled="loadingData"
                                        :validate="v$.password.password"
                                    />
                                </div>

                                <div class="col-12 md:col-6">
                                    <PasswordInput
                                        id="input_confirm_password"
                                        v-model="v$.password.confirm_password.$model"
                                        :label="$t('form.password_confirmation')"
                                        :placeholder="$t('form.password_confirmation')"
                                        type="password"
                                        :disabled="loadingData"
                                        :validate="v$.password.confirm_password"
                                    />
                                </div>
                                <div id="user_profile_password_buttons" class="col-12">
                                    <Button :label="$t('profile.change_password')" :disabled="loadingData" @click="changePassword" />
                                </div>
                            </div>
                        </TabPanel>
                    </TabView>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { email, required, minLength, sameAs } from '@vuelidate/validators'
import locales from '@/data/available_locales.json'
export default {
    name: 'Profile',
    setup: () => ({ v$: useVuelidate() }),
    data() {
        return {
            locales: locales,
            user_data: {
                first_name: '',
                last_name: '',
                email: '',
                language: '',
                initials: '',
                avatar: '',
                sessions: [],
            },
            password: {
                password: '',
                confirm_password: '',
            },
        }
    },
    created() {
        this.getMyProfile()
    },
    validations() {
        return {
            user_data: {
                first_name: { required },
                last_name: { required },
                email: { required, email },
                language: { required },
            },
            password: {
                password: { required, minLength: minLength(8) },
                confirm_password: { required, sameAs: sameAs(this.password.password) },
            },
        }
    },
    methods: {
        getMyProfile() {
            this.makeHttpRequest('GET', '/api/my_profile').then((response) => {
                this.user_data = response.data.data
            })
        },
        saveUser() {
            this.v$.user_data.$touch()
            if (this.v$.user_data.$invalid) {
                this.showToast(this.$t('basic.form_invalid'), '', 'error')
                return
            }

            this.makeHttpRequest('PUT', '/api/my_profile', this.user_data).then((response) => {
                this.showToast(response.data.message)
                this.getMyProfile()
            })
        },
        changePassword() {
            this.v$.password.$touch()
            if (this.v$.password.$invalid) {
                return this.showToast(this.$t('basic.form_invalid'), '', 'error')
            }

            this.makeHttpRequest('PUT', '/api/my_profile/password', this.password).then((response) => {
                this.password = {
                    password: '',
                    confirm_password: '',
                }
                this.showToast(response.data.message)
                this.$router.push({ name: 'AuthLogout' })
            })
        },
        beforeUploadAvatar(event) {
            event.xhr.setRequestHeader('Authorization', `Bearer ${this.token}`)
        },
        removeAvatar(event) {
            this.makeHttpRequest('DELETE', '/api/my_profile/avatar').then((response) => {
                this.showToast(response.data.message)
                this.getMyProfile()
            })
        },
    },
}
</script>
<style>
.p-fileupload-buttonbar {
    background: none !important;
    border: none !important;
    padding: 0 !important;
}

.p-fileupload .p-fileupload-content {
    display: none;
}

.p-tabview-panels {
    padding: 0 !important;
}
</style>
