<template>
    <admin-layout>
        <div id="admin_edit_user_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('admin.user.edit_user')" />

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
                                    placeholder="Email"
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
                    </form>
                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button
                            :label="$t('basic.close')"
                            icon="fa fa-times"
                            class="p-button-danger"
                            @click="goTo('/admin/users/' + $route.params.id)"
                        />
                        <Button :label="$t('basic.save')" icon="fa fa-floppy-disk" class="p-button-success" @click="validateForm" />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </admin-layout>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { email, required } from '@vuelidate/validators'
import AdminUserMixin from '@/mixins/admin/users'
export default {
    name: 'AdminEditUserPage',
    mixins: [AdminUserMixin],
    setup: () => ({ v$: useVuelidate() }),
    created() {
        this.getRoles()
        this.getUser(this.$route.params.id)
    },
    validations() {
        return {
            user: {
                first_name: { required },
                email: { required, email },
                role: { required },
                active: { required },
            },
        }
    },

    methods: {
        validateForm() {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }

            return this.updateUser(this.$route.params.id)
        },
    },
}
</script>

<style></style>
