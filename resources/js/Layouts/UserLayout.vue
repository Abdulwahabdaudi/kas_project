<script setup>
import { ref } from 'vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Mail, Facebook, Instagram, Phone, MapPin, Youtube } from 'lucide-vue-next'

const isMenuOpen = ref(false)

import { usePage } from '@inertiajs/vue3';

const page = usePage();


</script>

<template>

    <Head title="Welcome" />
    <div class="min-h-screen bg-white">
        <!-- Navigation -->
        <nav class="fixed w-full bg-white shadow-md z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex-shrink-0 flex items-center">
                        <ApplicationLogo class="h-20 w-20" />
                        <span class="hidden md:inline text-xl font-bold text-green-700">KILIKAYA AGRO.SUPPLIER</span>
                    </div>
                    <div class="hidden md:flex items-center space-x-8">

                        <Link :href="route('welcome')" :class="{ 'active': route().current('welcome') }"
                            class="text-gray-700 hover:text-green-600">Home</Link>
                        <Link :href="route('about')" :class="{ 'active': route().current('about') }"
                            class="text-gray-700 hover:text-green-600">About</Link>
                        <Link :href="route('products')" :class="{ 'active': route().current('products') }"
                            class="text-gray-700 hover:text-green-600">Products</Link>
                        <Link v-if="$page.props.auth.user" :href="route('orders')"
                            :class="{ 'active': route().current('orders') }" class="text-gray-700 hover:text-green-600">
                        Orders
                        </Link>
                        <div v-if="$page.props.auth.user">
                        <Link v-if="$page.props.auth.user.role == 'admin' " :href="route('admin/dashboard')"
                            class="text-gray-700 hover:text-green-600">Dashboard</Link>
                        </div>
                        <div>
                            <Link v-if="$page.props.auth.user" method="POST" :href="route('logout')"
                                class="text-green-300 hover:text-green-600 font-bold">
                            logout
                            </Link>
                            <Link v-else :href="route('login')" class="text-green-300 hover:text-green-600 font-bold">
                            Login
                            </Link>
                        </div>

                    </div>
                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button @click="isMenuOpen = !isMenuOpen" class="text-gray-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path v-if="!isMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Mobile menu -->
            <div v-if="isMenuOpen" class="md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <Link :href="route('welcome')" :class="{ 'active': route().current('welcome') }"
                        class="block px-3 py-2 text-gray-700 hover:text-green-600">Home
                    </Link>
                    <Link :href="route('about')" :class="{ 'active': route().current('about') }"
                        class="block px-3 py-2 text-gray-700 hover:text-green-600">About</Link>
                    <Link :href="route('products')" :class="{ 'active': route().current('products') }"
                        class="block px-3 py-2 text-gray-700 hover:text-green-600">Products
                    </Link>
                    <Link v-if="$page.props.auth.user" :href="route('orders')"
                        :class="{ 'active': route().current('orders') }"
                        class="block px-3 py-2 text-gray-700 hover:text-green-600">Orders</Link>
                    <div v-if="$page.props.auth.user">
                        <Link v-if="page.props.auth.user.role == 'admin'" :href="route('admin/dashboard')"
                            class="block px-3 py-2 text-gray-700 hover:text-green-600">Dashboard</Link>
                    </div>

                    <div>
                        <Link v-if="$page.props.auth.user" method="POST" :href="route('logout')"
                            class="block px-3 py-2 text-green-300 font-bold hover:text-green-600 ">
                        logout
                        </Link>
                        <Link v-else :href="route('login')"
                            class="block px-3 py-2 text-green-300 font-bold hover:text-green-600 ">
                        Login
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-green-800 text-gray-300">
            <div class="max-w-6xl mx-auto px-4 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-white">KILIKAYA AGRO.SUPPLIER</h3>
                        <p class="text-gray-400">Delivering quality agricultural solutions.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-white">Quick Links</h3>
                        <ul class="space-y-2">
                            <li>
                                <v-icon icon="mdi-chevron-right" />
                                <Link :href="route('welcome')" class="hover:text-white">Home</Link>
                            </li>
                            <li>
                                <v-icon icon="mdi-chevron-right" />
                                <Link :href="route('about')" class="hover:text-white">About</Link>
                            </li>
                            <li>
                                <v-icon icon="mdi-chevron-right" />
                                <Link :href="route('products')" class="hover:text-white">Products</Link>
                            </li>
                            <li v-if="!$page.props.auth.user">
                                <v-icon icon="mdi-chevron-right" />
                                <Link :href="route('login')" class="hover:text-white">Login</Link>
                            </li>
                            <li v-if="!$page.props.auth.user">
                                <v-icon icon="mdi-chevron-right" />
                                <Link :href="route('register')" class="hover:text-white">Register</Link>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-white">Contact</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li class="flex gap-3">
                                <Mail></Mail>kilikayaagrosuppliergmail.com
                            </li>
                            <li class="flex gap-3">
                                <Phone></Phone>+255683196764
                            </li>
                            <li class="flex gap-3">
                                <MapPin></MapPin>Morogoro Tz
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-white">Follow Us</h3>
                        <div class="flex space-x-4">
                            <div class="flex gap-2">
                                <Instagram></Instagram>
                                <a href="https://www.instagram.com/kilikaya_agro_suplier/"
                                    class="hover:text-white">Instagram</a>
                            </div>
                            <div class="flex gap-2">
                                <Youtube></Youtube>
                                <a href="www.youtube.com/@kilikayaAgro.supplier" class="hover:text-white">Youtube</a>
                            </div>
                            <!-- <div class="flex gap-2">
                                <Facebook></Facebook>
                                <a href="#" class="hover:text-white">Facebook</a>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="border-t border-green-700 mt-8 pt-8 text-center">
                    <p>&copy; {{ new Date().getFullYear() }} KILIKAYA AGRO.SUPPLIER. All rights reserved.</p>
                </div>
            </div>
            <div class="text-center pb-2">
                <a href="https://wa.me/+255655373215">
                    <v-icon icon="mdi-whatsapp" /> Developers Contacts
                </a>
            </div>
        </footer>
    </div>


</template>


<style>
.active {
    @apply bg-green-600 text-white rounded-lg p-2 hover:text-slate-200;
}
</style>
