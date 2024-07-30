<script setup>
import {onMounted} from "vue";

const props = defineProps({
    message : String,
    duration: {
        type: Number,
        default: 2000
    },
    type: String
})

onMounted(() => {
    setTimeout(() => emit('remove'), props.duration)
})

const emit = defineEmits(['remove']);
</script>

<template>
    <div class="flex items-center p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 " role="alert">
        <div
            v-if="props.type === 'sucess'"
            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-white bg-green-500 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
            <span class="sr-only">Check Icon</span>
        </div>
        <div
            v-else
            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-white bg-red-500 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            <span class="sr-only">X icon</span>
        </div>

        <div class="ms-3 text-sm font-normal">{{ props.message}}</div>
        <button type="button"
            @click="emit('remove')"
            class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-200 inline-flex items-center justify-center h-8 w-8 "
            data-dismiss-target="#toast-default" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>

</template>
