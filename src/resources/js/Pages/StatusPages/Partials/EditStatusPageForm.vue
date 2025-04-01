<script setup>
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import vSelect from "vue-select";
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

// Get the initial data from the server
const { statusPage, trackers } = usePage().props;

// Initialize the form with the existing status page data
const form = useForm({
    name: statusPage.name || '',
    url_slug: statusPage.url_slug || '',
    selectedOptions: statusPage.trackers_without_events.map(tracker => ({
        label: tracker.url,  // Use the tracker URL as the label
        value: tracker.id,   // Use the tracker ID as the value
    })), // Pre-select trackers
});

// Compute the options for the multi-select field
const options = computed(() =>
    trackers.map(tracker => ({
        label: tracker.url, // Display the URL as the label
        value: tracker.id,  // Use the tracker ID as the value
    }))
);

// Function to update the status page
const updateStatusPage = () => {
    form.put(route('statuspages.update', statusPage.id), {
        errorBag: 'editStatusPage',
        preserveScroll: true,
    });
};
</script>

<template>
    <FormSection @submitted="updateStatusPage">
        <template #title>
            Edit Status Page
        </template>

        <template #description>
            Update the details of your status page and manage its trackers.
        </template>

        <template #form>
            <!-- Name Field -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Title" />
                <TextInput id="name" v-model="form.name" type="text" class="block w-full mt-1" autofocus required />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- URL Slug Field -->
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="url_slug" value="AppsAre URL" />
                <TextInput id="url_slug" v-model="form.url_slug" type="text" class="block w-full mt-1" required />
                <p class="mt-1 text-sm leading-6 text-gray-600">
                    Your status page will appear here:
                    <a :href="`https://appsare.com/s/${form.url_slug}`" target="_blank" rel="noopener noreferrer"
                        class="text-blue-600 hover:underline">
                        https://appsare.com/s/{{ form.url_slug }}
                    </a>
                </p>
                <InputError :message="form.errors.url_slug" class="mt-2" />
            </div>

            <!-- Multi-Select Field for Trackers -->
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="multi-select" value="Select Trackers" />
                <v-select id="multi-select" v-model="form.selectedOptions" :options="options" :multiple="true"
                    :searchable="true" class="block w-full mt-1" />
                <InputError :message="form.errors.selectedOptions" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Update
            </PrimaryButton>
        </template>
    </FormSection>
</template>