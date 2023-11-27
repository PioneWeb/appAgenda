<template>
    <el-config-provider :locale="locales.find(x => {return x.name === $i18n.locale})">
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav class="bg-white dark:bg-black border-b border-gray-100 dark:border-gray-700">
                <!-- Primary Navigation Menu -->
                <div class="max-w-full mx-0 px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-12">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <application-mark style="width: 180px;" />
                                </Link>
                            </div>

                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 relative">
                                <!-- Teams Dropdown -->
                                <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.current_team.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <!-- Team Management -->
                                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Manage Team
                                                </div>
                                                <!-- Team Settings -->
                                                <DropdownLink :href="route('teams.show', $page.props.auth.user.current_team)">
                                                    Team Settings
                                                </DropdownLink>

                                                <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">
                                                    Create New Team
                                                </DropdownLink>

                                                <div class="border-t border-gray-200 dark:border-gray-600" />

                                                <!-- Team Switcher -->
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Switch Teams
                                                </div>

                                                <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                                    <form @submit.prevent="switchToTeam(team)">
                                                        <DropdownLink as="button">
                                                            <div class="flex items-center">
                                                                <svg v-if="team.id === $page.props.auth.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>

                                                                <div>{{ team.name }}</div>
                                                            </div>
                                                        </DropdownLink>
                                                    </form>
                                                </template>
                                            </template>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>

                            <el-button :icon="BeakerIcon" >  </el-button>

                            <el-button :icon="isDark ? MoonIcon : SunIcon" @click="toggleDark()" >  </el-button>

                            <el-button :icon="isDark ? Moon : Sunny" @click="toggleDark()">  </el-button>

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            {{ $t('Profile') }}
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                            {{ $t('API Tokens') }}
                                        </DropdownLink>

                                        <div class="border-t border-gray-200 dark:border-gray-600" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                {{ $t('Log Out') }}
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                {{ $t('Profile') }}
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200 dark:border-gray-600" />

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink :href="route('teams.show', $page.props.auth.user.current_team)" :active="route().current('teams.show')">
                                    Team Settings
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" :active="route().current('teams.create')">
                                    Create New Team
                                </ResponsiveNavLink>

                                <div class="border-t border-gray-200 dark:border-gray-600" />

                                <!-- Team Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Switch Teams
                                </div>

                                <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                    <form @submit.prevent="switchToTeam(team)">
                                        <ResponsiveNavLink as="button">
                                            <div class="flex items-center">
                                                <svg v-if="team.id == $page.props.auth.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </ResponsiveNavLink>
                                    </form>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <el-row class="tac">
                <el-col :span="3">
<!--                    <h5 class="mb-2 mx-12">Menu</h5>-->
                    <el-menu
                        default-active="2"
                        class="w-auto min-w-fit"
                        @open="handleOpen"
                        @close="handleClose"
                        @select="handleSelect"
                    >
                        <el-menu-item index="1">
                            <NavLink :href="route('home')" :active="route().current('home')"><el-icon><HomeIcon /></el-icon> {{ $t('Home') }}</NavLink>
                        </el-menu-item>

                        <el-sub-menu index="2" v-if="$page.props.roles[0].name==='amministratore' || $page.props.roles[0].name==='medico'">
                            <template #title>
                                <el-icon><edit /></el-icon>
                                <span>{{ $t('Anagrafica') }}</span>
                            </template>
                            <el-menu-item index="2-1" @click="">
                                <NavLink :href="route('companies.list')" :active="route().current('companies.list')"><el-icon><BuildingOfficeIcon /></el-icon> {{ $t('Aziende') }}</NavLink>
                            </el-menu-item>
                            <el-menu-item index="2-2">
                                <NavLink :href="route('users.list')" :active="route().current('users.list')"><el-icon><UsersIcon /></el-icon> {{ $t('Utenti') }}</NavLink>
                            </el-menu-item>
                            <el-menu-item index="2-3">
                                <NavLink :href="route('clinics.list')" :active="route().current('clinics.list')"><el-icon><UsersIcon /></el-icon> {{ $t('Ambulatori') }}</NavLink>
                            </el-menu-item>
                        </el-sub-menu>

                        <el-sub-menu index="3">
                            <template #title>
                                <el-icon><Operation /></el-icon>
                                <span>{{ $t('Operation') }}</span>
                            </template>

                            <el-menu-item index="2-4">
                                <NavLink :href="route('prescriptions.list')" :active="route().current('prescriptions.list')"><el-icon><UsersIcon /></el-icon> {{ $t('Ricette') }}</NavLink>
                            </el-menu-item>
                            <el-menu-item index="2-5">
                                <NavLink :href="route('schedules.list')" :active="route().current('schedules.list')"><el-icon><UsersIcon /></el-icon> {{ $t('Orari') }}</NavLink>
                            </el-menu-item>
                            <el-menu-item index="2-5">
                                <NavLink :href="route('events.list')" :active="route().current('events.list')"><el-icon><UsersIcon /></el-icon> {{ $t('Events') }}</NavLink>
                            </el-menu-item>

