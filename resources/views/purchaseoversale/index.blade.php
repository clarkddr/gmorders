<x-layout>
	@if(session('banner'))
	<x-banner message="{{session('banner.message')}}" type="success" class=""/>
	@endif
	{{-- Encabezado con título y espacio para dropdowns --}}
	<x-titlePage title="Reporte de Ventas vs Compras por Familia{{''}}">
		<form action ="/purchaseoversale" method="GET" class="flex flex-col md:flex-row md:space-x-4 justify-end">
			<div class="flex items-center space-x-2">
				<label for="goal" class="text-sm dark:text-gray-300">Meta</label>
				<input id="goal" name="goal" value="{{old('goal', $vars['goal'])}}" placeholder="Meta"
				class="w-16 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 form-input
					   border-gray-300 focus:border-gray-400 focus:outline-none focus:shadow-outline-gray dark:focus:shadow-outline-gray" />
			</div>
			<div class="flex items-center space-x-2">
				<label for="tc" class="text-sm dark:text-gray-300">TC</label>
				<input id="tc" name="tc" value="{{old('tc', $vars['tc'])}}" placeholder="TC"
				class="w-16 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input
					   bg-gray-100 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
			</div>
			<div class="flex items-center space-x-2">
				<label for="max" class="text-sm dark:text-gray-300">Max</label>
				<input id="max" name="max" value="{{old('max', $vars['max'])}}" placeholder="Maximo"
				class="w-12 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input
					   bg-gray-100 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
			</div>
			<div class="flex items-center space-x-2">
				<label for="min" class="text-sm dark:text-gray-300">Min</label>
				<input id="min" name="min" value="{{old('min', $vars['min'])}}" placeholder="Minimo"
				class="w-12 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input
					   bg-gray-100 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
			</div>
			<div class="flex items-center space-x-2">
                <select id="presetSelect" onchange="applyDates()" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option disabled selected>Fechas</option>
                </select>
				<input id="dates1" name="dates1" value="{{old('dates1')}}" class="bg-gray-100 block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />
			</div>
			<button	type="submit" class="px-3 mt-1 py-1 text-sm text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-blue focus:shadow-outline-blue">
				Buscar
			</button>
		</form>
	</x-titlePage>

	@if ($categories->count() > 0)
	<div class="grid gap-6 mb-2 md:grid-cols-2 xl:grid-cols-4">
		<!-- Card -->
		<div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
			<div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
				<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
					<path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"	clip-rule="evenodd"></path>
				</svg>
			</div>
			<div>
				<p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
					Ventas
				</p>
				<p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
					{{$grandTotal['sale']}}
				</p>
			</div>
		</div>
	<!-- Card -->
		<div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
			<div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
				<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
					<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
				</svg>
			</div>
			<div>
				<p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
					Compras
				</p>
				<p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
					{{$grandTotal['purchaseCost']}}
				</p>
			</div>
		</div>
		<!-- Card -->
		<div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
			<div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
					<path stroke-linecap="round" stroke-linejoin="round" d="m8.99 14.993 6-6m6 3.001c0 1.268-.63 2.39-1.593 3.069a3.746 3.746 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043 3.745 3.745 0 0 1-3.068 1.593c-1.268 0-2.39-.63-3.068-1.593a3.745 3.745 0 0 1-3.296-1.043 3.746 3.746 0 0 1-1.043-3.297 3.746 3.746 0 0 1-1.593-3.068c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 0 1 1.043-3.297 3.745 3.745 0 0 1 3.296-1.042 3.745 3.745 0 0 1 3.068-1.594c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.297 3.746 3.746 0 0 1 1.593 3.068ZM9.74 9.743h.008v.007H9.74v-.007Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
				  </svg>
			</div>
			<div>
				<p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400" >
				Compra vs Venta
				</p>
				<p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
				{{$grandTotal['relation']}}%
				</p>
			</div>
		</div>

		<!-- Card -->
		<div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
			<div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
					<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
				  </svg>
			</div>
			<div>
				<p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
					Por Comprar Dlls
				</p>
				<p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
					{{ $grandTotal['toPurchaseDlls']}}
				</p>
			</div>
		</div>
	</div>


