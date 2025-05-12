<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(["chambres"]);
const form = useForm(props);

const prix_change = ref([]);
const jours_change = ref([]);
const selectedDates = ref([]);

function jour_prix(chambre_id, date_id, dates) {
    const selected = dates.find((date) => date.id === date_id);
    if (selected) {
        prix_change.value[chambre_id] = selected.prix;
        jours_change.value[chambre_id] = selected.jours;
    }
}
</script>
<template>
    <GuestLayout title="Chambres">
        <h1 class="h1_titre">Les chambres</h1>
        <article id="chambres" v-if="props.chambres.length > 0">
            <section
                v-for="chambre in props.chambres"
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
                        {{ chambre.nbr_personnes }} personne(s) -
                        {{ chambre.nbr_lit }} lit(s) -
                        {{ chambre.nbr_sdb }} salle(s) de bains
                    </p>

                    <p>
                        <span class="gras_span">Disponibilité : </span>

                        <select
                            class="couleur_option"
                            v-model="selectedDates[chambre.id]"
                            @change="
                                jour_prix(
                                    chambre.id,
                                    selectedDates[chambre.id],
                                    chambre.dates
                                )
                            "
                        >
                            <option
                                v-for="date in chambre.dates"
                                :key="date.id"
                                :value="date.id"
                            >
                                {{ date.date_debut }} / {{ date.date_fin }}
                            </option>
                        </select>
                    </p>

                    <p>
                        {{ chambre.description }}
                    </p>
                    <p v-show="prix_change[chambre.id]" id="jours_prix">
                        <strong>
                            {{ prix_change[chambre.id] }}€
                            {{ jours_change[chambre.id] }} jours
                        </strong>
                    </p>
                </div>
            </section>
            <p class="text-center">
                Séduit ? Passez à l’étape suivante en remplissant le

                <a :href="route('contact')" class="font-bold">formulaire</a>.
            </p>
        </article>
        <p v-else class="rien">Pas de formule pour le moment</p>
    </GuestLayout>
</template>
<style scoped></style>
