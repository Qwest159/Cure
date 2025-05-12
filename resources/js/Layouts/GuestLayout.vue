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
            <div
                id="nav_back"
                class="mx-auto px-4 sm:px-6 lg:px-8 nav_background"
            >
                <div class="flex justify-between h-16">
                    <div class="flex w-full py-2">
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
                        <a
                            id="tel"
                            class="items-center border-b-2 border-transparent text-base font-medium leading-5 text-white focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
                            href="tel:+1234567890"
                            >Tél: 234 567 890</a
                        >
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            class="inline-flex items-center justify-center p-2 rounded-md transition duration-150 ease-in-out button_svg"
                            @click="
                                showingNavigationDropdown =
                                    !showingNavigationDropdown
                            "
                        >
                            <svg
                                class="size-7 text-black"
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
                class="sm:hidden grid justify-self-end"
            >
                <div class="pb-2 space-y-1 nav_background">
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
                    <h2>Me contacter</h2>
                    <ul>
                        <li>
                            <i class="fa-solid fa-envelope"></i
                            ><a href="http://"> email</a>
                        </li>
                        <li>
                            <i class="fa-solid fa-phone"></i
                            ><a href="http://"> téléphone</a>
                        </li>
                    </ul>
                </section>
                <section>
                    <h2>À propos</h2>
                    <ul>
                        <li>
                            <a
                                @click="
                                    () =>
                                        $inertia.get(route('mentions_legales'))
                                "
                                >Mentions légales</a
                            >
                        </li>
                        <li>
                            <a
                                @click="
                                    () =>
                                        $inertia.get(
                                            route('donnees_personnelles')
                                        )
                                "
                                >Données personnelles</a
                            >
                        </li>
                    </ul>

                    <p></p>
                </section>
                <section>
                    <h2>Me suivre</h2>
                    <ul>
                        <li>
                            <i class="fa-brands fa-facebook text-2xl"></i>
                            <a href="http://"> Cure&airbnsta.com</a>
                        </li>
                        <li>
                            <i class="fa-brands fa-instagram text-2xl"></i
                            ><a href="http://"> facebook.Cure&A.com</a>
                        </li>
                    </ul>
                </section>
            </article>
            <h3 class="text-center pt-5">© Cure, Made by Duchesne R.</h3>
        </footer>
    </div>
</template>
<style></style>
