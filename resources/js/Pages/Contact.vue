<script setup>
import Devis_fictif from "@/Components/Devis_fictif.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { defineProps, ref, onMounted } from "@vue/runtime-core";

// agrandir le text area auto
const textarea = ref(null);

const props = defineProps(["flash", "chambre_dispo"]);

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
    Nombres: "",
    Cure: "",
    Chambre: "",
    Formule: "",
    Commentaire: "",
});
// ref
let devis = ref(false);
let bouton_envoyer = ref(true);
let affichage_resultat = ref(false);

function succes() {
    bouton_envoyer.value = false;

    form.post(route("mail.email"), {
        // Condition avant de passer à onSuccess
        onSuccess: () => {
            // Vérification des données et des erreurs
            console.log("réussi");

            form = useForm({
                Nom: "",
                Prénom: "",
                Email: "",
                Téléphone: "",
                Nombres: "",
                Chambre: "",
                Commentaire: "",
            });
            // heuresDisponibles_totale.value = "";

            affichage_resultat.value = true; // Afficher le message "Veuillez patienter"
            bouton_envoyer.value = true; // Afficher le bouton d'envoi

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
    <GuestLayout title="Contact">
        <Devis_fictif v-if="devis" :chambre_detail="props.chambre_dispo" />
        <h1 class="h1_titre">Contact</h1>
        <p id="devis" @click="devis = !devis">Faire une estimation rapide</p>

        <p
            v-if="affichage_resultat"
            class="w-full p-2 bg-green-500 text-white text-center"
        >
            Message envoyée
        </p>

        <article id="contact">
            <form @submit.prevent="succes()" enctype="multipart/form-data">
                <!-- Nom -->
                <section id="nom">
                    <label for="Nom">Nom <span>*</span></label>
                    <input
                        type="text"
                        id="Nom"
                        v-model="form.Nom"
                        placeholder="Votre nom"
                    />
                    <p v-show="form.errors.Nom">{{ form.errors.Nom }}</p>
                </section>

                <!-- Prénom -->
                <section id="prenom">
                    <label for="Prenom">Prénom <span>*</span></label>
                    <input
                        type="text"
                        id="Prenom"
                        v-model="form.Prénom"
                        placeholder="Votre prénom"
                    />
                    <p v-show="form.errors.Prénom">
                        {{ form.errors.Prénom }}
                    </p>
                </section>

                <!-- Email -->
                <section id="email">
                    <label for="Email">Email <span>*</span></label>
                    <input
                        type="email"
                        id="Email"
                        v-model="form.Email"
                        placeholder="Votre email"
                    />
                    <p v-show="form.errors.Email">
                        {{ form.errors.Email }}
                    </p>
                </section>

                <!-- Téléphone -->
                <section id="tel">
                    <label for="Téléphone">Téléphone <span>*</span></label>
                    <input
                        type="tel"
                        id="Téléphone"
                        v-model="form.Téléphone"
                        placeholder="Votre téléphone"
                    />
                    <p v-show="form.errors.Téléphone">
                        {{ form.errors.Téléphone }}
                    </p>
                </section>

                <!-- Nombres -->
                <section id="nombres">
                    <label for="Nombres">Nombres Adultes <span>*</span></label>
                    <input
                        type="text"
                        id="Nombres"
                        v-model="form.Nombres"
                        placeholder="Combien de personnes"
                    />
                    <p v-show="form.errors.Nombres">
                        {{ form.errors.Nombres }}
                    </p>
                </section>

                <!-- chambre -->
                <section id="chambre">
                    <label for="chambre"> Chambre <span>*</span></label>
                    <select v-model="form.Chambre" class="">
                        <option
                            v-for="chambre in chambre_dispo"
                            :key="chambre.id"
                            :value="`${chambre.nom} | ${chambre.date_debut} / ${chambre.date_fin}`"
                        >
                            {{ chambre.nom }} {{ chambre.date_debut }} /
                            {{ chambre.date_fin }}
                        </option>
                    </select>
                    <div
                        v-if="form.errors.Chambre"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.Chambre }}
                    </div>
                </section>

                <!-- Cure -->
                <section id="cure">
                    <label id="titre_cure">Cure Complète <span>*</span></label>

                    <div class="grouper">
                        <input
                            type="radio"
                            id="oui"
                            value="Oui"
                            v-model="form.Cure"
                            name="Cure"
                        />
                        <label for="oui">Oui</label>

                        <input
                            type="radio"
                            id="Non"
                            value="Non"
                            v-model="form.Cure"
                            name="Cure"
                        />
                        <label for="Non">Non</label>
                    </div>
                    <p v-show="form.errors.Cure" class="mt-5">
                        {{ form.errors.Cure }}
                    </p>
                </section>

                <section id="type_cure" v-if="form.Cure === 'Oui'">
                    <label class="titre_cure"
                        >Type de cure <span>*</span></label
                    >

                    <div class="grouper">
                        <input
                            type="radio"
                            id="Freedom"
                            value="Freedom"
                            v-model="form.Formule"
                            name="Formule"
                        />
                        <label for="Freedom">Freedom</label>

                        <input
                            type="radio"
                            id="Aloe Vera"
                            value="Aloe Vera"
                            v-model="form.Formule"
                            name="Formule"
                        />
                        <label for="Aloe Vera">Aloe Vera</label>
                    </div>
                    <p v-show="form.errors.Cure" class="mt-5">
                        {{ form.errors.Cure }}
                    </p>
                </section>

                <!-- Commentaire -->
                <section id="comment">
                    <label for="commentaire">Commentaire</label>
                    <textarea
                        ref="textarea"
                        @input="adjustHeight"
                        name="message"
                        id="message"
                        v-model="form.Commentaire"
                        placeholder="Votre commentaire"
                    ></textarea>
                    <p v-show="form.errors.Commentaire">
                        {{ form.errors.Commentaire }}
                    </p>
                </section>

                <!-- Bouton -->

                <button class="bouton" type="submit">Envoyer</button>
                <!-- <button class="bouton" v-show="bouton_envoyer" type="submit">
                    Envoyer
                </button> -->
                <!-- <button class="bouton" disabled v-show="!bouton_envoyer">
                    Veuillez patienter
                </button> -->
            </form>

            <p id="information">
                Pour toute information complémentaire, veuillez me contacter au
                <a href="tel:+1234567890" class="hover:bg-red-700"
                    >234 567 890</a
                >
                ou bien par émail :
                <a href="tfe@hotmail.be.">tfe@hotmail.be.</a>
            </p>
        </article>
    </GuestLayout>
</template>
<style scoped></style>
