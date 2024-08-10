<template>
    <div class="card p-4">
        <span class="my-2 block">
            {{ $t('dashboard.current_time') }}
        </span>
        <span> <i class="fas fa-clock"></i> {{ currentTime }} </span>
    </div>
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
