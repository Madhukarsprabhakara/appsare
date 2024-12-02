<template>
<AppLayout title="Create Tracker">
	<DashboardLayout>
	<template #left>
			<p>left</p>
			
		</template>
		<template #main>
			<CreateTrackerForm />
			
		</template>
		<template #right>
			<p>Right</p>
		</template>
	</DashboardLayout>
</AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DashboardLayout from '@/Pages/Dashboard/Partials/DashboardLayout.vue';
import TrackerListHeader from '@/Pages/Trackers/Partials/TrackerListHeader.vue';
import TrackerList from '@/Pages/Trackers/Partials/TrackerList.vue';
import CreateTrackerForm from '@/Pages/Trackers/Partials/CreateTrackerForm.vue';
</script>