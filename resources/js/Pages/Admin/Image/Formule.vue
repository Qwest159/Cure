<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
//MODAL
import DialogModal from "@/Components/DialogModal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ActionModal from "@/Components/ActionModal.vue";

const props = defineProps(["imgEndroit_paysage", "flash"]);
const form = useForm({
    img_path: "",
    // admin: "",
});

// DELETE AVEC MODAL

const confirmingImageDeletion = ref(false);
let selected_image_id = 0;
let selected_img_path = "";

const confirmImageDeletion = (id, nom) => {
    selected_image_id = id;
    selected_img_path = nom;

    confirmingImageDeletion.value = true;
};
// console.log(usePage().props.image.id);

function deleteImage() {
    form.delete(route("lfclean.destroy", selected_image_id), {
        onSuccess: () => closeModal(),
    });
}
const closeModal = () => {
    confirmingImageDeletion.value = false;
};

//supprime les image

function sendform() {
    form.post(route("lfclean_store", "imgEndroit_paysage"));
}
function handlefilechange(event) {
    form.img_path = event.target.files;
}
</script>

<template>
    <AppLayout title="Create paysage">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Créer Image paysage
                </h2>
            </div>
        </template>

        <h1 class="text-xl font-bold mb-4 text-center">
            Mettre une image sur l'accueil Partie : Paysage
        </h1>
        <div class="text-center font-bold">
            <p class="bg-green-600 w-full p-2" v-if="props.flash.réussi">
                {{ props.flash.réussi ?? "" }}
            </p>
        </div>
        <form @submit.prevent="sendform" enctype="multipart/form-data">
            <div class="flex flex-col">
                <div class="p-6">
                    <!-- Input pour choisir une image -->
                    <div class="flex justify-center">
                        <div>
                            <h2>image Paysage</h2>
                            <input
                                multiple
                                type="file"
                                id="img_path"
                                name="img_path"
                                @change="handlefilechange"
                            />
                            <div
                                v-if="form.errors.img_path"
                                class="text-red-600"
                            >
                                {{ form.errors.img_path }}
                            </div>
                        </div>
                    </div>
                    <div class="text-center font-bold">
                        <span class="text-red-600" v-if="props.flash.error">{{
                            props.flash.error ?? ""
                        }}</span>
                    </div>
                    <!-- Prévisualisation de l'image -->
                    <!-- <div v-if="previewUrl" class="mt-4">
                        <h2 class="text-lg font-medium mb-2">Aperçu :</h2>
                        <img
                            alt="Aperçu de l'image"
                            class="w-64 h-64 object-cover border"
                        />
                    </div> -->
                </div>
                <!-- Submit -->
                <button type="submit" :disabled="form.processing">Créer</button>
            </div>
        </form>

        <h1
            class="font-bold , text-red-600 text-xl m-5 py-9 border-4 border-t-red-500"
        >
            Supprime les Images en cliquant dessus
        </h1>

        <!-- Itération sur les images -->
        <div class="grid grid-cols-3 gap-4 justify-evenly">
            <div v-for="image in imgEndroit_paysage" :key="image.id" class="">
                <!-- Bouton pour chaque image -->

                <ActionModal>
                    <template #content>
                        <DangerButton
                            @click="
                                confirmImageDeletion(image.id, image.img_path)
                            "
                        >
                            <figure>
                                <img
                                    :src="`/storage/${image.img_path}`"
                                    :alt="`Image ${image.id}`"
                                    class="w-96 object-cover border"
                                />
                            </figure>
                        </DangerButton>
                    </template>
                </ActionModal>
            </div>
        </div>

        <DialogModal :show="confirmingImageDeletion" @close="closeModal">
            <template #title> Supprimer les images </template>

            <template #content> L'image va être supprimée </template>

            <template #footer>
                <SecondaryButton @click="closeModal"> Annuler </SecondaryButton>

                <DangerButton
                    class="ms-3"
                    :class="{
                        'opacity-25': form.processing,
                    }"
                    @click="deleteImage()"
                >
                    Supprimer l'image
                </DangerButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>
