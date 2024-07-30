<script setup>
import {TriangleAlert} from "lucide-vue-next";

const props = defineProps([
    'message'
])

const emit = defineEmits(['cancel', 'remove']);
</script>

<template>
    <div class="px-6 pt-6 pb-2 sm:p-6 sm:pb-4">
        <div class="flex sm:flex sm:items-start">
            <div class="mx-auto my-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-yellow-200 sm:mx-0 sm:h-10 sm:w-10">
                <TriangleAlert
                    color="red"
                />
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Confirmação
                </h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">
                        {{ message }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
        <button
            @click="emit('remove')"
            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">
            <span>Deletar</span>
        </button>
        <button
            @click="emit('cancel')"
            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
            Cancelar
        </button>
    </div>
</template>
