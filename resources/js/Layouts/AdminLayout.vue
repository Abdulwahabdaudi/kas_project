<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue'
import { useTheme } from 'vuetify'

const theme = useTheme()
const drawer = ref(false)
const menu = ref(false)


function toggleTheme() {
    theme.global.name.value = theme.global.current.value.dark ? 'light' : 'dark'
}
</script>


<template>
    <v-app>

        <!-- Navbar -->
        <v-app-bar :elevation="1" rounded>
            <template v-slot:prepend>
                <v-app-bar-nav-icon variant="text" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            </template>

            <v-app-bar-title>Kas</v-app-bar-title>

            <div class="text-center">
                <v-menu v-model="menu" :close-on-content-click="false" location="end">
                    <template v-slot:activator="{ props }">

                        <div class="pr-3 text-center" v-bind="props">
                            <v-btn-group color="green" density="comfortable" rounded="pill" divided>
                                <v-btn class="pe-2" prepend-icon="mdi-account-outline" variant="flat">
                                    <div class="text-none font-weight-regular">
                                        Admin
                                    </div>
                                    <v-icon icon="mdi-menu-down"></v-icon>
                                </v-btn>

                            </v-btn-group>
                        </div>
                    </template>

                    <v-card min-width="200">
                        <v-list>
                            <v-list-item :prepend-avatar="'/image/Profile_avatar_placeholder.png'"
                                :subtitle="$page.props.auth.user.email" :title="$page.props.auth.user.first_name">

                            </v-list-item>
                        </v-list>
                        <v-divider></v-divider>
                        <div class="m-3">
                            <v-btn :prepend-icon="theme === 'light' ? 'mdi-weather-sunny' : 'mdi-weather-night'"
                                text="Toggle Theme" slim @click="toggleTheme"></v-btn>
                        </div>
                        <div class="m-3">
                            <Link :href="route('logout')" method="post">
                            <v-btn prepend-icon="mdi-logout" text="Logout"></v-btn>
                            </Link>

                        </div>
                    </v-card>
                </v-menu>
            </div>
        </v-app-bar>

        <!-- sidebar -->
        <v-navigation-drawer v-model="drawer" :location="$vuetify.display.mobile ? 'top' : undefined" temporary>
            <v-list>
                <Link :href="route('admin/dashboard')">
                <v-list-item title="Dashboard" value="Dashboard"
                    :class="{ 'bg-green': route().current('admin/dashboard') }">
                </v-list-item>
                </Link>
            </v-list>
            <v-list>
                <Link :href="route('admin/products')">
                <v-list-item title="Products" value="Products"
                    :class="{ 'bg-green': route().current('admin/products') }">
                </v-list-item>
                </Link>
            </v-list>
            <v-list>
                <Link :href="route('admin/orders')">
                <v-list-item title="Orders" value="Orders" :class="{ 'bg-green': route().current('admin/orders') }">
                </v-list-item>
                </Link>
            </v-list>

        </v-navigation-drawer>

        <!-- main content -->
        <v-main>
            <v-container>
                <slot />
            </v-container>
        </v-main>

    </v-app>
</template>