<template>
    <DefaultLayout menu_type="admin">
        <PageHeader :title="$t('admin.user.new_user')" />

        <LoadingScreen :blocked="loadingData">
            <div class="card">
                <form class="formgrid">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <TextInput
                            id="input_first_name"
                            v-model="v$.user.first_name.$model"
                            :label="$t('form.first_name')"
                            :placeholder="$t('form.first_name')"
                            :validate="v$.user.first_name"
                        />
                        <TextInput
                            id="input_last_name"
                            v-model="v$.user.last_name.$model"
                            :label="$t('form.last_name')"
                            :placeholder="$t('form.last_name')"
                            :validate="v$.user.last_name"
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="grid-col-1 md:col-span-3">
                            <SelectButtonInput
                                id="input_active"
                                v-model="v$.user.active.$model"
                                :label="$t('form.active')"
                                :options="[
                                    { value: true, label: $t('basic.yes') },
                                    { value: false, label: $t('basic.no') },
                                ]"
                                :validate="v$.user.active"
                            />
                        </div>
                        <div class="grid-col-1 md:col-span-9">
                            <TextInput
                                id="input_email"
                                v-model="v$.user.email.$model"
                                :label="$t('form.email')"
                                :placeholder="$t('form.email')"
                                :validate="v$.user.email"
                            />
                        </div>
                    </div>

                    <SelectInput
                        id="input_language"
                        v-model="v$.user.language.$model"
                        :label="$t('form.language')"
                        :options="locales"
                        option-label="locale"
                        option-value="code"
                        :validate="v$.user.language"
                    />

                    <SelectInput
                        id="input_role"
                        v-model="v$.user.role.$model"
                        :label="$t('form.role')"
                        :options="roles"
                        option-label="display_name"
                        option-value="name"
                        :validate="v$.user.role"
                    />

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <div class="col-span-1 md:col-span-3">
                            <Checkbox v-model="user.auto_generated_password" binary @change="generatePassword" />
                            <label class="ml-2">{{ $t('admin.user.auto_generate_password') }}</label>
                        </div>
                        <div class="col-span-1 md:col-span-9">
                            <TextInput
                                id="input_password"
                                v-model="v$.user.password.$model"
                                :label="$t('form.password')"
                                :placeholder="$t('form.password')"
                                :disabled="user.auto_generated_password"
                                :validate="v$.user.password"
                            />
                        </div>
                    </div>

                    <div class="grid">
                        <div class="flex flex-col gap-2 mb-2">
                            <label for="input_send_details_to" class="dark:text-surface-200"> {{ $t('admin.user.send_details_to') }}</label>
                            <AutoComplete
                                id="input_send_details_to"
                                v-model="user.send_details_to"
                                multiple
                                :typeahead="false"
                                :label="$t('admin.user.send_details_to')"
                            />
                        </div>
                    </div>
                </form>
            </div>
            <div id="function_buttons" class="flex justify-end gap-2 mt-4">
                <Button
                    id="cancel_button"
                    :label="$t('basic.cancel')"
                    icon="fa fa-times"
                    severity="secondary"
                    @click="goTo('/admin/users')"
                />
                <Button id="save_button" :label="$t('basic.save')" icon="fa fa-floppy-disk" severity="success" @click="validateForm" />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>
<script>
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
import AdminUserMixin from '@/mixins/admin/users'
export default {
    name: 'AdminNewUserPage',
    mixins: [AdminUserMixin],
    setup() {
        return { v$: useVuelidate() }
    },
    created() {
        this.getRoles()
        this.getLocales()
        this.user.timezone = this.$settings.default_timezone
        this.user.language = this.$settings.default_lang
    },

    validations() {
        return {
            user: {
                first_name: { required },
                last_name: { required },
                active: { required },
                email: { required },
                password: { required },
                role: { required },
                language: { required },
            },
        }
    },

    methods: {
        validateForm() {
            this.v$.user.$touch()
            if (this.v$.user.$error) {
                return this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
            }
            return this.createUser()
        },
    },
}
</script>
