<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

//MODAL
import DialogModal from "@/Components/DialogModal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ActionModal from "@/Components/ActionModal.vue";

const props = defineProps(["dates"]);
const form = useForm(props);
// DELETE AVEC MODAL
const confirmingdateDeletion = ref(false);
let affichage_resultat = ref(false);

let selected_date_id = 0;
let selected_date_debut = "";
let selected_date_fin = "";
let selected_date_prix = "";
const confirmdateDeletion = (id, debut, fin, prix) => {
    selected_date_id = id;
    selected_date_debut = debut;
    selected_date_fin = fin;
    selected_date_prix = prix;
    confirmingdateDeletion.value = true;
};

function deletedate() {
    form.delete(route("cure_date.destroy", selected_date_id), {
        onSuccess: () => {
            dateRecherche = props.dates;
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
    confirmingdateDeletion.value = false;
};

let searchinput = ref("");

// Résultats de la recherche
let dateRecherche = ref(props.dates);

// Fonction de recherche
function function_rechercher() {
    const searchValue = searchinput.value.toLowerCase();
    dateRecherche.value = props.dates.filter((date) => {
        return (
            date.date_debut.toLowerCase().includes(searchValue),
            date.date_fin.toLowerCase().includes(searchValue)
        );
    });
}
</script>

<template>
    <AppLayout title="dates">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Les dates
            </h2>
        </template>

        <label class="mx-4 font-bold">Recherche : </label>
        <input
            class="mr-5 w-64"
            type="search"
            name="search"
            id="search"
            v-model="searchinput"
            placeholder="Rechercher une date"
            @input="function_rechercher"
        />

        <button
            class="my-4"
            id="date_recherche"
            @click="() => $inertia.get(route('cure_date.create'))"
        >
            Ajouter date
        </button>
        <button
            v-if="affichage_resultat"
            class="w-full p-2 bg-green-500 text-white text-center"
        >
            Supprimer réussi
        </button>
        <article
            class="mt-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
        >
            <section
                v-for="date in dateRecherche"
                :key="date.id"
                class="border-4 p-4"
            >
                <h2 class="text-2xl">Date :</h2>
                <p>
                    <span class="text-cyan-500">{{ date.date_debut }}</span>
                    /
                    <span class="text-orange-400">{{ date.date_fin }}</span>
                </p>
                <p>Prix : {{ date.prix }}€</p>
                <div class="flex space-x-4 mt-4">
                    <!-- Bouton Modifier -->
                    <button
                        class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 plusieurs"
                        @click="
                            () => $inertia.get(route('cure_date.edit', date.id))
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
                                        confirmdateDeletion(
                                            date.id,
                                            date.date_debut,
                                            date.date_fin,
                                            date.prix
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

        <DialogModal :show="confirmingdateDeletion" @close="closeModal">
            <template #title>
                Supprimer
                <p>
                    <span class="text-cyan-500">{{ selected_date_debut }}</span>
                    /
                    <span class="text-orange-400">{{ selected_date_fin }}</span>
                    ({{ selected_date_prix }}€)
                </p>
            </template>

            <template #content>
                La date
                <p>
                    <span class="text-cyan-500">{{ selected_date_debut }}</span>
                    /
                    <span class="text-orange-400">{{ selected_date_fin }}</span>
                    ({{ selected_date_prix }}€)
                </p>
                va être supprimée
            </template>

            <template #footer>
                <SecondaryButton @click="closeModal"> Annuler </SecondaryButton>

                <DangerButton
                    class="ms-3"
                    :class="{
                        'opacity-25': form.processing,
                    }"
                    @click="deletedate()"
                >
                    Supprimer
                </DangerButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>

<style></style>
