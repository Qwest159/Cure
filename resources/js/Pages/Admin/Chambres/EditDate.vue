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
const confirmingdateDeletion = ref(false);

let selected_date_id = 0;
let selected_date_nom = "";
const confirmdateDeletion = (id, nom) => {
    selected_date_id = id;
    selected_date_nom = nom;
    confirmingdateDeletion.value = true;
};

function deletedate() {
    form.delete(
        route("cure_chambre.destroy_date", {
            chambre_id: props.chambre.id,
            date_id: selected_date_id,
        }),
        {
            onSuccess: () => {
                closeModal();
                affichage_resultat.value = true;
                setTimeout(() => {
                    affichage_resultat.value = false;
                }, 5000);
            },
        }
    );
}

const closeModal = () => {
    confirmingdateDeletion.value = false;
};

const props = defineProps(["chambre", "dates"]);

// let form = useForm({
//     nom: props.date.nom,
//     img_path: props.date.img,
//     description: props.date.description,
//     disponible: props.date.disponible,
// });

let form = useForm({
    date_id: "",
});
console.log(props.chambre);

let bouton_envoyer = ref(true);
let affichage_resultat = ref(false);

function succes() {
    bouton_envoyer.value = false;
    form.post(route("cure_chambre.update_date", props.chambre.id), {
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
</script>

<template>
    <AppLayout title="Date">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modification de la date
                <span class="text-orange-400">{{ chambre.nom }}</span>
            </h2>
        </template>

        <!-- Création d'une date-->
        <article class="max-w-5xl m-auto p-9">
            <div class="flex justify-between gap-20">
                <button
                    class="my-4"
                    @click="() => $inertia.get(route('cure_chambre'))"
                >
                    Retour en arrière
                </button>

                <button
                    class="inline-flex items-center justify-center my-4 bg-green-600 hover:bg-green-500 border border-transparent rounded-xl self-center"
                    @click="
                        () =>
                            $inertia.get(route('cure_chambre.edit', chambre.id))
                    "
                >
                    Voir la chambre
                </button>
            </div>

            <p
                v-if="affichage_resultat"
                class="w-full p-2 bg-green-500 text-white text-center"
            >
                Modification réussie
            </p>
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

                <label class="titre_cure">Rajout des dates</label>

                <select v-model="form.date_id">
                    <option
                        v-for="date in dates"
                        :key="date.id"
                        :value="date.id"
                    >
                        {{ date.date_debut }} / {{ date.date_fin }} ({{
                            date.prix
                        }}€)
                    </option>
                </select>

                <ul>
                    dates:
                </ul>
                <li
                    v-for="date in chambre.dates"
                    :key="date.id"
                    id="gsm_li"
                    class="flex text_button"
                >
                    <span
                        class="relative pl-4 pr-2 before:content-['•'] before:absolute before:left-0 before:text-black"
                    >
                        <span class="text-cyan-500">{{ date.date_debut }}</span>
                        /
                        <span class="text-orange-400">{{ date.date_fin }}</span>
                    </span>
                    ({{ date.prix }}€)
                    <ActionModal>
                        <template #content>
                            <div class="ml-5">
                                <DangerButton
                                    id="open-modal-button"
                                    @click="
                                        confirmdateDeletion(
                                            date.id,
                                            date.date_debut / date.date_fin
                                        )
                                    "
                                >
                                    Supprimer
                                </DangerButton>
                            </div>
                        </template>
                    </ActionModal>
                </li>

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
        <DialogModal :show="confirmingdateDeletion" @close="closeModal">
            <template #title>
                Supprimer
                {{ selected_date_nom }}</template
            >

            <template #content>
                La date <strong>"{{ selected_date_nom }}"</strong> va être
                supprimée de la date
            </template>

            <template #footer>
                <SecondaryButton @click="closeModal"> Annuler </SecondaryButton>

                <DangerButton
                    class="ms-3 bg-red-600 hover:bg-red-600"
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
