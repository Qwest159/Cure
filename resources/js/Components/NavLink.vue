<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? "inline-flex items-center px-1 pt-1 border-b-4 border-white text-sm font-medium leading-5 text-gray-900 focus:outline-none  transition duration-150 ease-in-out text-black  nav_text "
        : "inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700  focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out text-black nav_text ";
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
