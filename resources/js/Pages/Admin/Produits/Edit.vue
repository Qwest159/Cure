<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, defineProps } from "@vue/runtime-core";

import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps(["produit"]);

let form = useForm({
    nom: props.produit.nom,
    prix: props.produit.prix,
});
let bouton_envoyer = ref(true);
let affichage_resultat = ref(false);

function succes() {
    bouton_envoyer.value = false;
    form.post(route("cure_produit.update", props.produit.id), {
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
    <AppLayout title="produit">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modification du produit
                <span class="text-orange-400">{{ produit.nom }}</span>
            </h2>
        </template>

        <!-- Création d'une produit -->
        <article class="max-w-5xl m-auto p-9">
            <button
                class="my-4"
                @click="() => $inertia.get(route('cure_produit'))"
            >
                Retour en arrière
            </button>
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
                <div>
                    <label
                        for="nom"
                        class="block text-sm font-medium text-gray-700"
                        >Nom</label
                    >
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

                <div>
                    <label
                        for="prix"
                        class="block text-sm font-medium text-gray-700"
                        >Prix</label
                    >
                    <input
                        type="text"
                        id="prix"
                        v-model="form.prix"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    <div
                        v-if="form.errors.prix"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.prix }}
                    </div>
                </div>
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
    </AppLayout>
</template>

<style></style>
