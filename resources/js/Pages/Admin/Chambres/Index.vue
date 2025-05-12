<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

//MODAL
import DialogModal from "@/Components/DialogModal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ActionModal from "@/Components/ActionModal.vue";
let affichage_resultat = ref(false);

const props = defineProps(["chambres"]);
const form = useForm(props);
// DELETE AVEC MODAL
const confirmingchambreDeletion = ref(false);

let selected_chambre_id = 0;
let selected_chambre_nom = "";
const confirmchambreDeletion = (id, nom) => {
    selected_chambre_id = id;
    selected_chambre_nom = nom;
    confirmingchambreDeletion.value = true;
};

function deletechambre() {
    form.delete(route("cure_chambre.destroy", selected_chambre_id), {
        onSuccess: () => {
            chambreRecherche = props.chambres;
            searchinput.value = "";

            closeModal();
            affichage_resultat.value = true; // Afficher le message "Veuillez patienter"
            // Réinitialiser après 5 secondes
            setTimeout(() => {
                affichage_resultat.value = false;
            }, 5000);
        },
    });
}

const closeModal = () => {
    confirmingchambreDeletion.value = false;
};

let searchinput = ref("");

// Résultats de la recherche
let chambreRecherche = ref(props.chambres);

// Fonction de recherche
function function_rechercher() {
    const searchValue = searchinput.value.toLowerCase();
    chambreRecherche.value = props.chambres.filter((chambre) => {
        return chambre.nom.toLowerCase().includes(searchValue);
    });
}
</script>

<template>
    <AppLayout title="Chambres">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Les chambres
            </h2>
        </template>

        <label class="mx-4 font-bold">Recherche : </label>
        <input
            class="mr-5 w-64"
            type="search"
            name="search"
            id="search"
            v-model="searchinput"
            placeholder="Rechercher une chambre"
            @input="function_rechercher"
        />

        <button
            class="mt-2"
            id="chambre_recherche"
            @click="() => $inertia.get(route('cure_chambre.create'))"
        >
            Ajouter chambre
        </button>
        <button
            v-if="affichage_resultat"
            class="w-full p-2 bg-green-500 text-white text-center"
        >
            Supprimer réussi
        </button>
        <article
            class="mt-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text_button"
        >
            <section
                v-for="chambre in chambreRecherche"
                :key="chambre.id"
                class="border-4 p-4 space-y-2 grid"
            >
                <p>Nom: {{ chambre.nom }}</p>
                <h2 class="text-2xl my-2">Date :</h2>
                <p v-for="chambre in chambre.dates" :key="chambre.id">
                    <span class="text-cyan-500">{{ chambre.date_debut }}</span>
                    /
                    <span class="text-orange-400">{{ chambre.date_fin }}</span>
                    ({{ chambre.prix }}€)
                </p>
                <div class="flex flex-wrap space-x-4 m-auto items-center wrap">
                    <button
                        class="inline-flex items-center justify-center px-4 py-2 bg-violet-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-violet-500 active:bg-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition ease-in-out duration-150 plusieurs"
                        @click="
                            () =>
                                $inertia.get(
                                    route('cure_chambre.edit_date', chambre.id)
                                )
                        "
                    >
                        Date
                    </button>
                    <!-- Bouton Modifier -->
                    <button
                        class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 plusieurs"
                        @click="
                            () =>
                                $inertia.get(
                                    route('cure_chambre.edit', chambre.id)
                                )
                        "
                    >
                        Modifier
                    </button>
                    <!-- Bouton Supprimer -->

                    <ActionModal>
                        <template #content>
                            <div class="">
                                <DangerButton
                                    id="open-modal-button"
                                    @click="
                                        confirmchambreDeletion(
                                            chambre.id,
                                            chambre.nom
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

        <DialogModal :show="confirmingchambreDeletion" @close="closeModal">
            <template #title>
                Supprimer
                {{ selected_chambre_nom }}</template
            >

            <template #content>
                La chambre <strong>"{{ selected_chambre_nom }}"</strong> va être
                supprimée
            </template>

            <template #footer>
                <SecondaryButton @click="closeModal"> Annuler </SecondaryButton>

                <DangerButton
                    class="ms-3"
                    :class="{
                        'opacity-25': form.processing,
                    }"
                    @click="deletechambre()"
                >
                    Supprimer
                </DangerButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>

<style></style>
