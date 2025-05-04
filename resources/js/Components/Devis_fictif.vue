<script setup>
import { ref, defineProps } from "@vue/runtime-core";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(["chambre_detail", "formules"]);

let valeur_total = ref(0);

let tableaux_donnée = {
    Chambre: "",
    Formule: "",
    Formule2: "",
    nbr_personne: "",
};
function valeur_total_produits(tableau_produit) {
    let prix_total = 0;
    // ATTENTION CONVERT EN STRINF CHANGE la virgule en point test apres avec admin !!!!!!!!!!!!!!!!!
    tableau_produit.forEach((produit) => {
        prix_total += produit.prix;
    });
    return prix_total.toString().replace(".", ",");
}

function valeur_rajout(tableaux_donnée) {
    valeur_total.value = 0;
    Object.keys(tableaux_donnée).forEach((key) => {
        let donnée = tableaux_donnée[key].toString().replace(",", ".");
        console.log(typeof donnée);

        valeur_total.value += Number(donnée);
        console.log(valeur_total.value);
    });

    // nombre de personne si 1 alors prix pour deux personne sinon chambre pour deux personnes
    // selection formule prix + choisir si deux personne, deux input, si une personne, une input
}
</script>
<template>
    <section id="devis_fictif">
        <div>
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
                v-model="tableaux_donnée.nbr_personne"
                id="valeur-select"
                name="valeur-select"
            >
                <option value="1">1</option>
                <option value="2">2</option>
            </select>

            <label class="titre_cure">Type de cure</label>

            <select
                v-model="tableaux_donnée.Formule"
                class=""
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
                class=""
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
