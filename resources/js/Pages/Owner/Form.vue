<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import toast from "@/Stores/toast.js";
import axios from 'axios';

const props = defineProps([
    'owner'
])


const form = useForm({
    full_name: props.owner?.full_name,
    cpf: props.owner?.cpf,
    sex: props.owner?.sex,
    street: props.owner ? props.owner.address.street : '',
    house_number: props.owner ? props.owner.address.house_number : '' ,
    zipcode: props.owner ? props.owner.address.zipcode : '' ,
    city: props.owner ? props.owner.address.city : '' ,
    neighborhood: props.owner ? props.owner.address.neighborhood : '' ,
});


const title = props.owner ? 'Editar Cliente' : 'Adicionar Cliente';

const submit = () => {
    if (!props.owner) {
        form.post(route('clientes.adicionar'), {
            onSuccess: () => {
                toast.add({
                    message: `Cliente ${form.full_name} adicionado com sucesso!`,
                    type: "sucess",
                });
                form.reset();
            },
            onError: () => {
                toast.add({
                    message: `Não foi possivel adicionar o cliente ${form.full_name} adicionado com sucesso!`,
                    type: "erro",
                });
                form.reset();
            }
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

async function buscarEndereco(){
    if (form.zipcode != undefined && form.zipcode.length == 8 ) {
        const response = await axios.get(`https://viacep.com.br/ws/${form.zipcode}/json/`);
        console.log(response.data);
        form.street = response.data.logradouro;
        form.neighborhood = response.data.bairro;
        form.city = response.data.localidade;
    }else{
        toast.add({
            message: `Insira o CEP corretamente!`,
            type: "erro",
        });
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
                                    Nome Completo
                                </label>
                                <input v-model="form.full_name"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-500 rounded py-3 px-4 my-5 leading-tight focus:outline-none focus:bg-white"
                                    id="grid-first-name" type="text" placeholder="Vinicius Silva Balbino" />

                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-4"
                                    for="grid-first-name">
                                    CPF
                                </label>
                                <input v-model="form.cpf"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-500 rounded py-3 px-4 my-5 leading-tight focus:outline-none focus:bg-white"
                                    id="grid-first-name" type="text" placeholder="04714926128" />

                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-4"
                                    for="grid-first-name">
                                    Sexo
                                </label>
                                <select v-model="form.sex"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-500 rounded py-3 px-4 my-5 leading-tight focus:outline-none focus:bg-white">
                                    <option disabled value="">Selecione um sexo</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                </select>


                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-4"
                                    for="grid-first-name">
                                    cep
                                </label>
                                <input v-model="form.zipcode"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-500 rounded py-3 px-4 my-5 leading-tight focus:outline-none focus:bg-white"
                                    id="grid-first-name" type="text" placeholder="79801016" />

                                <button @click="buscarEndereco"
                                 type="button"
                                 class="w-full mb-6 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                 >Buscar Endereço</button>

                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-4"
                                    for="grid-first-name">
                                    Logradouro
                                </label>
                                <input v-model="form.street" disabled
                                    class="appearance-none block w-full bg-gray-500 placeholder:text-white text-white border border-gray-500 rounded py-3 px-4 my-5 leading-tight focus:outline-none focus:bg-white"
                                    id="grid-first-name" type="text" placeholder="Rua Audelino Garcia" />
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-4"
                                    for="grid-first-name">
                                    Bairro
                                </label>
                                <input v-model="form.neighborhood" disabled
                                    class="appearance-none block w-full bg-gray-500 placeholder:text-white text-white border border-gray-500 rounded py-3 px-4 my-5 leading-tight focus:outline-none focus:bg-white"
                                    id="grid-first-name" type="text" placeholder="Canna" />
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-4"
                                    for="grid-first-name">
                                    Número
                                </label>
                                <input v-model="form.house_number"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-500 rounded py-3 px-4 my-5 leading-tight focus:outline-none focus:bg-white"
                                    id="grid-first-name" type="text" placeholder="2020" />
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-4"
                                    for="grid-first-name">
                                    cidade
                                </label>
                                <input v-model="form.city" disabled
                                    class="appearance-none block w-full bg-gray-500 placeholder:text-white text-white border border-gray-500 rounded py-3 px-4 my-5 leading-tight focus:outline-none focus:bg-white"
                                    id="grid-first-name" type="text" placeholder="Dourados" />
                            </div>
                        </div>
                        <div class="flex gap-10 w-full md:w-7/12 mb-6 md:mb-0">
                            <Link :href="route('clientes')">
                            <DangerButton>
                                Cancelar
                            </DangerButton>
                            </Link>
                            <PrimaryButton type="submit" class="hover:bg-blue-400">
                                {{ props.owner ? 'Editar Cliente' : 'Salvar Cliente' }}
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
