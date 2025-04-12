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
const organizationId = ref('');
const projects = ref([]);
const selectedProject = ref('');
const campfireLine = ref('');
const form = useForm({
    _method: 'PUT',
    name: usePage().props.basecampConnection ? usePage().props.pushoverConnection.Pushover_channel_id : '',
    id: usePage().props.basecampConnection ? usePage().props.basecampConnection.id : '',
});
const PushoverConnectionBeingDeleted = ref(null);
const deletePushoverConnectionForm = useForm({});
const getProjects = useForm({});
const confirmPushoverConnectionDeletion = (Pushover_connection_id) => {

    PushoverConnectionBeingDeleted.value = Pushover_connection_id;

};
const fetchProjects = async () => {
    getProjects.processing = true;
    try {
        const response = await axios.get(route('basecamp.projects', { organization_id: organizationId.value }));
        projects.value = response.data.projects;
    } catch (error) {
        console.error('Error fetching projects:', error);
    } finally {
        form.processing = false;
    }
};
const deletePushoverConnection = () => {
    deletePushoverConnectionForm.delete(route('basecamp.destroy', { 'basecamp_connect': PushoverConnectionBeingDeleted.value }), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (PushoverConnectionBeingDeleted.value = null),
    });
};

const updatePushoverChannelId = () => {
    form.post(route('Pushover.update', { 'Pushover_connect': usePage().props.pushoverConnection.id }), {
        errorBag: 'updatePushoverChannelId',
        preserveScroll: true,
    });
};
</script>
<style type="text/css">
.basecamp_button {
    box-sizing: border-box !important;
    display: inline-block;
    background-color: #eee !important;
    background: url('/62c6f17a7a58a4aa1fb770a8.png') 3px 3px no-repeat;
    background-size: 15px 15px;
    border-bottom: 2px solid rgba(22, 22, 22, 0.25) !important;
    border-right: 2px solid rgba(22, 22, 22, 0.25) !important;
    box-shadow: 0pt 2px 0pt rgba(255, 255, 255, 0.2) inset, 0pt 2px 0px rgba(0, 0, 0, 0.05) !important;
    border-radius: 3px !important;
    color: #333 !important;
    display: inline-block !important;
    font: 11px/18px "Helvetica Neue", Arial, sans-serif !important;
    font-weight: bold !important;
    cursor: pointer !important;
    height: 22px !important;
    padding: 2px 6px 20px 22px !important;
    overflow: hidden !important;
    text-decoration: none !important;
    vertical-align: middle !important;
    height: 22px !important;
}
</style>
<template>
    <FormSection @submitted="updatePushoverChannelId">
        <template #title>
            Basecamp
        </template>

        <template #description>
            Connect your Basecamp account to receive push notifications on campfire chat and create a task on a todo
            list.
        </template>

        <template #form>
            <div class="col-span-6">

                <div v-if="!$page.props.basecampConnection" class="flex items-center mt-2">

                    <a class="basecamp_button" href="/auth/basecamp/redirect">Connect your Basecamp account</a>
                </div>
                <div v-else class="flex items-center mt-2">

                    <DangerButton type="button"
                        @click.prevent="confirmPushoverConnectionDeletion($page.props.basecampConnection.id)"
                        :disabled="deletePushoverConnectionForm.processing"
                        class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white  hover:bg-red-500 ">
                        <!-- <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5" aria-hidden="true" /> -->
                        Disconnect Basecamp account
                    </DangerButton>


                </div>
            </div>
             <!-- Organization ID Input -->
             <div class="col-span-6">
                <InputLabel for="organization_id" value="Basecamp Organization ID" />
                <TextInput
                    id="organization_id"
                    v-model="organizationId"
                    type="number"
                    class="block w-full mt-1"
                    placeholder="Enter your Basecamp Organization ID"
                    required
                />
                <InputError :message="form.errors.organization_id" class="mt-2" />
            </div>

            <!-- Fetch Projects Button -->
            <div class="col-span-6 mt-1">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="fetchProjects">
                    Fetch Projects
                </PrimaryButton>
            </div>
            <!-- Project Selection -->
             <!-- Projects Dropdown -->
            <div class="col-span-6 mt-4">
                <InputLabel for="project_id" value="Select a Project" />
                <select
                    id="project_id"
                    v-model="selectedProject"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
                    <option v-for="project in projects" :key="project.id" :value="project.id">
                        {{ project.name }}
                    </option>
                </select>
                <InputError :message="form.errors.project_id" class="mt-2" />
            </div>

            <!-- Save Campfire Line -->
            <div v-if="selectedProject" class="col-span-6 mt-4">
                <InputLabel for="campfire_line" value="Campfire Line" />
                <TextInput
                    id="campfire_line"
                    v-model="campfireLine"
                    type="text"
                    class="block w-full mt-1"
                    placeholder="Enter Campfire Line"
                    required
                />
                <InputError :message="form.errors.campfire_line" class="mt-2" />
            </div>
        </template>

        <template v-if="$page.props.pushoverConnection" #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Update
            </PrimaryButton>
        </template>
    </FormSection>

    <!-- Delete Token Confirmation Modal -->
    <ConfirmationModal :show="PushoverConnectionBeingDeleted != null" @close="PushoverConnectionBeingDeleted = null">
        <template #title>
            Delete Basecamp Connection
        </template>

        <template #content>
            Are you sure you would like to disconnect from this Basecamp account? This will delete the token and
            notifications will no longer be sent. You may reconnect at any time.
        </template>

        <template #footer>
            <SecondaryButton @click="PushoverConnectionBeingDeleted = null">
                Cancel
            </SecondaryButton>

            <DangerButton class="ms-3" :class="{ 'opacity-25': deletePushoverConnectionForm.processing }"
                :disabled="deletePushoverConnectionForm.processing" @click="deletePushoverConnection">
                Delete
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
