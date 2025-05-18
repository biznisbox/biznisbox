<template>
    <div id="side_menu">
        <template v-for="item of menu_items" :key="item.name">
            <div v-if="!item.children && hasPermission(item.permission)">
                <router-link :to="item.to" class="side-menu-item text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-700">
                    <i v-if="item.icon" class="icon" :class="item.icon"></i>
                    <span>{{ $t(item.name) }}</span>
                </router-link>
            </div>
            <div v-if="item.children && item.children.length && hasAnyPermission(item.permissions)" :id="`side_menu_item_${item.meta[0]}`">
                <template v-if="item.children">
                    <router-link v-slot="{ isActive }" :to="item.children[0].to" custom>
                        <div>
                            <a
                                tabindex="0"
                                class="side-menu-item text-surface-300 hover:bg-surface-200 dark:text-surface-100 dark:hover:bg-surface-700"
                                @click="toggleSubmenu($event, item.meta[0])"
                            >
                                <i v-if="item.icon" class="icon" :class="item.icon"></i>
                                <span>{{ $t(item.name) }}</span>
                                <i class="fa fa-chevron-down toggle-icon"></i>
                            </a>
                            <transition name="sidemenu-toggleable-content">
                                <div v-show="isSubmenuActive(item.meta[0], isActive)" class="sidemenu-toggleable-content">
                                    <ul>
                                        <li v-for="(submenuitem, i) of item.children" :key="i">
                                            <router-link
                                                v-if="hasPermission(submenuitem.permission)"
                                                :to="submenuitem.to"
                                                class="side-menu-item text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-700"
                                            >
                                                <i v-if="submenuitem.icon" class="icon" :class="submenuitem.icon"></i>
                                                <span>{{ $t(submenuitem.name) }}</span>
                                            </router-link>
                                        </li>
                                    </ul>
                                </div>
                            </transition>
                        </div>
                    </router-link>
                </template>
            </div>
        </template>
    </div>
</template>

<script>
import UserMenu from '@/data/user_menu_items.json'
import AdminMenu from '@/data/admin_menu_items.json'
import ClientPortalMenu from '@/data/client_menu_items.json'
export default {
    name: 'SideMenuComponent',
    props: {
        menu_type: {
            type: String,
            default: 'user', // user, admin, client
        },
    },
    data() {
        return {
            activeSubmenus: {},
            selectedRoute: null,
            routes: [],
        }
    },
    computed: {
        menu_items() {
            if (this.menu_type === 'user') {
                return UserMenu
            } else if (this.menu_type === 'admin') {
                return AdminMenu
            } else if (this.menu_type === 'client') {
                return ClientPortalMenu
            }
            return []
        },
    },
    methods: {
        toggleSubmenu(event, name) {
            let active = this.activeSubmenus[name] === true
            this.activeSubmenus = {}
            if (!active) {
                this.activeSubmenus[name] = true
            }
            event.preventDefault()
        },

        isSubmenuActive(name, routerIsActive) {
            if (this.activeSubmenus[name]) {
                return true
            } else if (routerIsActive) {
                this.activeSubmenus[name] = true
                return true
            }
            return false
        },
    },
}
</script>
<style scoped>
.menu-items {
    padding: 0 0 0rem 0;
    display: flex;
    flex-direction: column;
}

.side-menu-item {
    display: flex;
    align-items: center;
    padding: 0.5rem 1rem;
    min-height: 48px;
    color: var(--grey-500);
    text-decoration: none;
    font-size: 1rem;
    font-weight: 400;
    border-radius: 0.25rem;
    cursor: pointer;
}

.side-menu-item .icon {
    margin-right: 0.5rem;
    font-size: 1.25rem;
}

.side-menu-item .toggle-icon {
    margin-left: auto;
    font-size: 1rem;
}

ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.router-link-active {
    color: var(--primary-500);
}
</style>
