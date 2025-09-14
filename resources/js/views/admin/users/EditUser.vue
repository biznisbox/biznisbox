<template>
    <DefaultLayout menu_type="admin">
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('admin.user.edit_user')" />

            <div class="card">
                <form>
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
                        <div class="col-span-1 md:col-span-4">
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
                        <div class="col-span-1 md:col-span-8">
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
                </form>
            </div>
            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button
                    id="cancel_button"
                    :label="$t('basic.cancel')"
                    icon="fa fa-times"
                    severity="secondary"
                    @click="goTo('/admin/users/' + $route.params.id)"
                />
                <Button id="update_button" :label="$t('basic.update')" icon="fa fa-floppy-disk" severity="success" @click="validateForm" />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
import AdminUserMixin from '@/mixins/admin/users'
export default {
    name: 'AdminEditUserPage',
    mixins: [AdminUserMixin],
    setup() {
        return { v$: useVuelidate() }
    },
    created() {
        this.getRoles()
        this.getLocales()
        this.getUser(this.$route.params.id)
    },

    validations() {
        return {
            user: {
                first_name: { required },
                last_name: { required },
                active: { required },
                email: { required },
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
            return this.updateUser(this.$route.params.id)
        },
    },
}
</script>
