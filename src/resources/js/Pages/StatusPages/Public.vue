<template>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <!-- Status Page Name -->
        <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ statusPage.name }}</h1>

        <!-- Trackers Uptime -->
        <div v-if="trackers.length" class="space-y-6">
            <div v-for="tracker in trackers" :key="tracker.id" class="bg-white shadow-sm rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-800">{{ tracker.url }}</h2>
                <p class="text-sm text-gray-600">90-Day Uptime: <span class="font-medium">{{ tracker.uptime }}%</span></p>
                <UptimeIndicator />
            </div>
        </div>

        <!-- No Trackers Message -->
        <div v-else class="text-center text-gray-500">
            <p>No trackers are associated with this status page.</p>
        </div>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import UptimeIndicator from '@/Components/UptimeIndicator.vue';
// Access the props passed from the backend
const { props } = usePage();
const statusPage = props.statusPage;
const trackers = props.trackers;
</script>