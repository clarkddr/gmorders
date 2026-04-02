<template>
    <Head title="Buscador de Existencia" />
    <StyleLayout :title="'Buscador de Existencia ' + branchName">

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
import { Head, router, usePage} from '@inertiajs/vue3';

import StyleLayout from '@/Layouts/StyleLayout.vue';
import SearchForm from '@/Pages/StyleSearchInventory/Partials/SearchForm.vue';
import ResultsTable from '@/Pages/StyleSearchInventory/Partials/ResultsTable.vue';

// Props recibidos desde Laravel
const props = defineProps({
    styles: Array,
    filters: Object,
    slug: String,
    branchName: String
});

const searchText = ref(props.query || '');


const styles = ref(props.styles);
const filters = ref({ ...props.filters });
const searchFormRef = ref(null);
const currentUuid = props.slug;
// Métodos para buscar y resetear
const search = () => {
    router.get(
        `/styles/search/${currentUuid}`,
        { query: filters.value.query },
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
        `/styles/search/${currentUuid}`,
        {},                  // 2. SIN QUERY
        {
            preserveState: false,
            replace: true,
        }
    );
};

</script>
