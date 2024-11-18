
<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, computed ,watch, onMounted,} from 'vue'
import {  router } from '@inertiajs/vue3';

// State
const search = ref('')
const loading = ref(false)
const dialog = ref(false)
const dates = ref([])
const statusFilter = ref('')
const itemsPerPage = ref(10)
const editedIndex = ref(-1)

// Sample data

const headers = ref([
  { title: 'Order #', key: 'orderNumber', align: 'start' },
  { title: 'Customer', key: 'customerName' },
  { title: 'Date', key: 'date' },
  { title: 'Total', key: 'total', align: 'end' },
  { title: 'Status', key: 'status', align: 'center' },
  { title: 'Actions', key: 'actions', align: 'end', sortable: false }
])

const statusOptions = ref([
  'Pending',
  'Processing',
  'Shipped',
  'Delivered',
  'Cancelled'
])

const defaultItem = ref({
  orderNumber: '',
  customerName: '',
  email: '',
  phone: '',
  date: '',
  total: 0,
  status: '',
  items: []
})

const editedItem = ref({ ...defaultItem })

const orders = computed(() => props.orders);

const filteredOrders = computed(() => {
  let filtered = [...orders.value]
  if (statusFilter.value) {
    filtered = filtered.filter(order => order.status === statusFilter.value)
  }

  return filtered
})

const completedOrders = computed(() => 
  orders.value.filter(order => order.status === 'Delivered').length
)

const pendingOrders = computed(() => 
  orders.value.filter(order => ['Pending', 'Processing'].includes(order.status)).length
)

const cancelledOrders = computed(() => 
  orders.value.filter(order => order.status === 'Cancelled').length
)

// Methods
const getStatusColor = (status) => {
  const colors = {
    Pending: 'warning',
    Processing: 'info',
    Shipped: 'primary',
    Delivered: 'success',
    Cancelled: 'error'
  }
  return colors[status] || 'grey'
}

const getStatusTextColor = (status) => {
  return ['Pending', 'Delivered'].includes(status) ? 'white' : 'white'
}

const getStatusIcon = (status) => {
  const icons = {
    Pending: 'mdi-clock-outline',
    Processing: 'mdi-cog-outline',
    Shipped: 'mdi-truck-delivery-outline',
    Delivered: 'mdi-check-circle-outline',
    Cancelled: 'mdi-close-circle-outline'
  }
  return icons[status] || 'mdi-help-circle-outline'
}

const refreshOrders = async () => {
  loading.value = true
  // Simulate API call
  await new Promise(resolve => setTimeout(resolve, 1000))
  loading.value = false
}


const viewOrder = (item) => {
  editedIndex.value = orders.value.indexOf(item)
  editedItem.value = { ...item }
  dialog.value = true
}

const editOrder = (item) => {
  editedIndex.value = orders.value.indexOf(item)
  editedItem.value = JSON.parse(JSON.stringify(item))
  dialog.value = true
}

const closeDialog = () => {
  dialog.value = false
  // Wait for dialog close animation
  setTimeout(() => {
    editedItem.value = { ...defaultItem }
    editedIndex.value = -1
  }, 300)
}

const saveOrder = async () => {
  loading.value = true
  try {
    // Simulate API call
   // await new Promise(resolve => setTimeout(resolve, 1000))
    
    if (editedIndex.value > -1) {
       router.post(`/admin/orders/changeStatus/${editedItem.value.orderNumber}`,
       editedItem.value, {
         onSuccess: () => {
           showNotification('Product Update successfully')
         },
         onError: () => {
           showNotification('Error saving product. Please try again.', 'error')

         },
       })
       // Update existing order
      // //Object.assign(orders.value[editedIndex.value], editedItem.value)
      // // Show success notification
     // //showNotification('Order updated successfully', 'success')
    }
  } catch (error) {
    showNotification('Error saving order', 'error')
  } finally {
    loading.value = false
    closeDialog()
  }
}

// Notification system
const notification = ref({
  show: false,
  text: '',
  type: 'info'
})

