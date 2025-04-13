<script setup>
import { ref, computed, watch, onMounted } from 'vue';
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
const account_id = ref('');
const projects = ref([]);
const project_details = ref([]);
const project_name = ref('');
const campfire_line = ref('');
const form = useForm({
    _method: 'PUT',
    project_name: '',
    campfire_line: '',
    account_id: '',
});
const PushoverConnectionBeingDeleted = ref(null);
const deletePushoverConnectionForm = useForm({});
const getProjectsForm = useForm({});
const confirmPushoverConnectionDeletion = (Pushover_connection_id) => {

    PushoverConnectionBeingDeleted.value = Pushover_connection_id;

};
// Update form values when reactive variables change
watch([project_name, campfire_line, account_id], ([newProjectName, newCampfireLine, newAccountId]) => {
    form.project_name = newProjectName;
    form.campfire_line = newCampfireLine;
    form.account_id = newAccountId;
});
onMounted(() => {
    // Check if data is available from the server
    const basecampConnection = ref(usePage().props.basecampConnection);

    if (basecampConnection) {
        // Update the reactive variables with server data
        project_name.value = basecampConnection.value.project_name || '';
        campfire_line.value = basecampConnection.value.campfire_line || '';
        account_id.value = basecampConnection.value.account_id || '';
    }
});
const handleProjectSelection = (event) => {
    const selectedValue = JSON.parse(event.target.value);// Get the selected value
    campfire_line.value = selectedValue.campfire_line; // Set the campfire line (lines_url)
    project_name.value = selectedValue.project_name; // Set the project name
    console.log("Selected campfire line:", campfire_line.value);
    console.log("Selected project name:", project_name.value);
};
const fetchProjects = async () => {
    try {
        const response = await axios.get(route('basecamp.projects',{'account_id':account_id.value, 'id': usePage().props.basecampConnection.id}), {
            params: {
                preserveScroll: true,
                preserveState: true,
            },
        });

        projects.value = response.data; // Assuming the response contains a `projects` array
    } catch (error) {
        console.error("Error fetching projects:", error);
    }
};
const deletePushoverConnection = () => {
    deletePushoverConnectionForm.delete(route('basecamp.destroy', { 'basecamp_connect': PushoverConnectionBeingDeleted.value }), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (PushoverConnectionBeingDeleted.value = null),
    });
};

const updateBasecampConnection = () => {
    form.post(route('basecamp.update', { 'basecamp_connect': usePage().props.basecampConnection.id }), {
        errorBag: 'updateBasecampConnection',
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
    <FormSection @submitted="updateBasecampConnection">
        <template #title>
            Basecamp
        </template>

        <template #description>
            Connect your Basecamp account to receive push notifications on campfire chat for the selected project.
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
              
             <div v-if="$page.props.basecampConnection.id" class="col-span-6">
                <InputLabel for="account_id" value="Basecamp Account ID" />
                <TextInput
                    id="account_id"
                    v-model="account_id"
                    type="number"
                    class="block w-full mt-1"
                    placeholder="Enter your Basecamp account ID"
                    required
                />
                <InputError :message="getProjectsForm.errors.account_id" class="mt-2" />
            </div>

            <!-- Fetch Projects Button -->
            <div v-if="$page.props.basecampConnection.id" class="col-span-6 mt-1">
                <SecondaryButton :class="{ 'opacity-25': getProjectsForm.processing }" :disabled="getProjectsForm.processing" @click.prevent="fetchProjects">
                    Fetch Projects
                </SecondaryButton>
            </div>
            <div v-if="$page.props.basecampConnection.project_name" class="col-span-6 mt-1">
                <p class="mt-1 text-sm leading-6 text-gray-600">
                    <span class="underline font-bold">{{ $page.props.basecampConnection.project_name }}  </span> project was selected previouslyto receive campfire notifications. You may change this to any other project by fetching projects and selecting a different one.
                </p>

            </div>
            <!-- Project Selection -->
             <!-- Projects Dropdown -->
            <div v-if="projects.length>0" class="col-span-6 mt-4">
                <InputLabel for="project_id" value="Select a Project" />
                <select
                    id="project_id"
                    v-model="project_details"
                     @change="handleProjectSelection($event)"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
                    <option v-for="project in projects" :key="project.id" :value="JSON.stringify({ campfire_line: project.lines_url, project_name: project.bucket.name })">
                        {{ project.bucket.name }}
                    </option>
                    
                </select>
                <InputError :message="form.errors.project_id" class="mt-2" />
                <span class="text-sm leading-6 text-gray-600">Selected project: {{ project_name }}</span>
            </div>
            
            <!-- Save Campfire Line -->
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
