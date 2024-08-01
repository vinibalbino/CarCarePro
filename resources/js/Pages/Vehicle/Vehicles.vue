<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { PencilIcon, TrashIcon, PlusIcon, EyeIcon , MoveRightIcon } from 'lucide-vue-next';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import {ref} from "vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import {Inertia} from '@inertiajs/inertia'


const props = defineProps([
    'vehicles',
]);

const showModal = ref(false);
const messageModal = ref("");
const ownerId = ref();

const showDelete = (owner) => {
    showModal.value = true;
    messageModal.value = `Deseja realmente deletar o cliente ${owner.full_name}?`
    ownerId.value= owner.id;
}

function cancelModal() {
    showModal.value = !showModal.value;
}

function removeOwner() {
    console.log(ownerId.value)
    console.log(Inertia.delete(route('clientes.delete', {
        id: ownerId.value,
    })));
}



</script>

<template>
    <Head title="Veiculos" />

    <AuthenticatedLayout>
        <template #header >
            <div class="flex justify-between items-center mt-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Clientes</h2>
                    <PrimaryButton>
                        <Link
                            class="flex items-center flex gap-4"
                            :href="route('veiculos.formulario')">
                            <PlusIcon />
                            <span>Adicionar Veículo</span>
                        </Link>
                    </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="py-16 px-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    </div>
                </div>
            </div>

        </div>

        <Modal
            :show="showModal"
            :closeable="true"
        >
            <DeleteModal
                :message="messageModal"
                @cancel="cancelModal"
                @remove="removeOwner"
            />
        </Modal>
    </AuthenticatedLayout>
</template>
