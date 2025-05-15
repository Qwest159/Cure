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
            affichage_resultat.value = true; // Afficher le message "Veuillez patienter"
            // Réinitialiser après 5 secondes
            setTimeout(() => {
                affichage_resultat.value = false;
            }, 5000);
        },
    });
}


const closeModal = () => {
    confirmingformuleDeletion.value = false;
};


// Résultats de la recherche

// Fonction de recherche
let formuleRecherche = ref(props.formules);
let searchinput = ref("");

function function_rechercher() {
    const searchValue = searchinput.value.toLowerCase();
    formuleRecherche.value = props.formules.filter((formule) => {
        return formule.nom.toLowerCase().includes(searchValue);
    });
}
function valeur_total(tableau_produit) {
    let prix_total = 0;
    tableau_produit.forEach((produit) => {
        let changement_virgule = produit.prix.replace(",", ".");
        prix_total += parseFloat(changement_virgule);
    });
    return prix_total.toFixed(2).toString().replace(".", ",");
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

        <button
            class="mt-2"
            id="formule_recherche"
            @click="() => $inertia.get(route('cure_formule.create'))"
        >
            Ajouter formule
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
                v-for="formule in formuleRecherche"
                :key="formule.id"
                class="border-4 p-3 space-y-2 grid"
            >
                <p>Nom: {{ formule.nom }}</p>
                <ul>
                    Produits:
                </ul>
                <li
                    v-for="produit in formule.produits"
                    :key="produit.id"
                    class=""
                >
                    {{ produit.nom }} ({{ produit.prix }}€)
                </li>

                <p class="">
                    Valeur totale de la formule:
                    {{ valeur_total(formule.produits) }}€
                </p>
                <p :class="`${formule.disponible ? 'text-green-500' : 'text-red-600' }`">Disponible : {{ formule.disponible ? "Oui" : "Non" }}</p>
                <div class="flex  w-full justify-evenly items-center wrap">

                    <button
                        class="inline-flex items-center justify-center px-4 <py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-600 active:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-pink-600 focus:ring-offset-2 transition ease-in-out duration-150 self-center plusieurs"
                        @click="
                            () =>
                                $inertia.get(
                                    route('cure_formule.edit_produit', formule.id)
                                )
                        "
                    >
                        Produits
                    </button class="">

                    <!-- Ajout de produit  -->
                    <button
                        class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 self-center plusieurs"
                        @click="
                            () =>
                                $inertia.get(
                                    route('cure_formule.edit', formule.id)
                                )
                        "
                    >
                        Modifier
                    </button class="">
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
