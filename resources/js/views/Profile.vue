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
                                v-model="user_data.first_name"
                                :label="$t('profile.first_name')"
                                :placeholder="$t('profile.first_name')"
                                :disabled="loadingData"
                            />
                        </div>

                        <div class="col-6 md:col-5">
                            <TextInput
                                id="input_last_name"
                                v-model="user_data.last_name"
                                :label="$t('profile.last_name')"
                                :placeholder="$t('profile.last_name')"
                                :disabled="loadingData"
                            />
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12">
                            <TextInput
                                id="input_email"
                                v-model="user_data.email"
                                :label="$t('profile.email')"
                                :placeholder="$t('profile.email')"
                                :disabled="loadingData"
                            />
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12">
                            <SelectInput
                                id="input_language"
                                v-model="user_data.language"
                                :label="$t('profile.language')"
                                :options="locales"
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
                    <h2>{{ $t('profile.change_password') }}</h2>

                    <div class="grid">
                        <div class="col-12 md:col-6">
                            <TextInput
                                id="input_password"
                                v-model="password.password"
                                :label="$t('profile.new_password')"
                                :placeholder="$t('profile.new_password')"
                                type="password"
                                :disabled="loadingData"
                            />
                        </div>

                        <div class="col-12 md:col-6">
                            <TextInput
                                id="input_confirm_password"
                                v-model="password.confirm_password"
                                :label="$t('profile.password_confirmation')"
                                :placeholder="$t('profile.password_confirmation')"
                                type="password"
                                :disabled="loadingData"
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
import locales from '@/data/available_locales.json'
export default {
    name: 'Profile',
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
    methods: {
        getMyProfile() {
            this.makeHttpRequest('GET', '/api/my_profile').then((response) => {
                this.user_data = response.data.data
            })
        },

        saveUser() {
            this.makeHttpRequest('PUT', '/api/my_profile', this.user_data).then((response) => {
                this.showToast(response.data.message)
            })
        },

        changePassword() {
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
