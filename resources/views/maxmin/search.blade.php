<x-layout>
    @if(session('banner'))
        <x-banner message="{{session('banner.message')}}" type="{{session('banner.type')}}" class=""/>
    @endif
    {{-- Encabezado con título y espacio para dropdowns --}}
    @if ($errors->any())
        <div class="mb-4">
            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <x-titlePage title="Crear Máximo-Mínimo">
        <form action ="/maxmin/search" method="GET" class="flex space-x-4 justify-end">
            {{--            --}}{{-- Fechas de venta --}}
            <div class="flex flex-col w-full">
                <label for="code" class="text-xs text-gray-400 mb-1">Estilo</label>
                <input
                    id="code"
                    name="code"
                    value="{{ old('code', request('code')) }}"
                    placeholder="Buscar estilo"
                    class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-gray-300 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400"
                />
            </div>
            <div class="flex flex-col justify-end">
                <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Buscar
                </button>
            </div>
        </form>
    </x-titlePage>

    <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">

        @if(isset($codes))
            <!-- Tabla de Sucursales -->
            @php
                //                    $urlParameters = ['category'=> $selectedCategory,'family' => $selectedFamily, 'dates' => $selectedDate1];
            @endphp
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mt-1 mb-6"> <!-- Ocupa 8/12 -->
                <div class="w-full p-4 flex justify-between items-center bg-white dark:bg-gray-800 rounded-lg">
                    <div>
                        <h3 class="text-xl sm:text-xl font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400 my-2">
                            {{ 'Estilos' }}
                        </h3>
                    </div>
                </div>


                <table id="table" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Familia</th>
                        <th class="px-4 py-3">Subcategoria</th>
                        <th class="px-4 py-3">Proveedor</th>
                        <th class="px-4 py-3">Estilo</th>
                        <th class="px-4 py-3">Color</th>
                        <th class="px-4 py-3">Costo</th>
                        <th class="px-4 py-3">Precio</th>
                        <th class="px-4 py-3 dt-text-right">Fecha Compra</th>
                        <th class="px-4 py-3"></th>

                    </tr>
                    <tr class="filters text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                    </tr>
                    </thead>
                    @php
                        //                            $urlParameters = ['category'=> $selectedCategory,'branch' => $selectedBranch, 'dates1' => $selectedDate1, 'dates2' => $selectedDate2];
                    @endphp
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($codes as $code)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{ $code->FamilyName }}</td>
                            <td class="px-4 py-3">{{ $code->SubcategoryName }}</td>
                            <td class="px-4 py-3">{{ $code->SupplierName }}</td>
                            <td class="px-4 py-3">{{ $code->Code }}</td>
                            <td class="px-4 py-3">{{ $code->ColorName }}</td>
                            <td class="px-4 py-3">{{ number_format($code->Price,2) }}</td>
                            <td class="px-4 py-3">{{ number_format($code->SalePrice,2) }}</td>
                            <td class="px-4 py-3 text-right">{{ $code->DateFormatted }}</td>
                            <td class="px-4 py-3 items-center">
                                <a href="{{ route('maxmin.create', [
                                    'subcategoryid' => $code->SubcategoryId,
                                    'supplierid' => $code->SupplierId,
                                    'colorid' => $code->ColorId,
                                    'code' => $code->Code
                                    ]) }}"
                                    type="submit" class="btn-detail px-2 py-1 rounded-full bg-blue-300 text-blue-800 text-xs font-semibold flex items-center justify-center">
                                    {{ '+' }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <!-- termina Tabla de Estilos -->

    </div>
</x-layout>

<link rel="stylesheet" href="{{ asset('flatpickr/dark.css') }}">
<script src="{{ asset('flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('js/dateRanges.js') }}"></script>
<script> // Definimos las variables que pasaremos al script de DateRanges
    {{--window.selectedDate1 = @json($selectedDate1);--}}
    {{--window.dates = @json($dates);--}}
</script>
<script>
var table = $('#table').DataTable({
    orderCellsTop: true,   // asegura que la primera fila del thead se use para ordenar
    fixedHeader: true,     // opcional, si quieres que el header quede fijo
    paging:true,
    searching: true,
    info: false,
    "lenghtChange": false,
    "order": [[10, "desc"]],
});

table.columns().every(function() {
var column = this;
var colIdx = column.index();
// ❌ No poner filtro en la columna 1 (branches)
if (colIdx > 4) {
    return; // saltamos esta columna
}
// Crea select en el segundo thead (fila .filters)
var select = $('<select><option value="">Todos</option></select>')
    .appendTo($('.filters th').eq(column.index()).empty())
    .on('change', function() {
        var val = $.fn.dataTable.util.escapeRegex($(this).val());
        column.search(val ? '^' + val + '$' : '', true, false).draw();
    });
// Llena con valores únicos de la columna
column.data().unique().sort().each(function(d) {
    select.append('<option value="' + d + '">' + d + '</option>');
});
});


</script>
<style>

    form {
        margin: 0;
        padding: 0;
        border: none;
    }
    input, button, select, textarea {
        border: none;
        outline: none;
        background: none; /* Quita el fondo predeterminado */
        padding: 0; /* Quita el padding */
    }
    .dt-length label {
        color: #9ca3af;
    }
    /* Estilo base para todos los botones de la paginación */
    .dt-paging .dt-paging-button {
        color: #9CA3AF; /* gray-400 */
        background-color: transparent; /* Fondo transparente */
        border: none; /* Sin bordes */
        font-weight: normal;
        padding: 0.5rem 0.75rem; /* Ajuste de tamaño */
        border-radius: 0.375rem; /* Bordes redondeados */
        cursor: pointer;
    }

    /* Estilo para el botón de la página activa */
    .dt-paging .dt-paging-button.current {
        color: #9CA3AF !important; /* Gray-400 para el texto */
        background-color: transparent !important; /* Fondo transparente */
        font-weight: bold; /* Resaltar el texto de la página activa */
        border: 1px solid #9CA3AF !important; /* Borde gris para destacarlo */
    }

    /* Estilo para los botones deshabilitados */
    .dt-paging .dt-paging-button.disabled {
        color: #9CA3AF; /* gray-400 */
        cursor: not-allowed; /* Cambiar cursor cuando el botón está deshabilitado */
        opacity: 0.6; /* Reducir opacidad para indicar que está deshabilitado */
    }

    /* Asegura que el fondo del botón activo no sea oscuro */
    .dt-paging .dt-paging-button.current {
        background-color: transparent !important; /* Fondo transparente */
        color: #9CA3AF !important; /* Texto gris */
    }
    /* Cambiar el color del texto del select */
    .dt-length {
        color: #9ca3af; /* gray-400 */
    }
    /* Seleccionamos todos los inputs de paginación de DataTables */
    /* Texto dentro de los inputs/selects (v2) */
    .dt-container .dt-input,
    .dt-container .dt-search input,
    .dt-container .dt-length select {
        color: #c4c4c4;
    }
    /* Texto escrito dentro del input de búsqueda */
    .dt-container .dt-search input.dt-input {
        color: #c4c4c4 !important;
    }

    .dt-container .dt-search > label {
        color: #c4c4c4;
    }
    .dt-text-left {
        text-align: left !important;
    }
    .dt-text-right {
        text-align: right !important;
    }
    .th.th-center {
        text-align: center !important;
    }
</style>


