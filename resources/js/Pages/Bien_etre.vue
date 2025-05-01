<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(["produits"]);
const form = useForm(props);
</script>
<template>
    <GuestLayout title="Les produits bien-être"
        ><h1 class="h1_titre">Les produits bien-être</h1>
        <article id="bien_être">
            <section
                v-for="produit in form.produits"
                :key="produit.id"
                class=""
            >
                <figure>
                    <img
                        :src="`storage/${produit.img_path}`"
                        :alt="produit.nom"
                    />
                </figure>
                <h2>{{ produit.nom }}</h2>
                <div>
                    <p>{{ produit.litre }}ml</p>
                    <p>{{ produit.prix }}€</p>
                </div>

                <p>{{ produit.description }}</p>
            </section>
        </article>
        <p class="important">
            <a href="http://" target="_blank" rel="noopener noreferrer">
                Pour d'autres articles, n'hésitez pas à jeter un œil sur mon
                site de vente.</a
            >
        </p>
    </GuestLayout>
</template>
<style scoped></style>
