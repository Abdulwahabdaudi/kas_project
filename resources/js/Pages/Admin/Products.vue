<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, computed, reactive, watch, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'


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

console.log()

const statusOptions = ['In Stock', 'Out of Stock']

const headers = [
  { title: 'Image', key: 'image', sortable: false, align: 'center' },
  { title: 'Name', key: 'name', align: 'start' },
  { title: 'Category', key: 'category', align: 'start' },
  { title: 'Price', key: 'price', align: 'end' },
  { title: 'Quantity', key: 'quantity', align: 'end' },
  { title: 'Status', key: 'status', align: 'center' },
  { title: 'Actions', key: 'actions', sortable: false, align: 'center' }
]

// State
const loading = ref(false)
const form = ref(null)



const filters = reactive({
  search: '',
  category: null,
  status: null
})

const dialog = reactive({
  show: false,
  isEdit: false
})

const deleteDialog = reactive({
  show: false,
  item: null
})

const snackbar = reactive({
  show: false,
  text: '',
  color: 'success'
})

const productForm = reactive({
  id: '',
  name: '',
  category: '',
  price: 0,
  quantity: 0,
  description: '',
  image: '',
  imageFile: null

})

const showStatus = (q) => {
  if (q <= 0) {
    return 'Out Of stock'
  }
  return 'In Stock'
}

// Computed
const filteredProducts = computed(() => {
  let filtered = [...props.products]

  if (filters.category) {
    filtered = filtered.filter(p => p.category === filters.category)
  }

  if (filters.status === 'In Stock') {
    filtered = filtered.filter(p => p.quantity > 0)
  }
  if (filters.status === 'Out of Stock') {
    filtered = filtered.filter(p => p.quantity <= 0)
  }

  return filtered
})




const resetForm = () => {
  productForm.id = ''
  productForm.name = ''
  productForm.category = ''
  productForm.price = 0
  productForm.quantity = 0
  productForm.description = ''
  productForm.image = ''
  productForm.imageFile = null

  if (form.value) {
    form.value.resetValidation()
  }
}

const openDialog = (item = null) => {
  dialog.isEdit = !!item
  if (item) {
    Object.keys(productForm).forEach(key => {
      productForm[key] = item[key]
    })
  } else {
    resetForm()
  }
  dialog.show = true
}

const closeDialog = () => {
  dialog.show = false
  resetForm()
}

const updateProductStatus = (quantity) => {
  if (quantity <= 0) return 'Out of Stock'
  return 'In Stock'
}

const showNotification = (text, color = 'success') => {
  snackbar.text = text
  snackbar.color = color
  snackbar.show = true
}


const saveProduct = async () => {
  if (!form.value?.validate()) return

  loading.value = true

  try {
    // Simulate API call delay
    await new Promise(resolve => setTimeout(resolve, 1000))


    if (dialog.isEdit) {
      //Update existing product
      const selectedProduct = props.products.find(p => p.id === productForm.id)
      productForm._method = 'PUT'
      router.post(`/admin/products/${selectedProduct.id}`,
        productForm, {
        onSuccess: () => {
          showNotification('Product Update successfully')
        },
        onError: () => {
          showNotification('Error saving product. Please try again.', 'error')

        },
      })


    } else {

      router.post('/admin/products', productForm, {
        onSuccess: () => {
          showNotification('Product added successfully')
        },
        onError: () => {
          showNotification('Error saving product. Please try again.', 'error')

        },
      })

    }

    closeDialog()
  } catch (error) {
    //   console.error('Error saving product:', error)
    showNotification('Error saving product. Please try again.', 'error')
  } finally {
    loading.value = false
  }
}

const deleteProduct = (item) => {
  deleteDialog.item = item
  deleteDialog.show = true
}

const confirmDelete = async () => {
  if (!deleteDialog.item) return

  loading.value = true

  try {
    // Simulate API call delay
    await new Promise(resolve => setTimeout(resolve, 1000))

    const selectedProduct = props.products.find(p => p.id === deleteDialog.item.id)
    router.delete(`/admin/products/${selectedProduct.id}`, {
      onSuccess: () => {
        showNotification('Product deleted successfully')
      },
      onError: () => {
        showNotification('Error deleting product. Please try again.', 'error')
      }
    })
    deleteDialog.show = false
    deleteDialog.item = null
  } catch (error) {
    console.error('Error deleting product:', error)
    showNotification('Error deleting product. Please try again.', 'error')
  } finally {
    loading.value = false
  }
}

