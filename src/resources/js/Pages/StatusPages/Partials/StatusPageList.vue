<template>
    <div>
    <ul role="list"
        class="divide-y divide-gray-100  bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <li v-for="statusPage in statusPages" :key="statusPage.id"
            class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
            <div class="flex min-w-0 gap-x-4">
                <div class="min-w-0 flex-auto">
                    <p class="text-sm/6 font-semibold text-gray-900">
                        <a :href="route('statuspages.show', statusPage.url_slug)" target="_blank">
                            <span class="absolute inset-x-0 -top-px bottom-0" />
                            {{ statusPage.name }}
                        </a>
                    </p>
                    <p class="mt-1 flex text-xs/5 text-gray-500">
                        <span class="relative truncate">URL: {{route('statuspages.show', statusPage.url_slug)}}</span>
                    </p>
                </div>
            </div>
            
            <div class="flex flex-none items-center gap-x-4">
                <a :href="route('statuspages.show', statusPage.url_slug)"
                    class="hidden rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:block">View
                    Status Page<span class="sr-only">, {{ statusPage.name }}</span></a>
                <Menu as="div" class="relative flex-none">
                    <MenuButton class="-m-2.5 block p-2.5 text-gray-500 hover:text-gray-900">
                        <span class="sr-only">Open options</span>
                        <EllipsisVerticalIcon class="size-5" aria-hidden="true" />
                    </MenuButton>
                    <transition enter-active-class="transition ease-out duration-100"
                        enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95">
                        <MenuItems
                            class="absolute right-0 z-10 mt-2 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                            <MenuItem v-slot="{ active }">
                                <Link :href="route('statuspages.edit', statusPage.id)"
                                    :class="[active ? 'bg-gray-50 outline-none' : '', 'block px-3 py-1 text-sm/6 text-gray-900']">Edit<span
                                        class="sr-only">, {{ statusPage.name }}</span></Link>
                            </MenuItem>
                           
                            <MenuItem v-slot="{ active }">
                                <a @click="confirmSlackConnectionDeletion(statusPage.id)" href="#" 
                                    :class="[active ? 'bg-gray-50 outline-none' : '', 'block px-3 py-1 text-sm/6 text-gray-900']">Delete<span
                                        class="sr-only">, {{ statusPage.name }}</span></a>
                            </MenuItem>
                        </MenuItems>
                    </transition>
                </Menu>
            </div>
             
        </li>
    </ul>
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
</div>
</template>

<script setup>
import { ref } from 'vue';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { EllipsisVerticalIcon } from '@heroicons/vue/20/solid';
import { usePage, Link, useForm, router } from '@inertiajs/vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';


// Access the statusPages prop from Inertia's usePage
const { props } = usePage();
const statusPages = ref(props.statusPages);
const slackConnectionBeingDeleted = ref(null);
const deleteSlackConnectionForm = useForm({});

const confirmSlackConnectionDeletion = (slack_connection_id) => {
    
    slackConnectionBeingDeleted.value = slack_connection_id;
    
    
};
const deleteSlackConnection = () => {
    deleteSlackConnectionForm.delete(route('statuspages.destroy',slackConnectionBeingDeleted.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (slackConnectionBeingDeleted.value = null, 
        router.visit('/statuspages')),
    });
    console.log( props.statusPages);
};
</script>