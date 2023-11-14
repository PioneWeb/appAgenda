<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    email: props.user.email,
    codice: props.user.codice,
});

const sendCodeEmail = () => {
    form.post(route('user-profile-code.send'), {
        errorBag: 'sendCodeEmail',
        preserveScroll: true,
    });
};

</script>

<template>
    <FormSection @submitted="sendCodeEmail">
        <template #title>
            Code Information
        </template>

        <template #description>
            da inviare per email al paziente per la registrazione sul medico corretto.
        </template>

        <template #form>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="codice" value="Codice" />
                <TextInput
                    id="codice"
                    v-model="form.codice"
                    type="text"
                    class="mt-1 block w-full"
                    v-bind:readonly=true
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="emailPaziente" value="Email paziente" />
                <TextInput
                    id="emailPaziente"
                    type="text"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.emailPaziente" class="mt-2" />
            </div>

        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                Inviato.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Invia
            </PrimaryButton>
        </template>
    </FormSection>
</template>
