<!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<template>
  <form @submit.prevent="storeTracker" class="border-2 border-teal-500 px-4 py-2">
    <div class="space-y-12 ">
      <div class="pb-2 pt-2 pl-2 pr-2">
        <h2 class="text-base font-semibold leading-7 text-gray-900">Create a new App is...</h2>
        

        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-4">
            <label for="url" class="block text-sm font-medium leading-6 text-gray-900">URL to track</label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <!-- <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">workcation.com/</span> -->
                <input type="text" name="url" id="url" v-model="form.url" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" />

              </div>
              
              <p class="mt-1 text-sm leading-6 text-gray-600">You may track non-secured sites using http:// instead of https://</p>
            </div>
          </div>
          
         <!-- <div class="col-span-full">
            <label for="about" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
            <div class="mt-2">
              <textarea id="about" name="about" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <p class="mt-1 text-sm leading-6 text-gray-600">Describe what the survey will be for in a few lines. This WILL not be displayed on the public link.</p>
          </div>-->

          

          
        </div>
      </div>

      

      
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
      
      <NavLink  :href="route('trackers.index')"  preserve-scroll> 
          <button type="button" class="text-sm font-semibold leading-6 text-gray-900  ">
            <!-- <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5" aria-hidden="true" /> -->
            Cancel
          </button>
    
      </NavLink>
      <button type="submit" class="rounded-md bg-teal-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600">Save</button>
    </div>
  </form>
</template>

<script setup>
import { PhotoIcon, UserCircleIcon } from '@heroicons/vue/24/solid';
import NavLink from '@/Components/NavLink.vue';
import InputError from '@/Components/InputError.vue';
import { useForm, usePage } from '@inertiajs/vue3'; 
import { ref, computed, onMounted } from 'vue';

function storeTracker() {
    form.post(route('trackers.store'), {
      preserveScroll: true,

    })
  }
const form = useForm({
    url: 'https://',
    
    
});


</script>