
// CartStore.js
import { ref, computed } from 'vue'

// Define shared state outside of the function to ensure a single instance
const cartItems = ref([])
const isCartOpen = ref(false)

const cartTotal = computed(() => {
  return cartItems.value.reduce((total, item) => total + item.price * item.quantity, 0)
})

const cartCount = computed(() => {
  return cartItems.value.reduce((count, item) => count + item.quantity, 0)
})

const addToCart = (product) => {
  const existingItem = cartItems.value.find(item => item.id === product.id)
  if (existingItem) {
    existingItem.quantity += 1
  } else {
    cartItems.value.push({ ...product, quantity: 1 })
  }
  isCartOpen.value = true
}

const removeFromCart = (productId) => {
  const index = cartItems.value.findIndex(item => item.id === productId)
  if (index > -1) {
    cartItems.value.splice(index, 1)
  }
}

const updateQuantity = (productId, quantity) => {
  const item = cartItems.value.find(item => item.id === productId)
  if (item) {
    item.quantity = Math.max(0, quantity)
    if (item.quantity === 0) {
      removeFromCart(productId)
    }
  }
}

const clearCart = () => {
  cartItems.value = []
  isCartOpen.value = false
}

export const useCartStore = () => ({
  cartItems,
  isCartOpen,
  cartTotal,
  cartCount,
  addToCart,
  removeFromCart,
  updateQuantity,
  clearCart
})
