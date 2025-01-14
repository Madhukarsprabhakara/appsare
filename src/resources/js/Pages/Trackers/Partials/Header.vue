<template>
    <div class="border-b border-gray-200  px-4 py-5 sm:px-6">
      <div class="-ml-4 -mt-2 flex flex-wrap items-center justify-between sm:flex-nowrap">
        <div class="ml-4 mt-2">
          <h3 class="font-semibold text-xl text-gray-800 leading-tight">Trackers</h3>
        </div>
        <div class="ml-4 mt-2 shrink-0">
            <NavLink  :href="route('trackers.create')" :active="route().current('trackers.create')" preserve-scroll> 
          <button type="button" class="relative inline-flex items-center rounded-md bg-teal-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600">New Tracker</button>
            </NavLink>
        </div>
      </div>
    </div>
  </template>
  <script setup>
  import NavLink from '@/Components/NavLink.vue';
  </script>