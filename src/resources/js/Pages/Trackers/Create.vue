<template>
<AppLayout title="Create Tracker">
	<DashboardLayout>
	<template #left>
			<p>left 11</p>
			
		</template>
		<template #main>
			<CreateTrackerForm />
			
		</template>
		<template #right>
			<a href="https://slack.com/oauth/v2/authorize?client_id=8203461021637.8218998231409&scope=chat:write,chat:write.customize,chat:write.public,channels:read&user_scope="><img alt="Add to Slack" height="40" width="139" src="https://platform.slack-edge.com/img/add_to_slack.png" srcSet="https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x" /></a>
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