<div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
	<div class="rounded-lg">
		@foreach ($categories as $category)
		<h2 class="text-xl font-semibold tracking-wide text-left text-gray-500 uppercase dark:text-gray-400 mb-2">{{ $category['name'] }}</h2>
		<div class="grid grid-cols-2 gap-4 rounded-lg shadow-xs mb-4">
			<div class="min-w-0 p-4 h-96 bg-white rounded-lg shadow-xs dark:bg-gray-800">
				<h3 class="text-center text-lg font-semibold tracking-wide text-left text-gray-500 uppercase dark:text-gray-400 my-1">{{ 'Compra vs Venta %' }}</h3>
				<canvas id="relation-chart-{{$category['id']}}" class=""></canvas>
			</div> <!-- Ocupa 8/12 -->
			<div class="min-w-0 p-4 h-96 bg-white rounded-lg shadow-xs dark:bg-gray-800">
				<h3 class="flext text-center text-lg font-semibold tracking-wide text-left text-gray-500 uppercase dark:text-gray-400 my-1">{{ 'Compra vs Venta $' }}</h3>
				<canvas id="salepurchase-chart-{{$category['id']}}" class=""></canvas>
			</div> <!-- Ocupa 8/12 -->

		</div>

		<div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
			<table id="table{{$category['id']}}" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
				<thead>
					<tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
						<th class="px-4 py-3">Familia</th>
						<th class="px-4 py-3">Venta</th>
						<th class="px-4 py-3">Compra Costo</th>
						<th class="px-4 py-3">Compra P.Venta</th>
						<th class="px-4 py-3">C/V%</th>
						<th class="px-4 py-3">Margen</th>
						<th class="px-4 py-3">Por Comprar Dlls</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
					@foreach ( $category['families'] as $family)
					<tr class="text-gray-700 dark:text-gray-400">
						<td class="px-4 py-3">
							<a href="{{route('purchaseoversale.show',[$family['familyId'],'goal'=>$vars['goal'], 'tc'=>$vars['tc'], 'max'=>$vars['max'], 'min'=>$vars['min'], 'dates'=>$selectedDate1])}}" class="text-blue-600 hover:underline">
								{{$family['name']}}
							</a>
						</td>
						<td class="px-4 py-3">{{ $family['sale'] }}</td>
						<td class="px-4 py-3">{{ $family['purchaseCost'] }}</td>
						<td class="px-4 py-3">{{ $family['purchaseSale'] }}</td>
						<td class="px-4 py-3">
							<x-percentageButton below="green" above="red" :min="$vars['min']" :max="$vars['max']" :value="$family['relation']" />
						</td>
						<td class="px-4 py-3 text-sm">{{ $family['margin'] }}</td>
						<td class="px-4 py-3 text-sm">{{ $family['toPurchaseDlls'] }}</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot class="dark:divide-gray-700">
					<tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
						<td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
						<td class="px-4 py-3 font-bold text-xl"> {{ $category['sale'] }} </td>
						<td class="px-4 py-3 font-bold text-xl"> {{ $category['purchaseCost'] }} </td>
						<td class="px-4 py-3 font-bold text-xl"> {{ $category['purchaseSale'] }} </td>
						<td class="px-4 py-3 font-bold text-xl">
							<x-percentageButton size="xl" below="green" above="red" :min="$vars['min']" :max="$vars['max']" :value="$category['relation']" /></td>
							<td class="px-4 py-3 font-bold text-xl"> {{ $category['margin'] }} </td>
							<td class="px-4 py-3 font-bold text-xl"> {{ $category['toPurchaseDlls'] }} </td>
						</tr>
					</tfoot>
				</table>

			</div>

			@endforeach
			@endif

		</div>
	</div>
</div>



</x-layout>

<link rel="stylesheet" href="{{ asset('flatpickr/dark.css') }}">
<script src="{{ asset('flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('js/dateRanges.js') }}"></script>
<script> // Definimos las variables que pasaremos al script de DateRanges
    window.selectedDate1 = @json($selectedDate1);
    window.dates = @json($dates);
</script>


<script>
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
        const tableId = table.id;
        $(`#${tableId}`).DataTable({
            dom: 't',
            paging:false,
            searching: false,
            info: false,
            lenghtChange: false,
            "order": [[]],
            "columnDefs": [{
                //"targets": 3, "orderable": false,
            }]
        });
    });
</script>

