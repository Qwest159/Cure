<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    active: Boolean,
    href: String,
    as: String,
});

const classes = computed(() => {
    return props.active
        ? "block w-full ps-3 pe-4 py-2 border-l-4 border-white text-start text-base font-medium  transition duration-150 ease-in-out nav_profil"
        : "block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600   transition duration-150 ease-in-out nav_profil";
});
</script>

<template>
    <div class="lien">
        <button
            v-if="as == 'button'"
            :class="classes"
            class="w-full text-start"
        >
            <slot />
        </button>

        <a
            v-else-if="as == 'a'"
            :class="classes"
            class="w-full text-start"
            :href="href"
        >
            <slot />
        </a>

        <Link v-else :href="href" :class="classes">
            <slot />
        </Link>
    </div>
</template>
