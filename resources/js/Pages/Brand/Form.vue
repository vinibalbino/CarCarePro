<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import toast from "@/Stores/toast.js";

const props = defineProps([
    'brand'
])

const form = useForm({
    name: props.brand?.name,
});

const title = props.brand ? 'Editar Marca' : 'Adicionar Marca';

const submit = () => {
    if(!props.brand){
        form.post(route('marcas.adicionar'), {
            onSuccess: () => {
                toast.add({
                    message: `Marca ${form.name} adicionada com sucesso!`,
                    type: "sucess",
                });
                form.reset();
            },
        })
    }else {
        form.put(route('marcas.editar', {
            'id': props.brand.id
        }), {
            onSuccess: () => {
                toast.add({
                    message: `Marca ${form.name} editada com sucesso!`,
                    type: "sucess",
                });
                form.reset();
            }

        })
    }
}

</script>

<template>

    <Head :title="title"  />

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
                                    nome da marca
                                </label>
                                <input
                                    v-model="form.name"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                    id="grid-first-name" type="text" placeholder="Chevrolet" />
                                <p v-if="form.errors.name" class="text-red-500 text-xs italic">Já existe a marca com este nome</p>
                            </div>
                        </div>
                        <div class="flex gap-10 w-full md:w-7/12 mb-6 md:mb-0">
                            <Link :href="route('marcas')">
                                <DangerButton>
                                    Cancelar
                                </DangerButton>
                            </Link>
                            <PrimaryButton type="submit" class=" hover:bg-blue-400">
                                {{ props.brand ? 'Editar Marca' : 'Salvar Marca' }}
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
