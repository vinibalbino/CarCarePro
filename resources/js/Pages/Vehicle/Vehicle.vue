<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link } from '@inertiajs/vue3';
import Modal from "@/Components/Modal.vue";

import { ref } from "vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import { Inertia } from '@inertiajs/inertia'
import toast from '@/Stores/toast';


const props = defineProps([
    'owner',
]);


const showModal = ref(false);
const messageModal = ref("");
const ownerId = ref();

const showDelete = (owner) => {
    showModal.value = true;
    messageModal.value = `Deseja realmente deletar o cliente ${owner.full_name}?`
    ownerId.value = owner.id;
}

function cancelModal() {
    showModal.value = !showModal.value;
}

async function removeOwner() {
    let message = `Cliente ${props.owner.full_name} removido com sucesso!`;

    Inertia.delete(route('clientes.delete', {
        id: ownerId.value,
    }));
    route().redirect('clientes');
}

</script>

<template>

    <Head title="Clientes" />

    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-100 py-12 px-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Detalhes do Usuário</h3>
                        <div class="mt-5 border-t border-gray-200">
                            <dl class="divide-y divide-gray-200">
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Nome Completo</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ owner.full_name }}
                                    </dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">CPF</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ owner.cpf }}</dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Sexo</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ owner.sex == 'M' ?
                                        "Masculino" : "Feminino" }}</dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">CEP</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{
                                        owner.address.zipcode }}</dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Logradouro</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ owner.address.street
                                        }}</dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Número</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{
                                        owner.address.house_number }}</dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Bairro</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{
                                        owner.address.neighborhood }}</dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Cidade</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ owner.address.city
                                        }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div class="mt-6 flex justify-end gap-4">
                            <Link :href="route('clientes.formulario', {
                                id: owner.id
                            })">
                            <PrimaryButton>Editar</PrimaryButton>
                            </Link>

                            <DangerButton @click="showDelete(owner)">
                                Deletar
                            </DangerButton>

                            <Link :href="route('clientes')">
                            <PrimaryButton
                                class="bg-black text-white px-4 rounded hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75">
                                Voltar
                            </PrimaryButton>
                            </Link>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="showModal" :closeable="true">
            <DeleteModal :message="messageModal" @cancel="cancelModal" @remove="removeOwner" />
        </Modal>
    </AuthenticatedLayout>
</template>
