<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import toast from "@/Stores/toast.js";

const props = defineProps([
    'owner',
    'vehicle',
])

console.log(props.owner);
const form = useForm({
    model: props.vehicle?.model
});


const title = props.vehicle ? 'Editar Veiculo' : 'Adicionar Veiculo';

const submit = () => {
    if (!props.vehicle) {
        form.post(route('veiculos.adicionar'), {
            onSuccess: () => {
                toast.add({
                    message: `Veiculo adicionado com sucesso!`,
                    type: "sucess",
                });
                form.reset();
            },
            onError: () => {
                toast.add({
                    message: `Não foi possivel adicionar o veículo`,
                    type: "erro",
                });
                form.reset();
            },

        })
    } else {
        form.put(route('clientes.editar', {
            'id': props.owner.id
        }), {
            onSuccess: () => {
                toast.add({
                    message: `Cliente ${form.full_name} alterado com sucesso!`,
                    type: "sucess",
                });
                form.reset();
            },
            onError: () => {
                toast.add({
                    message: `Não foi possivel alterar o cliente ${form.full_name} com sucesso!`,
                    type: "erro",
                });
                form.reset();
            }
        })
    }
}



</script>

<template>

    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ title }}</h2>

        </template>

        <div class="py-12 px-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-3 sm:px-6 lg:px-8 sm:py-6 lg:py-8 overflow-hidden shadow-sm sm:rounded-lg">
                    <form class="w-full max-w-lg" @submit.prevent="submit">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-7/12 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-4"
                                    for="grid-first-name">
                                    Modelo
                                </label>
                                <input v-model="form.model"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-500 rounded py-3 px-4 my-5 leading-tight focus:outline-none focus:bg-white"
                                    id="grid-first-name" type="text" placeholder="Cruze" />
                                    <p v-if="form.model" class="text-red-500 text-xs italic">Nome do modelo é necessário</p>
                            </div>
                        </div>
                        <div class="flex gap-10 w-full md:w-7/12 mb-6 md:mb-0">
                            <Link :href="route('clientes')">
                            <DangerButton>
                                Cancelar
                            </DangerButton>
                            </Link>
                            <PrimaryButton type="submit" class="hover:bg-blue-400">
                                {{ props.owner ? 'Editar Veículo' : 'Salvar Cliente' }}
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
