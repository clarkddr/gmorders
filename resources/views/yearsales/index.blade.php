<x-layout>
    @if(session('banner'))
        <x-banner message="{{session('banner.message')}}" type="success" class=""/>
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

    <x-titlePage title="Ventas">
{{--        <form action ="/saleandpurchase" method="GET" class="flex space-x-4 justify-end">--}}
{{--            <select name="branch" id="branch" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">--}}
{{--                <option value="0"  {{ $selectedBranch ? '' : 'selected' }}>Sucursal</option>--}}
{{--                @foreach ($branchesList as $branch)--}}
{{--                    <option value="{{ $branch->BranchId }}"--}}
{{--                        {{ $selectedBranch == $branch->BranchId ? 'selected' : '' }}>--}}
{{--                        {{ $branch->Name }}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--            <select name="family" id="family" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">--}}
{{--                <option value="0"  {{ $selectedFamily ? '' : 'selected' }}>Familia</option>--}}
{{--                @foreach ($familiesList as $category)--}}
{{--                    <optgroup label="{{ $category->Name }}">--}}
{{--                        @foreach ($category->families as $family)--}}
{{--                            <option value="{{ $family->FamilyId }}"--}}
{{--                                {{ $selectedFamily == $family->FamilyId ? 'selected' : '' }}>--}}
{{--                                {{ $family->Name }}--}}
{{--                            </option>--}}
{{--                @endforeach--}}
{{--                @endforeach--}}


{{--            </select>--}}
{{--            <select name="category" id="category" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">--}}
{{--                <option value="0"  {{ $selectedCategory ? '' : 'selected' }}>Depto</option>--}}
{{--                @foreach ($categoriesList as $category)--}}
{{--                    <option value="{{ $category->CategoryId }}"--}}
{{--                        {{ $selectedCategory == $category->CategoryId ? 'selected' : '' }}>--}}
{{--                        {{ $category->Name }}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--            <select id="presetSelect" onchange="applyDates2()" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">--}}
{{--                <option disabled selected>Fechas</option>--}}
{{--                <option value="year">Anual</option>--}}
{{--                <option value="summer">Verano</option>--}}
{{--                <option value="winter">Invierno</option>--}}
{{--                <option value="lastMonth">Mes Anterior</option>--}}
{{--                <option value="thisMonth">Este Mes</option>--}}
{{--                <option value="week">Semana</option>--}}
{{--                <option value="yesterday">Ayer</option>--}}
{{--                <option value="today">Hoy</option>--}}
{{--            </select>--}}
{{--            <input id="dates2" name="dates2" value="{{old('dates2')}}" class="block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />--}}
{{--            <input id="dates1" name="dates1" value="{{old('dates1')}}" class="block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />--}}
{{--            <button	type="submit" class="px-3 mt-1 py-1 text-sm text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">--}}
{{--                Buscar--}}
{{--            </button>--}}
{{--        </form>--}}
    </x-titlePage>

    <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
        <div class="rounded-lg">
            <!-- Gráfico de Ventas -->
            <div class="rounded-lg shadow-xs">
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
{{--                    <h3 class="text-center text-lg sm:text-xl font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400 my-2">--}}
{{--                        {{ 'Ventas' }}--}}
{{--                    </h3>--}}
                    <canvas height="300" id="sales-chart" class="w-full max-w-full"></canvas>
                </div>
            </div>

            <!-- Tabla de Familias -->
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mt-6 mb-6"> <!-- Ocupa 8/12 -->
                <table id="familiesTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-lg mb-6 border border-gray-200 dark:border-gray-700">
                    <thead>
                    <!-- Fila de cabeceras de años agrupadas -->
                    <tr class="text-xs font-semibold tracking-wide text-center text-gray-600 uppercase border-b dark:border-gray-700 bg-gray-100 dark:text-gray-300 dark:bg-gray-800">
                        <th class="px-4 py-2 border border-gray-300 dark:border-gray-600" rowspan="2">Familia</th>
                        <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 bg-green-50 dark:bg-gray-600 text-green-800 dark:text-green-200" rowspan="2">Total Venta</th>
                        <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 bg-amber-50 dark:bg-gray-600 text-amber-800 dark:text-amber-200" rowspan="2">Total Descuento</th>
                        <th class="px-4 py-2 text-xs border border-gray-300 dark:border-gray-600 bg-amber-50 dark:bg-gray-600 text-amber-800 dark:text-amber-200" rowspan="2">%</th>
                        @foreach($years as $year)
                            <th class="px-4 py-2 text-center border border-gray-300 dark:border-gray-600 border-b-0 th-center" colspan="4">
                                {{ $year }}
                            </th>
                        @endforeach
                    </tr>
                    <!-- Subfila para Venta/Descuento -->
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        @foreach($years as $year)
                            <th class="px-4 py-2 bg-blue-50 dark:bg-gray-700 text-blue-700 dark:text-blue-300 border-r-0 border-gray-300 dark:border-gray-600">
                                Venta
                            </th>
                            <th class="px-4 py-2 bg-blue-50 dark:bg-gray-700 text-blue-700 dark:text-blue-300 border-l-0 border-gray-300 dark:border-gray-600">
                                %
                            </th>
                            <th class="px-4 py-2 bg-red-50 dark:bg-gray-900 text-red-700 dark:text-red-300 border border-gray-300 dark:border-gray-600">
                                Descuento
                            </th>
                            <th class="px-4 py-2 text-xs bg-red-50 dark:bg-gray-900 text-red-700 dark:text-red-300 border border-gray-300 dark:border-gray-600">
                                %
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($familyRows as $family)
                        <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 font-medium border border-gray-200 dark:border-gray-700">{{ $family['Name'] }}</td>
                            <td class="px-4 py-3 font-semibold text-right border-r-0 border-gray-200 dark:border-gray-700 bg-green-50 dark:bg-gray-600 text-green-800 dark:text-green-200">
                                {{ number_format($family['Sale'],0) }}
                            </td>
                            <td class="px-4 py-3 font-semibold text-right border border-gray-200 dark:border-gray-700 bg-amber-50 dark:bg-gray-600 text-amber-800 dark:text-amber-200">
                                {{ number_format($family['Discount'],0) }}
                            </td>
                            <td class="px-4 py-3 text-xs text-right border border-gray-200 dark:border-gray-700 bg-amber-50 dark:bg-gray-600 text-amber-800 dark:text-amber-200">
                                {{ number_format($family['Total_discount_percentage']) }}%
                            </td>
                            @foreach($family['Years'] as $year)
                                <td class="px-4 py-3 text-right bg-blue-50 dark:bg-gray-700 text-blue-800 dark:text-blue-200 border-l border-gray-200 dark:border-gray-700">
                                    {{ number_format($year['Sale'],0) }}
                                </td>
                                <td class="px-4 py-3 text-xs text-right bg-blue-50 dark:bg-gray-700 text-blue-800 dark:text-blue-200 border-r border-gray-200 dark:border-gray-700">
                                    {{ number_format($year['sale_proportion'],0) }}%
                                </td>
                                <td class="px-4 py-3 text-right bg-red-50 dark:bg-gray-900 text-red-800 dark:text-red-200 border border-gray-200 dark:border-gray-700">
                                    {{ number_format($year['Discount'],0) }}</td>
                                @php $inventorySale = $year['Sale'] + $year['Discount']; @endphp
                                <td class="px-4 py-3 text-xs text-right bg-red-50 dark:bg-gray-900 text-red-800 dark:text-red-200 border border-gray-200 dark:border-gray-700">
                                    {{ number_format($year['discount_percentage'],0) }}%
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide uppercase border-t dark:border-gray-700 bg-gray-100 sm:grid-cols-9 dark:text-gray-300 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl border border-gray-200 dark:border-gray-700">Total</td>
                        <td class="px-4 py-3 font-bold text-xl text-right border-r-0 border-gray-200 dark:border-gray-700 bg-green-100 dark:bg-gray-600 text-green-900 dark:text-green-100">{{ number_format(0,0) }}</td>
                        <td class="px-4 py-3 font-bold text-xl text-right border border-gray-200 dark:border-gray-700 bg-amber-100 dark:bg-gray-600 text-amber-900 dark:text-amber-100">{{ number_format(0,0) }}</td>
                        <td class="px-4 py-3 font-bold text-right border border-gray-200 dark:border-gray-700 bg-amber-100 dark:bg-gray-600 text-amber-900 dark:text-amber-100">{{ number_format(0,0) }}%</td>
                        @foreach($years as $year)
                            <td class="px-4 py-3 font-bold text-xl text-right bg-blue-100 dark:bg-gray-700 border-r-0 border-gray-200 dark:border-gray-700 text-blue-900 dark:text-blue-100">{{ number_format(0,0) }}</td>
                            <td class="px-4 py-3 font-bold text-right bg-blue-100 dark:bg-gray-700 border-l-0 border-gray-200 dark:border-gray-700 text-blue-900 dark:text-blue-100">{{ number_format(0,0) }}</td>
                            <td class="px-4 py-3 font-bold text-xl text-right bg-red-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-red-900 dark:text-red-100">{{ number_format(0,0) }}</td>
                            <td class="px-4 py-3 font-bold text-right bg-red-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-red-900 dark:text-red-100">{{ number_format(0,0) }}%</td>
                        @endforeach
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- termina Tabla de Familias -->
            <!-- Tabla de Sucursales -->
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mt-6 mb-6"> <!-- Ocupa 8/12 -->
                <table id="branchesTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Sucursal</th>
                        <th class="px-4 py-3">Total</th>
                        @foreach($years as $year)
                            <th class="px-4 py-3">{{$year}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($branchRows as $branch)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{ $branch['Name'] }}</td>
                            <td class="px-4 py-3">{{ number_format($branch['Sale'],0) }}</td>
                            @foreach($branch['Years'] as $year)
                                <td class="px-4 py-3">{{ number_format($year['Sale'],0) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ 0 }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ 0 }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ 0 }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ 0 }} </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- termina Tabla de Sucursales -->


        </div>
    </div>



</x-layout>

<link rel="stylesheet" href="{{ asset('flatpickr/dark.css') }}">
<script src="{{ asset('flatpickr/flatpickr.js') }}"></script>

<script>
    const chartData = @json($chartData);
    //Chart.register(window['chartjs-plugin-colors']);

    const ctx = document.getElementById('sales-chart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Ventas y Descuentos por Semana'
                }
            },
            scales: {
                x: {
                    ticks: {
                        display: false
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
<script>
    $('#familiesTable').DataTable({
        paging:true,
        searching: true,
        info: false,
        "lenghtChange": false,
        "order": [[1, "desc"]],
    });
    $('#branchesTable').DataTable({
        paging:false,
        searching: false,
        info: false,
        "lenghtChange": false,
        "order": [[1, "desc"]],
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
    #familiesTable_wrapper .dt-input {
        color: #c4c4c4; /* Color similar a gray-400 */
    }
    #branchesTable_wrapper .dt-input {
        color: #c4c4c4; /* Color similar a gray-400 */
    }
    .dt-text-left {
        text-align: left !important;
    }
    .th.th-center {
        text-align: center !important;
    }
</style>


