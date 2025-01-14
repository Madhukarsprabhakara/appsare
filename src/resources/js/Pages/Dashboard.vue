<script setup>
import AppLayoutv2 from '@/Layouts/AppLayoutv2.vue';
import Welcome from '@/Components/Welcome.vue';
import Show from '@/Pages/Trackers/Show.vue';
</script>

<template>
    <AppLayoutv2 title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trackers
            </h2>
        </template>

        <div class="">
            <div class="max-w-full mx-auto ">
                <div class="bg-white overflow-hidden  sm:rounded-lg">
                    <Show/>
                </div>
            </div>
        </div>
    </AppLayoutv2>
</template>
