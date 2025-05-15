<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "@vue/runtime-core";

import AppLayout from "@/Layouts/AppLayout.vue";

let form = useForm({
    nom: "",
    img_path: "",
    nbr_personnes: "",
    nbr_lit: "",
    nbr_sdb: "",
    description: "",
});

let bouton_envoyer = ref(true);
let affichage_resultat = ref(false);
function succes() {
    bouton_envoyer.value = false;
    form.post(route("cure_chambre.store"), {
        // Condition avant de passer à onSuccess
        onSuccess: () => {
            // Vérification des données et des erreurs

            form = useForm({
                nom: "",
                nbr_personnes: "",
                img_path: "",
                nbr_lit: "",
                nbr_sdb: "",
                description: "",
            });

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

function handlefilechange(event) {
    form.img_path = event.target.files[0];
}
</script>

<template>
    <AppLayout title="chambre">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Création d'une chambre
            </h2>
        </template>

        <!-- Création d'une chambre -->
        <article class="max-w-5xl m-auto p-9">
            <button
                class="my-4"
                @click="() => $inertia.get(route('cure_chambre'))"
            >
                Retour en arrière
            </button>
            <h2 class="text-red-600 text-center m-auto pt-5">
                <span class=""
                    >N'oubliez pas de valider "Disponible" dans la modification
                    de la chambre pour la faire apparaitre.</span
                >
            </h2>
            <button
                v-if="affichage_resultat"
                class="w-full p-2 bg-green-500 text-white text-center"
            >
                Création réussie
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

                <div class="">
                    <div>
                        <label
                            for="img"
                            class="block text-sm font-medium text-gray-700"
                            >Image</label
                        >
                        <input
                            type="file"
                            id="img_path"
                            name="img_path"
                            @change="handlefilechange"
                        />
                        <div
                            v-if="form.errors.img_path"
                            class="text-sm text-red-500 mt-1"
                        >
                            {{ form.errors.img_path }}
                        </div>
                    </div>
                </div>

                <div>
                    <label
                        for="nbr_personnes"
                        class="block text-sm font-medium text-gray-700"
                        >Nombre de personnes</label
                    >
                    <input
                        type="text"
                        id="nbr_personnes"
                        v-model="form.nbr_personnes"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    <div
                        v-if="form.errors.nbr_personnes"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.nbr_personnes }}
                    </div>
                </div>

                <div>
                    <label
                        for="nbr_lit"
                        class="block text-sm font-medium text-gray-700"
                        >Nombre de lits</label
                    >
                    <input
                        type="text"
                        id="nbr_lit"
                        v-model="form.nbr_lit"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    <div
                        v-if="form.errors.nbr_lit"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.nbr_lit }}
                    </div>
                </div>

                <div>
                    <label
                        for="nbr_sdb"
                        class="block text-sm font-medium text-gray-700"
                        >Nombre de salles de bain</label
                    >
                    <input
                        type="text"
                        id="nbr_sdb"
                        v-model="form.nbr_sdb"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    <div
                        v-if="form.errors.nbr_sdb"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.nbr_sdb }}
                    </div>
                </div>

                <div>
                    <label
                        for="description"
                        class="block text-sm font-medium text-gray-700"
                        >Description</label
                    >
                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="3"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    ></textarea>
                    <div
                        v-if="form.errors.description"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.description }}
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
