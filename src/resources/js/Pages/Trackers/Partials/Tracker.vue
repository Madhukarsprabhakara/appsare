<template>
  <div class="bg-white mb-4   sm:rounded-lg">
    <div class="bg-white px-4 py-5 sm:px-6">
      <div class="flex space-x-3">
        <div class="shrink-0">
          <!-- <img class="size-10 rounded-full"
            src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
            alt="" /> -->
        </div>
        <div class="min-w-0 flex-1">
          <p class="text-md font-semibold text-gray-900">
            <a :href="tracker.url" class="hover:underline">{{ tracker.url }}</a>
          </p>
          <p v-if="tracker.domain_cert" class="text-sm text-gray-500 mt-2">
            <span v-if="tracker.domain_cert.cert_expires_at"
              :class="[
                'mr-2 inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset',
                sslExpiryClass,
              ]"
            >
              SSL Expires in {{ sslDaysRemaining }} days
            </span>
            <!-- Domain Expiry -->
            <span v-if="tracker.domain_cert.domain_expires_at"
              :class="[
                'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset',
                domainExpiryClass,
              ]"
            >
              Domain Expires in {{ domainDaysRemaining }} days
            </span>
          </p>
          
        </div>
        <div class="flex shrink-0 self-center">
          <div class="mr-8">
            <UptimeIndicator :uptime_data="tracker.analytics" />
            <p class="text-sm mt-2 text-gray-500">
              <a href="#" class="hover:underline">HTTP | Status each day for past 60 days</a>
            </p>
          </div>
          <Menu as="div" class="relative inline-block text-left">
            <div>
              <MenuButton class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600">
                <span class="sr-only">Open options</span>
                <EllipsisVerticalIcon class="size-5" aria-hidden="true" />
              </MenuButton>
            </div>

            <transition enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95">
              <MenuItems
                class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                <div class="py-1">

                  <MenuItem v-slot="{ active }">
                  <Link :href="route('trackers.edit', tracker.id)"
                    :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'flex px-4 py-2 text-sm']">
                  <PencilIcon class="mr-3 size-5 text-gray-400" aria-hidden="true" />
                  <span>Edit</span>
                  </Link>
                  </MenuItem>
                  <MenuItem v-slot="{ active }">
                  <a @click="confirmSlackConnectionDeletion(tracker.id)" href="#"
                    :class="[active ? 'bg-gray-100 text-gray-900 outline-none' : 'text-gray-700', 'flex px-4 py-2 text-sm']">
                    <TrashIcon class="mr-3 size-5 text-gray-400" aria-hidden="true" />
                    <span>Delete</span>
                  </a>
                  </MenuItem>
                </div>
              </MenuItems>
            </transition>
          </Menu>
        </div>
      </div>
      <!-- Delete Token Confirmation Modal -->
      <ConfirmationModal :show="slackConnectionBeingDeleted != null" @close="slackConnectionBeingDeleted = null">
        <template #title>
          Delete Tracker
        </template>

        <template #content>
          Are you sure you want to delete the Tracker? This will delete the Tracker and all the associated events
          recorded so far. You can always add the tracker back.
        </template>

        <template #footer>
          <ActionMessage :on="deleteTracker.processing" class="mr-4">
            Deleting...
          </ActionMessage>
          <SecondaryButton @click="slackConnectionBeingDeleted = null">
            Cancel
          </SecondaryButton>

          <DangerButton class="ms-3" :class="{ 'opacity-25': deleteTracker.processing }"
            :disabled="deleteTracker.processing" @click="deleteSlackConnection">
            Delete
          </DangerButton>
          
        </template>
      </ConfirmationModal>

    </div>
  </div>

</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { TrashIcon, EllipsisVerticalIcon, FlagIcon, PencilIcon } from '@heroicons/vue/20/solid';
import { Link } from '@inertiajs/vue3';
import UptimeIndicator from '@/Components/UptimeIndicator.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
const props = defineProps({
  tracker: Object,
});
const slackConnectionBeingDeleted = ref(null);
const deleteTracker = useForm({});

const confirmSlackConnectionDeletion = (slack_connection_id) => {

  slackConnectionBeingDeleted.value = slack_connection_id;


};
const deleteSlackConnection = () => {
  deleteTracker.delete(route('trackers.destroy', slackConnectionBeingDeleted.value), {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => (slackConnectionBeingDeleted.value = null,
      router.visit('/trackers')),
  });
  console.log(props.statusPages);
};

// Helper function to calculate days remaining
const calculateDaysRemaining = (date) => {
  if (!date) return null;
  const now = new Date();
  const targetDate = new Date(date);
  const diffTime = targetDate - now;
  return Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Convert milliseconds to days
};

// Computed properties for SSL and domain expiry
const sslDaysRemaining = computed(() =>
  calculateDaysRemaining(props.tracker.domain_cert?.cert_expires_at)
);
const domainDaysRemaining = computed(() =>
  calculateDaysRemaining(props.tracker.domain_cert?.domain_expires_at)
);

// Computed properties for dynamic classes
const sslExpiryClass = computed(() => {
  if (sslDaysRemaining.value === null) return 'bg-gray-50 text-gray-600 ring-gray-500/10';
  if (sslDaysRemaining.value >= 30) return 'bg-green-50 text-green-600 ring-green-500/10';
  if (sslDaysRemaining.value < 30 && sslDaysRemaining.value >= 5)
    return 'bg-orange-50 text-orange-600 ring-orange-500/10';
  return 'bg-red-50 text-red-600 ring-red-500/10';
});

const domainExpiryClass = computed(() => {
  if (domainDaysRemaining.value === null) return 'bg-gray-50 text-gray-600 ring-gray-500/10';
  if (domainDaysRemaining.value >= 30) return 'bg-green-50 text-green-600 ring-green-500/10';
  if (domainDaysRemaining.value < 30 && domainDaysRemaining.value >= 5)
    return 'bg-orange-50 text-orange-600 ring-orange-500/10';
  return 'bg-red-50 text-red-600 ring-red-500/10';
});
</script>