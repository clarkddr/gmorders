<template>
    <div class="rounded-lg border border-gray-800 shadow-md bg-gray-900 overflow-hidden">

        <div v-show="!isMobile" class="overflow-x-auto">
            <table ref="tableRef" class="min-w-full divide-y divide-gray-800">
                <thead class="bg-gray-800">
                <tr class="text-xs text-gray-400 uppercase text-left">
                    <th class="px-4 py-3">Descripción</th>
                    <th class="px-4 py-3">Estilo</th>
                    <th class="px-4 py-3">Precio</th>
                    <th class="px-4 py-3">Color</th>
                    <th class="px-4 py-3">Fecha</th>
                    <th class="px-4 py-3">Inventario</th>
                </tr>
                </thead>
                <tbody class="bg-gray-900 divide-y divide-gray-800 text-gray-300"></tbody>
            </table>
        </div>

        <div v-if="isMobile" class="divide-y divide-gray-800">
            <div v-for="item in styles" :key="item.Code" class="p-4 active:bg-gray-800 transition-colors">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="uppercase tracking-wider text-blue-400 font-bold">
                            {{ item.SubcategoryName }}
                        </p>
                        <h3 class="text-xl text-gray-100">{{ item.Code }} - {{ item.ColorName }}</h3>
                    </div>
                    <div class="text-right">
                        <p class="text-lg text-green-400">${{ item.SalePrice }}</p>
                        <p class=" text-gray-500">{{ item.YearMonth }}</p>
                    </div>
                    <div class="flex items-center justify-end">
                        <p class="text-xl text-green-400">{{ item.StockTotal }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="!styles.length" class="px-4 py-10 text-center text-gray-500 text-sm italic bg-gray-900">
            No se encontraron resultados.
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch, nextTick } from 'vue';

const props = defineProps({
    styles: { type: Array, default: () => [] },
});

const tableRef = ref(null);
const isMobile = ref(false);
let dataTable = null;

// Función para detectar si es móvil
const checkMobile = () => {
    isMobile.value = window.innerWidth < 768;
    // Si pasamos de móvil a PC, necesitamos reinicializar o ajustar DataTables
    if (!isMobile.value) {
        nextTick(() => {
            initOrUpdateDataTable();
        });
    }
};

const initOrUpdateDataTable = () => {
    // Si estamos en móvil o no hay referencia a la tabla, no hacemos nada
    if (isMobile.value || !tableRef.value) return;

    const $ = window.$;
    if (!$.fn.DataTable) return;

    if (!dataTable) {
        dataTable = $(tableRef.value).DataTable({
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            autoWidth: false,
            data: props.styles,
            columns: [
                { data: 'SubcategoryName' },
                { data: 'Code' },
                { data: 'SalePrice' },
                { data: 'ColorName' },
                { data: 'YearMonth' },
                { data: 'StockTotal' },
            ],
            language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },
            order: [[3, 'desc']]
        });
    } else {
        dataTable.clear().rows.add(props.styles).draw();
    }
};

onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
    initOrUpdateDataTable();
});

watch(() => props.styles, () => {
    initOrUpdateDataTable();
}, { deep: true });

onBeforeUnmount(() => {
    window.removeEventListener('resize', checkMobile);
    if (dataTable) {
        dataTable.destroy();
        dataTable = null;
    }
});
</script>
