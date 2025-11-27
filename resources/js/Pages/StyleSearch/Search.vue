<template>
    <StyleLayout title="Buscador de Estilos">

        <!-- Buscador -->
        <section class="mb-6">
            <SearchForm
                ref="searchFormRef"
                v-model:query="filters.query"
                @search="search"
                @reset="resetFilters"
            />
        </section>

        <!-- Resultados -->
        <section>
            <ResultsTable :styles="styles" />
        </section>
    </StyleLayout>
</template>

<script setup>
import { ref, nextTick } from 'vue';
import {router, usePage} from '@inertiajs/vue3';

import StyleLayout from '@/Layouts/StyleLayout.vue';
import SearchForm from '@/Pages/StyleSearch/Partials/SearchForm.vue';
import ResultsTable from '@/Pages/StyleSearch/Partials/ResultsTable.vue';

// Props recibidos desde Laravel
const props = defineProps({
    styles: Array,
    filters: Object
});

const searchText = ref(props.query || '');


const styles = ref(props.styles);
const filters = ref({ ...props.filters });
const searchFormRef = ref(null);
// Métodos para buscar y resetear
const search = () => {
    router.get(
        '/styles/search',
        { query: filters.value.query },
        {
            preserveState: true,
            replace: true,
            onSuccess: () => {
                styles.value = usePage().props.styles;
                nextTick(() => {
                    searchFormRef.value?.focusAndSelect();
                });
            }
        }
    );
};
const resetFilters = () => {
    searchText.value = '';   // 1. limpiar input visualmente

    router.get(
        '/styles/search',
        {},                  // 2. SIN QUERY
        {
            preserveState: false,
            replace: true,
        }
    );
};

</script>
