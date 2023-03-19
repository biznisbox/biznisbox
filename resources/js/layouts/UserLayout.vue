<template>
    <div id="user_layout" class="mb-3">
        <Toolbar class="toolbar">
            <template #start>
                <Button icon="pi pi-bars" class="p-button-rounded p-button-text" @click="toggleMenu" />
            </template>

            <template #end>
                <Avatar
                    v-if="user.data.avatar == null"
                    :label="user.data.initials"
                    class="user-avatar cursor-pointer"
                    @click="toggleUserMenu"
                />
                <Avatar
                    v-if="user.data.avatar != null"
                    :image="user.data.avatar"
                    class="user-avatar cursor-pointer"
                    @click="toggleUserMenu"
                />
                <Menu ref="user-avatar-menu" :model="menu_items" :popup="true" class="user-avatar-menu-dropdown" />
            </template>
        </Toolbar>

        <Sidebar id="menu" v-model:visible="showSidebar" :show-close-icon="false">
            <template #header>
                <div class="justify-content-start">
                    <h3>{{ $settings.company_name }}</h3>
                </div>
            </template>

            <div id="sidebar_menu">
                <side-menu :menu="user_menu_items"></side-menu>
            </div>
        </Sidebar>

        <div class="mx-3 mt-3">
            <slot></slot>
        </div>
    </div>
</template>

<script>
import UserMenuItems from '@/data/user_menu_items.json'
import SideMenu from '@/components/SideMenu.vue'
export default {
    name: 'UserLayout',
    components: { SideMenu },
    data() {
        return {
            showSidebar: false,
            user_menu_items: UserMenuItems,
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
