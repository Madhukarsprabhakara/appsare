<script setup>
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import vSelect from "vue-select";
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3'
const form = useForm({
    name: '',
    url_slug:'',
    selectedOptions: [], // For multi-select
});
const trackers = usePage().props.trackers;
const options = computed(() =>
    trackers.map(tracker => ({
        label: tracker.url, // Display the URL as the label
        value: tracker.id,  // Use the tracker ID as the value
    }))
);
const createStatusPage = () => {
    form.post(route('statuspages.store'), {
        errorBag: 'createStatusPage',
        preserveScroll: true,
    });
};
</script>

<template>

    <FormSection @submitted="createStatusPage">
        <template #title>
            Status Page
        </template>

        <template #description>
            Create a new status page and add trackers to it.
        </template>

        <template #form>


            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Title" />
                <TextInput id="name" v-model="form.name" type="text" class="block w-full mt-1" autofocus required/>
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="url_slug" value="AppsAre URL" />
                <TextInput id="url_slug" v-model="form.url_slug" type="text" class="block w-full mt-1" required/>
                <p class="mt-1 text-sm leading-6 text-gray-600">Your status page will appear here <a
                        href="https://appsare.com/s/yournam" target="_blank" rel="noopener noreferrer"
                        class="text-blue-600 hover:underline">
                        https://appsare.com/s/yourname
                    </a></p>
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="multi-select" value="Select Trackers" />
                <v-select id="multi-select"  v-model="form.selectedOptions" :options="options" :multiple="true"
                    :searchable="true" class="block w-full mt-1" />
                <InputError :message="form.errors.selectedOptions" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </PrimaryButton>
        </template>
    </FormSection>

</template>