<template>

    <AppLayoutv2>
        <template #header>
           <Header />
        </template>
        <div class="">
            <div class="max-w-full  mx-auto ">
                <div>
                    <p>Coming soon</p>
                </div>
            </div>
        </div>
    </AppLayoutv2>
</template>
<script setup>
import AppLayoutv2 from '@/Layouts/AppLayoutv2.vue';
import Notification from './Partials/Notification.vue';
import { usePage } from '@inertiajs/vue3';
import Header from './Partials/Header.vue';
</script>