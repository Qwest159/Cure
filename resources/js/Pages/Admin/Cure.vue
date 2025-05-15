<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
const props = defineProps(["date_dispo"]);
console.log(props.date_dispo);
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cure
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <h1 class="text-center">Page Admin</h1>
                    <article class="mt-9">
                        <p>
                            Il est important de supprimer les dates qui n'ont
                            plus de chambre
                        </p>
                        <section
                            v-for="date in props.date_dispo"
                            :key="date.id"
                        >
                            <p class="my-4">
                                <span class="text-cyan-500">{{
                                    date.date_debut
                                }}</span>
                                /
                                <span class="text-orange-400">{{
                                    date.date_fin
                                }}</span>
                                ({{ date.prix }}€) Chambre restante :
                                {{ date.chambres_count }}
                            </p>
                        </section>
                    </article>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
