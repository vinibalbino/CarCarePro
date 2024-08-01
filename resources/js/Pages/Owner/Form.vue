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

function validateCPF(cpf) {
    // Remove caracteres não numéricos
    cpf = cpf.replace(/[^\d]/g, '');

    // Verifica se o CPF tem 11 dígitos e não é uma sequência repetida
    if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
        return false;
    }

    // Função para calcular o dígito verificador
    const calcularDigito = (cpf, peso) => {
        let soma = 0;
        for (let i = 0; i < cpf.length; i++) {
            soma += cpf[i] * peso--;
        }
        const resto = soma % 11;
        return resto < 2 ? 0 : 11 - resto;
    };

    // Verifica o primeiro dígito verificador
    const primeiroDigito = calcularDigito(cpf.substring(0, 9), 10);
    if (parseInt(cpf.charAt(9), 10) !== primeiroDigito) {
        return false;
    }

    // Verifica o segundo dígito verificador
    const segundoDigito = calcularDigito(cpf.substring(0, 10), 11);
    return parseInt(cpf.charAt(10), 10) === segundoDigito;
}


const title = props.owner ? 'Editar Cliente' : 'Adicionar Cliente';

const submit = () => {
    if (!props.owner) {
        if(validateCPF(form.cpf)){
            form.post(route('clientes.adicionar'), {
                onSuccess: () => {
                    toast.add({
                        message: `Cliente adicionado com sucesso!`,
                        type: "sucess",
                    });
                    form.reset();
                },
                onError: () => {
                    toast.add({
                        message: `Não foi possivel adicionar o cliente adicionado com sucesso!`,
                        type: "erro",
                    });
                    form.reset();
                }
            })
        }else {
            toast.add({
                        message: `CPF do cliente não é valido!`,
                        type: "erro",
                    });
        }
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
        form.zipcode.replace(/[.\-]/g, '');
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

function formatCpf() {

      let cpfValue = (form.cpf).replace(/\D/g, '');


      if (cpfValue.length <= 11) {
        cpfValue = cpfValue.replace(/(\d{3})(\d)/, '$1.$2');
        cpfValue = cpfValue.replace(/(\d{3})(\d)/, '$1.$2');
        cpfValue = cpfValue.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
      }

      form.cpf = cpfValue;
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
                                    <p v-if="form.errors.full_name" class="text-red-500 text-xs italic">Nome do Cliente é necessario</p>
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-4"
                                    for="grid-first-name">
                                    CPF
                                </label>
                                <input v-model="form.cpf" maxlength="14" @input="formatCpf"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-500 rounded py-3 px-4 my-5 leading-tight focus:outline-none focus:bg-white"
                                    id="grid-first-name" type="text" placeholder="000.000.000-00" />
                                    <p v-if="form.errors.cpf" class="text-red-500 text-xs italic">CPF do Cliente é necessario</p>
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
                                <p v-if="form.errors.sex" class="text-red-500 text-xs italic">Sexo do Cliente é necessario</p>
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-4"
                                    for="grid-first-name">
                                    cep
                                </label>
                                <input v-model="form.zipcode"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-500 rounded py-3 px-4 my-5 leading-tight focus:outline-none focus:bg-white"
                                    id="grid-first-name" type="text" placeholder="79801016" />
                                    <p v-if="form.errors.zipcode" class="text-red-500 text-xs italic">CEP do Cliente é necessario</p>
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
                                <p v-if="form.errors.house_number" class="text-red-500 text-xs italic">Numero da residencia do Cliente é necessario</p>
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
