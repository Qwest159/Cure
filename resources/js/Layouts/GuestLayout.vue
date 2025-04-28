<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";

import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <Head :title="title" />

        <nav class="fixed w-full z-50">
            <!-- Primary Navigation Menu -->
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex w-full">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <Link :href="route('accueil')">
                                <ApplicationMark />
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:ms-10 sm:flex">
                            <NavLink
                                :href="route('accueil')"
                                :active="route().current('accueil')"
                            >
                                Accueil
                            </NavLink>
                            <NavLink
                                :href="route('bien_etre')"
                                :active="route().current('bien_etre')"
                            >
                                Bien-être
                            </NavLink>
                            <NavLink
                                :href="route('chambre')"
                                :active="route().current('chambre')"
                            >
                                Chambres
                            </NavLink>
                            <NavLink
                                :href="route('contact')"
                                :active="route().current('contact')"
                            >
                                Contact
                            </NavLink>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            class="inline-flex items-center justify-center p-2 rounded-md hover:text-gray-300 transition duration-150 ease-in-out"
                            @click="
                                showingNavigationDropdown =
                                    !showingNavigationDropdown
                            "
                        >
                            <svg
                                class="size-6 text-black"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex':
                                            !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex':
                                            showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div
                :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }"
                class="sm:hidden grid w-52 justify-self-end"
            >
                <div class="pb-2 space-y-1">
                    <ResponsiveNavLink
                        :href="route('accueil')"
                        :active="route().current('accueil')"
                    >
                        Accueil
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        :href="route('bien_etre')"
                        :active="route().current('bien_etre')"
                    >
                        Bien-être
                    </ResponsiveNavLink>

                    <ResponsiveNavLink
                        :href="route('chambre')"
                        :active="route().current('chambre')"
                    >
                        Chambres
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        :href="route('contact')"
                        :active="route().current('contact')"
                    >
                        Contact
                    </ResponsiveNavLink>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->

        <!-- Page Content -->
        <main>
            <slot />
        </main>
        <footer>
            <article class="">
                <section id="reseau">
                    <h2>Me Contacter</h2>
                    <p><i class="fa-brands fa-facebook-f"></i> facebook</p>
                    <p><i class="fa-brands fa-instagram"></i> instagram</p>
                </section>
                <section>
                    <h2>À PROPOS</h2>
                    <p @click="() => $inertia.get(route('mentions_legales'))">
                        Mentions légales
                    </p>
                    <p
                        @click="
                            () => $inertia.get(route('donnees_personnelles'))
                        "
                    >
                        Données personnelles
                    </p>
                </section>
                <section>
                    <h2>Me suivre</h2>
                    <p>Cure&airbnsta.com</p>
                    <p>facebook.Cure&A.com</p>
                </section>
            </article>
            <h3 class="text-center pt-5">© Cure, Made by Duchesne R.</h3>
        </footer>
    </div>
</template>
<style></style>
