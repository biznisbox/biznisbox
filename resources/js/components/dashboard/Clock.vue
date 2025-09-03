<template>
    <DashboardCardWithIcon :iconClass="'fas fa-clock'" :dashboardTitle="$t('dashboard.current_time')" :dashboardData="currentTime" />
</template>
<script>
export default {
    name: 'DashboardClock',
    data() {
        return {
            currentTime: new Date().toLocaleTimeString(),
        }
    },
    created() {
        setInterval(() => {
            this.currentTime = new Date().toLocaleTimeString()
        }, 1000)
    },
}
</script>