// Optional: Add watchers for automatic status updates
watch(() => productForm.stock, (newStock) => {
  productForm.status = updateProductStatus(newStock)
})

// Optional: Add fetch products on mount
onMounted(async () => {
  loading.value = true
  try {
    // Simulate API call to fetch products
    await new Promise(resolve => setTimeout(resolve, 1000))
    // In a real app, you would fetch products from your API here
    // products.value = await fetchProducts()
  } catch (error) {
    console.error('Error fetching products:', error)
    showNotification('Error loading products', 'error')
  } finally {
    loading.value = false
  }
})



// Methods
const getStatusColor = (status) => {
  if (Number(status) >= 1) {
    return 'success'
  } else {
    return 'error'
  }
}


</script>





<template>

  <AdminLayout>
    <v-container fluid class="pa-6">
      <!-- Dashboard Stats -->
      <v-row class="mb-6">
        <v-col cols="12" sm="6" md="4">
          <v-card class="rounded-lg">
            <v-card-text class="d-flex align-center">
              <v-avatar color="primary" size="48" class="me-4">
                <v-icon color="white" size="24">mdi-package-variant</v-icon>
              </v-avatar>
              <div>
                <div class="text-subtitle-2 text-medium-emphasis">Total Products</div>
                <div class="text-h6 font-weight-bold">{{ products.length }}</div>
              </div>
            </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" sm="6" md="4">
          <v-card class="rounded-lg">
            <v-card-text class="d-flex align-center">
              <v-avatar color="success" size="48" class="me-4">
                <v-icon color="white" size="24">mdi-check-circle</v-icon>
              </v-avatar>
              <div>
                <div class="text-subtitle-2 text-medium-emphasis">In Stock</div>
                <div class="text-h6 font-weight-bold">
                  {{ products.filter(p => p.quantity >= 0).length }}
                </div>
              </div>
            </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" sm="6" md="4">
          <v-card class="rounded-lg">
            <v-card-text class="d-flex align-center">
              <v-avatar color="error" size="48" class="me-4">
                <v-icon color="white" size="24">mdi-close-circle</v-icon>
              </v-avatar>
              <div>
                <div class="text-subtitle-2 text-medium-emphasis">Out of Stock</div>
                <div class="text-h6 font-weight-bold">
                  {{ products.filter(p => p.quantity <= 0).length }} </div>
                </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <!-- Main Content Card -->
      <v-card class="rounded-lg">
        <v-card-title class="d-flex justify-space-between align-center pa-6">
          <span class="text-h5">Products</span>
          <v-btn color="primary" prepend-icon="mdi-plus" @click="openDialog()" variant="elevated">
            Add Product
          </v-btn>
        </v-card-title>

        <!-- Filters -->
        <v-card-text>
          <v-row>
            <v-col cols="12" sm="4">
              <v-text-field v-model="filters.search" label="Search products" prepend-inner-icon="mdi-magnify" clearable
                hide-details variant="outlined" density="comfortable"></v-text-field>
            </v-col>
            <v-col cols="12" sm="4">
              <v-select v-model="filters.category" :items="categories" label="Category" clearable hide-details
                variant="outlined" density="comfortable"></v-select>
            </v-col>
            <v-col cols="12" sm="4">
              <v-select v-model="filters.status" :items="statusOptions" label="Status" clearable hide-details
                variant="outlined" density="comfortable"></v-select>
            </v-col>
          </v-row>
        </v-card-text>

        <!-- Products Table -->
        <v-data-table :headers="headers" :items="filteredProducts" :loading="loading" :search="filters.search" hover>
          <template v-slot:item.image="{ item }">
            <v-avatar rounded size="48">
              <v-img :src="!item.image ? '/image/Place_holder.jpg' : `/storage/${item.image}`" cover></v-img>
            </v-avatar>
          </template>

          <template v-slot:item.price="{ item }">
            <span class="font-weight-medium">${{ item.price.toFixed(2) }}</span>
          </template>

          <template v-slot:item.status="{ item }">
            <v-chip :color="getStatusColor(item.quantity)" size="small" variant="elevated">
              {{ showStatus(item.quantity) }}
            </v-chip>
          </template>

          <template v-slot:item.actions="{ item }">
            <v-btn icon="mdi-pencil" size="small" color="primary" variant="text" @click="openDialog(item)"></v-btn>
            <v-btn icon="mdi-delete" size="small" color="error" variant="text" @click="deleteProduct(item)"></v-btn>
          </template>
        </v-data-table>
      </v-card>

      <!-- Add/Edit Dialog -->
      <v-dialog v-model="dialog.show" max-width="700px">
        <v-card>
          <v-card-title class="pa-6">
            <span class="text-h5">{{ dialog.isEdit ? 'Edit Product' : 'New Product' }}</span>
          </v-card-title>

          <v-card-text>
            <v-form ref="form" @submit.prevent="saveProduct">
              <v-container>
                <v-row>
                  <v-col cols="12" class="pb-0">
                    <v-file-input v-model="productForm.imageFile" :image-preview="true" accept="image/*"
                      label="Product Image" prepend-icon="mdi-camera" show-size variant="outlined"
                      density="comfortable">
                      <template v-slot:selection="{ fileNames }">
                        <v-chip size="small" label color="primary" variant="outlined">
                          {{ fileNames[0] }}
                        </v-chip>
                      </template>
                    </v-file-input>
                  </v-col>

                  <v-col cols="12" md="6" class="pb-0">
                    <v-text-field v-model="productForm.name" label="Product Name"
                      :rules="[v => !!v || 'Name is required']" variant="outlined" density="comfortable"></v-text-field>
                  </v-col>

                  <v-col cols="12" md="6" class="pb-0">
                    <v-combobox v-model="productForm.category" :items="categories" label="Category"
                      :rules="[v => !!v || 'Category is required']" variant="outlined" density="comfortable" 
                       ></v-combobox>
                  </v-col>

                  <v-col cols="12" md="6" class="pb-0">
                    <v-text-field v-model.number="productForm.price" label="Price" prefix="$" type="number" :rules="[
                      v => !!v || 'Price is required',
                      v => v >= 0 || 'Price must be positive'
                    ]" variant="outlined" density="comfortable"></v-text-field>
                  </v-col>

                  <v-col cols="12" md="6" class="pb-0">
                    <v-text-field v-model.number="productForm.quantity" label="Quantity" type="number" :rules="[
                      v => !!v || 'Stock is required',
                      v => v >= 0 || 'Stock must be positive'
                    ]" variant="outlined" density="comfortable"></v-text-field>
                  </v-col>

                  <v-col cols="12" class="pb-0">
                    <v-textarea v-model="productForm.description" label="Description" rows="3" variant="outlined"
                      density="comfortable"></v-textarea>
                  </v-col>
                </v-row>
              </v-container>
            </v-form>
          </v-card-text>

          <v-card-actions class="pa-6">
            <v-spacer></v-spacer>
            <v-btn color="error" variant="outlined" @click="closeDialog">
              Cancel
            </v-btn>
            <v-btn color="primary" variant="elevated" @click="saveProduct" :loading="loading">
              Save
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Delete Confirmation Dialog -->
      <v-dialog v-model="deleteDialog.show" max-width="400px">
        <v-card>
          <v-card-title class="pa-6 text-h5">Delete Product</v-card-title>
          <v-card-text class="pa-6">
            Are you sure you want to delete <strong>{{ deleteDialog.item?.name }}</strong>?
            This action cannot be undone.
          </v-card-text>
          <v-card-actions class="pa-6">
            <v-spacer></v-spacer>
            <v-btn color="default" variant="outlined" @click="deleteDialog.show = false">
              Cancel
            </v-btn>
            <v-btn color="error" variant="elevated" @click="confirmDelete" :loading="loading">
              Delete
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Snackbar for notifications -->
      <v-snackbar v-model="snackbar.show" :color="snackbar.color" :timeout="3000">
        {{ snackbar.text }}
        <template v-slot:actions>
          <v-btn color="white" variant="text" @click="snackbar.show = false">
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </v-container>
  </AdminLayout>

</template>