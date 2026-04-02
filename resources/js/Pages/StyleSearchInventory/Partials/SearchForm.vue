<template>
    <form @submit.prevent="onSearch" class="grid gap-4 md:grid-cols-3 items-end">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-300 mb-1">Buscar estilo</label>
            <input
                v-model="localQuery"
                ref="searchInput"
                type="text"
                class="w-full rounded-md border border-gray-700 bg-gray-800 text-gray-100 px-3 py-2 text-sm"
                placeholder="Estilo..."
            >
        </div>

        <div class="flex gap-2">
            <button
                type="submit"
                class="px-4 py-2 text-sm font-semibold rounded-md bg-blue-600 hover:bg-blue-700"
            >
                Buscar
            </button>

            <button
                type="button"
                @click="onReset"
                class="px-4 py-2 text-sm rounded-md border border-gray-600 text-gray-200 hover:bg-gray-800"
            >
                Limpiar
            </button>
        </div>
    </form>
</template>

<script setup>
import {nextTick, onMounted, ref, watch} from 'vue';

const props = defineProps({
    query: String
});

const emit = defineEmits(['update:query', 'search', 'reset']);

const localQuery = ref(props.query);

const searchInput = ref(null);

// Sincronizar input
watch(localQuery, (val) => emit('update:query', val));

onMounted(() => {
    nextTick(() => {
        if (searchInput.value) {
            searchInput.value.focus();
            searchInput.value.select(); // 👈 Seleccionar el texto
        }
    });
});

const focusAndSelect = () => {
    if (searchInput.value) {
        searchInput.value.focus();
        searchInput.value.select(); // 👈 Seleccionar el texto
    }
}
defineExpose({focusAndSelect});

const onSearch = () => emit('search');

const onReset = () => {
    localQuery.value = "";
    emit('reset');
};
</script>
