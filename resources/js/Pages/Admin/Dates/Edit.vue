<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, defineProps } from "@vue/runtime-core";

import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps(["date", "date_fin", "date_debut"]);

let form = useForm({
    date_debut: props.date_debut,
    date_fin: props.date_fin,
    prix: props.date.prix,
    jours: props.date.jours,
});
let bouton_envoyer = ref(true);
let affichage_resultat = ref(false);

function succes() {
    bouton_envoyer.value = false;
    form.post(route("cure_date.update", props.date.id), {
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
    <AppLayout title="date">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modification de la date
                <p>
                    <span class="text-cyan-500">{{ date.date_debut }}</span>
                    /
                    <span class="text-orange-400">{{ date.date_fin }}</span>
                </p>
            </h2>
        </template>

        <!-- Création d'une date -->
        <article class="max-w-5xl m-auto p-9">
            <button
                class="my-4"
                @click="() => $inertia.get(route('cure_date'))"
            >
                Retour en arrière
            </button>
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
                <div>
                    <label
                        for="date_debut"
                        class="block text-sm font-medium text-gray-700"
                        >Date de début</label
                    >
                    <input
                        type="date"
                        id="date_debut"
                        v-model="form.date_debut"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    <div
                        v-if="form.errors.date_debut"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.date_debut }}
                    </div>
                </div>

                <div>
                    <label
                        for="date_fin"
                        class="block text-sm font-medium text-gray-700"
                        >Date de fin</label
                    >
                    <input
                        type="date"
                        id="date_fin"
                        v-model="form.date_fin"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    <div
                        v-if="form.errors.date_fin"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.date_fin }}
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

                <div>
                    <label
                        for="jours"
                        class="block text-sm font-medium text-gray-700"
                        >Nombre de jour</label
                    >
                    <input
                        type="text"
                        id="jours"
                        v-model="form.jours"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    <div
                        v-if="form.errors.jours"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.jours }}
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
