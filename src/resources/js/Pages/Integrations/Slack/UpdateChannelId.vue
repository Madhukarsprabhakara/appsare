<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import NavLink from '@/Components/NavLink.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
const form = useForm({
    _method: 'PUT',
    name: usePage().props.slackConnection    ? usePage().props.slackConnection.slack_channel_id : '',
    id: usePage().props.slackConnection    ? usePage().props.slackConnection.id : '',
});



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
                    <NavLink  href="#"  preserve-scroll> 
                        <button type="button" class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white  hover:bg-red-500  ">
                            <!-- <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5" aria-hidden="true" /> -->
                            Disconnect Slack
                        </button>
                    
                    </NavLink>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
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

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Update
            </PrimaryButton>
        </template>
    </FormSection>
</template>
