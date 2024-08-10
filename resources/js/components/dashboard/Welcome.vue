<template>
    <div class="card">
        <h1>{{ $t('dashboard.welcome') + ' ' + user.data.first_name }}</h1>
    </div>
</template>
<script>
export default {
    name: 'DashboardWelcomeCard',
}
</script>
