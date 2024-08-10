<template>
    <DefaultLayout menu_type="admin">
        <PageHeader :title="$t('admin.dashboard.title')">
            <template v-slot:actions>
                <Button v-if="!editDashboard" @click="editDashboard = true" icon="fa fa-edit" text />
                <Button
                    v-if="editDashboard"
                    @click="editDashboard = false"
                    icon="fa fa-save"
                    :label="$t('basic.save')"
                    severity="success"
                />
                <Button
                    v-if="editDashboard"
                    @click="addElementDialog = true"
                    icon="fa fa-plus"
                    :label="$t('dashboard.add_element')"
                    severity="secondary"
                />
                <Button
                    v-if="editDashboard"
                    @click="removeElementDialog = true"
                    icon="fa fa-trash"
                    :label="$t('dashboard.remove_element')"
                    severity="danger"
                />
            </template>
        </PageHeader>
        <LoadingScreen :blocked="loadingData">
            <GridLayout
                v-model:layout="layout"
                responsive
                prevent-collision
                :is-resizable="editDashboard"
                :col-num="12"
                :row-height="50"
                :is-draggable="editDashboard"
                use-css-transforms
            >
                <GridItem
                    v-for="item in layout"
                    :key="item.i"
                    :x="item.x"
                    :y="item.y"
                    :w="item.w"
                    :min-w="item.minW"
                    :min-h="item.minH"
                    :max-w="item.maxW"
                    :max-h="item.maxH"
                    :h="item.h"
                    :i="item.i"
                    @moved="saveDashboardLayout"
                    @resized="saveDashboardLayout"
                    class="grid-item"
                >
                    <div :id="item.i" v-if="hasPermission(item.permission)">
                        <component :is="item.component" />
                    </div>
                </GridItem>
            </GridLayout>
        </LoadingScreen>

        <!-- Add Element Dialog -->
        <Dialog v-model:visible="addElementDialog" :header="$t('dashboard.add_element')" modal>
            <SelectInput v-model="selectedComponent" :options="availableComponents" option-label="name" option-value="i" />

            <template v-slot:footer>
                <Button @click="addElementDialog = false" severity="secondary" :label="$t('basic.cancel')" />
                <Button @click="addToDashboard" severity="success" :label="$t('basic.add')" />
            </template>
        </Dialog>

        <!-- Remove Element Dialog -->
        <Dialog v-model:visible="removeElementDialog" :header="$t('dashboard.remove_element')" modal>
            <SelectInput v-model="selectedComponent" :options="layout" option-label="name" option-value="i" />

            <template v-slot:footer>
                <Button @click="removeElementDialog = false" severity="secondary" :label="$t('basic.cancel')" />
                <Button @click="removeFromDashboard" severity="danger" :label="$t('basic.remove')" />
            </template>
        </Dialog>
    </DefaultLayout>
</template>
<script>
import { GridLayout, GridItem } from 'grid-layout-plus'
import NumberOfUsers from '@/components/dashboard/admin/NumberOfUsers.vue'
import ChartOfLoginsThisMonth from '@/components/dashboard/admin/ChartOfLoginsThisMonth.vue'
export default {
    name: 'AdminDashboardPage',
    components: {
        GridLayout,
        GridItem,
        NumberOfUsers,
        ChartOfLoginsThisMonth,
    },
    data() {
        return {
            layout: [],
            selectedComponent: null,
            addElementDialog: false,
            removeElementDialog: false,
            editDashboard: false,
            availableComponents: [
                { name: 'Number of Users', i: 'number_of_users', component: 'NumberOfUsers', minW: 2, minH: 2, permission: 'admin_users' },
                {
                    name: 'Chart of Logins This Month',
                    i: 'chart_of_logins_this_month',
                    component: 'ChartOfLoginsThisMonth',
                    minW: 4,
                    minH: 5,
                    permission: 'admin_users',
                },
            ],
        }
    },

    created() {
        this.getDashboardLayout()
    },

    methods: {
        saveDashboardLayout() {
            this.makeHttpRequest('POST', '/api/dashboard?type=admin', { layout: this.layout })
        },

        getDashboardLayout() {
            this.makeHttpRequest('GET', '/api/dashboard?type=admin').then((response) => {
                this.layout = JSON.parse(response.data.data.content)
            })
        },

        removeFromDashboard() {
            this.availableComponents.push(this.layout.find((item) => item.i === this.selectedComponent))
            this.layout = this.layout.filter((item) => item.i !== this.selectedComponent)
            this.removeElementDialog = false
            this.saveDashboardLayout()
        },

        addToDashboard() {
            let component = this.availableComponents.find((component) => component.i === this.selectedComponent)
            if (this.hasPermission(component.permission) || component.permission === 'admin') {
                this.layout.push({
                    x: Math.floor(Math.random() * 6) * 2,
                    y: Math.floor(Math.random() * 6) * 2,
                    w: component.minW,
                    h: component.minH,
                    minH: component.minH,
                    minW: component.minW,
                    i: component.i,
                    name: component.name,
                    component: component.component,
                    permission: component.permission,
                })
                this.availableComponents = this.availableComponents.filter((component) => component.i !== this.selectedComponent)
                this.addElementDialog = false
                this.saveDashboardLayout()
            } else {
                this.showToast(this.$t('errors.permission_denied'), this.$t('errors.permission_denied_message'), 'error')
            }
        },
    },

    watch: {
        layout: {
            handler: function (newVal) {
                this.availableComponents = this.availableComponents.filter((component) => !newVal.find((item) => item.i === component.i))
            },
            deep: true,
        },
    },
}
</script>
