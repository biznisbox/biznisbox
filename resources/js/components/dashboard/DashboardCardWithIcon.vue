<template>
    <div class="card">
        <div class="flex items-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-100 dark:bg-primary-900/50 mr-4">
                <i :class="iconClass + ' text-primary-600 dark:text-primary-400 text-xl'"></i>
            </div>

            <div>
                <span class="block text-sm font-medium text-surface-500 dark:text-surface-400">
                    {{ dashboardTitle }}
                </span>
                <div class="text-2xl font-bold mt-1">
                    {{ dashboardData }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'DashboardCardWithIcon',
    props: {
        dashboardData: {
            type: [Number, String],
            required: true,
        },
        dashboardTitle: {
            type: String,
            required: true,
        },
        iconClass: {
            type: String,
            default: 'fa fa-info-circle',
        },
    },
}
</script>
