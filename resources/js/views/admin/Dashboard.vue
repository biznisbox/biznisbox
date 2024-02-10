<template>
    <admin-layout>
        <LoadingScreen :blocked="loadingData">
            <user-header :title="$t('admin.dashboard.title')" />

            <div id="admin_dashboard">
                <div id="numbers" class="grid">
                    <div class="col-12 md:col-3">
                        <DashboardCard
                            :title="$t('admin.dashboard.total_users')"
                            icon="fa fa-users"
                            link="/admin/users"
                            :data="data.users"
                        />
                    </div>

                    <div class="col-12 md:col-3">
                        <DashboardCard
                            :title="$t('admin.dashboard.departments')"
                            icon="fa fa-building"
                            link="/admin/departments"
                            :data="data.departments"
                        />
                    </div>

                    <div class="col-12 md:col-3">
                        <DashboardCard
                            :title="$t('admin.dashboard.active_users_today')"
                            icon="fa fa-building-user"
                            :data="data.active_users"
                        />
                    </div>

                    <div class="col-12 md:col-3">
                        <DashboardCard
                            :title="$t('admin.dashboard.number_of_logins_today')"
                            icon="fa fa-right-to-bracket"
                            :data="data.logins"
                        />
                    </div>
                </div>
            </div>
        </LoadingScreen>
    </admin-layout>
</template>

<script>
export default {
    name: 'AdminDashboard',
    data() {
        return {
            data: {
                logins: 0,
                users: 0,
                active_users: 0,
            },
        }
    },

    created() {
        this.getDashboardData()
    },

    methods: {
        getDashboardData() {
            this.makeHttpRequest('get', '/api/admin/dashboard').then((response) => {
                this.data = response.data.data
            })
        },
    },
}
</script>

<style></style>
