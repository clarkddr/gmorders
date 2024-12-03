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
        @php
            $selectedCategory = request('category', old('category'));
        @endphp
	<x-titlePage title="Reporte de ventas {{$selectedCategory->name ?? ''}}">
		<form action ="/saleandpurchase" method="GET" class="flex space-x-4 justify-end">
            <select id="presetSelect" onchange="applyDates2()" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option disabled selected>Fechas</option>
                <option value="year">Anual</option>
                <option value="lastMonth">Mes Anterior</option>
                <option value="thisMonth">Este Mes</option>
                <option value="week">Semana</option>
                <option value="yesterday">Ayer</option>
                <option value="today">Hoy</option>
            </select>
            <select name="category" id="category" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option value="0"  {{ $selectedCategory ? '' : 'selected' }}>Departamento</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->CategoryId }}"
                        {{ $selectedCategory == $category->CategoryId ? 'selected' : '' }}>
                        {{ $category->Name }}
                    </option>
                @endforeach
            </select>
			<input id="dates2" name="dates2" value="{{old('dates2')}}" class="block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />
			<input id="dates1" name="dates1" value="{{old('dates1')}}" class="block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />
			<button	type="submit" class="px-3 mt-1 py-1 text-sm text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
				Buscar
			</button>
		</form>
	</x-titlePage>

	<div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
		<div class="rounded-lg">
			<div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
				<table id="familiesTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
					<thead>
						<tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
							<th class="px-4 py-3">Familia</th>
							<th class="px-4 py-3">Venta Periodo 1</th>
							<th class="px-4 py-3">Venta Periodo 2</th>
							<th class="px-4 py-3">%</th>
							<th class="px-4 py-3">Compra Periodo 1</th>
							<th class="px-4 py-3">Compra Periodo 2</th>
							<th class="px-4 py-3">%</th>

						</tr>
					</thead>
					<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($families as $family)
						<tr class="text-gray-700 dark:text-gray-400">
							<td class="px-4 py-3">{{ $family['name'] }}</td>
							<td class="px-4 py-3">{{ $family['sale2'] }}</td>
							<td class="px-4 py-3">{{ $family['sale1'] }}</td>
							<td class="px-4 py-3">
                                <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$family['saleRelation']" />
                            </td>

							<td class="px-4 py-3">{{ $family['purchase2'] }}</td>
							<td class="px-4 py-3">{{ $family['purchase1'] }}</td>
							<td class="px-4 py-3">
                                <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$family['purchaseRelation']" />
                            </td>
						</tr>
                        @endforeach
					</tbody>
					<tfoot class="dark:divide-gray-700">
						<tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
							<td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
							<td class="px-4 py-3 font-bold text-xl"> {{ $totals['sale2'] }} </td>
							<td class="px-4 py-3 font-bold text-xl"> {{ $totals['sale1'] }} </td>
							<td class="px-4 py-3 font-bold text-xl">
                                <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$totals['saleRelation']" size="xl"/>
                            </td>
							<td class="px-4 py-3 font-bold text-xl"> {{ $totals['purchase2'] }} </td>
							<td class="px-4 py-3 font-bold text-xl"> {{ $totals['purchase1'] }} </td>
                            <td class="px-4 py-3 font-bold text-xl">
                                <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$totals['purchaseRelation']" size="xl"/>
                            </td>

						</tr>
					</tfoot>
				</table>
			</div>

            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
                <table id="branchesTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Sucursal</th>
                        <th class="px-4 py-3">Venta Periodo 1</th>
                        <th class="px-4 py-3">Venta Periodo 2</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">Compra Periodo 1</th>
                        <th class="px-4 py-3">Compra Periodo 2</th>
                        <th class="px-4 py-3">%</th>

                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($branches as $branch)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{ $branch['name'] }}</td>
                            <td class="px-4 py-3">{{ $branch['sale2'] }}</td>
                            <td class="px-4 py-3">{{ $branch['sale1'] }}</td>
                            <td class="px-4 py-3">
                                <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$branch['saleRelation']" />
                            </td>

                            <td class="px-4 py-3">{{ $branch['purchase2'] }}</td>
                            <td class="px-4 py-3">{{ $branch['purchase1'] }}</td>
                            <td class="px-4 py-3">
                                <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$branch['purchaseRelation']" />
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $totals['sale2'] }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $totals['sale1'] }} </td>
                        <td class="px-4 py-3 font-bold text-xl">
                            <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$totals['saleRelation']" size="xl"/>
                        </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $totals['purchase2'] }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $totals['purchase1'] }} </td>
                        <td class="px-4 py-3 font-bold text-xl">
                            <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$totals['purchaseRelation']" size="xl"/>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
                <table id="suppliersTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Proveedor</th>
                        <th class="px-4 py-3">Venta Periodo 1</th>
                        <th class="px-4 py-3">Venta Periodo 2</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">Compra Periodo 1</th>
                        <th class="px-4 py-3">Compra Periodo 2</th>
                        <th class="px-4 py-3">%</th>

                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($suppliers as $supplier)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{ $supplier['name'] }}</td>
                            <td class="px-4 py-3">{{ $supplier['sale2'] }}</td>
                            <td class="px-4 py-3">{{ $supplier['sale1'] }}</td>
                            <td class="px-4 py-3">
                                <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$supplier['saleRelation']" />
                            </td>

                            <td class="px-4 py-3">{{ $supplier['purchase2'] }}</td>
                            <td class="px-4 py-3">{{ $supplier['purchase1'] }}</td>
                            <td class="px-4 py-3">
                                <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$supplier['purchaseRelation']" />
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $totals['sale2'] }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $totals['sale1'] }} </td>
                        <td class="px-4 py-3 font-bold text-xl">
                            <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$totals['saleRelation']" size="xl"/>
                        </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $totals['purchase2'] }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $totals['purchase1'] }} </td>
                        <td class="px-4 py-3 font-bold text-xl">
                            <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$totals['purchaseRelation']" size="xl"/>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

		</div>
	</div>



