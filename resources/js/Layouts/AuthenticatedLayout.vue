<script setup>
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

import { HomeIcon, CarIcon, UsersRound, User, WrenchIcon, LogOut, ContainerIcon} from 'lucide-vue-next';
import ToastList from '@/Components/ToastList.vue'


const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <ToastList />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100" style="background-color: #003366;">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink class="text-white" :href="route('dashboard')"
                                    :active="route().current('dashboard')">
                                    <HomeIcon strokeWidth={1} class="mr-2" />
                                    Home
                                </NavLink>
                                <NavLink class="text-white" :href="route('clientes')" :active="$page.url.startsWith('/clientes') || $page.url.startsWith('/veiculos')">
                                    <UsersRound strokeWidth={1} class="mr-2" />
                                    Clientes
                                </NavLink>
                                <NavLink class="text-white" :href="route('marcas')" :active="$page.url.startsWith('/revisoes')">
                                    <WrenchIcon strokeWidth={1} class="mr-2" />
                                    Revisões
                                </NavLink>
                                <NavLink class="text-white" :href="route('marcas')" :active="$page.url.startsWith('/marcas')">
                                    <ContainerIcon strokeWidth={1} class="mr-2" />
                                    Marcas
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white  hover:text-blue-400 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')">
                                            <User />
                                            Perfil
                                        </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            <LogOut />
                                            Sair
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400  focus:outline-none focus:bg-blue-400 focus:text-white-500 transition duration-150 ease-in-out">
                                <svg class="text-white h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink class="" :href="route('dashboard')" :active="route().current('dashboard')">
                            <HomeIcon strokeWidth={1} class="mr-2" />
                            Home
                        </ResponsiveNavLink>
                        <ResponsiveNavLink class="" :href="route('clientes')" :active="$page.url.startsWith('/clientes') || $page.url.startsWith('/veiculos') ">
                            <UsersRound strokeWidth={1} class="mr-2" />
                            Clientes
                        </ResponsiveNavLink>
                        <ResponsiveNavLink class="" :href="route('marcas')" :active="$page.url.startsWith('/revisoes')">
                            <WrenchIcon strokeWidth={1} class="mr-2" />
                            Revisões
                        </ResponsiveNavLink>
                        <ResponsiveNavLink class="" :href="route('marcas')" :active="$page.url.startsWith('/revisoes')">
                            <ContainerIcon strokeWidth={1} class="mr-2" />
                            Marcas
                        </ResponsiveNavLink>

                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-white">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-white">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                <User />
                                Perfil
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                <LogOut />
                                Sair
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
