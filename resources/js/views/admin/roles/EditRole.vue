<template>
    <admin-layout>
        <div id="admin_edit_role_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('admin.role.edit_role')">
                    <template #actions>
                        <Button
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            class="p-button-danger"
                            @click="deleteRole($route.params.id)"
                        />
                    </template>
                </user-header>

                <div class="card">
                    <form class="formgrid">
                        <TextInput
                            id="input_name"
                            v-model="v$.role.name.$model"
                            :label="$t('admin.role.name')"
                            :placeholder="$t('admin.role.name')"
                            :validate="v$.role.name"
                        />

                        <TextAreaInput
                            id="input_description"
                            v-model="v$.role.description.$model"
                            class="w-full"
                            :label="$t('admin.role.description')"
                            :placeholder="$t('admin.role.description')"
                            :validate="v$.role.description"
                        />

                        <div id="permissions" class="my-2">
                            <h3>{{ $t('admin.role.permissions') }}</h3>
                            <div class="flex flex-wrap gap-2">
                                <div v-for="permission in permissions" :key="permission.id" class="field-checkbox">
                                    <Checkbox v-model="role.permissions" name="permission" :value="permission.name" />
                                    <label :for="permission.name">{{ permission.display_name }}</label>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="goTo('/admin/roles')" />
                        <Button
                            :label="$t('basic.update')"
                            icon="fa fa-floppy-disk"
                            class="p-button-success"
                            :disabled="role.name == 'Super Admin'"
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
    name: 'AdminEditRolePage',
    mixins: [RoleMixin],
    setup: () => ({ v$: useVuelidate() }),
    created() {
        this.getPermissions()
        this.getRole(this.$route.params.id)
        this.role.name = this.role.display_name
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

            return this.updateRole(this.$route.params.id)
        },
    },
}
</script>

<style></style>
