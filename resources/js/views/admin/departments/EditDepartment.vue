<template>
    <DefaultLayout menu_type="admin">
        <loadingScreen :blocked="loadingData">
            <PageHeader :title="$t('admin.department.edit_department')" />

            <div class="card">
                <form>
                    <TextInput
                        id="input_name"
                        v-model="v$.department.name.$model"
                        :label="$t('form.name')"
                        :placeholder="$t('form.name')"
                        :validate="v$.department.name"
                    />
                    <TextAreaInput
                        id="input_description"
                        v-model="department.description"
                        class="w-full"
                        :label="$t('form.description')"
                        :placeholder="$t('form.description')"
                    />

                    <SelectInput
                        id="input_department_type"
                        v-model="v$.department.type.$model"
                        :label="$t('form.type')"
                        :placeholder="$t('form.type')"
                        :options="[
                            { label: $t('department_type.office'), value: 'office' },
                            { label: $t('department_type.warehouse'), value: 'warehouse' },
                            { label: $t('department_type.store'), value: 'store' },
                            { label: $t('department_type.support'), value: 'support' },
                            { label: $t('basic.other'), value: 'other' },
                        ]"
                        :validate="v$.department.type"
                    />

                    <TextInput
                        id="input_address"
                        v-model="v$.department.address.$model"
                        :label="$t('form.address')"
                        :placeholder="$t('form.address')"
                        :validate="v$.department.address"
                    />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <TextInput
                            id="input_zip_code"
                            v-model="v$.department.zip_code.$model"
                            :label="$t('form.zip_code')"
                            :placeholder="$t('form.zip_code')"
                            :validate="v$.department.zip_code"
                        />
                        <TextInput
                            id="input_city"
                            v-model="v$.department.city.$model"
                            :label="$t('form.city')"
                            :placeholder="$t('form.city')"
                            :validate="v$.department.city"
                        />
                    </div>
                    <CountrySelect
                        id="input_country"
                        v-model="v$.department.country.$model"
                        :label="$t('form.country')"
                        :placeholder="$t('form.country')"
                        :validate="v$.department.country"
                    />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <TextInput
                            id="input_phone"
                            v-model="department.phone_number"
                            :label="$t('form.phone_number')"
                            :placeholder="$t('form.phone_number')"
                        />
                        <TextInput id="input_email" v-model="department.email" :label="$t('form.email')" :placeholder="$t('form.email')" />
                    </div>

                    <Button
                        id="get_current_location_button"
                        :label="$t('basic.get_current_location')"
                        icon="fa fa-map-marker"
                        @click="getCurrentLocation"
                        class="my-2"
                    />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <TextInput
                            id="input_longitude"
                            v-model="department.longitude"
                            :label="$t('form.longitude')"
                            :placeholder="$t('form.longitude')"
                        />

                        <TextInput
                            id="input_latitude"
                            v-model="department.latitude"
                            :label="$t('form.latitude')"
                            :placeholder="$t('form.latitude')"
                        />
                    </div>
                </form>
            </div>
        </loadingScreen>
        <div id="function_buttons" class="flex justify-end mt-4 gap-2">
            <Button
                id="cancel_button"
                :label="$t('basic.cancel')"
                icon="fa fa-times"
                severity="secondary"
                @click="goTo('/admin/departments')"
            />
            <Button id="update_button" :label="$t('basic.update')" icon="fa fa-floppy-disk" severity="success" @click="validateForm" />
        </div>
    </DefaultLayout>
</template>

<script>
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
import DepartmentsMixin from '@/mixins/admin/departments'
export default {
    name: 'AdminEditDepartmentPage',
    mixins: [DepartmentsMixin],
    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            department: {
                name: { required },
                type: { required },
                address: { required },
                zip_code: { required },
                city: { required },
                country: { required },
            },
        }
    },
    created() {
        this.getDepartment(this.$route.params.id)
    },
    methods: {
        validateForm() {
            this.v$.department.$touch()
            if (this.v$.department.$error) {
                return this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
            }
            this.updateDepartment()
        },
    },

    data() {
        return {
            showAuditLogDialog: false,
        }
    },
}
</script>

<style></style>
