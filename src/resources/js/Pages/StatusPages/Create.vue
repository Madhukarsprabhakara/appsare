<script setup>
import AppLayoutv2 from '@/Layouts/AppLayoutv2.vue';
import CreateStatusPageForm from '@/Pages/StatusPages/Partials/CreateStatusPageForm.vue';
</script>

<template>
    <AppLayoutv2 title="Create Status Page">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Status Page
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6  lg:px-8">
                <CreateStatusPageForm />
            </div>
        </div>
    </AppLayoutv2>
</template>
