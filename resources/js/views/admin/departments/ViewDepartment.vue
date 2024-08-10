<template>
    <DefaultLayout menu_type="admin">
        <loadingScreen :blocked="loadingData">
            <PageHeader :title="$t('admin.department.view_department')">
                <template #actions>
                    <Button
                        id="edit_button"
                        :label="$t('basic.edit')"
                        severity="success"
                        icon="fa fa-edit"
                        @click="$router.push({ name: 'admin-department-edit', params: { id: $route.params.id } })"
                    />
                    <Button
                        id="delete_button"
                        :label="$t('basic.delete')"
                        icon="fa fa-trash"
                        severity="danger"
                        @click="deleteDepartmentAsk($route.params.id)"
                    />
                    <Button
                        id="audit_log_button"
                        :label="$t('audit_log.audit_log')"
                        icon="fa fa-history"
                        severity="info"
                        @click="showAuditLogDialog = true"
                    />
                </template>
            </PageHeader>

            <div class="card">
                <DisplayData :input="$t('form.name')" :value="department.name" />
                <DisplayData :input="$t('form.description')" :value="department.description" />
                <DisplayData :input="$t('form.type')" custom-value>
                    <Tag>{{ $t('department_type.' + department.type) }}</Tag>
                </DisplayData>
                <DisplayData :input="$t('form.address')" :value="department.address" />
                <DisplayData :input="$t('form.zip_code')" :value="department.zip_code" />
                <DisplayData :input="$t('form.city')" :value="department.city" />
                <DisplayData :input="$t('form.country')" :value="department.country" />
                <DisplayData :input="$t('form.latitude')" :value="department.latitude" />
                <DisplayData :input="$t('form.longitude')" :value="department.longitude" />

                <VMap style="height: 200px" :center="[department.latitude, department.longitude]" :zoom="15">
                    <VMapOsmTileLayer />
                    <VMapZoomControl />
                    <VMapMarker :latlng="[department.latitude, department.longitude]" />
                </VMap>
            </div>
        </loadingScreen>

        <!-- Audit log dialog -->
        <Dialog
            v-model:visible="showAuditLogDialog"
            modal
            maximizable
            class="w-full m-2 lg:w-1/2"
            :header="$t('audit_log.audit_log')"
            :draggable="false"
        >
            <AuditLog :item_id="$route.params.id" item_type="Department" />
        </Dialog>
    </DefaultLayout>
</template>

<script>
import DepartmentsMixin from '@/mixins/admin/departments'
import { VMap, VMapOsmTileLayer, VMapZoomControl, VMapMarker } from 'vue-map-ui'
export default {
    name: 'AdminViewDepartmentPage',
    mixins: [DepartmentsMixin],
    components: { VMap, VMapOsmTileLayer, VMapZoomControl, VMapMarker },
    created() {
        this.getDepartment(this.$route.params.id)
    },

    data() {
        return {
            showAuditLogDialog: false,
        }
    },
}
</script>

<style></style>
