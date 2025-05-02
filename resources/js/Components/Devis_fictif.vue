<script setup>
import { defineEmits, ref, defineProps } from "@vue/runtime-core";

const props = defineProps(["chambre_detail"]);
let valeur_total = ref(0);
function valeur(prix) {
    return valeur_total + prix;
}
</script>
<template>
    <section id="devis_fictif">
        <h1>Devis</h1>

        <label for="chambre"> Chambre <span>*</span></label>
        <select class="">
            <option
                v-for="chambre in chambre_detail"
                :key="chambre.id"
                :value="`${chambre.nom} | ${chambre.date_debut} / ${chambre.date_fin}`"
            >
                {{ chambre.nom }} {{ chambre.date_debut }} /
                {{ chambre.date_fin }}
            </option>
        </select>
    </section>
    <p>{{ valeur_total }}</p>
</template>
<script scope></script>
