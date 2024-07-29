<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
const imageUrl = "https://img.freepik.com/free-photo/car-mechanic-with-tablet-near-car-work-clothes_1157-46144.jpg?t=st=1722217010~exp=1722220610~hmac=c387bf8ca163ce172293e1ac7b5662f02d4db41a486a5d0ce0412e7263dd9566&w=1380"

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Login" />

    <div class="flex h-screen bg-slate-50">
        <div class="flex flex-col justify-center w-full md:w-1/2 px-8 py-12">
            <div class="max-w-md mx-auto">
                <div class="mb-16 text-center italic">
                    <h2 class="text-3xl font-bold mb-6">CarCarePro</h2>
                    <p class="font-thin mb-5">Software de controle de revisões veículares</p>
                    <Link class="underline font-bold text-blue-600" :href="route('register')">Comece um teste gratuito de 14 dias
                    </Link>
                </div>
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="email" value="Usuário" />

                        <TextInput id="email" type="email" class="mt-4 block w-full" v-model="form.email" required
                            autofocus autocomplete="username" />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password" value="Senha" />

                        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password"
                            required autocomplete="current-password" />

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="block mt-4">
                        <label class="flex items-center">
                            <Checkbox class="cursor-pointer" name="remember" v-model:checked="form.remember" />
                            <span class="ms-2 text-sm text-gray-600">Lembre-me</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <!-- <Link v-if="canResetPassword" :href="route('password.request')"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Esqueceu a senha?
                        </Link> -->

                        <PrimaryButton class="ms-8" :class="{ 'opacity-15': form.processing }"
                            :disabled="form.processing">
                            Entrar
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>

        <div class="hidden md:flex w-1/2 bg-cover bg-center bg-no-repeat brightness-75"
            :style="{ backgroundImage: `url(${imageUrl})` }">
        </div>

    </div>

</template>
