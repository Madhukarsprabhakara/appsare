<script setup>
import AppLayoutv2 from '@/Layouts/AppLayoutv2.vue';
import Welcome from '@/Components/Welcome.vue';
import Show from '@/Pages/Dashboard/Show.vue';
</script>

<template>
    <AppLayoutv2 title="Dashboard">
        <template #main>
            <Show/>
        </template>
        
      
    </AppLayoutv2>
</template>
