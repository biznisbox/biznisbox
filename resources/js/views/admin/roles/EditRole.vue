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
                        <TextInput id="input_name" v-model="role.name" :label="$t('admin.role.name')" placeholder="Name" />

                        <TextAreaInput
                            id="input_description"
                            v-model="role.description"
                            class="w-full"
                            :label="$t('admin.role.description')"
                            :placeholder="$t('admin.role.description')"
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
                            @click="updateRole($route.params.id)"
                        />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </admin-layout>
</template>

<script>
import RoleMixin from '@/mixins/admin/roles'
export default {
    name: 'AdminEditRolePage',
    mixins: [RoleMixin],

    created() {
        this.getPermissions()
        this.getRole(this.$route.params.id)
        this.role.name = this.role.display_name
    },
}
</script>

<style></style>
