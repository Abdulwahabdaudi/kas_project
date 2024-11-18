<script setup>

import { ShoppingCart, ShoppingBag, X, Plus, Minus } from 'lucide-vue-next'
import { useCartStore } from '../../CartStore';
import { router } from '@inertiajs/vue3'
import { useToast } from "vue-toastification";

const toast = useToast();
const {
      cartItems,
      isCartOpen,
      cartTotal,
      cartCount,
      removeFromCart,
      updateQuantity,
      clearCart
    } = useCartStore()



const checkout = async () => {
    try {

        router.post(route('checkout'), [cartTotal.value,cartItems.value], {
        onSuccess: () => {
          toast.success('Order added successfully')
        },
        onError: () => {
          toast.error('Error saving product. Please try again.', 'error')

        },
      })

        clearCart()
        // Show success message or redirect to checkout page
    } catch (error) {
        toast.error('Error saving product. Please try again.', 'error')
    }
}


</script>
<!-- ShoppingCart.vue -->
<template>
    <!-- Cart Overlay -->
    <div v-if="isCartOpen" class="fixed inset-0 bg-gray-600 bg-opacity-10 z-40" @click="isCartOpen = false"></div>

    <!-- Cart Sidebar -->
    <div class="fixed right-0 top-0 h-full w-full sm:w-96 bg-white z-50 transform transition-transform duration-300"
        :class="isCartOpen ? 'translate-x-0' : 'translate-x-full'">
        <div class="flex flex-col h-full">
            <!-- Cart Header -->
            <div class="p-4 border-b bg-green-50">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Shopping Cart</h2>
                    <button @click="isCartOpen = false" class="text-gray-500 hover:text-gray-700">
                        <X class="h-6 w-6" />
                    </button>
                </div>
                <div class="mt-2 text-sm text-gray-500">
                    {{ cartCount }} items in cart
                </div>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4">
                <template v-if="cartItems.length">
                    <div v-for="item in cartItems" :key="item.id"
                        class="flex items-center space-x-4 bg-white rounded-lg border p-4">
                        <img :src="!item.image ? '/image/Place_holder.jpg' : `/storage/${item.image}`" :alt="item.image" class="w-20 h-20 object-cover rounded">
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-900">{{ item.name }}</h3>
                            <p class="text-sm text-gray-500">{{ item.category }}</p>
                            <div class="mt-1 flex items-center space-x-2">
                                <button @click="updateQuantity(item.id, item.quantity - 1)"
                                    class="text-gray-500 hover:text-gray-700">
                                    <Minus class="h-4 w-4" />
                                </button>
                                <span class="text-gray-700">{{ item.quantity }}</span>
                                <button @click="updateQuantity(item.id, item.quantity + 1)"
                                    class="text-gray-500 hover:text-gray-700">
                                    <Plus class="h-4 w-4" />
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <span class="font-medium text-gray-900">${{ (item.price * item.quantity).toFixed(2)
                                }}</span>
                            <button @click="removeFromCart(item.id)" class="text-red-600 hover:text-red-700 text-sm">
                                Remove
                            </button>
                        </div>
                    </div>
                </template>
                <div v-else class="text-center py-8">
                    <ShoppingBag class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-gray-900 font-medium">Your cart is empty</h3>
                    <p class="mt-1 text-gray-500">Add some products to your cart</p>
                </div>
            </div>

            <!-- Cart Footer -->
            <div class="border-t p-4 space-y-4">
                <div v-if="cartItems.length" class="space-y-2">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Subtotal</span>
                        <span>${{ cartTotal.toFixed(2) }}</span>
                    </div>
                   
                    <div class="flex justify-between font-medium text-gray-900">
                        <span>Total</span>
                        <span>${{ cartTotal.toFixed(2) }}</span>
                    </div>
                </div>
                <button @click="checkout" :disabled="!cartItems.length"
                    class="w-full bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed">
                   Add ORDER
                </button>
            </div>
        </div>
    </div>

    <!-- Cart Trigger Button -->
    <button @click="isCartOpen = true"
        class="fixed bottom-4 right-4 bg-green-600 text-white p-3 rounded-full shadow-lg hover:bg-green-700 z-30">
        <div class="relative">
            <ShoppingCart class="h-6 w-6" />
            <span v-if="cartCount"
                class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                {{ cartCount }}
            </span>
        </div>
    </button>
</template>