<template>
    <div class="card p-4" @dblclick="goToLink">
        <span class="text-xl font-bold my-2 block">
            {{ title }}
        </span>

        <span class="float-right text-xl font-bold"> <i v-if="icon" :class="icon + ' mr-2'"></i> {{ data }} </span>
    </div>
</template>
<script>
export default {
    name: 'DashboardCardComponent',
    props: {
        title: {
            type: String,
            required: true,
        },
        icon: {
            type: String,
            required: false,
        },
        link: {
            type: String,
            required: false,
        },
        data: {
            required: false,
        },
    },

    methods: {
        goToLink() {
            if (this.link) {
                window.open(this.link, '_self')
            }
        },
    },
}
</script>
