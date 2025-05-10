<template>
    <FormSection>
        <template #title>
            Notifications per Channel
        </template>

        <template #description>
            Enable or Disable notifications for individual channels (Email, Slack, Basecamp, SMS).
        </template>

        <template #form>
            <div class="col-span-6">
                <h3 class="text-lg font-medium text-gray-900">
                    Notification Settings
                </h3>
                <p class="mt-3 text-sm/6 text-gray-600">
                    You can enable or disable notifications for individual channels. When notifications are disabled for
                    a channel, you won't receive notifications on that channel, but your applications will still be
                    tracked, and events will be stored in the database.
                </p>

                <!-- Notification Toggles in Grid -->
                <div class="grid grid-cols-2 gap-6 mt-6">
                    <!-- Email Notification Toggle -->
                    <div v-for="user_notif in $page.props.userNotificationSettings"
                        class="flex items-center justify-between">

                        <span>{{ user_notif.notification_type.type }} Notifications</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" :checked="user_notif.is_enabled" @change="toggleNotification(
                                user_notif.notification_type_id,
                                !user_notif.is_enabled,
                                user_notif.team_id,
                                user_notif.user_id
                            )" />
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600">
                            </div>
                            <div
                                class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-5">
                            </div>
                        </label>

                    </div>

                    <!-- Slack Notification Toggle -->
                    <div v-for="team_notif in $page.props.teamNotificationSettings"
                        class="flex items-center justify-between">

                        <span>{{ team_notif.notification_type.type }} Notifications</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" :checked="team_notif.is_enabled" @change="toggleNotification(
                                team_notif.notification_type_id,
                                !team_notif.is_enabled,
                                team_notif.team_id,
                                team_notif.user_id
                            )" />
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600">
                            </div>
                            <div
                                class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-5">
                            </div>
                        </label>

                    </div>




                </div>
            </div>
        </template>
    </FormSection>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';

const toggleNotificationForm = useForm({
    _method: 'PUT',
    team_id: null,
    user_id: null,
    notification_type_id: null,
    is_enabled: null,
});

const toggleNotification = (channel_id, enable, team_id, user_id) => {
    toggleNotificationForm.team_id = team_id;
    toggleNotificationForm.user_id = user_id;
    toggleNotificationForm.notification_type_id = channel_id;
    toggleNotificationForm.is_enabled = enable;

    toggleNotificationForm.post(route('channel_notification_settings.update'), {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>