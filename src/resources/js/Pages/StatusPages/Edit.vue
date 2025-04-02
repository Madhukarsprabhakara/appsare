<script setup>
import AppLayoutv2 from '@/Layouts/AppLayoutv2.vue';
import EditStatusPageForm from '@/Pages/StatusPages/Partials/EditStatusPageForm.vue';
</script>

<template>
    <AppLayoutv2 title="Create Status Page">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Status Page
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6  lg:px-8">
                <EditStatusPageForm />
            </div>
        </div>
    </AppLayoutv2>
</template>
