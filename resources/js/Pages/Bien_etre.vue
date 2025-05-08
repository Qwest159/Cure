<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(["formules"]);
const form = useForm(props);

function valeur_total(tableau_produit) {
    let prix_total = 0;
    tableau_produit.forEach((produit) => {
        let changement_virgule = produit.prix.replace(",", ".");
        prix_total += parseFloat(changement_virgule);
    });
    return prix_total.toFixed(2).toString().replace(".", ",");
}
</script>
<template>
    <GuestLayout title="Les formules bien-être"
        ><h1 class="h1_titre">Les formules bien-être</h1>
        <article id="bien_être">
            <section
                v-for="formule in form.formules"
                :key="formule.id"
                class=""
            >
                <figure>
                    <img
                        :src="`storage/${formule.img_path}`"
                        :alt="formule.nom"
                    />
                </figure>
                <h2>{{ formule.nom }}</h2>

                <ul>
                    Produits:
                </ul>
                <li
                    v-for="produit in formule.produits"
                    :key="produit.id"
                    class=""
                >
                    {{ produit.nom }}
                </li>
                <p>{{ formule.description }}</p>
                <p class="">
                    Valeur totale de la formule:
                    {{ valeur_total(formule.produits) }}€
                </p>
            </section>
        </article>
        <p class="important">
            <a
                href="http://310002138977.fbo.foreverliving.com/bel/fr-be/home"
                target="_blank"
                rel="noopener noreferrer"
            >
                Pour d'autres produits, n'hésitez pas à jeter un œil sur mon
                site de vente.</a
            >
        </p>
    </GuestLayout>
</template>
<style scoped></style>
