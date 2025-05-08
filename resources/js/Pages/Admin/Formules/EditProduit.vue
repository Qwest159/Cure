<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, defineProps } from "@vue/runtime-core";
//MODAL
import DialogModal from "@/Components/DialogModal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ActionModal from "@/Components/ActionModal.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
// DELETE AVEC MODAL
const confirmingproduitDeletion = ref(false);

let selected_produit_id = 0;
let selected_produit_nom = "";
const confirmproduitDeletion = (id, nom) => {
    selected_produit_id = id;
    selected_produit_nom = nom;
    confirmingproduitDeletion.value = true;
};

function deleteproduit() {
    form.delete(
        route("cure_formule.destroy_produit", {
            id: props.formule.id,
            id_produit: selected_produit_id,
        }),
        {
            onSuccess: () => {
                closeModal();
            },
        }
    );
}

const closeModal = () => {
    confirmingproduitDeletion.value = false;
};

const props = defineProps(["formule", "produits"]);

// let form = useForm({
//     nom: props.formule.nom,
//     img_path: props.formule.img,
//     description: props.formule.description,
//     disponible: props.formule.disponible,
// });

let form = useForm({
    produit: "",
});
let bouton_envoyer = ref(true);
let affichage_resultat = ref(false);

function succes() {
    bouton_envoyer.value = false;
    form.post(route("cure_formule.update_produit", props.formule.id), {
        // Condition avant de passer à onSuccess
        onSuccess: () => {
            // Vérification des données et des erreurs
            affichage_resultat.value = true; // Afficher le message "Veuillez patienter"
            // Réinitialiser après 5 secondes
            setTimeout(() => {
                affichage_resultat.value = false;
            }, 5000);

            bouton_envoyer.value = true;
        },

        onError: () => {
            // erreurs.value = {
            //     error: usePage().props.errors,
            // };
            bouton_envoyer.value = true;
        },
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
console.log(props.formule);
</script>

<template>
    <AppLayout title="formule">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modification de la formule
                <span class="text-orange-400">{{ formule.nom }}</span>
            </h2>
        </template>

        <!-- Création d'une formule -->
        <article class="max-w-5xl m-auto p-9">
            <div class="flex justify-between gap-20">
                <button
                    class="my-4"
                    @click="() => $inertia.get(route('cure_formule'))"
                >
                    Retour en arrière
                </button>
                <button
                    class="inline-flex items-center justify-center my-4 bg-green-600 hover:bg-green-500 border border-transparent rounded-xl self-center"
                    @click="
                        () =>
                            $inertia.get(route('cure_formule.edit', formule.id))
                    "
                >
                    Voir la formule
                </button>
            </div>

            <button
                v-if="affichage_resultat"
                class="w-full p-2 bg-green-500 text-white text-center"
            >
                Modification réussie
            </button>
            <form
                @submit.prevent="succes()"
                enctype="multipart/form-data"
                class="space-y-6 p-5 flex flex-col border-2 rounded-xl"
            >
                <!-- <div>
                    <label>Disponible</label>

                    <div class="grouper">
                        <input
                            type="radio"
                            id="true"
                            :value="1"
                            v-model="form.disponible"
                            name="disponible"
                        />
                        <label for="true">Oui</label>

                        <input
                            type="radio"
                            id="false"
                            :value="0"
                            v-model="form.disponible"
                            name="disponible"
                        />
                        <label for="false">Non</label>
                    </div>
                    <p
                        v-show="form.errors.disponible"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.disponible }}
                    </p>
                </div> -->

                <label class="titre_cure">Rajout du produit</label>

                <select v-model="form.produit">
                    <option
                        v-for="produit in produits"
                        :key="produit.id"
                        :value="produit.id"
                    >
                        {{ produit.nom }}
                    </option>
                </select>

                <ul>
                    Produits:
                </ul>
                <li
                    v-for="produit in formule.produits"
                    :key="produit.id"
                    id="gsm_li"
                    class="flex text_button"
                >
                    <span
                        class="relative pl-4 pr-2 before:content-['•'] before:absolute before:left-0 before:text-black"
                        >{{ produit.nom }}
                    </span>
                    ({{ produit.prix }}€)
                    <ActionModal>
                        <template #content>
                            <div class="ml-5">
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
                </li>

                <p class="">
                    Valeur totale de la formule:
                    {{ valeur_total(formule.produits) }}€
                </p>

                <!-- Bouton -->
                <button
                    class="bouton m-auto"
                    v-show="bouton_envoyer"
                    type="submit"
                >
                    Envoyer
                </button>
                <button class="bouton m-auto" disabled v-show="!bouton_envoyer">
                    Veuillez patienter
                </button>
            </form>
        </article>
        <DialogModal :show="confirmingproduitDeletion" @close="closeModal">
            <template #title>
                Supprimer
                {{ selected_produit_nom }}</template
            >

            <template #content>
                La produit <strong>"{{ selected_produit_nom }}"</strong> va être
                supprimée de la formule
            </template>

            <template #footer>
                <SecondaryButton @click="closeModal"> Annuler </SecondaryButton>

                <DangerButton
                    class="ms-3 bg-red-600 hover:bg-red-600"
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
