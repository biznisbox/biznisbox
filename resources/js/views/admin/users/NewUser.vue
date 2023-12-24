<template>
    <admin-layout>
        <div id="admin_new_user_page">
            <user-header :title="$t('admin.user.new_user')" />

            <div class="card">
                <form class="formgrid">
                    <div class="grid">
                        <div class="col-12 md:col-6">
                            <TextInput
                                id="input_first_name"
                                v-model="v$.user.first_name.$model"
                                :label="$t('form.first_name')"
                                :placeholder="$t('form.first_name')"
                                :validate="v$.user.first_name"
                            />
                        </div>

                        <div class="col-12 md:col-6">
                            <TextInput
                                id="input_last_name"
                                v-model="user.last_name"
                                :label="$t('form.last_name')"
                                :placeholder="$t('form.last_name')"
                            />
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12 md:col-4">
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
                        <div class="col-12 md:col-8">
                            <TextInput
                                id="input_email"
                                v-model="v$.user.email.$model"
                                :label="$t('form.email')"
                                :placeholder="$t('form.email')"
                                :validate="v$.user.email"
                            />
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12">
                            <SelectInput
                                id="input_language"
                                v-model="user.language"
                                :label="$t('form.language')"
                                :options="locales"
                                option-label="name"
                                option-value="locale"
                            />
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12">
                            <SelectInput
                                id="input_role"
                                v-model="v$.user.role.$model"
                                :label="$t('form.role')"
                                :options="roles"
                                option-label="display_name"
                                option-value="name"
                                :validate="v$.user.role"
                            />
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-3 field-checkbox">
                            <Checkbox v-model="user.auto_generated_password" binary @change="generatePassword" />
                            <label>{{ $t('admin.user.auto_generate_password') }}</label>
                        </div>
                        <div class="col-9">
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
                        <div class="flex flex-column mb-3 col-12">
                            <label for="input_send_details_to" class="block text-900 font-medium mb-2">
                                {{ $t('admin.user.send_details_to') }}</label
                            >
                            <Chips
                                id="input_send_details_to"
                                v-model="user.send_details_to"
                                :allow-duplicates="false"
                                separator=","
                                :label="$t('admin.user.send_details_to')"
                            />
                        </div>
                    </div>
                </form>
            </div>
            <div id="function_buttons" class="flex gap-2 justify-content-end">
                <Button
                    id="cancel_button"
                    :label="$t('basic.cancel')"
                    icon="fa fa-times"
                    class="p-button-danger"
                    @click="goTo('/admin/users')"
                />
                <Button
                    id="save_button"
                    :label="$t('basic.save')"
                    icon="fa fa-floppy-disk"
                    class="p-button-success"
                    @click="validateForm"
                />
            </div>
        </div>
    </admin-layout>
</template>
<script>
import { useVuelidate } from '@vuelidate/core'
import { email, required } from '@vuelidate/validators'
import AdminUserMixin from '@/mixins/admin/users'
export default {
    name: 'AdminNewUserPage',
    mixins: [AdminUserMixin],
    setup: () => ({ v$: useVuelidate() }),
    created() {
        this.getRoles()
        this.user.timezone = this.$settings.default_timezone
        this.user.language = this.$settings.default_lang
    },

    validations() {
        return {
            user: {
                first_name: { required },
                email: { required, email },
                role: { required },
                active: { required },
                password: { required },
            },
        }
    },

    methods: {
        validateForm() {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }

            return this.createUser()
        },
    },
}
</script>

<style></style>
