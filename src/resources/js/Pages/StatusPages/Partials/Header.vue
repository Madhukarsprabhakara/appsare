<template>
    <div class="border-b border-gray-200  px-4 pb-5 sm:px-6">
        <div class="-ml-4 -mt-2 flex flex-wrap items-center justify-between sm:flex-nowrap">
            <div class="ml-4 mt-2">
                <h3 class="font-semibold text-xl text-gray-800 leading-tight">Status Pages</h3>
            </div>
            <div class="ml-4 mt-2 shrink-0">
                <NavLink :href="route('statuspages.create')" :active="route().current('statuspages.create')" preserve-scroll>
                    <PrimaryButton type="button"
                        class="relative inline-flex items-center rounded-md bg-teal-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600">
                        New Status Page</PrimaryButton>
                </NavLink>
            </div>
        </div>
    </div>
</template>
<script setup>
import NavLink from '@/Components/NavLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>