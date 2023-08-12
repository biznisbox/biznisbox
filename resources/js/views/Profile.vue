<template>
    <user-layout>
        <div id="user_profile">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('profile.title')" />
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
                                :label="$t('profile.first_name')"
                                :placeholder="$t('profile.first_name')"
                                :disabled="loadingData"
                                :validate="v$.user_data.first_name"
                            />
                        </div>

                        <div class="col-6 md:col-5">
                            <TextInput
                                id="input_last_name"
                                v-model="v$.user_data.last_name.$model"
                                :label="$t('profile.last_name')"
                                :placeholder="$t('profile.last_name')"
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
                                :label="$t('profile.email')"
                                :placeholder="$t('profile.email')"
                                :disabled="loadingData"
                                :validate="v$.user_data.email"
                            />
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12">
                            <SelectInput
                                id="input_language"
                                v-model="v$.user_data.language.$model"
                                :label="$t('profile.language')"
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

                <div id="user_profile_password" class="mt-5 card">
                    <h3>{{ $t('profile.change_password') }}</h3>

                    <div class="grid my-2">
                        <div class="col-12 md:col-6">
                            <PasswordInput
                                id="input_password"
                                v-model="v$.password.password.$model"
                                :label="$t('profile.new_password')"
                                :placeholder="$t('profile.new_password')"
                                type="password"
                                :disabled="loadingData"
                                :validate="v$.password.password"
                            />
                        </div>

                        <div class="col-12 md:col-6">
                            <PasswordInput
                                id="input_confirm_password"
                                v-model="v$.password.confirm_password.$model"
                                :label="$t('profile.password_confirmation')"
                                :placeholder="$t('profile.password_confirmation')"
                                type="password"
                                :disabled="loadingData"
                                :validate="v$.password.confirm_password"
                            />
                        </div>
                    </div>

                    <div id="user_profile_password_buttons">
                        <Button :label="$t('profile.change_password')" :disabled="loadingData" @click="changePassword" />
                    </div>
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
</style>
