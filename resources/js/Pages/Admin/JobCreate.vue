<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
//MODAL
import DialogModal from "@/Components/DialogModal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ActionModal from "@/Components/ActionModal.vue";

const props = defineProps(["Job", "flash"]);
const form = useForm({
    nom: "",
    type_contrat: "",
    heure: "",
    localité: "",
    permis: "",
    descriptions: "",
});
// agrandir le text area auto
const textarea = ref(null);
function adjustHeight() {
    textarea.value.style.height = "auto";
    textarea.value.style.height = textarea.value.scrollHeight + "px";
}
// DELETE AVEC MODAL

const confirmingJobDeletion = ref(false);
let selected_job_id = 0;
let selected_nom = "";

const confirmJobDeletion = (id, nom) => {
    selected_job_id = id;
    selected_nom = nom;

    confirmingJobDeletion.value = true;
};
// console.log(usePage().props.job.id);

function deleteJob() {
    form.delete(route("lfclean_destroy_job", selected_job_id), {
        onSuccess: () => closeModal(),
    });
}
const closeModal = () => {
    confirmingJobDeletion.value = false;
};

//supprime les job

function sendform() {
    form.post(route("lfclean_store_job"));
}
</script>

<template>
    <AppLayout title="Create job">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Créer Job
                </h2>
            </div>
        </template>

        <h1 class="text-xl font-bold mb-4 text-center">Création d'un job</h1>
        <div class="text-center font-bold">
            <p class="bg-green-600 w-full p-2" v-if="props.flash.réussi">
                {{ props.flash.réussi ?? "" }}
            </p>
        </div>
        <form @submit.prevent="sendform" enctype="multipart/form-data">
            <!-- Input pour choisir une job -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Nom -->
                <div>
                    <label
                        for="nom"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Nom du travail
                    </label>
                    <input
                        type="text"
                        id="nom"
                        v-model="form.nom"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    <div
                        v-if="form.errors.nom"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.nom }}
                    </div>
                </div>

                <!-- Type_contrat -->
                <div>
                    <label
                        for="type_contrat"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Type de contract (cdi/cdd)
                    </label>
                    <input
                        type="text"
                        id="type_contrat"
                        v-model="form.type_contrat"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    <div
                        v-if="form.errors.type_contrat"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.type_contrat }}
                    </div>
                </div>

                <!-- heure/semaine -->
                <div>
                    <label
                        for="heure"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Nombre d'heure/semaine
                    </label>
                    <input
                        type="tel"
                        id="heure"
                        v-model="form.heure"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    <div
                        v-if="form.errors.heure"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.heure }}
                    </div>
                </div>
                <!-- Localité -->
                <div>
                    <label
                        for="localité"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Localité
                    </label>
                    <input
                        type="text"
                        id="localité"
                        v-model="form.localité"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    <div
                        v-if="form.errors.localité"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.localité }}
                    </div>
                </div>

                <!-- ---Permis--- -->
                <div>
                    <label
                        for="permis"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Permis
                    </label>
                    <input
                        type="text"
                        id="permis"
                        v-model="form.permis"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    <div
                        v-if="form.errors.permis"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.permis }}
                    </div>
                </div>

                <!-- descriptions -->
                <div>
                    <label
                        for="descriptions"
                        class="block text-sm font-medium text-gray-700"
                    >
                        descriptions
                    </label>
                    <textarea
                        ref="textarea"
                        @input="adjustHeight"
                        name="message"
                        id="message"
                        v-model="form.descriptions"
                        class="border border-gray-300 w-full overflow-hidden"
                    ></textarea>
                    <div
                        v-if="form.errors.descriptions"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.descriptions }}
                    </div>
                </div>
            </div>

            <div class="text-center font-bold">
                <span class="text-red-600" v-if="props.flash.error">{{
                    props.flash.error ?? ""
                }}</span>
            </div>
            <!-- Prévisualisation de le job -->
            <!-- <div v-if="previewUrl" class="mt-4">
                        <h2 class="text-lg font-medium mb-2">Aperçu :</h2>
                        <img
                            alt="Aperçu de le job"
                            class="w-64 h-64 object-cover border"
                        />
                    </div> -->

            <!-- Submit -->
            <div class="m-auto text-center pt-8">
                <button type="submit" :disabled="form.processing">
                    Créer le job
                </button>
            </div>
        </form>

        <h1
            class="font-bold , text-red-600 text-xl m-5 py-9 border-4 border-t-red-500"
        >
            Supprime les Jobs en cliquant dessus
        </h1>

        <!-- Itération sur les job -->
        <div class="grid grid-cols-3 gap-4 justify-center text-xs">
            <div v-for="travail in Job" :key="Job.id" class="">
                <!-- Bouton pour chaque job -->

                <ActionModal>
                    <template #content>
                        <DangerButton
                            @click="confirmJobDeletion(travail.id, travail.nom)"
                        >
                            <div>
                                <p class="bg-none">
                                    {{ travail.nom }}
                                </p>
                                <p>
                                    {{ travail.type_contrat }} /
                                    {{ travail.heure }}
                                </p>
                                <p>
                                    {{ travail.descriptions }}
                                </p>
                            </div>
                        </DangerButton>
                    </template>
                </ActionModal>
            </div>
        </div>

        <DialogModal :show="confirmingJobDeletion" @close="closeModal">
            <template #title> Supprimer les job </template>

            <template #content>
                Le Job va être supprimée :
                <span class="font-bold">{{ selected_nom }}</span>
            </template>

            <template #footer>
                <SecondaryButton @click="closeModal"> Annuler </SecondaryButton>

                <DangerButton
                    class="ms-3"
                    :class="{
                        'opacity-25': form.processing,
                    }"
                    @click="deleteJob()"
                >
                    Supprimer le job
                </DangerButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>
