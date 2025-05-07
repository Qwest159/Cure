<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, watch } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";

//MODAL
import DialogModal from "@/Components/DialogModal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ActionModal from "@/Components/ActionModal.vue";

const props = defineProps(["formules"]);
const form = useForm(props);
// DELETE AVEC MODAL
const confirmingformuleDeletion = ref(false);

let selected_formule_id = 0;
let selected_formule_nom = "";
const confirmformuleDeletion = (id, nom) => {
    selected_formule_id = id;
    selected_formule_nom = nom;
    confirmingformuleDeletion.value = true;
};

function deleteformule() {
    form.delete(route("cure_formule.destroy", selected_formule_id), {
        onSuccess: () => {
            formuleRecherche = props.formules;
            searchinput.value = "";
            closeModal();
        },
    });
}
let erreurs = ref();

// function succes(formule) {
//     form.post(route("mail.email", formule), {
//         onSuccess: () => {
//             erreurs.value = null;
//             formuleRecherche = props.formules;
//             searchinput.value = "";
//             closeModal();
//         },
//         onError: () => {
//             erreurs.value = {
//                 id: usePage().props.errors.id,
//                 error: usePage().props.errors.error,
//             };
//         },
//     });
// }
const closeModal = () => {
    confirmingformuleDeletion.value = false;
};

let searchinput = ref("");

// Résultats de la recherche
let formuleRecherche = ref(props.formules);

// Fonction de recherche
function function_rechercher() {
    const searchValue = searchinput.value.toLowerCase();
    formuleRecherche.value = props.formules.filter((formule) => {
        return formule.nom.toLowerCase().includes(searchValue);
    });
}
</script>

<template>
    <AppLayout title="formules">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Les formules
            </h2>
        </template>

        <label class="mx-4 font-bold">Recherche : </label>
        <input
            class="mr-5 w-64"
            type="search"
            name="search"
            id="search"
            v-model="searchinput"
            placeholder="Rechercher une formule"
            @input="function_rechercher"
        />
        <h1 v-if="erreurs?.id" class="text-red-500 text-2xl text-center">
            <p v-html="erreurs.error"></p>
        </h1>
        <button
            class="mt-2"
            id="formule_recherche"
            @click="() => $inertia.get(route('cure_formule.create'))"
        >
            Ajouter formule
        </button>
        <article
            class="mt-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
        >
            <section
                v-for="formule in formuleRecherche"
                :key="formule.id"
                class="border-4 p-4"
            >
                <p>Nom: {{ formule.nom }} ({{ formule.prix }}€)</p>
                <p>
                    Date :
                    <span class="text-cyan-500">{{ formule.date_debut }}</span>
                    /
                    <span class="text-orange-400">{{ formule.date_fin }}</span>
                </p>
                <div class="flex space-x-4 mt-4">
                    <!-- Bouton Modifier -->
                    <button
                        class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        @click="
                            () =>
                                $inertia.get(
                                    route('cure_formule.edit', formule.id)
                                )
                        "
                    >
                        Moddifier
                    </button>
                    <!-- Bouton Supprimer -->

                    <ActionModal>
                        <template #content>
                            <div class="">
                                <DangerButton
                                    id="open-modal-button"
                                    @click="
                                        confirmformuleDeletion(
                                            formule.id,
                                            formule.nom
                                        )
                                    "
                                >
                                    Supprimer
                                </DangerButton>
                            </div>
                        </template>
                    </ActionModal>
                </div>
            </section>
        </article>

        <DialogModal :show="confirmingformuleDeletion" @close="closeModal">
            <template #title>
                Supprimer
                {{ selected_formule_nom }}</template
            >

            <template #content>
                La formule <strong>"{{ selected_formule_nom }}"</strong> va être
                supprimée
            </template>

            <template #footer>
                <SecondaryButton @click="closeModal"> Annuler </SecondaryButton>

                <DangerButton
                    class="ms-3"
                    :class="{
                        'opacity-25': form.processing,
                    }"
                    @click="deleteformule()"
                >
                    Supprimer
                </DangerButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>

<style></style>
