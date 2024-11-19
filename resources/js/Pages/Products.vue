<script setup>
import { ref, computed, watch } from 'vue'
import { LayoutGrid, List, ShoppingBag } from 'lucide-vue-next'
import UserLayout from '@/Layouts/UserLayout.vue';
import ShoppingCart from './Cart/ShoppingCart.vue';

import { useCartStore } from '../CartStore'


const { addToCart, } = useCartStore()


const selectedCategories = ref([])
const inStockOnly = ref(false)
const sortBy = ref('name')
const viewMode = ref('grid')

const props = defineProps({
    products: {
        type: Object,
        required: true,
    }
})
const categories = computed(() => {
    const categories = props.products.map(product => product.category);
    const uniqueCategories = [...new Set(categories)];
    return uniqueCategories;
})


const filteredProducts = computed(() => {
    let filtered = props.products

    // Category filter
    if (selectedCategories.value.length > 0) {
        filtered = filtered.filter(product =>
            selectedCategories.value.includes(product.category)
        )
    }

    // Stock filter
    if (inStockOnly.value) {
        filtered = filtered.filter(product => product.quantity >= 0)
    }

    // Sorting
    filtered = [...filtered].sort((a, b) => {
        switch (sortBy.value) {
            case 'price-asc':
                return a.price - b.price
            case 'price-desc':
                return b.price - a.price
            default:
                return a.name.localeCompare(b.name)
        }
    })

    return filtered
})


</script>


<!-- ProductPage.vue -->
<template>

    <UserLayout>
        <ShoppingCart />

        <div class="min-h-screen bg-gray-50">
            <!-- Hero Section -->
            <section id="home" class="relative pt-16 bg-green-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="pt-20 pb-24 text-center">
                        <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                            Your Premier Agricultural Supply Partner
                        </h1>
                        <p class="mt-6 max-w-2xl mx-auto text-xl text-green-100">
                            Delivering quality agricultural products and solutions to enhance farm productivity and
                            sustainability
                        </p>
                    </div>
                </div>
            </section>

            <!-- Header -->
            <div class="bg-white shadow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <h1 class="text-2xl font-bold text-gray-900">Agricultural Products</h1>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Filters Sidebar -->
                    <div class="w-full md:w-64 flex-none">
                        <div class="bg-white rounded-lg shadow p-4">
                            <h2 class="text-lg font-semibold mb-4">Filters</h2>

                            <!-- Category Filter -->
                            <div class="mb-6">
                                <h3 class="font-medium mb-2">Category</h3>
                                <div class="space-y-2">
                                    <label v-for="category in categories" :key="category" class="flex items-center">
                                        <input type="checkbox" :value="category" v-model="selectedCategories"
                                            class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                        <span class="ml-2 text-gray-700">{{ category }}</span>
                                    </label>
                                </div>
                            </div>



                            <!-- Availability Filter -->
                            <div class="mb-6">
                                <h3 class="font-medium mb-2">Availability</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" v-model="inStockOnly"
                                            class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                        <span class="ml-2 text-gray-700">In Stock Only</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="flex-grow">
                        <!-- Sort and View Options -->
                        <div class="bg-white rounded-lg shadow p-4 mb-6">
                            <div class="flex flex-col sm:flex-row justify-between items-center">
                                <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                                    <label class="text-sm font-medium text-gray-700">Sort by:</label>
                                    <select v-model="sortBy"
                                        class="rounded-md border-gray-300 text-sm focus:ring-green-500 focus:border-green-500">
                                        <option value="name">Name</option>
                                        <option value="price-asc">Price: Low to High</option>
                                        <option value="price-desc">Price: High to Low</option>
                                    </select>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button @click="viewMode = 'grid'"
                                        :class="['p-2 rounded-md', viewMode === 'grid' ? 'bg-green-100 text-green-600' : 'text-gray-400']">
                                        <LayoutGrid class="h-5 w-5" />
                                    </button>
                                    <button @click="viewMode = 'list'"
                                        :class="['p-2 rounded-md', viewMode === 'list' ? 'bg-green-100 text-green-600' : 'text-gray-400']">
                                        <List class="h-5 w-5" />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Products Display -->
                        <div :class="{
                            'grid gap-6': true,
                            'grid-cols-1': viewMode === 'list',
                            'grid-cols-2 lg:grid-cols-3': viewMode === 'grid'
                        }">
                            <div v-for="product in filteredProducts" :key="product.id"
                                class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div :class="{
                                    'flex': viewMode === 'list',
                                    'flex-col': viewMode === 'grid'
                                }">
                                    <div :class="{
                                        'flex-none': viewMode === 'list',
                                        'w-48': viewMode === 'list'
                                    }">
                                        <img :src="!product.image ? '/image/Place_holder.jpg' : `/storage/${product.image}`" :alt="product.name" class="h-48 w-full object-cover">
                                    </div>
                                    <div class="p-4 flex flex-col flex-grow">
                                        <div class="md:flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900">{{ product.name }}</h3>
                                                <p class="text-sm text-gray-600">{{ product.category }}</p>
                                            </div>
                                            <span class="text-lg font-bold text-green-600">{{ product.price }}Tsh</span>
                                        </div>
                                        <p class="mt-2 text-gray-700">{{ product.description }}</p>
                                        <div class="mt-4 md:flex  items-center justify-between">
                                            <span :class="[
                                                ' px-2 py-1 text-sm rounded-full',
                                                product.quantity >= 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                            ]">
                                                {{ product.quantity >= 1 ? 'In Stock' : 'Out of Stock' }}
                                            </span>
                                            <button @click="addToCart(product)" :disabled="product.quantity <= 0"
                                                class="mt-2 md:mt-0 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div v-if="filteredProducts.length === 0" class="text-center py-12">
                            <ShoppingBag class="mx-auto h-12 w-12 text-gray-400" />
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No products found</h3>
                            <p class="mt-2 text-gray-500">Try adjusting your filters or search criteria</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <ShoppingCart />

    </UserLayout>


</template>