<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import NavLink from '@/Components/NavLink.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
const form = useForm({
    _method: 'PUT',
    name: usePage().props.slackConnection    ? usePage().props.slackConnection.slack_channel_id : '',
    id: usePage().props.slackConnection    ? usePage().props.slackConnection.id : '',
});
const notificationBeingDisabled = ref(null);
const disableNotifications = useForm({ _method: 'PUT'});

const confirmDisableNotification = (notification_id) => {
    notificationBeingDisabled.value = notification_id;
    
};

const disableNotification = () => {
    disableNotifications.post(route('notification_settings.update', {'notification_setting':notificationBeingDisabled.value }), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (notificationBeingDisabled.value = null),
    });
};

const updateSlackChannelId = () => {
    form.post(route('slack.update', {'slack_connect': usePage().props.slackConnection.id}), {
        errorBag: 'updateSlackChannelId',
        preserveScroll: true,
    });
};
</script>

<template>
    <FormSection @submitted="updateSlackChannelId">
        <template #title>
            Notification Switch
        </template>

        <template #description>
            Enable or Disable notifications on events.        </template>

        <template #form>
            
            
        
            <div class="col-span-6">
                <h3  v-if="$page.props.notificationSettings[0].notificatons_enabled" class="text-lg font-medium text-gray-900">
                    Notifications are <span class="text-green-600">enabled</span> at the moment.
                </h3>
                <h3  v-else class="text-lg font-medium text-gray-900">
                    Notifications are <span class="text-red-600">disabled</span> at the moment.   
                </h3>
                <p class="mt-3 text-sm/6 text-gray-600">You can enable or disable notifications at any time. When notifications are disabled, you won't be notified of any events but your applications will still be tracked and events will be stored in the database.</p>
            
                
                <div v-if="$page.props.notificationSettings[0].notificatons_enabled" class="flex items-center mt-2">
                    
                    <PrimaryButton  @click.prevent="confirmDisableNotification($page.props.notificationSettings[0].id)" class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white  hover:bg-red-500 " >
                        <!-- <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5" aria-hidden="true" /> -->
                        Disable Notifications
                    </PrimaryButton>
                    
                    
                </div>
                <div v-else class="flex items-center mt-2">
                    
                    <PrimaryButton @click.prevent="confirmDisableNotification($page.props.notificationSettings[0].id)" class="inline-flex items-center rounded-md bg-gray-800 px-3 py-2 text-sm font-semibold text-white  hover:bg-gray-700 " >
                        <!-- <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5" aria-hidden="true" /> -->
                        Enable Notifications
                    </PrimaryButton>
                    
                    
                </div>
            </div>

            <div v-if="$page.props.slackConnection" class="col-span-6 sm:col-span-4">
                <InputLabel for="channel_id" value="Slack Channel Id" />
                <TextInput
                    id="channel_id"
                    v-model="form.name"
                    placeholder="#social"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                    required
                    
                />
                <p class="mt-3 text-sm/6 text-gray-600">Please use the complete channel id prepended by a #. (e.g. #your-channel-id)</p>
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template v-if="$page.props.slackConnection" #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Update
            </PrimaryButton>
        </template>
    </FormSection>

    <!-- Delete Token Confirmation Modal -->
    <ConfirmationModal :show="notificationBeingDisabled != null" @close="notificationBeingDisabled = null">
            <template #title>
                Disable Notifications
            </template>

            <template #content v-if="$page.props.notificationSettings[0].notificatons_enabled">
                Are you sure you would like to disable notifications? You will no longer be notified of any events but your applications will still be tracked and events will be stored in the database.
            </template>
            <template #content v-else>
                Are you sure you would like to enable notifications? You will immediately start receving notifications of any events.
            </template>
            <template #footer>
                <SecondaryButton @click="notificationBeingDisabled = null">
                    Cancel
                </SecondaryButton>

                <DangerButton
                    v-if="$page.props.notificationSettings[0].notificatons_enabled" class="ms-3"
                    :class="{ 'opacity-25': disableNotifications.processing }"
                    :disabled="disableNotifications.processing"
                    @click="disableNotification"
                >
                    Yes, disable notifications
                </DangerButton>
                <PrimaryButton
                v-else class="ms-3"
                    :class="{ 'opacity-25': disableNotifications.processing }"
                    :disabled="disableNotifications.processing"
                    @click="disableNotification"    
                >
                    Yes, enable notifications   
                </PrimaryButton>
            </template>
    </ConfirmationModal>
</template>
