<script setup>
import Devis_fictif from "@/Components/Devis_fictif.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { defineProps, ref, onMounted } from "@vue/runtime-core";

// agrandir le text area auto
const textarea = ref(null);

const props = defineProps(["chambre_dispo", "formules", "dates"]);

function adjustHeight() {
    textarea.value.style.height = "auto";
    textarea.value.style.height = textarea.value.scrollHeight + "px";
}

onMounted(adjustHeight);

// définir les données

let form = useForm({
    nom: "",
    prénom: "",
    email: "",
    téléphone: "",
    nombres: "",
    cure: "",
    chambre: "",
    date: "",
    formule1: "",
    formule2: "",
    commentaire: "",
});
// ref
let devis = ref(false);
let bouton_envoyer = ref(true);
let affichage_resultat = ref(false);

function valeur_total(tableau_produit) {
    let prix_total = 0;
    tableau_produit.forEach((produit) => {
        let changement_virgule = produit.prix.replace(",", ".");
        prix_total += parseFloat(changement_virgule);
    });
    return prix_total.toFixed(2).toString().replace(".", ",");
}

let dateRecherche = ref([]);

// Fonction de recherche
function function_rechercher() {
    form.chambre = "";
    const [date_debut, date_fin] = form.date.toLowerCase().split(" / ");
    dateRecherche.value = props.chambre_dispo.filter((chambre) => {
        return chambre.dates.some((date) => {
            return (
                date.date_debut.toLowerCase().includes(date_debut) &&
                date.date_fin.toLowerCase().includes(date_fin)
            );
        });
    });
}

function succes() {
    bouton_envoyer.value = false;

    form.post(route("mail.email"), {
        onSuccess: () => {
            // Réinitialise le formulaire
            form = useForm({
                nom: "",
                prénom: "",
                email: "",
                téléphone: "",
                nombres: "",
                cure: "",
                chambre: "",
                date: "",
                formule1: "",
                formule2: "",
                commentaire: "",
            });

            affichage_resultat.value = true;

            // Réinitialise après 5 secondes
            setTimeout(() => {
                affichage_resultat.value = false;
            }, 5000);

            bouton_envoyer.value = true;
        },

        onError: () => {
            bouton_envoyer.value = true;
        },
    });
}

