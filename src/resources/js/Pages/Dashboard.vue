<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import Show from '@/Pages/Dashboard/Show.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template> -->

        <div class="">
            <div class="max-w-full mx-auto ">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <show/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
