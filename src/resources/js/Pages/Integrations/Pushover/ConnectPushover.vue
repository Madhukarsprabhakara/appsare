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
    name: usePage().props.pushoverConnection ? usePage().props.pushoverConnection.Pushover_channel_id : '',
    id: usePage().props.pushoverConnection ? usePage().props.pushoverConnection.id : '',
});
const PushoverConnectionBeingDeleted = ref(null);
const deletePushoverConnectionForm = useForm({});

const confirmPushoverConnectionDeletion = (Pushover_connection_id) => {

    PushoverConnectionBeingDeleted.value = Pushover_connection_id;

};

const deletePushoverConnection = () => {
    deletePushoverConnectionForm.delete(route('pushover.destroy', { 'pushover_connect': PushoverConnectionBeingDeleted.value }), {
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
                        .pushover_button {
                            box-sizing: border-box !important;
                            display: inline-block;
                            background-color: #eee !important;
                            background: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAycHgiIGhlaWdodD0iNjAycHgiIHZlcnNpb249IjEuMSIgdmlld0JveD0iNTcgNTcgNjAyIDYwMiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSg1OC45NjQgNTguODg4KSIgb3BhY2l0eT0iLjkxIj48ZWxsaXBzZSB0cmFuc2Zvcm09Im1hdHJpeCgtLjY3NDU3IC43MzgyMSAtLjczODIxIC0uNjc0NTcgNTU2LjgzIDI0MS42MSkiIGN4PSIyMTYuMzEiIGN5PSIxNTIuMDgiIHJ4PSIyOTYuODYiIHJ5PSIyOTYuODYiIGZpbGw9IiMyNDlkZjEiIGZpbGwtcnVsZT0iZXZlbm9kZCIgc3Ryb2tlLXdpZHRoPSIwIi8+PHBhdGggZD0ibTI4MC45NSAxNzIuNTFsNzQuNDgtOS44LTcyLjUyIDE2My42NmMxMi43NC0wLjk4IDI1LjIzMy01LjMwNyAzNy40OC0xMi45OCAxMi4yNTMtNy42OCAyMy41MjctMTcuMzE3IDMzLjgyLTI4LjkxIDEwLjI4Ny0xMS42IDE5LjE4Ny0yNC41MDMgMjYuNy0zOC43MSA3LjUxMy0xNC4yMTMgMTIuOTAzLTI4LjE4IDE2LjE3LTQxLjkgMS45Ni04LjQ5MyAyLjg2LTE2LjY2IDIuNy0yNC41LTAuMTY3LTcuODQtMi4yMS0xNC43LTYuMTMtMjAuNThzLTkuODgzLTEwLjYxNy0xNy44OS0xNC4yMWMtOC0zLjU5My0xOC44Ni01LjM5LTMyLjU4LTUuMzktMTYuMDA3IDAtMzEuNzcgMi42MTMtNDcuMjkgNy44NC0xNS41MTMgNS4yMjctMjkuODg3IDEyLjgyMy00My4xMiAyMi43OS0xMy4yMjcgOS45Ni0yNC43NCAyMi4zNzMtMzQuNTQgMzcuMjQtOS44IDE0Ljg2LTE2LjgyMyAzMS43NjMtMjEuMDcgNTAuNzEtMS42MzMgNi4yMDctMi42MTMgMTEuMTg3LTIuOTQgMTQuOTQtMC4zMjcgMy43Ni0wLjQwNyA2Ljg2My0wLjI0IDkuMzEgMC4xNiAyLjQ1MyAwLjQ4MyA0LjMzMyAwLjk3IDUuNjQgMC40OTMgMS4zMDcgMC45MDMgMi42MTMgMS4yMyAzLjkyLTE2LjY2IDAtMjguODMtMy4zNS0zNi41MS0xMC4wNS03LjY3My02LjY5My05LjU1LTE4LjM3LTUuNjMtMzUuMDMgMy45Mi0xNy4zMTMgMTIuODIzLTMzLjgxIDI2LjcxLTQ5LjQ5IDEzLjg4LTE1LjY4IDMwLjM3My0yOS40ODMgNDkuNDgtNDEuNDEgMTkuMTEzLTExLjkyIDQwLjAyLTIxLjM5IDYyLjcyLTI4LjQxIDIyLjcwNy03LjAyNyA0NC44NC0xMC41NCA2Ni40LTEwLjU0IDE4Ljk0NyAwIDM0Ljg3IDIuNjkzIDQ3Ljc3IDguMDggMTIuOTA3IDUuMzkzIDIyLjk1MyAxMi41IDMwLjE0IDIxLjMyczExLjY3NyAxOS4xMSAxMy40NyAzMC44N2MxLjggMTEuNzYgMS4yMyAyNC4wMS0xLjcxIDM2Ljc1LTMuNTkzIDE1LjM1My0xMC4zNzMgMzAuNzktMjAuMzQgNDYuMzEtOS45NiAxNS41MTMtMjIuNDUzIDI5LjU2LTM3LjQ4IDQyLjE0LTE1LjAyNyAxMi41NzMtMzIuMjYgMjIuNzgtNTEuNyAzMC42Mi0xOS40MzMgNy44NC00MC4wOTMgMTEuNzYtNjEuOTggMTEuNzZoLTIuNDVsLTYyLjIzIDEzOS42NWgtNzAuNTZsMTM4LjY3LTMxMS42NHoiIGZpbGw9IiNmZmYiIHN0eWxlPSJ3aGl0ZS1zcGFjZTpwcmUiLz48L2c+PC9zdmc+) 3px 3px no-repeat;
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
            Pushover
        </template>

        <template #description>
            Connect your Pushover account to receive push notifications on your Pushover devices.
        </template>

        <template #form>
            <div class="col-span-6">

                <div v-if="!$page.props.pushoverConnection" class="flex items-center mt-2">
                    
                    <a class="pushover_button" href="/auth/pushover/redirect">Connect your Pushover account</a>
                </div>
                <div v-else class="flex items-center mt-2">

                    <button type="button"
                        @click.prevent="confirmPushoverConnectionDeletion($page.props.pushoverConnection.id)"
                        class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white  hover:bg-red-500 ">
                        <!-- <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5" aria-hidden="true" /> -->
                        Disconnect Pushover account
                    </button>


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
            Delete Pushover Connection
        </template>

        <template #content>
            Are you sure you would like to disconnect from this Pushover account? This will delete the token and
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