<script>
	document.addEventListener('DOMContentLoaded', function () {

		chartData = @json($categories);
		const annotationValue = @json($vars['goal']);

		// Función para obtener el color dependiendo de la comparación con la línea de anotación
		const getBarColor = (value) => {
			return Number(value) < Number(annotationValue) ? 'rgba(255, 99, 132, 0.8)' : 'rgba(28, 100, 242, 0.8)'; // Rojo si está por debajo, azul si no
		};
		const getBorderColor = (value) => {
			return Number(value) < Number(annotationValue) ? 'rgba(255, 99, 132, 0.9)' : 'rgba(28, 100, 242, 0.9)'; // Rojo si está por debajo, azul si no
		};

		chartData.forEach(category => {
			const relationcanvasId = `relation-chart-${category.id}`;
			const salepurchasecanvasId = `salepurchase-chart-${category.id}`;
			const relationCtx = document.getElementById(relationcanvasId).getContext('2d');
			const salepurchaseCtx = document.getElementById(salepurchasecanvasId).getContext('2d');

			const relationConfig = {
				type: 'bar',
				data: {
					labels: category.families.map(family => family.name),
					datasets: [
					{
						label: 'Ventas',
						// Aplica el color dinámicamente para cada barra
						// backgroundColor: relation.map(value => getBarColor(value)),
						backgroundColor: category.families.map(family=> getBarColor(family.relation)),
						borderColor: category.families.map(family=> getBorderColor(family.relation)),
						// borderColor: relation.map(value => getBorderColor(value)),
						borderWidth: 2,
						data: category.families.map(family=>family.relation),
						borderRadius: 5,
						// barThickness: 35,
						// Habilitar el plugin para mostrar las etiquetas
						datalabels: {
							anchor: 'start', // Coloca las etiquetas al final de las barras
							align: 'top', // Alineación en la parte superior de las barras
							color: 'white', // Color gray-500 de tailwind
							font: {
								// weight: 'bold', // Estilo de fuente
								size: 12, // Tamaño de la fuente
							},
							formatter: function(value) {
								return (value * 1).toFixed(0) + '%'; // Convierte a porcentaje
							},
							offset: 10 // Mover las etiquetas hacia abajo para evitar que se encimen con las leyendas del eje x
						}
					},
					],
				},
				options: {
					responsive: true,
					scales: {
						y: {
							beginAtZero: true,
							ticks: {
								callback: function(value) {
									return (value * 1).toFixed(0) + '%'; // Convierte a porcentaje
								}
							}
						},
						x: {
							type: 'category',
							labels: category.families.map(family => family.name),
							position: 'bottom', // Asegura que las etiquetas se alineen correctamente
							stacked: false,
						},
					},
					plugins: {
						// Habilitar el plugin de datos
						datalabels: {
							display: true,
							align: 'top', // Alineación en la parte superior de las barras
							font: {
								// weight: 'bold',
								size: 12,
							},
							color: 'white', // Color de las etiquetas (blanco)
							formatter: function(value) {
								return value.toFixed(2); // Formatear los valores a 2 decimales
							},
							offset: 10 // Mover las etiquetas hacia abajo para evitar que se encimen con las leyendas del eje x
						},
						annotation: {
							annotations: [
							{
								type: 'line',
								mode: 'horizontal',
								scaleID: 'y',
								value: annotationValue,
								borderColor: 'rgba(255, 99, 132, 0.8)', // Color de la linea roja suave (compatible con dark mode y light mode)
								borderWidth: 2,
							}
							],
						},
						legend: {
							display: false,
						},
					},
				},
				// Habilitar el plugin datalabels globalmente
				plugins: [ChartDataLabels]
			};


			const sale = category.families.map(family => parseInt(family.sale.replace(/,/g, ''))); // Convertir a número
			const purchase = category.families.map(family => parseInt(family.purchaseCost.replace(/,/g, ''))); // Convertir a número

			const salepurchaseConfig = {
				type: 'bar',
				data: {
					labels: category.families.map(family => family.name),
					datasets: [
					{
						label: 'Ventas',
						backgroundColor: 'rgba(28, 100, 242, 0.3)',
						borderColor: 'rgba(28, 100, 242, 0.8)',
						borderWidth: 2,
						data: sale,
						borderRadius: 5,
					},
					{
						label: 'Compras',
						type: 'line',
						backgroundColor: 'rgba(52, 211, 153, 0.3)',
						borderColor: 'rgba(52, 211, 153, 0.8)',
						borderWidth: 2,
						data: purchase,
						borderRadius: 5,
					},
					],
				},
				options: {
					responsive: true,
					scales: {
						y: {
							beginAtZero: true,
						},
						x: {
							type: 'category',
							labels: category.families.map(family => family.name),
							position: 'bottom', // Asegura que las etiquetas se alineen correctamente
							stacked: false,
						},
					},
					plugins: {
						legend: {
							display: false,
						},
					},
				},


			};

			new Chart(relationCtx, relationConfig);
			new Chart(salepurchaseCtx, salepurchaseConfig);
		});
	});

</script>
<style>
	div.dt-container div.dt-layout-row {
		margin: 0 !important;
	}
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
</style>
