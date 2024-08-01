<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { PencilIcon, TrashIcon, PlusIcon } from 'lucide-vue-next';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import { ref } from "vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import { Inertia } from '@inertiajs/inertia'


const props = defineProps([
    'brands',
]);

const showModal = ref(false);
const messageModal = ref("");
const brandId = ref();

const showDelete = (brand) => {
    showModal.value = true;
    messageModal.value = `Deseja realmente deletar a marca ${brand.name}?`
    brandId.value = brand.id;
}

function cancelModal() {
    showModal.value = !showModal.value;
}

function removeBrand() {
    console.log(brandId.value)
    Inertia.delete(route('marcas.delete', {
        id: brandId.value
    }));
}



</script>

<template>

    <Head title="Marcas" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center mt-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Marcas</h2>
                <Link  :href="route('marcas.formulario')">
                <PrimaryButton class="flex items-center flex gap-4">
                    <PlusIcon />
                    <span>Adicionar Marca</span>
                </PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="py-16 px-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="brand in brands" :key="brand.id" class="bg-white-500 shadow-md rounded-lg p-6">
                            <h2 class="text-xl font-bold mb-2">{{ brand.name }}</h2>
                            <div class="flex justify-between items-center mt-4">

                                <Link :href="route('marcas.formulario', {
                                    id: brand.id
                                })" class="flex gap-2 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                <PencilIcon strokeWidth={1} />
                                Editar
                                </Link>
                                <button @click="showDelete(brand)"
                                    class="flex self-center justify-centers gap-2 bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    <TrashIcon strokeWidth={1} />
                                    Deletar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <Modal :show="showModal" :closeable="true">
            <DeleteModal :message="messageModal" @cancel="cancelModal" @remove="removeBrand" />
        </Modal>
    </AuthenticatedLayout>
</template>
