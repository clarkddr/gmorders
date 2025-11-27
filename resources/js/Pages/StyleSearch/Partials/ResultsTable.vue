<template>
    <div class="overflow-hidden rounded-lg border border-gray-800 shadow-md">
        <!-- Mensaje personalizado de conteo (para debug si quieres)
        <p class="text-xs text-gray-400 px-4 py-2">
            Registros: {{ styles.length }}
        </p>
        -->

        <table ref="tableRef" class="min-w-full divide-y divide-gray-800">
            <thead class="bg-gray-800">
            <tr class="text-xs text-gray-400 uppercase">
                <th class="px-4 py-3">Descripción</th>
                <th class="px-4 py-3">Estilo</th>
                <th class="px-4 py-3">Precio</th>
                <th class="px-4 py-3">Fecha</th>
            </tr>
            </thead>

            <!-- tbody vacío: lo va a controlar DataTables -->
            <tbody class="bg-gray-900 divide-y divide-gray-800"></tbody>
        </table>

        <!-- Mensaje de "sin resultados" personalizado -->
        <div
            v-if="!styles.length"
            class="px-4 py-6 text-center text-gray-400 text-sm bg-gray-900 border-t border-gray-800"
        >
            No hay resultados.
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';

const props = defineProps({
    styles: {
        type: Array,
        default: () => [],
    },
});

const tableRef = ref(null);
let dataTable = null;

const initOrUpdateDataTable = () => {
    if (!tableRef.value) return;

    if (
        typeof window === 'undefined' ||
        !window.$ ||
        !window.$.fn ||
        !window.$.fn.DataTable
    ) {
        console.warn('jQuery o DataTables no están disponibles todavía');
        return;
    }

    const $ = window.$;

    // Primera vez: inicializamos DataTables con data desde props.styles
    if (!dataTable) {
        dataTable = $(tableRef.value).DataTable({
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            autoWidth: false,
            data: props.styles || [],
            columns: [
                { data: 'SubcategoryName' },
                { data: 'Code' },
                { data: 'SalePrice' },
                { data: 'YearMonth' },
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                // Opcional: ocultar completamente el mensaje de tabla vacía de DataTables
                emptyTable: '',
            },
            order: [[3, 'desc']]
        });

        return;
    }

    // Si ya existe la instancia, solo actualizamos los datos
    dataTable.clear();
    dataTable.rows.add(props.styles || []);
    dataTable.draw();
};

onMounted(() => {
    // Inicializar DataTables (aunque styles venga vacío, no pasa nada;
    // con emptyTable: '' no se verá el mensaje feo).
    initOrUpdateDataTable();
});

// Cada vez que cambien los resultados que vienen de Inertia
watch(
    () => props.styles,
    () => {
        if (!dataTable) return;
        initOrUpdateDataTable();
    }
);

onBeforeUnmount(() => {
    if (dataTable) {
        dataTable.destroy();
        dataTable = null;
    }
});
</script>
