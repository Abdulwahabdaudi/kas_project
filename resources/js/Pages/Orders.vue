<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3';

import { useToast } from "vue-toastification";

const toast = useToast();
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'



// State
const searchQuery = ref('')
const statusFilter = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)
const isModalOpen = ref(false)


// Sample orders data (replace with API call)
//const orders = computed(() => props.orders);
const orders = computed(() => props.orders);

const props = defineProps({

orders: {
  type:Object,
  required: true
}
})

const orderItems = ref({
    items: [
        {
            productId: '',
            name: '',
            quantity: 1,
            price: 0
        }
    ]
})

// Computed Properties
const filteredOrders = computed(() => {
    let filtered = orders.value

    if (searchQuery.value) {
        filtered = filtered.filter(order =>
            order.id.includes(searchQuery.value) ||
            order.items.some(item => item.name.toLowerCase().includes(searchQuery.value.toLowerCase()))
        )
    }

    if (statusFilter.value) {
        filtered = filtered.filter(order => order.status === statusFilter.value)
    }

    return filtered
})

const totalOrders = computed(() => filteredOrders.value.length)
const totalPages = computed(() => Math.ceil(totalOrders.value / itemsPerPage.value))
const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value)
const endIndex = computed(() => Math.min(startIndex.value + itemsPerPage.value, totalOrders.value))


const calculateTotal = computed(() => {
    return orderItems.value.items.reduce((total, item) => {
        return total + (item.quantity * item.price)
    }, 0).toFixed(2)
})


const getStatusClasses = (status) => {
    const baseClasses = 'px-2 py-1 text-xs font-medium rounded-full'
    const statusClasses = {
        pending: 'bg-yellow-100 text-yellow-800',
        confirmed: 'bg-blue-100 text-blue-800',
        shipped: 'bg-purple-100 text-purple-800',
        delivered: 'bg-green-100 text-green-800',
        cancelled: 'bg-red-100 text-red-800'
    }
    return `${baseClasses} ${statusClasses[status]}`
}



const openModal = () => {
    isModalOpen.value = true
}

const closeModal = () => {
    isModalOpen.value = false
}


const viewOrder = (order) => {
    orderItems.value = {
        items: [...order.items]
    }
    openModal()
}




const cancelOrder = async (order) => {
    if (confirm('Are you sure you want to cancel this order?')) {
        // loading.value = true
        try {
            // Simulate API call
            await new Promise(resolve => setTimeout(resolve, 1000))

            const selectedOrder = orders.value.find(o => o.id === order.id)

            router.post(`/orders/changeStatus/${selectedOrder.id}`,
                selectedOrder, {
                onSuccess: () => {
                    toast.success('Product Update successfully')
                },
                onError: () => {
                    toast.error('Error saving product. Please try again.', 'error')

                },
            })
            // Here you would normally make an API call to cancel the order
            // await cancelOrder(order.id)

            // Simulate order cancellation for demo
            // if (orderIndex !== -1) {
            //     orders.value[orderIndex].status = 'cancelled'
            // }

            // Show success message
            //alert('Order cancelled successfully!')
        } catch (error) {
            console.error('Error cancelling order:', error)
            alert('Error cancelling order. Please try again.')
        } finally {
            //loading.value = false
        }
    }
}

const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--
    }
}

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++
    }
}


</script>


