<script setup>

import { ref, watch } from 'vue'
import { useTheme } from 'vuetify'
import AdminLayout from '@/Layouts/AdminLayout.vue';


</script>


<template>
    <AdminLayout>

        <v-container>

      <!-- Header Section with Statistics -->
      <v-row>
        <v-col cols="12" sm="3">
          <v-card class="rounded-lg" elevation="2">
            <v-card-item>
              <v-card-subtitle class="text-primary-lighten-1 mb-1">Total Orders</v-card-subtitle>
              <v-card-title class="text-h4"> 4 </v-card-title>
            </v-card-item>         
          </v-card>
        </v-col>
        <v-col cols="12" sm="3">
          <v-card class="rounded-lg" elevation="2">
            <v-card-item>
              <v-card-subtitle class="text-success-lighten-1 mb-1">Completed Orders</v-card-subtitle>
              <v-card-title class="text-h4"> 6 </v-card-title>
            </v-card-item>
          </v-card>
        </v-col>
        <v-col cols="12" sm="3">
          <v-card class="rounded-lg" elevation="2">
            <v-card-item>
              <v-card-subtitle class="text-warning-lighten-1 mb-1">Pending Orders</v-card-subtitle>
              <v-card-title class="text-h4"> 3 </v-card-title>
            </v-card-item>
          </v-card>
        </v-col>
        <v-col cols="12" sm="3">
          <v-card class="rounded-lg" elevation="2">
            <v-card-item>
              <v-card-subtitle class="text-error-lighten-1 mb-1">Cancelled Orders</v-card-subtitle>
              <v-card-title class="text-h4"> 0 </v-card-title>
            </v-card-item>
          </v-card>
        </v-col>
      </v-row>
  
        </v-container>

    </AdminLayout>>
</template>