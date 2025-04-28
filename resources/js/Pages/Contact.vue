<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { defineProps, ref, onMounted } from "@vue/runtime-core";

// agrandir le text area auto
const textarea = ref(null);

const props = defineProps(["flash", "date_heure"]);

function adjustHeight() {
    textarea.value.style.height = "auto";
    textarea.value.style.height = textarea.value.scrollHeight + "px";
}
onMounted(adjustHeight);

// définir les données

let form = useForm({
    Nom: "",
    Prénom: "",
    Email: "",
    Téléphone: "",
    nombres: "",
    Commentaire: "",
});

function succes() {
    bouton_envoyer.value = false;
    form.post(route("mail.email"), {
        // Condition avant de passer à onSuccess
        onSuccess: () => {
            // Vérification des données et des erreurs
            form = useForm({
                Nom: "",
                Prénom: "",
                Email: "",
                Téléphone: "",

                nombres: "",
                Nettoyage: "",
                Habitat: "",
                Fréquence: "",
                Installation: "",
                Nombre: "",
                images: "",
                Date: "",
                Heure: "",
                Commentaire: "",
            });
            heuresDisponibles_totale.value = "";

            affichage_resultat.value = true; // Afficher le message "Veuillez patienter"
            bouton_envoyer.value = true; // Afficher le bouton d'envoi

            // Réinitialiser après 5 secondes
            setTimeout(() => {
                affichage_resultat.value = false;
            }, 5000);

            bouton_envoyer.value = true;
        },

        onError: () => {
            erreurs.value = {
                error: usePage().props.errors,
            };
            bouton_envoyer.value = true;
        },
    });
}
</script>
<template>
    <GuestLayout title="Contact">
        <h1 id="h1" class="text-center">Contact</h1>
        <div v-if="affichage_resultat">
            <p class="w-full p-2 bg-green-500 text-white text-center">
                Message envoyée
            </p>
        </div>
        <article
            id="img_form"
            class="w-5/6 m-auto border-4 border-solid border-black"
        >
            <section id="image_contact" class="">
                <figure class="h-full">
                    <img
                        class="h-full"
                        src="/storage/contact/image_contact.jpg"
                        alt="image de présentation"
                    />
                </figure>
            </section>
            <section id="formulaire" class="">
                <form
                    @submit.prevent="succes()"
                    enctype="multipart/form-data"
                    class="space-y-6 w-4/6 m-auto"
                >
                    <h2 class="mt-3">Informations personnelles</h2>

                    <div class="">
                        <!-- Nom -->
                        <label
                            for="Nom"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Nom
                        </label>
                        <input
                            type="text"
                            id="Nom"
                            v-model="form.Nom"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div
                            v-if="form.errors.Nom"
                            class="text-sm text-red-500 mt-1"
                        >
                            {{ form.errors.Nom }}
                        </div>
                    </div>
                    <!-- Prénom -->
                    <div class="">
                        <label
                            for="Prénom"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Prénom
                        </label>
                        <input
                            type="text"
                            id="Prénom"
                            v-model="form.Prénom"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div
                            v-if="form.errors.Prénom"
                            class="text-sm text-red-500 mt-1"
                        >
                            {{ form.errors.Prénom }}
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="">
                        <label
                            for="Email"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Email
                        </label>
                        <input
                            type="Email"
                            id="Email"
                            v-model="form.Email"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div
                            v-if="form.errors.Email"
                            class="text-sm text-red-500 mt-1"
                        >
                            {{ form.errors.Email }}
                        </div>
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label
                            for="Téléphone"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Téléphone
                        </label>
                        <input
                            type="tel"
                            id="Téléphone"
                            v-model="form.Téléphone"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div
                            v-if="form.errors.Téléphone"
                            class="text-sm text-red-500 mt-1"
                        >
                            {{ form.errors.Téléphone }}
                        </div>
                    </div>

                    <!-- nombres -->
                    <div class="">
                        <label
                            for="nombres"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Nombres Adultes
                        </label>
                        <input
                            type="text"
                            id="nombres"
                            v-model="form.nombres"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div
                            v-if="form.errors.nombres"
                            class="text-sm text-red-500 mt-1"
                        >
                            {{ form.errors.nombres }} adultes
                        </div>
                    </div>

                    <h2 class="mt-3">Détails de la maison / immeuble</h2>

                    <!-- Commentaire -->
                    <div>
                        <label
                            for="commentaire"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Commentaire
                        </label>
                        <textarea
                            ref="textarea"
                            @input="adjustHeight"
                            name="message"
                            id="message"
                            v-model="form.Commentaire"
                            class="border border-gray-300 w-full overflow-hidden"
                        ></textarea>
                        <div
                            v-if="form.errors.Commentaire"
                            class="text-sm text-red-500 mt-1"
                        >
                            {{ form.errors.Commentaire }}
                        </div>
                    </div>

                    <!-- Bouton -->
                    <div class="py-5 m-auto flex flex-col w-52">
                        <button
                            id="envoyer_button"
                            v-show="bouton_envoyer"
                            type="submit"
                            class="rounded-none font-bold"
                        >
                            Envoyer
                        </button>
                        <button
                            disabled
                            id="envoyer_p"
                            v-show="!bouton_envoyer"
                            class="rounded-none font-bold text-center z-10"
                        >
                            Veuillez patienter
                        </button>
                    </div>
                </form>
            </section>
        </article>
        <section class="my-10">
            <p id="informations" class="text-white text-center w-80 m-auto p-6">
                Pour toute information complémentaire, veuillez me contacter au
                <a id="tel" href="tel:+1234567890" class="hover:bg-red-700"
                    >234 567 890</a
                >
            </p>
        </section>
    </GuestLayout>
</template>
<style scoped></style>