</x-layout>

<link rel="stylesheet" href="{{ asset('flatpickr/dark.css') }}">
<script src="{{ asset('flatpickr/flatpickr.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

	const datesInput1 = document.getElementById('dates1');
	const flatpickr1 = flatpickr(datesInput1, {
		// plugins: [new rangePlugin({ input: endInput })],
		dateFormat: "Y-m-d",
		mode: "range",
        altInput: true,
        altFormat: "d M y",
        locale: {firstDayOfWeek: 1},
		onReady: function(selectedDates1, dateStr, instance) {
			// Establecer el valor si ya existe uno seleccionado en la base de datos
			const selectedDate1 = "{{ $selectedDate1 }}"; // Recoges esto desde el backend
			if (selectedDate1) {
				instance.setDate(selectedDate1);
			}
		},
	});
	const datesInput2 = document.getElementById('dates2');
	const flatpickr2 = flatpickr(datesInput2, {
		// plugins: [new rangePlugin({ input: endInput })],
		dateFormat: "Y-m-d",
		mode: "range",
        altInput: true,
        altFormat: "d M y",
        locale: {firstDayOfWeek: 1},
        onReady: function(selectedDates2, dateStr, instance) {
            // Establecer el valor si ya existe uno seleccionado en la base de datos
            const selectedDate2 = "{{ $selectedDate2 }}"; // Recoges esto desde el backend
            if (selectedDate2) {
                instance.setDate(selectedDate2);
            }
        },
	});

    const applyDates2 = () => {
        const select = document.getElementById("presetSelect");
        const selectedValue = select.value;
        if (selectedValue === "today") {
            const today = "{{$dates['today']}}";
            const todaySameWeekdayLastYear = "{{$dates['todaySameWeekdayLastYear']}}";
            flatpickr1.setDate([todaySameWeekdayLastYear, todaySameWeekdayLastYear]);
            flatpickr2.setDate([today, today]);
        }
        if (selectedValue === "yesterday") {
            const yesterday = "{{$dates['yesterday']}}";
            const sameWeekdayLastYear = "{{$dates['sameWeekdayLastYear']}}";
            flatpickr1.setDate([sameWeekdayLastYear, sameWeekdayLastYear]);
            flatpickr2.setDate([yesterday, yesterday]);
        }
        if (selectedValue === "thisMonth") {
            const thisMonthInitial = "{{$dates['thisMonthInitial']}}";
            const yesterday = "{{$dates['yesterday']}}";
            const thisMonthInitialLastYear = "{{$dates['thisMonthInitialLastYear']}}";
            const yesterdayLastYear = "{{$dates['yesterdayLastYear']}}";
            flatpickr1.setDate([thisMonthInitialLastYear, yesterdayLastYear]);
            flatpickr2.setDate([thisMonthInitial, yesterday]);
        }
        if (selectedValue === "lastMonth") {
            const lastMonthInitial = "{{$dates['lastMonthInitial']}}";
            const lastMonthEnd = "{{$dates['lastMonthEnd']}}";
            const lastMonthInitialLastYear = "{{$dates['lastMonthInitialLastYear']}}";
            const lastMonthEndLastYear = "{{$dates['lastMonthEndLastYear']}}";
            flatpickr1.setDate([lastMonthInitialLastYear, lastMonthEndLastYear]);
            flatpickr2.setDate([lastMonthInitial, lastMonthEnd]);
        }
        if (selectedValue === "week") {
            const yesterday = "{{$dates['yesterday']}}";
            const initialWeekday = "{{$dates['initialWeekday']}}";
            const initialWeekdayLastYear = "{{$dates['initialWeekdayLastYear']}}";
            const finalWeekdayLastYear = "{{$dates['finalWeekdayLastYear']}}";
            flatpickr1.setDate([initialWeekdayLastYear, finalWeekdayLastYear]);
            flatpickr2.setDate([initialWeekday,yesterday]);
        }
        if (selectedValue === "year") {
            const yesterday = "{{$dates['yesterday']}}";
            const initialYear = "{{$dates['initialYear']}}";
            const initialLastYear = "{{$dates['initialLastYear']}}";
            const finalLastYear = "{{$dates['finalLastYear']}}";
            flatpickr1.setDate([initialLastYear, finalLastYear]);
            flatpickr2.setDate([initialYear,yesterday]);
        }
    };
    // Registrar la función en el ámbito global
    window.applyDates2 = applyDates2;

	$('#familiesTable').DataTable({
        paging:true,
        searching: false,
        info: false,
        // language: {
        //     url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
        // },
        "lenghtChange": false,
		"order": [[]],
		"columnDefs": [{/*"targets": 3, "orderable": false,*/}]
	});
    $('#branchesTable').DataTable({
		dom: 't',
		paging:false,
		searching: false,
		info: false,
        "lenghtChange": false,
		"order": [[]],
		"columnDefs": [{
			//"targets": 3, "orderable": false,
		}]
	});
    $('#suppliersTable').DataTable({
		// dom: 't',
		paging:true,
		searching: false,
		info: false,
        // language: {
        //     url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
        // },
        "lenghtChange": false,
		"order": [[]],
		"columnDefs": [

		]
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
    #familiesTable_wrapper .dt-input {
        color: #c4c4c4; /* Color similar a gray-400 */
    }
    #suppliersTable_wrapper .dt-input {
        color: #c4c4c4; /* Color similar a gray-400 */
    }

</style>
