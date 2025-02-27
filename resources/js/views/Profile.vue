<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('profile.profile')" />
            <div class="card">
                <div id="user_profile_upload" class="flex mb-2">
                    <Avatar
                        :image="user_data.avatar_url"
                        size="xlarge"
                        v-if="user_data.avatar_url"
                        @contextmenu.prevent="removeAvatar"
                        class="user-avatar"
                    />
                    <FileUpload
                        name="picture"
                        url="/api/profile/avatar"
                        auto
                        accept="image/*"
                        @before-send="beforeUploadAvatar"
                        @upload="getProfile"
                        mode="basic"
                        class="flex items-center justify-center"
                        :class="user_data.avatar_url ? 'ml-4' : 'ml-0'"
                        :disabled="loadingData"
                    />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <TextInput
                            id="input_first_name"
                            v-model="v$.user_data.first_name.$model"
                            :label="$t('form.first_name')"
                            :placeholder="$t('form.first_name')"
                            :disabled="loadingData"
                            :validate="v$.user_data.first_name"
                        />
                    </div>

                    <div>
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

                <TextInput
                    id="input_email"
                    v-model="v$.user_data.email.$model"
                    :label="$t('form.email')"
                    :placeholder="$t('form.email')"
                    disabled
                    :validate="v$.user_data.email"
                />

                <SelectInput
                    id="input_language"
                    v-model="v$.user_data.language.$model"
                    :label="$t('form.language')"
                    :options="locales"
                    :disabled="loadingData"
                    option-label="locale"
                    option-value="code"
                    :validate="v$.user_data.language"
                />
            </div>
            <div id="user_profile_buttons" class="flex justify-end mt-4 gap-2">
                <Button
                    id="update_button"
                    :label="$t('basic.update')"
                    :disabled="loadingData"
                    icon="fa fa-floppy-disk"
                    severity="success"
                    @click="saveUser"
                />
            </div>

            <div class="card mt-3">
                <Tabs value="login_history">
                    <TabList>
                        <Tab value="login_history"> {{ $t('login_history.login_history') }} </Tab>
                        <Tab value="change_password"> {{ $t('profile.change_password') }} </Tab>
                        <Tab value="two_factor_authentication"> {{ $t('profile.two_factor_authentication') }} </Tab>
                    </TabList>

                    <TabPanels>
                        <TabPanel value="login_history">
                            <DataTable
                                :value="user_data.sessions"
                                paginator
                                :rows="10"
                                :rows-per-page-options="[10, 20, 50]"
                                v-model:expandedRows="expandedRows"
                            >
                                <template #empty>
                                    <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                                        <i class="fa fa-info-circle empty-icon"></i>
                                        <p>{{ $t('login_history.no_login_history') }}</p>
                                    </div>
                                </template>

                                <Column expander />
                                <Column field="created_at" :header="$t('login_history.login_time')" sortable>
                                    <template #body="{ data }">
                                        <Tag :value="formatDateTime(data.created_at)" />
                                    </template>
                                </Column>
                                <Column field="ip" :header="$t('login_history.ip_address')" />
                                <Column field="device_type" :header="$t('login_history.device_type')">
                                    <template #body="{ data }">
                                        <span v-if="data.device_type === 'desktop'">
                                            <i class="fa fa-desktop text-blue-500"></i>
                                        </span>

                                        <span v-else-if="data.device_type === 'mobile'">
                                            <i class="fa fa-mobile text-blue-500"></i>
                                        </span>

                                        <span v-else-if="data.device_type === 'tablet'">
                                            <i class="fa fa-tablet text-blue-500"></i>
                                        </span>
                                        <span v-else-if="data.device_type === 'bot'">
                                            <i class="fa fa-robot text-slate-500"></i>
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

                                <template #expansion="{ data }">
                                    <DisplayData :input="$t('login_history.browser')" custom-value v-if="data.browser">
                                        <Tag>{{ data.browser }}</Tag>
                                    </DisplayData>

                                    <DisplayData :input="$t('login_history.location')" custom-value v-if="data.latitude && data.longitude">
                                        <VMap style="height: 200px" :center="[data.latitude, data.longitude]" :zoom="15">
                                            <VMapOsmTileLayer />
                                            <VMapZoomControl />
                                            <VMapMarker :latlng="[data.latitude, data.longitude]" />
                                        </VMap>
                                    </DisplayData>
                                </template>
                            </DataTable>
                        </TabPanel>

                        <TabPanel value="change_password">
                            <form id="user_profile_password_form">
                                <PasswordInput
                                    id="input_current_password"
                                    v-model="v$.password.current_password.$model"
                                    :label="$t('form.current_password')"
                                    :placeholder="$t('form.current_password')"
                                    :disabled="loadingData"
                                    :validate="v$.password.current_password"
                                />
                                <PasswordInput
                                    id="input_password"
                                    v-model="v$.password.password.$model"
                                    :label="$t('form.new_password')"
                                    :placeholder="$t('form.new_password')"
                                    :disabled="loadingData"
                                    :validate="v$.password.password"
                                />
                                <PasswordInput
                                    id="input_confirm_password"
                                    v-model="v$.password.password_confirmation.$model"
                                    :label="$t('form.password_confirmation')"
                                    :placeholder="$t('form.password_confirmation')"
                                    :disabled="loadingData"
                                    :validate="v$.password.password_confirmation"
                                />
                                <div id="user_profile_password_buttons" class="flex gap-2 justify-end">
                                    <Button
                                        :label="$t('profile.change_password')"
                                        :disabled="loadingData"
                                        @click="changePassword"
                                        severity="success"
                                        icon="fa fa-key"
                                    />
                                </div>
                            </form>
                        </TabPanel>

                        <TabPanel value="two_factor_authentication">
                            <div class="flex gap-2 justify-center mt-5">
                                <Button
                                    :label="$t('profile.enable_2fa')"
                                    :disabled="loadingData"
                                    v-if="user_data.two_factor_auth == false && !show_2fa"
                                    @click="enable2FA"
                                    severity="success"
                                    icon="fa fa-key"
                                />

                                <Button
                                    :label="$t('profile.disable_2fa')"
                                    :disabled="loadingData"
                                    severity="danger"
                                    icon="fa fa-key"
                                    @click="disable2FA"
                                    v-if="user_data.two_factor_auth == true"
                                />
                            </div>

                            <div v-if="show_2fa">
                                <div class="mt-3">
                                    <p>{{ $t('profile.scan_qr_code') }}</p>
                                    <p>
                                        {{ $t('profile.two_factor_authentication_secret') }}: <strong>{{ two_factor.secret }}</strong>
                                    </p>
                                    <p>{{ $t('profile.two_factor_authentication_qr_code') }}:</p>

                                    <div class="flex justify-center my-2">
                                        <QrcodeVue :value="two_factor.url" />
                                    </div>

                                    <div class="flex justify-center mt-3">
                                        <OtpInput
                                            id="input_2fa_code"
                                            v-model="v$.two_factor_code.$model"
                                            :label="$t('profile.two_factor_authentication_code')"
                                            :disabled="loadingData"
                                            :validate="v$.two_factor_code"
                                        />
                                    </div>

                                    <div id="user_profile_2fa_buttons" class="flex gap-2 justify-center mt-3">
                                        <Button
                                            :label="$t('profile.verify_2fa')"
                                            :disabled="loadingData"
                                            @click="verify2FA"
                                            severity="success"
                                            icon="fa fa-key"
                                        />
                                    </div>
                                </div>
                            </div>
                        </TabPanel>
                    </TabPanels>
                </Tabs>
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
import { required, email, sameAs, minLength } from '@vuelidate/validators'
import { useVuelidate } from '@vuelidate/core'
import QrcodeVue from 'qrcode.vue'
import { VMap, VMapOsmTileLayer, VMapZoomControl, VMapMarker } from 'vue-map-ui'
export default {
    name: 'ProfilePage',
    components: {
        QrcodeVue,
        VMap,
        VMapOsmTileLayer,
        VMapZoomControl,
        VMapMarker,
    },
    setup() {
        return { v$: useVuelidate() }
    },

    data() {
        return {
            expandedRows: [],
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
                current_password: '',
                password: '',
                password_confirmation: '',
            },
            two_factor: [],
            two_factor_code: '',
            show_2fa: false,
        }
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
                current_password: { required },
                password: { required, minLength: minLength(8) },
                password_confirmation: { required, sameAs: sameAs(this.password.password) },
            },
            two_factor_code: { required, minLength: minLength(6) },
        }
    },

    created() {
        this.getProfile()
        this.getLocales()
    },

    methods: {
        getProfile() {
            this.makeHttpRequest('GET', '/api/profile').then((response) => {
                this.user_data = response.data.data
            })
        },
        saveUser() {
            this.v$.user_data.$touch()
            if (this.v$.user_data.$invalid) {
                this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
                return
            }

            this.makeHttpRequest('PUT', '/api/profile', this.user_data).then((response) => {
                this.showToast(response.data.message)
                this.refreshToken()
                this.getProfile()
            })
        },
        changePassword() {
            this.v$.password.$touch()
            if (this.v$.password.$invalid) {
                this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
                return
            }

            this.makeHttpRequest('PUT', '/api/profile/password', this.password)
                .then((response) => {
                    this.password = {
                        current_password: '',
                        password: '',
                        confirm_password: '',
                    }

                    this.showToast(response.data.message)
                    this.$router.push({ name: 'auth-logout' })
                })
                .catch((error) => {
                    if (error.response.status === 400) {
                        this.showToast(error.response.data.message, this.$t('basic.error'), 'error')
                    }
                })
        },

        beforeUploadAvatar(event) {
            event.xhr.setRequestHeader('Authorization', `Bearer ${this.token}`)
        },

        removeAvatar() {
            if (this.user_data.picture === this.user_data.id + '.png') {
                this.showToast(this.$t('profile.cannot_remove__default_avatar'), this.$t('basic.info'), 'info')
                return false
            }

            this.makeHttpRequest('DELETE', '/api/profile/avatar').then((response) => {
                this.showToast(response.data.message)
                this.getProfile()
            })
        },

        enable2FA() {
            this.makeHttpRequest('POST', '/api/profile/2fa').then((response) => {
                this.show_2fa = true
                this.two_factor = response.data.data
            })
        },

        disable2FA() {
            this.makeHttpRequest('DELETE', '/api/profile/2fa').then((response) => {
                this.show_2fa = false
                this.two_factor = []
                this.showToast(response.data.message)
                this.getProfile()
            })
        },

        verify2FA() {
            this.v$.two_factor_code.$touch()

            if (this.v$.two_factor_code.$invalid) {
                this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
                return
            }

            this.makeHttpRequest('POST', '/api/profile/2fa/verify', { code: this.two_factor_code, secret: this.two_factor.secret }).then(
                (response) => {
                    this.two_factor_code = ''
                    this.two_factor = []
                    this.showToast(response.data.message)
                    this.show_2fa = false
                    this.getProfile()
                }
            )
        },
    },

    watch: {
        'user_data.language': {
            handler: function (value) {
                this.$i18n.locale = value
                this.$cookies.set('lang', value, '1y')
            },
            immediate: true,
        },
    },
}
</script>
<style>
.user-avatar {
    background-color: transparent !important;
}
</style>
