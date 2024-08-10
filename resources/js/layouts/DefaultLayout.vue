<template>
    <div id="toolbar">
        <Toolbar class="toolbar">
            <template #start>
                <Button icon="fa fa-bars" class="w-10 h-10" @click="toggleSidebar" />
            </template>

            <template #end>
                <div id="theme-switch" class="mr-3">
                    <Button v-if="theme == 'dark'" icon="fa fa-sun" text rounded @click="changeTheme" />
                    <Button v-if="theme == 'light'" icon="fa fa-moon" text rounded @click="changeTheme" />
                </div>

                <!--
                <div class="mr-3">
                    <div class="relative">
                        <span
                            v-if="countUnreadNotifications() > 0"
                            class="absolute -top-2 -right-2 h-5 w-5 rounded-full text-white bg-red-600 flex justify-center items-center items p-2"
                            ><span>{{ countUnreadNotifications() }}</span></span
                        >
                        <Button icon="fa fa-bell" class="w-10 h-10" @click="toggleNotifications" text rounded />
                    </div>

                    <OverlayPanel ref="notificationsOverlay" id="notifications-overlay">
                        <div class="flex flex-col">
                            <div>
                                <div class="flex justify-center items-center gap-2">
                                    <span class="font-medium text-surface-700 dark:text-surface-100">{{
                                        $t('user_nav_menu.notifications')
                                    }}</span>
                                    <Button icon="fa fa-refresh" class="ml-auto w-5 h-5" @click="getNotifications" text rounded />
                                </div>
                                <ul class="list-none flex flex-col gap-2 overflow-y-auto h-[20rem]">
                                    <li
                                        v-for="notification in notifications"
                                        :key="notification.id"
                                        class="flex items-center gap-2 hover:bg-gray-100 dark:hover:bg-slate-500 p-2 rounded-lg"
                                        @click="notificationAction(notification.action_url)"
                                        :class="{
                                            'bg-gray-100 dark:bg-slate-500': notification.is_read == 0,
                                            'cursor-pointer': notification.action_url,
                                        }"
                                    >
                                        <i v-if="notification.type == 'error'" class="fa fa-exclamation-circle text-2xl text-red-500"></i>
                                        <i v-if="notification.type == 'info'" class="fa fa-info-circle text-2xl text-blue-500"></i>
                                        <i
                                            v-if="notification.type == 'warning'"
                                            class="fa fa-exclamation-triangle text-2xl text-yellow-500"
                                        ></i>
                                        <i v-if="notification.type == 'success'" class="fa fa-check-circle text-2xl text-green-500"></i>

                                        <div>
                                            <span class="font-medium dark:text-surface-100">{{ notification.title }}</span>
                                            <div class="text-sm dark:text-surface-100 text-wrap">{{ notification.content }}</div>
                                            <div class="text-xs dark:text-surface-100">{{ formatDateTime(notification.created_at) }}</div>
                                        </div>
                                        <div class="flex-grow"></div>
                                        <Button
                                            v-if="notification.is_read == false"
                                            icon="fa fa-eye"
                                            class="w-5 h-5"
                                            @click="markNotificationAsRead(notification.id)"
                                            text
                                            rounded
                                        />
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </OverlayPanel>
                </div>
                -->
                <Avatar :image="user.data.avatar_url" class="user-avatar" @click="toggleUserMenu" size="large" />
                <Menu ref="user-avatar-menu" :model="menu_items" popup />
            </template>
        </Toolbar>

        <Drawer
            id="side-menu"
            v-model:visible="showSidebar"
            :showCloseIcon="false"
            :pt="{
                content: {
                    class: ['h-full', 'w-full', 'grow', 'overflow-y-auto'],
                },
            }"
        >
            <template #header>
                <img v-if="$settings.company_logo" :src="`/storage/${$settings.company_logo}`" class="w-10 h-10" alt="logo" />
                <div class="text-sufrace-500 dark:text-surface-100">
                    <h1 class="text-lg font-bold">{{ $settings?.company_name ?? 'BiznisBox' }}</h1>
                </div>
            </template>

            <div id="sidebar-menu">
                <SideMenu :menu_type="menu_type" />
            </div>
        </Drawer>

        <div class="mx-1 p-1 pb-4">
            <slot></slot>
        </div>
    </div>
</template>
<script>
export default {
    name: 'DefaultLayout',
    props: {
        menu_type: {
            type: String,
            default: 'user', // user, admin, client
        },
    },

    created() {
        this.getNotifications()
    },

    data() {
        return {
            showSidebar: false,
            menu_items: [
                {
                    label: this.$t('user_nav_menu.profile'),
                    icon: 'fa fa-user',
                    command: () => {
                        this.$router.push('/profile')
                    },
                },
                {
                    label: this.$t('user_nav_menu.logout'),
                    icon: 'fa fa-sign-out-alt',
                    command: () => {
                        this.$router.push('/auth/logout')
                    },
                },
            ],
        }
    },

    methods: {
        toggleUserMenu(event) {
            this.$refs['user-avatar-menu'].toggle(event)
        },

        toggleSidebar() {
            this.showSidebar = !this.showSidebar
        },

        toggleNotifications() {
            this.$refs.notificationsOverlay.toggle(event)
        },

        countUnreadNotifications() {
            return this.notifications.filter((notification) => notification.is_read == 0).length
        },

        notificationAction(url) {
            if (url) {
                return this.$router.push('/' + url)
            }
            return
        },
    },
}
</script>
<style>
.toolbar {
    padding: 0.5rem !important;
    border-radius: 0 !important;
}

.user-avatar {
    background-color: transparent !important;
    margin-right: 10px !important;
}

.user-avatar-menu-dropdown {
    width: 250px !important;
}
</style>
