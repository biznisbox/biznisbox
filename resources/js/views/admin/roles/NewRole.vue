<template>
    <admin-layout>
        <div id="admin_new_role_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('admin.role.new_role')" />

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
                            @click="createRole"
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
    },
}
</script>

<style></style>
