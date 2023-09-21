<template>
    <admin-layout>
        <div id="admin_new_role_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('admin.role.new_role')" />

                <div class="card">
                    <form class="formgrid">
                        <TextInput
                            id="input_name"
                            v-model="v$.role.name.$model"
                            :label="$t('form.name')"
                            :placeholder="$t('form.name')"
                            :validate="v$.role.name"
                        />

                        <TextAreaInput
                            id="input_description"
                            v-model="v$.role.description.$model"
                            class="w-full"
                            :label="$t('form.description')"
                            :placeholder="$t('form.description')"
                            :validate="v$.role.description"
                        />

                        <div id="permissions" class="my-2">
                            <h3>{{ $t('form.permissions') }}</h3>
                            <div class="flex flex-wrap gap-2">
                                <div v-for="permission in permissions" :key="permission.id" class="field-checkbox">
                                    <Checkbox
                                        v-model="role.permissions"
                                        name="permission"
                                        :value="permission.name"
                                        :label="permission.name"
                                    />
                                    <label :for="permission.id">{{ permission.display_name }}</label>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="goTo('/admin/roles/')" />
                        <Button
                            :label="$t('basic.save')"
                            :disabled="role.name == 'Super Admin'"
                            icon="fa fa-floppy-disk"
                            class="p-button-success"
                            @click="validateForm"
                        />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </admin-layout>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import RoleMixin from '@/mixins/admin/roles'
export default {
    name: 'AdminNewRolePage',
    mixins: [RoleMixin],
    setup: () => ({ v$: useVuelidate() }),
    created() {
        this.getPermissions()
    },

    validations() {
        return {
            role: {
                name: { required },
                description: { required },
            },
        }
    },

    methods: {
        validateForm() {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }

            return this.createRole()
        },
    },
}
</script>

<style></style>
