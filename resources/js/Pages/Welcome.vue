<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3';

import { Leaf, Settings, Truck, Phone } from 'lucide-vue-next'
import UserLayout from '@/Layouts/UserLayout.vue';

import { Splide, SplideSlide } from '@splidejs/vue-splide';
import '@splidejs/splide/dist/css/splide.min.css';



const services = ref([
  {
    icon: Leaf,
    title: 'Agricultural Producers',
    description: 'We produce and purchase various crops from farmers.'
  },
  {
    icon: Settings,
    title: 'Technical Support',
    description: 'We provide agricultural expertise to help farmers produce quality agricultural products'
  },
  {
    icon: Truck,
    title: 'Agricultural Supplier',
    description: 'We sell to the local and international markets'
  }
])

const stats = [
  { value: '5+', label: 'Years Experience' },
  { value: '100+', label: 'Happy Farmers' },
  { value: '50+', label: 'Products' },
  { value: '24/7', label: 'Support' }
]

const landingProducts = [
  { name: 'SISAL FIBRE', description: 'High quantity', image: 'SISAL FIBRE.jpg' },
  { name: 'SEEDS OILS CROPS', description: 'High quantity', image: '' },
  { name: 'CEREALS', description: 'High quantity', image: '' },
  { name: 'TIMBER', description: 'High quantity', image: '' },
  { name: 'COFFEE', description: 'High quantity', image: '' },
  { name: 'CASHEW NUT', description: 'High quantity', image: '' },
  { name: 'ANIMAL PRODUCTS', description: 'High quantity', image: '' },
  { name: 'SESAME', description: 'High quantity', image: '' },
  { name: 'BEANS CROPS', description: 'High quantity', image: '' }
]

const formData = ref({
  name: '',
  email: '',
  message: ''
})

const handleSubmit = () => {
  console.log('Form submitted:', formData.value)
  // Add form submission logic here
  formData.value = {
    name: '',
    email: '',
    message: ''
  }
}



</script>




<template>

  <UserLayout>

    <!-- Hero Section -->
    <div class="bg-green-700">
      <div class="max-w-6xl mx-auto px-4 py-20 md:py-32">
        <div class="flex flex-col md:flex-row items-center justify-between">
          <div class="md:w-1/2 mb-8 md:mb-0">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
              Trusted Agro Solutions
            </h1>
            <p class="text-xl text-gray-200 mb-8">
              KILIKAYA AGRO.SUPPLIER provides high-quality agricultural products and services to support
              your
              farming success.
            </p>
            <Link :href="route('products')" class="hover:text-white">
            <button
              class="bg-yellow-500 text-green-700 px-6 py-3 rounded-lg hover:bg-yellow-600 transition-colors">Explore
              Our Products 
            </button>
            </Link>

          </div>
          <div class="md:w-1/2 ">
            <Splide :options="{
              type: 'loop',
              perPage: 1,
              autoplay: true,
              interval: 3000,
              gap: '1rem',
            }">
                <SplideSlide>
                  <img src="/image/logo.png" alt="Hero image" class="object-cover h-full w-full rounded-lg shadow-xl" />
                </SplideSlide>
              <SplideSlide>
                <img src="/image/SISAL FIBRE.png" alt="Hero image" class=" object-cover h-full w-full rounded-lg shadow-xl" />
              </SplideSlide>
              <SplideSlide>
                <img src="/image/CEREALS.png" alt="Hero image" class="object-cover h-full w-full rounded-lg shadow-xl" />
              </SplideSlide>
            </Splide>
          </div>
        </div>
      </div>
    </div>



    <!-- About Section -->
    <div class="bg-white py-16">
      <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-green-700 mb-12">About Us</h2>
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
          <div class="md:w-1/2 mb-8 md:mb-0">
            <img src="/image/logo.png" alt="About image" class="rounded-lg shadow-xl">
          </div>
          <div class="md:w-1/2">
            <h2 class="text-3xl font-bold text-green-700 mb-4">About Us</h2>
            <p class="text-gray-600 mb-8">
              Kilikaya Agro Supplier (K.A.S) is reliable and trustworthy import and export company in
              Tanzania (situated in Morogoro region) incorporated by law with certificate no. 589009&
              taxpayer identification number (TIN)145925266 . The company is established in order to
              complete the value chain by linking rural farmers with the end users.
              We produce and procure raw and semi-processed agricultural products
            </p>

            <Link :href="route('about')" class="hover:text-white">
            <button class="bg-green-700 text-white px-6 py-3 rounded-lg hover:bg-green-800 transition-colors">
              Learn More
            </button>
            </Link>

          </div>
        </div>
      </div>
    </div>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-12">
          Our Services
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div v-for="service in services" :key="service.title"
            class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
            <div class="text-center">
              <div class="h-16 w-16 mx-auto bg-green-100 rounded-full flex items-center justify-center">
                <component :is="service.icon" class="h-8 w-8 text-green-600" />
              </div>
              <h3 class="mt-4 text-xl font-semibold text-gray-900">{{ service.title }}</h3>
              <p class="mt-2 text-gray-600">{{ service.description }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- Contact Section -->
    <div class="bg-green-700 py-16">
      <div class="max-w-6xl mx-auto px-4">
        <div class="text-center">
          <h2 class="text-3xl font-bold text-white mb-4">Get in Touch</h2>
          <p class="text-xl text-gray-200 mb-8">
            Have any questions or need assistance? Our team is here to help.
          </p>
          <div class="flex gap-3 justify-center">

            <a href="tel:+255683196764"
              class="flex gap-2 bg-yellow-500 text-green-700 px-4 py-3 rounded-lg hover:bg-yellow-600 transition-colors">
              <Phone></Phone> Call Us
            </a>
            <a href="https://wa.me/+255683196764"
              class="bg-yellow-500 text-green-700 px-4 py-3 rounded-lg hover:bg-yellow-600 transition-colors">
              <v-icon icon="mdi-whatsapp" /> Message Us
            </a>
          </div>

        </div>
      </div>
    </div>



    <!-- Products Section -->
    <div class="bg-gray-100 py-16">
      <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-green-700 mb-12">Our Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div v-for="product in landingProducts" :key="product.name" class="bg-white p-6 rounded-lg shadow">
            <div class=" mb-4 flex items-center justify-center">
              <img :src="`/image/${product.name}.png`" :alt="product.name" class="object-cover h-56 w-full">
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ product.name }}</h3>
            <p class="text-gray-600">{{ product.description + ' ' + product.name }}</p>
          </div>

        </div>
      </div>
    </div>



    <!-- Stats Section -->
    <section id="about" class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-12">
          Why Choose Us
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div v-for="stat in stats" :key="stat.label" class="text-center p-6 bg-white rounded-lg shadow">
            <div class="text-4xl font-bold text-green-600">{{ stat.value }}</div>
            <div class="mt-2 text-gray-600">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-12">
          Contact Us
        </h2>
        <form @submit.prevent="handleSubmit" class="space-y-6">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" id="name" v-model="formData.name" required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
          </div>
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" v-model="formData.email" required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
          </div>
          <div>
            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
            <textarea id="message" v-model="formData.message" rows="4" required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
          </div>
          <div>
            <button type="submit"
              class="w-full bg-green-600 py-3 px-4 text-white rounded-md hover:bg-green-700 transition duration-300">
              Send Message
            </button>
          </div>
        </form>
      </div>
    </section>

  </UserLayout>
</template>
