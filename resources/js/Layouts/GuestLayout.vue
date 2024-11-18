<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <div class="flex min-h-screen flex-col items-center pt-6 sm:justify-center sm:pt-0">
        <div>
            <Link href="/">
            <ApplicationLogo class="h-32 w-32h-32" />
            </Link>
        </div>

        <Card class="mb-10 w-11/12 md:w-full overflow-hidden bg-slate-50 px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg">
            <slot />
        </Card>
    </div>
</template>
