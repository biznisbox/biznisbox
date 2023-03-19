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
                                    v-model="user.first_name"
                                    :label="$t('admin.user.first_name')"
                                    placeholder="First Name"
                                />
                            </div>

                            <div class="col-12 md:col-6">
                                <TextInput
                                    id="input_last_name"
                                    v-model="user.last_name"
                                    :label="$t('admin.user.last_name')"
                                    placeholder="Last Name"
                                />
                            </div>
                        </div>

                        <div class="grid">
                            <div class="col-12 md:col-4">
                                <SelectButtonInput
                                    id="input_active"
                                    v-model="user.active"
                                    :label="$t('admin.user.active')"
                                    :options="[
                                        { value: true, label: $t('basic.yes') },
                                        { value: false, label: $t('basic.no') },
                                    ]"
                                />
                            </div>
                            <div class="col-12 md:col-8">
                                <TextInput id="input_email" v-model="user.email" :label="$t('admin.user.email')" placeholder="Email" />
                            </div>
                        </div>

                        <div class="grid">
                            <div class="col-12">
                                <SelectInput
                                    id="input_language"
                                    v-model="user.language"
                                    :label="$t('admin.user.language')"
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
                                    v-model="user.role"
                                    :label="$t('admin.user.role')"
                                    :options="roles"
                                    option-label="display_name"
                                    option-value="name"
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
                        <Button
                            :label="$t('basic.save')"
                            icon="fa fa-floppy-disk"
                            class="p-button-success"
                            @click="updateUser($route.params.id)"
                        />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </admin-layout>
</template>

<script>
import AdminUserMixin from '@/mixins/admin/users'
export default {
    name: 'AdminEditUserPage',
    mixins: [AdminUserMixin],

    created() {
        this.getRoles()
        this.getUser(this.$route.params.id)
    },
}
</script>

<style></style>
