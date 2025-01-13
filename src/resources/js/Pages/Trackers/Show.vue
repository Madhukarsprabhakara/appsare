<template>
    <AppLayoutv2>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trackers
            </h2>
        </template>
        <div class="">
            <div class="max-w-full mx-auto ">
                
                    
                        <Tracker/>
                    
                    
                    
                    
              
                
                   
                        <Tracker/>
                    
                    
                    
                    
                
            </div>
        </div>
    </AppLayoutv2>

</template>
<script setup>
import AppLayoutv2 from '@/Layouts/AppLayoutv2.vue';
import Tracker from './Partials/Tracker.vue';
</script>