const showNotification = (text, type = 'info') => {
  notification.value = {
    show: true,
    text,
    type
  }
  setTimeout(() => {
    notification.value.show = false
  }, 3000)
}

// Add watchers for filters to automatically refresh data
watch([statusFilter], () => {
  refreshOrders()
}, { deep: true })


// Export dialog state for potential parent component interaction
defineExpose({
  dialog,
  refreshOrders
})

// Optional: Add lifecycle hooks if needed
onMounted(() => {
  refreshOrders()
})


const props = defineProps({
notification: {
  type: Object,
  required: true,
  default: () => ({
    show: false,
    text: '',
    type: 'info'
  })
},
orders: {
  type:Object,
  required: true
}
})

const getIcon = computed(() => {
const icons = {
  success: 'mdi-check-circle',
  error: 'mdi-alert-circle',
  warning: 'mdi-alert',
  info: 'mdi-information'
}
return icons[props.notification.type] || icons.info
})

</script>






<!-- OrderManagement.vue -->
<template>

<AdminLayout>
<v-container fluid class="pa-6">
      <!-- Header Section with Statistics -->
      <v-row>
        <v-col cols="12" sm="3">
          <v-card class="rounded-lg" elevation="2">
            <v-card-item>
              <v-card-subtitle class="text-primary-lighten-1 mb-1">Total Orders</v-card-subtitle>
              <v-card-title class="text-h4">{{ orders.length }}</v-card-title>
            </v-card-item>         
          </v-card>
        </v-col>
        <v-col cols="12" sm="3">
          <v-card class="rounded-lg" elevation="2">
            <v-card-item>
              <v-card-subtitle class="text-success-lighten-1 mb-1">Completed Orders</v-card-subtitle>
              <v-card-title class="text-h4">{{ completedOrders }}</v-card-title>
            </v-card-item>
          </v-card>
        </v-col>
        <v-col cols="12" sm="3">
          <v-card class="rounded-lg" elevation="2">
            <v-card-item>
              <v-card-subtitle class="text-warning-lighten-1 mb-1">Pending Orders</v-card-subtitle>
              <v-card-title class="text-h4">{{ pendingOrders }}</v-card-title>
            </v-card-item>
          </v-card>
        </v-col>
        <v-col cols="12" sm="3">
          <v-card class="rounded-lg" elevation="2">
            <v-card-item>
              <v-card-subtitle class="text-error-lighten-1 mb-1">Cancelled Orders</v-card-subtitle>
              <v-card-title class="text-h4">{{ cancelledOrders }}</v-card-title>
            </v-card-item>
          </v-card>
        </v-col>
      </v-row>
  
      <!-- Search and Filter Section -->
      <v-card class="mt-6 rounded-lg" elevation="2">
        <v-card-text>
          <v-row align="center">
            <v-col cols="12" sm="4">
              <v-text-field
                v-model="search"
                label="Search Orders"
                prepend-inner-icon="mdi-magnify"
                variant="outlined"
                density="comfortable"
                hide-details
                clearable
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="4" >
              <v-select
                v-model="statusFilter"
                :items="statusOptions"
                label="Status"
                variant="outlined"
                density="comfortable"
                hide-details
                clearable
              ></v-select>
            </v-col>

          </v-row>
        </v-card-text>
      </v-card>
  
      <!-- Orders Table -->
      <v-card class="mt-6 rounded-lg" elevation="2">
        <v-card-title class="d-flex justify-space-between align-center pa-6">
          <span class="text-h5">Orders</span>
          <v-btn
                color="primary"
                variant="elevated"       
                @click="refreshOrders"
                :loading="loading"
              >
                <v-icon start icon="mdi-refresh"></v-icon>
                Refresh
              </v-btn>
        </v-card-title>
        <v-data-table
          v-model:items-per-page="itemsPerPage"
          :headers="headers"
          :items="filteredOrders"
          :search="search"
          :loading="loading"
          hover
        >
          <template v-slot:item.status="{ item }">
            <v-chip
              :color="getStatusColor(item.status)"
              :text-color="getStatusTextColor(item.status)"
              size="small"
              variant="elevated"
            >
              <v-icon start :icon="getStatusIcon(item.status)" size="small"></v-icon>
              {{ item.status }}
            </v-chip>
          </template>
  
          <template v-slot:item.total="{ item }">
            <span class="font-weight-medium">${{ item.total }}</span>
          </template>
  
          <template v-slot:item.actions="{ item }">
            <v-tooltip location="top" text="View Details">
              <template v-slot:activator="{ props }">
                <v-btn
                  icon="mdi-eye"
                  size="small"
                  color="primary"
                  variant="text"
                  class="mr-2"
                  v-bind="props"
                  @click="viewOrder(item)"
                ></v-btn>
              </template>
            </v-tooltip>
            <v-tooltip location="top" text="Edit Order">
              <template v-slot:activator="{ props }">
                <v-btn
                  icon="mdi-pencil"
                  size="small"
                  color="warning"
                  variant="text"
                  class="mr-2"
                  v-bind="props"
                  @click="editOrder(item)"
                ></v-btn>
              </template>
            </v-tooltip>
          </template>
        </v-data-table>
      </v-card>
  
      <!-- Order Details Dialog -->
      <v-dialog v-model="dialog" max-width="800">
        <v-card>
          <v-toolbar
            :color="getStatusColor(editedItem.status)"
            :text-color="getStatusTextColor(editedItem.status)"
            density="comfortable"
          >
            <v-toolbar-title>
              Order #{{ editedItem.orderNumber }}
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon="mdi-close" variant="text" @click="closeDialog"></v-btn>
          </v-toolbar>
  
          <v-card-text class="pa-6">
            <v-row>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="editedItem.customerName"
                  label="Customer Name"
                  variant="outlined"
                  density="comfortable"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-select
                  v-model="editedItem.status"
                  :items="statusOptions"
                  label="Status"
                  variant="outlined"
                  density="comfortable"
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="editedItem.email"
                  label="Email"
                  variant="outlined"
                  density="comfortable"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="editedItem.phone"
                  label="Phone"
                  variant="outlined"
                  density="comfortable"
                ></v-text-field>
              </v-col>
         
            </v-row>
  
            <v-divider class="my-4"></v-divider>
  
            <v-table density="comfortable">
              <thead>
                <tr>
                  <th>Product</th>
                  <th class="text-right">Quantity</th>
                  <th class="text-right">Price</th>
                  <th class="text-right">Total</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in editedItem.items" :key="item.id">
                  <td>{{ item.name }}</td>
                  <td class="text-right">{{ item.quantity }}</td>
                  <td class="text-right">${{ Number(item.price).toFixed(2) }}</td>
                  <td class="text-right">${{ (Number(item.quantity) * item.price).toFixed(2) }}</td>
                </tr>
                <tr class="font-weight-bold">
                  <td colspan="3" class="text-right">Total:</td>
                  <td class="text-right">${{ Number(editedItem.total)?.toFixed(2) }}</td>
                </tr>
              </tbody>
            </v-table>
          </v-card-text>
  
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="error"
              variant="text"
              @click="closeDialog"
            >
              Cancel
            </v-btn>
            <v-btn
              color="primary"
              variant="elevated"
              @click="saveOrder"
            >
              Save Changes
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>

<!-- ToastNotification.vue -->
<template>
  <v-snackbar
    v-model="notification.show"
    :color="notification.type"
    location="top right"
    :timeout="3000"
  >
    <div class="d-flex align-center">
      <v-icon
        :icon="getIcon"
        class="mr-2"
        size="small"
      ></v-icon>
      {{ notification.text }}
    </div>

    <template v-slot:actions>
      <v-btn
        color="white"
        variant="text"
        icon="mdi-close"
        @click="notification.show = false"
      ></v-btn>
    </template>
  </v-snackbar>
</template>

</AdminLayout>
    
  </template>
  
