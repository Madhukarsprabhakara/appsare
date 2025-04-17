<script setup>
import { ref, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
// Props to receive the tracker data from the server
const tracker = ref(usePage().props.tracker)

// Reactive form for editing the tracker
const form = useForm({
    _method: 'PUT', // Specify the HTTP method for updating
    url: tracker.value.url || '', // Initialize with the URL from props
});

// Function to submit the form
function updateTracker() {
    form.put(route('trackers.update', { tracker: tracker.value.id }), {
        errorBag: 'editTracker',
        preserveScroll: true,
    });
}
</script>

<template>
    <FormSection @submitted="updateTracker">
        <template #title>
            Edit Tracker
        </template>

        <template #description>
            Update the URL of your website tracker.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="url" value="URL" />
                <TextInput
                    id="url"
                    v-model="form.url"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                    required
                />
                <p class="mt-1 text-sm leading-6 text-gray-600">
                    Ensure the URL starts with http:// or https://
                </p>
                <InputError :message="form.errors.url" class="mt-2" />
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