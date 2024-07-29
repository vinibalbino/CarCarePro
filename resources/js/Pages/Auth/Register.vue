<script setup>

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const imgRegister = "https://img.freepik.com/free-photo/portrait-young-automechanic-writing-clipboard-looking-camera-while-another-specialist-working_496169-946.jpg?t=st=1722219486~exp=1722223086~hmac=e5ba94dbd0622b383a45bc243cefd0fa5d037fa3ac11338fecda818be83f2b6c&w=1380"

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>

    <Head title="Register" />

    <div class="flex h-screen bg-slate-50">
        <div class="hidden md:flex w-1/2 bg-cover bg-center bg-no-repeat brightness-75"
            :style="{ backgroundImage: `url(${imgRegister})` }">
        </div>
        <div class="flex flex-col justify-center w-full md:w-1/2 px-8 py-12">
            <div class="max-w-md mx-auto">
                <div class="mb-16 text-center italic">
                    <h2 class="text-3xl font-bold mb-6">CarCarePro</h2>
                    <p class="font-thin">Software de controle de revisões veículares</p>
                </div>
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="name" value="Nome Completo" />

                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                            autocomplete="name" />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="email" value="Email" />

                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                            autocomplete="username" />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password" value="Senha" />

                        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password"
                            required autocomplete="new-password" />

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password_confirmation" value="Confirme a senha" />

                        <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                            v-model="form.password_confirmation" required autocomplete="new-password" />

                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link :href="route('login')"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Já está cadastrado?
                        </Link>

                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Registrar
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>
