<script setup>
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
});

const createTeam = () => {
    form.post(route('teams.store'), {
        errorBag: 'createTeam',
        preserveScroll: true,
    });
};
</script>

<template>
    <FormSection @submitted="createTeam">
        <template #title>
            Slack
        </template>

        <template #description>
            Connect your slack account and update channel id to receive notifications.
        </template>

        <template #form>
            <div class="col-span-6">

                <div class="flex items-center mt-2">
                    <a href="/auth/slack/redirect"><img alt="Add to Slack" height="40" width="139" src="https://platform.slack-edge.com/img/add_to_slack.png" srcSet="https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x" /></a>
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
                    disabled
                />
                <p class="mt-3 text-sm/6 text-gray-600">Please use the complete channel id prepended by a #. (e.g. #your-channel-id)</p>
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Update
            </PrimaryButton>
        </template>
    </FormSection>
</template>
