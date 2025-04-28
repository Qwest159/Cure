<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
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
                Retrouver votre équilibre et coachez-vous
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
                C9 Forever ! Pendant neuf jours, transformez votre vie grâce à
                un programme complet : alimentation saine, sport quotidien et
                ressourcement au cœur de la campagne.
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
                            src="storage/accueil/location.jpg"
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
                            src="storage/accueil/paysage_accueil.jpg"
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
                        <img src="storage/accueil/fitness.jpg" alt="fitness" />
                        <p>Fitness</p>
                    </div>
                    <figcaption>
                        Profitez d'une expérience sportive et de bien-être, où
                        sérénité et vitalité se rencontrent en parfaite harmonie
                        pour un équilibre total.
                    </figcaption>
                </figure>
            </section>
            <button @click="() => $inertia.get(route('contact'))">
                Voir plus
            </button>
        </article>
        <article id="produits">
            <h1>Produits phares</h1>
            <section>
                <figure>
                    <img
                        src="storage/produits/alofa.jpg"
                        alt="forever Alofa Fine"
                    />
                </figure>
                <figure>
                    <img
                        src="storage/produits/malosi.jpg"
                        alt="Forever Malosi Fine"
                    />
                </figure>
                <figure>
                    <img
                        src="storage/produits/olofi.jpg"
                        alt="Forever Olofi Fine"
                    />
                </figure>
            </section>
            <button @click="() => $inertia.get(route('contact'))">
                Autres<span class="block">produits</span>
            </button>
        </article>
        <article id="localisation">
            <h1>Localisation</h1>
            <section>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d81694.43245120201!2d5.339842000000001!3d50.21813585!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c026825ad1d17b%3A0xfbf7763207a668ea!2s6900%20Marche-en-Famenne!5e0!3m2!1sfr!2sbe!4v1745522564920!5m2!1sfr!2sbe"
                    style="border: 0"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </section>
        </article>
    </GuestLayout>
</template>
<style></style>
