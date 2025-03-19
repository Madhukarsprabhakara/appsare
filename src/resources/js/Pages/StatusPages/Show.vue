<template>
    <AppLayoutv2 title="Status Pages">
        <template #header>
            <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trackers
            </h2> -->
            <Header />
        </template>
        <div class="">
            <div class="max-w-full mx-auto ">
                
                    <div>
                        <StatusPageList :people="$page.props.statusPages" />
                    </div>
            </div>
        </div>
    </AppLayoutv2>

</template>
<script setup>
import AppLayoutv2 from '@/Layouts/AppLayoutv2.vue';
import Header from './Partials/Header.vue';
import { usePage } from '@inertiajs/vue3';
import StatusPageList from './Partials/StatusPageList.vue';

const trackers = usePage().props.trackers;
</script>