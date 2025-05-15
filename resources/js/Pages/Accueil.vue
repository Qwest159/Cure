<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { defineProps } from "@vue/runtime-core";

// agrandir le text area auto

const props = defineProps(["formules"]);
</script>

<template>
    <GuestLayout title="Accueil">
        <article id="description_accueil">
            <h1 id="h1_description">
                <span class="block">Envie de renouveau</span>
                <span class="block">et</span>
                <span class="block">de bien-être durable ?</span>
            </h1>
            <h2 id="h2_description">
                Retrouvez votre équilibre et coachez-vous
            </h2>
            <button
                id="contactez"
                @click="() => $inertia.get(route('contact'))"
            >
                Contactez-moi
            </button>
        </article>
        <article id="proposons">
            <h1>Ce que nous vous proposons</h1>
            <p>
                Rejoignez-nous pour une retraite en pleine nature avec la cure
                C9 Forever ! Durant plusieurs jours, transformez votre vie grâce
                à un programme complet : alimentation saine, sport quotidien et
                ressourcement au cœur de la campagne.
            </p>
            <p class="pt-5">
                Le but est simple : choisir une
                <a
                    class="cursor-pointer font-bold"
                    @click="() => $inertia.get(route('bien_etre'))"
                    >formule bien-être</a
                >,
                <a
                    class="cursor-pointer font-bold"
                    @click="() => $inertia.get(route('chambre'))"
                    >une chambre</a
                >, et je m'occupe du reste !
            </p>
        </article>
        <article id="univers">
            <h1>
                Un Univers de Détente <span class="block">et de Plaisirs</span>
            </h1>

            <section>
                <figure>
                    <div>
                        <img
                            src="storage/accueil/location.webp"
                            alt="Location"
                        />
                        <p>Location</p>
                    </div>
                    <figcaption>
                        Cette maison est bien plus qu'un simple lieu de
                        résidence : c'est un sanctuaire où l'on peut se
                        reconnecter à soi-même et à la nature, chaque recoin
                        étant pensé pour le confort et la relaxation.
                    </figcaption>
                </figure>
                <figure>
                    <div>
                        <img
                            src="storage/accueil/paysage_accueil.webp"
                            alt="paysage nature"
                        />
                        <p>Paysage</p>
                    </div>

                    <figcaption>
                        Profitez de cette vue magnifique, avec des montagnes
                        douces et un ciel dégagé, qui offre une parfaite
                        harmonie entre l’homme et la nature, renforçant leur
                        lien profond.
                    </figcaption>
                </figure>
                <figure>
                    <div>
                        <img src="storage/accueil/fitness.webp" alt="fitness" />
                        <p>Fitness</p>
                    </div>
                    <figcaption>
                        Profitez d'une expérience sportive et de bien-être, où
                        sérénité et vitalité se rencontrent en parfaite harmonie
                        pour un équilibre total.
                    </figcaption>
                </figure>
            </section>
            <button @click="() => $inertia.get(route('chambre'))">
                Voir plus
            </button>
        </article>
        <article id="formules" v-if="props.formules.length > 0">
            <h1>Les incontournables Bien-Être</h1>
            <section>
                <figure
                    v-for="formule in props.formules"
                    :key="formule.id"
                    :value="formule.nom"
                >
                    <img
                        :src="`storage/${formule.img_path}`"
                        :alt="formule.description"
                    />
                    <figcaption>{{ formule.nom }}</figcaption>
                </figure>
            </section>
            <button @click="() => $inertia.get(route('bien_etre'))">
                Autres<span class="block">formules</span>
            </button>
        </article>
        <article id="localisation">
            <h1>Localisation</h1>
            <p>Rue du Molignat 6, 5377 Somme-Leuze</p>
            <section>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2548.023910413767!2d5.361518776251386!3d50.31014587156579!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c04c80fe1e21a7%3A0x281b2499ad73424e!2sRue%20du%20Molignat%206%2C%205377%20Somme-Leuze!5e0!3m2!1sfr!2sbe!4v1747243790292!5m2!1sfr!2sbe"
                    style="border: 0"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </section>
            <p>
                <i class="fa-solid fa-car"></i> Le transport de la gare à mon
                domicile est offert.
            </p>
        </article>
    </GuestLayout>
</template>
<style></style>