function montrer_disparait() {
    const devis_block = document.querySelector(".element");
    if (!devis.value) {
        devis_block.classList.remove("disparait");
        devis_block.classList.add("apparait");
    } else {
        devis_block.classList.remove("apparait");
        devis_block.classList.add("disparait");
    }
    devis.value = !devis.value;
}
</script>
<template>
    <GuestLayout title="Contact">
        <Devis_fictif
            class="element"
            :chambre_detail="props.chambre_dispo"
            :formules="props.formules"
            @ref_devis_disparait="devis = $event"
        />
        <h1 class="h1_titre">Contact</h1>

        <p id="devis" @click="montrer_disparait()">
            Faites une estimation rapide en cliquant ici.
        </p>

        <button
            v-if="affichage_resultat"
            class="w-full p-2 bg-green-500 text-white text-center"
        >
            Message envoyée
        </button>

        <article id="contact">
            <form @submit.prevent="succes()" enctype="multipart/form-data">
                <!-- Nom -->
                <section id="nom">
                    <label for="Nom">Nom <span>*</span></label>
                    <input
                        type="text"
                        id="Nom"
                        v-model="form.nom"
                        placeholder="Votre nom"
                    />
                    <p v-show="form.errors.nom">{{ form.errors.nom }}</p>
                </section>

                <!-- Prénom -->
                <section id="prenom">
                    <label for="Prenom">Prénom <span>*</span></label>
                    <input
                        type="text"
                        id="Prenom"
                        v-model="form.prénom"
                        placeholder="Votre prénom"
                    />
                    <p v-show="form.errors.prénom">
                        {{ form.errors.prénom }}
                    </p>
                </section>

                <!-- Email -->
                <section id="email">
                    <label for="Email">Email <span>*</span></label>
                    <input
                        type="email"
                        id="Email"
                        v-model="form.email"
                        placeholder="Votre email"
                    />
                    <p v-show="form.errors.email">
                        {{ form.errors.email }}
                    </p>
                </section>

                <!-- Téléphone -->
                <section id="tel">
                    <label for="Téléphone">Téléphone <span>*</span></label>
                    <input
                        type="tel"
                        id="Téléphone"
                        v-model="form.téléphone"
                        placeholder="Votre téléphone"
                    />
                    <p v-show="form.errors.téléphone">
                        {{ form.errors.téléphone }}
                    </p>
                </section>

                <!-- Nombres -->

                <section id="nombres">
                    <label for="Nombres">Nombre d'adultes <span>*</span></label>
                    <select v-model="form.nombres">
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                    <p v-show="form.errors.nombres">
                        {{ form.errors.nombres }}
                    </p>
                </section>

                <!-- date -->
                <section id="date">
                    <label for="date"> Date <span>*</span></label>
                    <select
                        class="couleur_option"
                        v-model="form.date"
                        @change="function_rechercher"
                    >
                        <option
                            v-for="date in props.dates"
                            :key="date.id"
                            :value="`${date.date_debut} / ${date.date_fin}`"
                        >
                            {{ date.date_debut }} / {{ date.date_fin }}
                        </option>
                    </select>
                    <p
                        v-if="form.errors.date"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.date }}
                    </p>
                </section>

                <!-- chambre -->
                <section id="chambre">
                    <label for="chambre"> Chambre <span>*</span></label>
                    <select
                        v-model="form.chambre"
                        class=""
                        v-if="dateRecherche.length > 0"
                    >
                        <option
                            v-for="chambre in dateRecherche"
                            :key="chambre.id"
                            :value="chambre.nom"
                        >
                            {{ chambre.nom }}
                        </option>
                    </select>
                    <p v-else>Date inexsistante</p>
                    <p
                        v-if="form.errors.chambre"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.chambre }}
                    </p>
                </section>
                <!-- Cure -->
                <section id="cure">
                    <label id="titre_cure">Cure Complète <span>*</span></label>

                    <div class="grouper">
                        <input
                            type="radio"
                            id="Oui"
                            value="Oui"
                            v-model="form.cure"
                            name="cure"
                        />
                        <label for="Oui">Oui</label>

                        <input
                            type="radio"
                            id="Non"
                            value="Non"
                            v-model="form.cure"
                            name="cure"
                        />
                        <label for="Non">Non</label>
                    </div>
                    <p v-show="form.errors.cure" class="mt-5">
                        {{ form.errors.cure }}
                    </p>
                </section>

                <!-- chambre -->
                <section id="type_cure" v-show="form.cure === 'Oui'">
                    <label class="titre_cure"
                        >Type de cure <span>*</span>
                        <p v-if="form.nombres === '2'">Une par personne</p>
                    </label>

                    <select v-model="form.formule1" class="">
                        <option
                            v-for="formule in formules"
                            :key="formule.id"
                            :value="formule.nom"
                        >
                            {{ formule.nom }}
                            ({{ valeur_total(formule.produits) }}€)
                        </option>
                    </select>
                    <div
                        v-if="form.errors.formule1"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.formule1 }}
                    </div>

                    <select
                        v-show="form.nombres === '2'"
                        v-model="form.formule2"
                        class="mt-2"
                    >
                        <option
                            v-for="formule in formules"
                            :key="formule.id"
                            :value="formule.nom"
                        >
                            {{ formule.nom }}
                            ({{ valeur_total(formule.produits) }}€)
                        </option>
                        <option class="text-red-600" value="Non Merci">
                            Non merci
                        </option>
                    </select>
                    <div
                        v-if="form.errors.formule2"
                        class="text-sm text-red-500 mt-1"
                    >
                        {{ form.errors.formule2 }}
                    </div>
                </section>

                <!-- Commentaire -->
                <section id="comment">
                    <label for="commentaire">Commentaire</label>
                    <textarea
                        ref="textarea"
                        @input="adjustHeight"
                        name="message"
                        id="message"
                        v-model="form.commentaire"
                        placeholder="Votre commentaire"
                    ></textarea>
                    <p v-show="form.errors.commentaire">
                        {{ form.errors.commentaire }}
                    </p>
                </section>

                <!-- Bouton -->

                <button class="bouton" v-show="bouton_envoyer" type="submit">
                    Envoyer
                </button>
                <button class="bouton" disabled v-show="!bouton_envoyer">
                    Veuillez patienter
                </button>
            </form>

            <p id="information">
                Pour toute information complémentaire, veuillez me contacter au
                <a href="tel:+1234567890" class=""
                    ><strong>234 567 890</strong></a
                >
                ou bien par émail :
                <a href="tfe@hotmail.be."><strong>tfe@hotmail.be</strong></a
                >.
            </p>
        </article>
    </GuestLayout>
</template>
<style scoped></style>
