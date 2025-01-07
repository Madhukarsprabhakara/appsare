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
const slackConnectionBeingDeleted = ref(null);
const deleteSlackConnectionForm = useForm({});

const confirmSlackConnectionDeletion = (slack_connection_id) => {
    
    slackConnectionBeingDeleted.value = slack_connection_id;
    
};

const deleteSlackConnection = () => {
    deleteSlackConnectionForm.delete(route('slack.destroy', {'slack_connect':slackConnectionBeingDeleted.value }), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (slackConnectionBeingDeleted.value = null),
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
            Slack
        </template>

        <template #description>
            Connect your slack account and update channel id to receive notifications.
        </template>

        <template #form>
            <div class="col-span-6">

                <div v-if="!$page.props.slackConnection" class="flex items-center mt-2">
                    <a href="/auth/slack/redirect"><img alt="Add to Slack" height="40" width="139" src="https://platform.slack-edge.com/img/add_to_slack.png" srcSet="https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x" /></a>
                </div>
                <div v-else class="flex items-center mt-2">
                    
                    <button type="button" @click.prevent="confirmSlackConnectionDeletion($page.props.slackConnection.id)" class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white  hover:bg-red-500 " >
                        <!-- <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5" aria-hidden="true" /> -->
                        Disconnect Slack
                    </button>
                    
                    
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
    <ConfirmationModal :show="slackConnectionBeingDeleted != null" @close="slackConnectionBeingDeleted = null">
            <template #title>
                Delete Slack Connection
            </template>

            <template #content>
                Are you sure you would like to disconnect from this Slack account? This will delete the token and notifications will no longer be sent. You may reconnect at any time.
            </template>

            <template #footer>
                <SecondaryButton @click="slackConnectionBeingDeleted = null">
                    Cancel
                </SecondaryButton>

                <DangerButton
                    class="ms-3"
                    :class="{ 'opacity-25': deleteSlackConnectionForm.processing }"
                    :disabled="deleteSlackConnectionForm.processing"
                    @click="deleteSlackConnection"
                >
                    Delete
                </DangerButton>
            </template>
    </ConfirmationModal>
</template>
