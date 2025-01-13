<template>

	<DashboardLayout>
	
		<template #main>
			<TrackerListHeader />
			<TrackerList />
			
		</template>
		
	</DashboardLayout>

</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DashboardLayout from '@/Pages/Dashboard/Partials/DashboardLayout.vue';
import TrackerListHeader from '@/Pages/Trackers/Partials/TrackerListHeader.vue';
import TrackerList from '@/Pages/Trackers/Partials/TrackerList.vue';
import Sidebar from './Partials/Sidebar.vue';
</script>