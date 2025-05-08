<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, defineProps } from "@vue/runtime-core";

import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps(["formule"]);

let form = useForm({
    nom: props.formule.nom,
    img_path: props.formule.img,
    description: props.formule.description,
    disponible: props.formule.disponible,
});
let bouton_envoyer = ref(true);
let affichage_resultat = ref(false);
let ancienne_image = props.formule.img_path;

function succes() {
    bouton_envoyer.value = false;
    form.post(route("cure_formule.update", props.formule.id), {
        // Condition avant de passer à onSuccess
        onSuccess: () => {
            // Vérification des données et des erreurs
            ancienne_image = props.formule.img_path;
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
    <AppLayout title="formule">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modification de la formule
                <span class="text-orange-400">{{ formule.nom }}</span>
            </h2>
        </template>

        <!-- Création d'une formule -->
        <article class="max-w-5xl m-auto p-9">
            <button
                class="my-4"
                @click="() => $inertia.get(route('cure_formule'))"
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

                <div class="">
                    <div>
                        <div class="">
                            <div>
                                <label
                                    for="img_path"
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
                    </div>
                    <figure class="">
                        <h3 class="font-bold text-xl">Image actuel</h3>
                        <img
                            class="w-36"
                            :src="`/storage/${ancienne_image}`"
                            :alt="form.nom"
                        />
                    </figure>
                </div>

                <div>
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
