<template>
    <DefaultLayout menu_type="admin">
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('admin.role.new_role')" />

            <div class="card">
                <form class="formgrid">
                    <TextInput id="input_name" v-model="role.name" :label="$t('form.name')" :placeholder="$t('form.name')" />
                    <TextAreaInput
                        id="input_description"
                        v-model="role.description"
                        class="w-full"
                        :label="$t('form.description')"
                        :placeholder="$t('form.description')"
                    />
                    <div id="permissions" class="my-2">
                        <h3>{{ $t('form.permissions') }}</h3>
                        <div class="flex flex-wrap gap-2">
                            <div v-for="permission in permissions" :key="permission.id" class="flex items-center gap-2">
                                <Checkbox v-model="role.permissions" name="permission" :value="permission.name" class="mr-1" />
                                <label :for="permission.id">{{ permission.display_name }}</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button
                    id="cancel_button"
                    :label="$t('basic.cancel')"
                    icon="fa fa-times"
                    severity="secondary"
                    @click="goTo('/admin/roles/')"
                />
                <Button
                    id="save_button"
                    :label="$t('basic.save')"
                    :disabled="role.name == 'Super Admin'"
                    icon="fa fa-floppy-disk"
                    severity="success"
                    @click="validateForm"
                />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
import RoleMixin from '@/mixins/admin/roles'
export default {
    name: 'AdminCreateRolePage',
    mixins: [RoleMixin],
    created() {
        this.getPermissions()
    },

    methods: {
        validateForm() {
            return this.createRole()
        },
    },
}
</script>

<style></style>
