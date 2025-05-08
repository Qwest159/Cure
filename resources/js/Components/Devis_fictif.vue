<script setup>
import { ref, defineProps, defineEmits } from "@vue/runtime-core";
import { useForm } from "@inertiajs/vue3";
const props = defineProps(["chambre_detail", "formules"]);

const emit = defineEmits(["ref_devis_disparait"]);
let valeur_total = ref(0);
let nbr_personne = ref("");
let tableaux_donnée = {
    Chambre: "",
    Formule: "",
    Formule2: "",
};
function valeur_total_produits(tableau_produit) {
    let prix_total = 0;
    tableau_produit.forEach((produit) => {
        let changement_virgule = produit.prix.replace(",", ".");
        prix_total += parseFloat(changement_virgule);
    });
    return prix_total.toFixed(2).toString().replace(".", ",");
}

function valeur_rajout(tableaux_donnée) {
    valeur_total.value = 0;
    nbr_personne.value === "1"
        ? (tableaux_donnée.Formule2 = "0")
        : tableaux_donnée.Formule2;
    Object.keys(tableaux_donnée).forEach((key) => {
        let donnée = tableaux_donnée[key].toString().replace(",", ".");

        valeur_total.value += Number(donnée);
    });

    // nombre de personne si 1 alors prix pour deux personne sinon chambre pour deux personnes
    // selection formule prix + choisir si deux personne, deux input, si une personne, une input
}
function montrer_disparait() {
    const devis_block = document.querySelector(".element");
    devis_block.classList.remove("apparait");
    devis_block.classList.add("disparait");
}
</script>
<template>
    <section id="devis_fictif">
        <div>
            <p
                id="croix"
                @click="montrer_disparait(), emit('ref_devis_disparait', false)"
            >
                ❌
            </p>
            <h1>Devis</h1>

            <label for="chambre">Chambre</label>
            <select
                v-model="tableaux_donnée.Chambre"
                @change="valeur_rajout(tableaux_donnée)"
            >
                <option
                    v-for="chambre in chambre_detail"
                    :key="chambre.id"
                    :value="chambre.prix"
                >
                    {{ chambre.nom }} {{ chambre.date_debut }} /
                    {{ chambre.date_fin }}
                </option>
            </select>

            <label for="valeur-select">Nombre de personnes :</label>
            <select
                v-model="nbr_personne"
                id="valeur-select"
                name="valeur-select"
                @change="valeur_rajout(tableaux_donnée)"
            >
                <option value="1">1</option>
                <option value="2">2</option>
            </select>

            <label class="titre_cure">Type de cure</label>

            <select
                v-model="tableaux_donnée.Formule"
                v-show="nbr_personne >= '1'"
                @change="valeur_rajout(tableaux_donnée)"
            >
                <option
                    v-for="formule in formules"
                    :key="formule.id"
                    :value="valeur_total_produits(formule.produits)"
                >
                    {{ formule.nom }}
                    ({{ valeur_total_produits(formule.produits) }}€)
                </option>
            </select>
            <select
                v-model="tableaux_donnée.Formule2"
                v-show="nbr_personne >= '2'"
                @change="valeur_rajout(tableaux_donnée)"
            >
                <option
                    v-for="formule in formules"
                    :key="formule.id"
                    :value="valeur_total_produits(formule.produits)"
                >
                    {{ formule.nom }}
                    ({{ valeur_total_produits(formule.produits) }}€)
                </option>
            </select>

            <p class="">
                Valeur totale du séjour:
                {{ valeur_total.toFixed(2).toString().replace(".", ",") }}€
            </p>
        </div>
    </section>
</template>
<script scope></script>
