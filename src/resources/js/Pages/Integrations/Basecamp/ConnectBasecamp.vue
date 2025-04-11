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
const form = useForm({
    _method: 'PUT',
    name: usePage().props.basecampConnection ? usePage().props.pushoverConnection.Pushover_channel_id : '',
    id: usePage().props.basecampConnection ? usePage().props.basecampConnection.id : '',
});
const PushoverConnectionBeingDeleted = ref(null);
const deletePushoverConnectionForm = useForm({});

const confirmPushoverConnectionDeletion = (Pushover_connection_id) => {

    PushoverConnectionBeingDeleted.value = Pushover_connection_id;

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
