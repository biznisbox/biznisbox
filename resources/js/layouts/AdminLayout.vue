<template>
    <div id="admin_layout">
        <Toolbar class="toolbar">
            <template #start>
                <Button icon="pi pi-bars" class="p-button-rounded p-button-text" @click="toggleMenu" />
            </template>

            <template #end>
                <Button v-if="theme == 'dark'" icon="pi pi-sun" text rounded aria-label="Filter" @click="changeTheme()" />
                <Button v-if="theme == 'light'" icon="pi pi-moon" text rounded aria-label="Filter" @click="changeTheme()" />

                <Avatar
                    v-if="user.data.picture == null"
                    :label="user.data.initials"
                    class="user-avatar cursor-pointer"
                    @click="toggleUserMenu"
                />
                <Avatar
                    v-if="user.data.picture != null"
                    :image="user.data.picture"
                    class="user-avatar cursor-pointer bg-transparent"
                    @click="toggleUserMenu"
                />
                <Menu ref="user-avatar-menu" :model="menu_items" popup class="user-avatar-menu-dropdown" />
            </template>
        </Toolbar>

        <Sidebar id="menu" v-model:visible="showSidebar" :show-close-icon="false">
            <template #header>
                <div class="justify-content-start">
                    <h3>{{ $settings.company_name }}</h3>
                </div>
            </template>

            <div id="sidebar_menu">
                <side-menu :menu="admin_menu_items"></side-menu>
            </div>
        </Sidebar>

        <div class="m-2">
            <slot></slot>
        </div>
    </div>
</template>

<script>
import AdminMenuItems from '@/data/admin_menu_items.json'
import SideMenu from '@/components/SideMenu.vue'
export default {
    name: 'AdminLayout',
    components: { SideMenu },
    data() {
        return {
            showSidebar: false,
            admin_menu_items: AdminMenuItems,
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
        toggleMenu() {
            this.showSidebar = !this.showSidebar
        },

        toggleUserMenu(event) {
            this.$refs['user-avatar-menu'].toggle(event)
        },
    },
}
</script>

<style scoped>
.p-menu {
    width: 100% !important;
    border: none !important;
}

.p-menu .p-menuitem-link {
    padding-left: 0 !important;
}

.p-toolbar {
    border-radius: 0 !important;
    border: none !important;
    padding: 0 !important;
}

.user-avatar {
    margin-right: 10px !important;
}

.user-avatar-menu-dropdown {
    width: 250px !important;
}

.p-menu .p-menuitem-link {
    padding: 5 !important;
}
</style>
