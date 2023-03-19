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
                                v-model="user.first_name"
                                :label="$t('admin.user.first_name')"
                                :placeholder="$t('admin.user.first_name')"
                            />
                        </div>

                        <div class="col-12 md:col-6">
                            <TextInput
                                id="input_last_name"
                                v-model="user.last_name"
                                :label="$t('admin.user.last_name')"
                                :placeholder="$t('admin.user.last_name')"
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

                    <div class="grid">
                        <div class="col-3 field-checkbox">
                            <Checkbox v-model="user.auto_generated_password" binary @change="generatePassword" />
                            <label>{{ $t('admin.user.auto_generate_password') }}</label>
                        </div>
                        <div class="col-9">
                            <TextInput
                                id="input_password"
                                v-model="user.password"
                                :label="$t('admin.user.password')"
                                :placeholder="$t('admin.user.password')"
                                :disabled="user.auto_generated_password"
                            />
                        </div>
                    </div>

                    <div class="grid">
                        <div class="flex flex-column mb-3">
                            <label for="input_send_details_to" class="block text-900 font-medium mb-2">
                                {{ $t('admin.user.send_details_to') }}</label
                            >
                            <Chips
                                id="input_send_details_to"
                                v-model="user.send_details_to"
                                :allow-duplicates="false"
                                separator=","
                                input-class="w-full"
                                input-style="width: 100%"
                                :label="$t('admin.user.send_details_to')"
                            />
                        </div>
                    </div>
                </form>
                <div id="function_buttons" class="flex gap-2 justify-content-end">
                    <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="goTo('/admin/users')" />
                    <Button :label="$t('basic.save')" icon="fa fa-floppy-disk" class="p-button-success" @click="createUser" />
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import AdminUserMixin from '@/mixins/admin/users'
export default {
    name: 'AdminNewUserPage',
    mixins: [AdminUserMixin],

    created() {
        this.getRoles()
        this.user.timezone = this.$settings.default_timezone
        this.user.language = this.$settings.default_lang
    },
}
</script>

<style></style>
