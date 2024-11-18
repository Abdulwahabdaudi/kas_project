<script setup>
import { ref,onMounted } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });



</script>


<template>
        <div class="flex w-full relative">
        
         
            <div class="relative w-full">
                <input 
                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                v-model="model"
                ref="input"
                placeholder="07xxxxxxxx" required />

            </div>
        </div>

</template>