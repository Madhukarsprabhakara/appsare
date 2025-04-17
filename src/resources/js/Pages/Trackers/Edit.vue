<template>
    <AppLayoutv2 title="Create Tracker">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Tracker
            </h2>

        </template>
        <DashboardLayout>
            <template #left>
                <p>left 11</p>

            </template>
            <template #main>
                <EditTrackerForm />

            </template>
            <template #right>
                <a
                    href="https://slack.com/oauth/v2/authorize?client_id=8203461021637.8218998231409&scope=chat:write,chat:write.customize,chat:write.public,channels:read&user_scope="><img
                        alt="Add to Slack" height="40" width="139"
                        src="https://platform.slack-edge.com/img/add_to_slack.png"
                        srcSet="https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x" /></a>
            </template>
        </DashboardLayout>
    </AppLayoutv2>
</template>

<script setup>
import AppLayoutv2 from '@/Layouts/AppLayoutv2.vue';
import DashboardLayout from '@/Pages/Dashboard/Partials/DashboardLayout.vue';
import EditTrackerForm from '@/Pages/Trackers/Partials/EditTrackerForm.vue';
</script>