<template>


    <UserLayout>
        <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
            <div class="mt-12 md:max-w-[90%] mx-auto ">

                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">My Orders</h1>
                    <p class="mt-2 text-sm text-gray-600">Track and manage your orders</p>
                </div>

                <!-- Filters -->
                <div class="mb-6 flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <input v-model="searchQuery" type="text" placeholder="Search orders..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                    </div>
                    <select v-model="statusFilter"
                        class="px-8 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <Link :href="route('products')" class="text-gray-700 hover:text-green-600">
                    <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        Place New Order
                    </button>
                    </Link>

                </div>

                <!-- Orders Table -->
                <div class="bg-white rounded-lg shadow overflow-scroll">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order ID
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order Date
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Items
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="order in filteredOrders" :key="order.id">
                                <td class="px-6 py-4 whitespace-nowrap">#{{ order.id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ order.date }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ order.items.length }} items</div>
                                    <!-- <div class="text-sm text-gray-500">{{ order.items[0].name ?? 'no' }}...</div> -->
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">${{ Number(order.total).toFixed(2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="getStatusClasses(order.status)">{{ order.status }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <button @click="viewOrder(order)" class="text-blue-600 hover:text-blue-900 mr-3">
                                        View
                                    </button>
                                    <button v-if="order.status === 'pending'" @click="cancelOrder(order)"
                                        class="text-red-600 hover:text-red-900">
                                        Cancel
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-between items-center">
                    <div class="text-sm text-gray-700">
                        Showing {{ startIndex + 1 }} to {{ endIndex }} of {{ totalOrders }} orders
                    </div>
                    <div class="flex gap-2">
                        <button @click="previousPage" :disabled="currentPage === 1"
                            class="px-4 py-2 border border-gray-300 rounded-lg disabled:opacity-50">
                            Previous
                        </button>
                        <button @click="nextPage" :disabled="currentPage === totalPages"
                            class="px-4 py-2 border border-gray-300 rounded-lg disabled:opacity-50">
                            Next
                        </button>
                    </div>
                </div>

                <!-- Order Modal -->
                <TransitionRoot appear :show="isModalOpen" as="template">
                    <Dialog as="div" @close="closeModal" class="relative z-50">
                        <!-- Backdrop -->
                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0"
                            enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100"
                            leave-to="opacity-0">
                            <div class="fixed inset-0 bg-black/25" />
                        </TransitionChild>

                        <!-- Modal -->
                        <div class="fixed inset-0 overflow-y-auto">
                            <div class="flex min-h-full items-center justify-center p-4">
                                <TransitionChild as="template" enter="duration-300 ease-out"
                                    enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100"
                                    leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                                    leave-to="opacity-0 scale-95">
                                    <DialogPanel
                                        class="w-full max-w-3xl transform overflow-hidden rounded-lg bg-white p-6 shadow-xl transition-all">
                                        <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900 mb-4">
                                            Order Details
                                        </DialogTitle>

                                        <!-- Order Form -->
                                        <form @submit.prevent="" class="space-y-6">

                                            <!-- Product Selection -->
                                            <div class="space-y-4">
                                                <div class="flex justify-between items-center">
                                                    <h4 class="text-sm font-medium text-gray-900">Products</h4>

                                                </div>

                                                <div v-for="(item, index) in orderItems.items" :key="index"
                                                    class="space-y-4">
                                                    <div class="flex items-center gap-4">
                                                        <div class="flex-1">

                                                            <div class="text-sm text-gray-900">
                                                                {{ item.name }}
                                                            </div>
                                                        </div>
                                                        <div class="w-24">
                                                            <label
                                                                class="block text-sm font-medium text-gray-700">Quantity</label>
                                                            <input type="number" v-model="item.quantity" readonly
                                                                min="1"
                                                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-green-500 focus:ring-green-500"
                                                                required />
                                                        </div>
                                                        <div class="w-32">
                                                            <label
                                                                class="block text-sm font-medium text-gray-700">Price</label>
                                                            <div class="mt-2 text-sm text-gray-900">${{ (item.price *
                                                                item.quantity).toFixed(2) }}</div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Order Summary -->
                                            <div class="space-y-4 border-t pt-4">
                                                <h4 class="text-sm font-medium text-gray-900">Order Summary</h4>
                                                <div class="flex justify-between text-sm font-bold">
                                                    <span>Total:</span>
                                                    <span>${{ calculateTotal }}</span>
                                                </div>
                                            </div>

                                            <!-- Form Actions -->
                                            <div class="flex justify-end gap-4">
                                                <button type="button" @click="closeModal"
                                                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-800 focus:outline-none">
                                                    Cancel
                                                </button>

                                            </div>
                                        </form>
                                    </DialogPanel>
                                </TransitionChild>
                            </div>
                        </div>
                    </Dialog>
                </TransitionRoot>
            </div>
        </div>
    </UserLayout>

</template>