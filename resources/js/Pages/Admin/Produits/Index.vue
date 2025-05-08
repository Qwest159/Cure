<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

//MODAL
import DialogModal from "@/Components/DialogModal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ActionModal from "@/Components/ActionModal.vue";

const props = defineProps(["produits"]);
const form = useForm(props);
// DELETE AVEC MODAL
const confirmingproduitDeletion = ref(false);
let affichage_resultat = ref(false);

let selected_produit_id = 0;
let selected_produit_nom = "";
const confirmproduitDeletion = (id, nom) => {
    selected_produit_id = id;
    selected_produit_nom = nom;
    confirmingproduitDeletion.value = true;
};

function deleteproduit() {
    form.delete(route("cure_produit.destroy", selected_produit_id), {
        onSuccess: () => {
            produitRecherche = props.produits;
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
    confirmingproduitDeletion.value = false;
};

let searchinput = ref("");

// Résultats de la recherche
let produitRecherche = ref(props.produits);

// Fonction de recherche
function function_rechercher() {
    const searchValue = searchinput.value.toLowerCase();
    produitRecherche.value = props.produits.filter((produit) => {
        return produit.nom.toLowerCase().includes(searchValue);
    });
}
</script>

<template>
    <AppLayout title="produits">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Les produits
            </h2>
        </template>

        <label class="mx-4 font-bold">Recherche : </label>
        <input
            class="mr-5 w-64"
            type="search"
            name="search"
            id="search"
            v-model="searchinput"
            placeholder="Rechercher un produit"
            @input="function_rechercher"
        />

        <button
            class="my-4"
            id="produit_recherche"
            @click="() => $inertia.get(route('cure_produit.create'))"
        >
            Ajouter produit
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
                v-for="produit in produitRecherche"
                :key="produit.id"
                class="border-4 p-4"
            >
                <p>Nom: {{ produit.nom }}</p>
                <p>Prix : {{ produit.prix }}€</p>
                <div class="flex space-x-4 mt-4">
                    <!-- Bouton Modifier -->
                    <button
                        class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        @click="
                            () =>
                                $inertia.get(
                                    route('cure_produit.edit', produit.id)
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
                                        confirmproduitDeletion(
                                            produit.id,
                                            produit.nom
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

        <DialogModal :show="confirmingproduitDeletion" @close="closeModal">
            <template #title>
                Supprimer
                {{ selected_produit_nom }}</template
            >

            <template #content>
                La produit <strong>"{{ selected_produit_nom }}"</strong> va être
                supprimée
            </template>

            <template #footer>
                <SecondaryButton @click="closeModal"> Annuler </SecondaryButton>

                <DangerButton
                    class="ms-3"
                    :class="{
                        'opacity-25': form.processing,
                    }"
                    @click="deleteproduit()"
                >
                    Supprimer
                </DangerButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>

<style></style>
