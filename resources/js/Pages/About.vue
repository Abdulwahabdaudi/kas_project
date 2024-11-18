<script setup>
import { ref } from 'vue'
import UserLayout from '@/Layouts/UserLayout.vue';

const title = ref('About Kilikayo Agro Suppliers')
const subtitle = ref('Your Trusted Partner in Agricultural Excellence')
const mission = ref('Emphasis on bridging the gap between small farmers and end users as most of smallholders in Tanzania are faced with limited market opportunities. ')
const vision = ref('To become a leading agricultural products export company in east Africa and Africa at large by ensuring provision of quality products to our clients. Quality is our first concern. ')

const values = ref([
    {
        title: 'Quality',
        description: 'We provide only the highest quality agricultural supplies and products to ensure optimal results for our customers.'
    },
    {
        title: 'Sustainability',
        description: 'We promote environmentally conscious farming practices and sustainable agricultural solutions.'
    },
    {
        title: 'Innovation',
        description: 'We continuously seek and implement innovative agricultural technologies and methods.'
    },
    {
        title: 'Customer Focus',
        description: 'We prioritize our customers needs and provide personalized support and solutions.'
    }
])



</script>


<template>
    <UserLayout>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-32">
            <!-- Hero Section -->
            <header class="text-center  mb-16 bg-green-700 py-16 rounded-lg">
                <h1 class="text-4xl font-bold text-gray-200 mb-4">{{ title }}</h1>
                <p class="text-xl text-gray-300">{{ subtitle }}</p>
            </header>

            <!-- Mission Section -->
            <section class="mb-16">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Our Mission</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto text-center">{{ mission }}</p>
            </section>

            <!-- vision Section -->
            <section class="mb-16">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Our Vision</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto text-center">{{ vision }}</p>
            </section>

            <!-- Values Section -->
            <section class="mb-16">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Our Values</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div v-for="(value, index) in values" :key="index"
                        class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ value.title }}</h3>
                        <p class="text-gray-600">{{ value.description }}</p>
                    </div>
                </div>
            </section>



        </div>

    </UserLayout>
</template>