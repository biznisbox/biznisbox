<template>
    <div id="side_menu">
        <template v-for="item of menu" :key="item.name">
            <div v-if="!item.children && hasPermission(item.permission)">
                <router-link :to="item.to" class="side-menu-item">
                    <i v-if="item.icon" class="icon" :class="item.icon"></i>
                    <span>{{ $t(item.name) }}</span>
                </router-link>
            </div>
            <div v-if="item.children && item.children.length">
                <template v-if="item.children">
                    <router-link v-slot="{ isActive }" :to="item.children[0].to" custom>
                        <div>
                            <a tabindex="0" class="side-menu-item" @click="toggleSubmenu($event, item.meta[0])">
                                <i v-if="item.icon" class="icon" :class="item.icon"></i>
                                <span>{{ $t(item.name) }}</span>
                                <i class="fa fa-chevron-down toggle-icon"></i>
                            </a>
                            <transition name="p-toggleable-content">
                                <div v-show="isSubmenuActive(item.meta[0], isActive)" class="p-toggleable-content">
                                    <ul>
                                        <li v-for="(submenuitem, i) of item.children" :key="i">
                                            <router-link
                                                v-if="hasPermission(submenuitem.permission)"
                                                :to="submenuitem.to"
                                                class="side-menu-item"
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
export default {
    name: 'SideMenuComponent',
    props: {
        menu: {
            type: Array,
            default: UserMenu,
        },
    },
    data() {
        return {
            activeSubmenus: {},
            selectedRoute: null,
            routes: [],
        }
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
    padding: 0 0 1rem 0;
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

.side-menu-item:hover {
    background-color: var(--blue-50);
    color: var(--blue-600);
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
    color: var(--blue-500);
}
</style>
