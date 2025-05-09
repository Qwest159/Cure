<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(["chambres"]);
const form = useForm(props);
</script>
<template>
    <GuestLayout title="Chambres">
        <h1 class="h1_titre">Les chambres</h1>
        <article id="chambres">
            <section
                v-for="chambre in form.chambres"
                :key="chambre.id"
                class=""
            >
                <figure id="partie_gauche">
                    <img
                        :src="`storage/${chambre.img_path}`"
                        :alt="chambre.nom"
                    />
                </figure>
                <div id="partie_droite">
                    <h2>{{ chambre.nom }}</h2>

                    <p>
                        {{ chambre.nbr_personnes }} personnes -
                        {{ chambre.nbr_lit }} lit(s) -
                        {{ chambre.nbr_sdb }} salle de bain
                    </p>

                    <p>
                        <span class="gras_span">Disponibilité : </span>
                        Du {{ chambre.date_debut }} Au {{ chambre.date_fin }}
                    </p>

                    <p>
                        {{ chambre.description }}
                    </p>
                    <p id="jours_prix">
                        <strong
                            >{{ chambre.prix }}€ {{ chambre.jours }} jours
                        </strong>
                    </p>
                </div>
            </section>
        </article>
        <p class="important">
            <a :href="route('contact')">
                Séduit ? Passez à l’étape suivante en remplissant le
                <span class="gras_span">formulaire</span>.</a
            >
        </p>
    </GuestLayout>
</template>
<style scoped></style>
