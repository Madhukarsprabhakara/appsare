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
function storeTracker() {
    form.post(route('trackers.store'), {
      preserveScroll: true,

    })
  }
const form = useForm({
    url: 'https://',
    
    
});
</script>

<template>

    <FormSection @submitted="storeTracker">
        <template #title>
            Create Tracker
        </template>

        <template #description>
            Create a website tracker to keep track of its uptime and to get notified of any downtimes.
        </template>

        <template #form>


            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="URL" />
                <TextInput id="name" v-model="form.url" type="text" class="block w-full mt-1" autofocus required/>
                <p class="mt-1 text-sm leading-6 text-gray-600">You may track non-secured sites using http:// instead of https://</p>
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </PrimaryButton>
        </template>
    </FormSection>

</template>