<!--                            <el-menu-item index="4">-->
<!--                                <NavLink :href="route('tickets.list')" :active="route().current('tickets.list')"><el-icon><Menu /></el-icon> {{ $t('Tickets') }}</NavLink>-->
<!--                            </el-menu-item>-->

<!--                            <el-menu-item index="4-1-1">-->
<!--                                <NavLink :href="route('services.list')" :active="route().current('services.list')"><el-icon><Document /></el-icon> {{ $t('Services') }}</NavLink>-->
<!--                            </el-menu-item>-->
<!--                            <el-menu-item index="4-1-2">-->
<!--                                <NavLink :href="route('tipitickets.list')" :active="route().current('tipitickets.list')"><el-icon><CreditCard /></el-icon> {{ $t('Tickets_types') }}</NavLink>-->
<!--                            </el-menu-item>-->

                        </el-sub-menu>

                        <el-menu-item index="5">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')"><el-icon><setting /></el-icon> {{ $t('Dashboard') }}</NavLink>
                        </el-menu-item>

                    </el-menu>

                </el-col>
                <el-col :span="21">
                    <!-- Page Content -->
                    <main>
                        <slot />
                    </main>
                </el-col>
            </el-row>


        </div>
    </el-config-provider>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { useDark, useToggle } from '@vueuse/core'
import 'element-plus/es/components/message/style/css';
import 'element-plus/es/components/message-box/style/css';
import 'element-plus/es/components/notification/style/css';
import 'element-plus/theme-chalk/dark/css-vars.css';
import 'element-plus/es/components/drawer/style/css';
import { HomeFilled, Setting, Document, Location, Menu, User, Sunny, Moon, Operation, CreditCard, Money, Edit } from '@element-plus/icons-vue';
import { BeakerIcon, BuildingOfficeIcon, UsersIcon, UserIcon, SunIcon, MoonIcon, HomeIcon } from '@heroicons/vue/24/solid';

// import { BeakerIcon, GlobeEuropeAfricaIcon, SunIcon, MoonIcon, HomeIcon } from '@heroicons/vue/24/outline';

const isDark = useDark()
const toggleDark = useToggle(isDark)

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
const handleSelect = (key, keyPath) => {
    console.log('Select ',key, keyPath)
}
const isCollapse = true
const handleOpen = (key, keyPath) => {
    console.log('Open ',key, keyPath)
}
const handleClose = (key, keyPath) => {
    //console.log('Close ',key, keyPath)
}
</script>

<style>

.btn {
    background-color: #409eff; /* Colore di sfondo del pulsante */
    border: none; /* Rimuove il bordo di default */
    color: white; /* Colore del testo del pulsante */
    padding: 8px 12px; /* Padding interno del pulsante */
    text-align: center; /* Centra il testo all'interno del pulsante */
    text-decoration: none; /* Rimuove il sottolineato del testo */
    display: inline-block; /* Imposta il display del pulsante come inline-block */
    font-size: 20px; /* Imposta la dimensione del testo del pulsante */
    border-radius: 4px; /* Arrotonda gli angoli del pulsante */
}
.gruppo{
    background-color: #043560;
}
</style>
<style scoped>
a {
    color: inherit;
    text-decoration: none;
    width: 100% !important;
}
</style>
