<x-layout>	
	@if(session('banner'))
	<x-banner message="{{session('banner.message')}}" type="success" class=""/>
	@endif
    {{-- Encabezado con título y espacio para dropdowns --}}
	<x-titlePage title="Reporte de ventas de {{$selectedCategory->Name ?? ''}}">
		<form action ="/salesyearoy" method="GET" class="flex space-x-4 justify-end">				
			<select id="dropdown" name="category" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
				<option>Departamento</option>					
				@foreach ($categories as $category)						
				<option {{ ($selectedCategory->CategoryId ?? null) == $category->CategoryId ? 'selected' : '' }}						
				value="{{$category->CategoryId}}">{{$category->Name}}</option>
				@endforeach
			</select>
			{{-- <input id="datess" class="text-xs px-2 border border-gray-600 dark:bg-gray-700 form-input text-white rounded-md" placeholder="Fechas" /> --}}
			<input id="dates" name="dates" value="{{old('dates')}}" class="block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />
			<button	type="submit" class="px-3 mt-1 py-1 text-sm text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
				Buscar
			</button>
		</form>
	</x-titlePage>
	
	<div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
		<div class="rounded-lg">
			
			<div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
				<canvas id="bars_salesYoy"></canvas>
			</div>
			
			<div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
				<table id="table" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
					<thead>
						<tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
							<th class="px-4 py-3">Familia</th>
							<th class="px-4 py-3">Venta 2024</th>
							<th class="px-4 py-3">% v23</th>
							<th class="px-4 py-3">% v22</th>
							<th class="px-4 py-3">Venta 2023</th>							
							<th class="px-4 py-3">Venta 2022</th>
							<th class="px-4 py-3">Compra 2024</th>
							<th class="px-4 py-3 text-center">% C/V</th>
							<th class="px-4 py-3">Compra 2023</th>
							<th class="px-4 py-3 text-center">% C/V</th>						
							<th class="px-4 py-3">Compra 2022</th>
							<th class="px-4 py-3 text-center">% C/V</th>						
						</tr>
					</thead>
					<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
						@foreach ($amounts as $family)
							
						<tr class="text-gray-700 dark:text-gray-400">
							<td class="px-4 py-3">{{ $family['name'] }}</td>
							<td class="px-4 py-3">{{ $family['sale0'] }}</td>
							<td class="px-4 py-3">
								<x-percentageButton :value="$family['relation0vs1']" above="green" below="red" min="90" max="90" />
							</td>
							<td class="px-4 py-3">
								<x-percentageButton :value="$family['relation0vs2']" above="green" below="red" min="90" max="90" />
							</td>
							<td class="px-4 py-3">{{ $family['sale1'] }}</td>
							<td class="px-4 py-3">{{ $family['sale2'] }}</td>								
							<td class="px-4 py-3">{{ $family['purchase0'] }}</td>
							<td class="px-4 py-3 text-center">
								<x-percentageButton :value="$family['relation0']" above="red" below="green" min="30" max="50" />
							</td>
							<td class="px-4 py-3">{{ $family['purchase1'] }}</td>
							<td class="px-4 py-3 text-center">
								<x-percentageButton :value="$family['relation1']" above="red" below="green" min="30" max="50" />
							</td>							
							<td class="px-4 py-3">{{ $family['purchase2'] }}</td>								
							<td class="px-4 py-3 text-center">
								<x-percentageButton :value="$family['relation2']" above="red" below="green" min="30" max="50" />
							</td>
						</tr>
						@endforeach							
					</tbody>
					<tfoot>
				
						<tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
							<td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>		
							<td class="px-4 py-3 text-xl font-bold"> {{$totalSales['sale0']}} </td>
							<td class="px-4 py-3 text-xl font-bold">
								<x-percentageButton :value="$totalSales['relation0vs1']" above="red" below="green" min="30" max="50" size="xl"/>
							</td>
							<td class="px-4 py-3 text-xl font-bold">
								<x-percentageButton :value="$totalSales['relation0vs1']" above="red" below="green" min="30" max="50" size="xl"/>
							</td>
							<td class="px-4 py-3 text-xl font-bold"> {{$totalSales['sale1']}} </td>
							<td class="px-4 py-3 text-xl font-bold"> {{$totalSales['sale2']}} </td>
							<td class="px-4 py-3 text-xl font-bold">{{$totalPurchase['purchase0']}}</td>
							<td class="px-4 py-3 text-xl font-bold">
								<x-percentageButton :value="$totalPurchase['relation0']" above="red" below="green" min="30" max="50" size="xl"/>
							</td>
							<td class="px-4 py-3 text-xl font-bold">{{$totalPurchase['purchase1']}}</td>
							<td class="px-4 py-3 text-xl font-bold">
								<x-percentageButton :value="$totalPurchase['relation1']" above="red" below="green" min="30" max="50" size="xl"/>
							</td>							
							<td class="px-4 py-3 text-xl font-bold">{{$totalPurchase['purchase2']}}</td>
							<td class="px-4 py-3 text-xl font-bold">
								<x-percentageButton :value="$totalPurchase['relation2']" above="red" below="green" min="30" max="50" size="xl"/>
							</td>							
						</tr>
					</tfoot>
				</table>
			</div>
				
				{{-- End Table --}}
			</div>
		</div>
	</div>
	
	
	
</x-layout>

<link rel="stylesheet" href="{{ asset('flatpickr/dark.css') }}">
<script src="{{ asset('flatpickr/flatpickr.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
	const data = @json($amounts);
	const labels = data.map(item => item.name);	
	const sale0 = data.map(item => parseInt(item.sale0.replace(/,/g, ''))); // Convertir a número
	const sale1 = data.map(item => parseInt(item.sale1.replace(/,/g, ''))); // Convertir a número
	const sale2 = data.map(item => parseInt(item.sale2.replace(/,/g, '')));
	const purchase0 = data.map(item => parseInt(item.purchase0.replace(/,/g, ''))); // Convertir a número
	const purchase1 = data.map(item => parseInt(item.purchase1.replace(/,/g, ''))); // Convertir a número
	const purchase2 = data.map(item => parseInt(item.purchase2.replace(/,/g, '')));
	
	const barConfig = {
		type: 'bar',
		data: {
			labels: labels,
			datasets: [
			{
				type: 'line',
				label: 'Compra 2022',				
				borderColor: 'rgba(28, 100, 242,1)',				
				borderWidth: 2,
				borderRadius: 5,
				data: purchase2,
				hidden: true
			},
			{
				type: 'line',
				label: 'Compra 2023',				
				borderColor: 'rgba(126, 58, 242, 1)',				
				borderWidth: 1,
				borderRadius: 5,
				data: purchase1,
				hidden: true,
			},
			{
				type: 'line',
				label: 'Compra 2024',				
				borderColor: 'rgba(6, 148, 162, 1)',        
				borderWidth: 2,
				borderRadius: 5,
				data: purchase0,				
			},
			{
				label: 'Venta 2022',
				backgroundColor: 'rgba(28, 100, 242, 0.5)',
				borderColor: 'rgba(28, 100, 242,1)',				
				borderWidth: 2,
				borderRadius: 5,
				data: sale2,
			},
			{
				label: 'Venta 2023',
				backgroundColor: 'rgba(126, 58, 242, 0.5)',				
				borderColor: 'rgba(126, 58, 242, 1)',				
				borderWidth: 2,
				borderRadius: 5,
				data: sale1,
			},
			{
				label: 'Venta 2024',
				backgroundColor: 'rgba(6, 148, 162, 0.5)',        
				borderColor: 'rgba(6, 148, 162, 1)',        
				borderWidth: 2,
				borderRadius: 5,
				data: sale0,				
			},
			],
		},
		options: {
			responsive: true,
			legend: {
				display: false,
			},
		},
	}
	
	const barsCtx = document.getElementById('bars_salesYoy')
	window.myBar = new Chart(barsCtx, barConfig)	
	
	const datesInput = document.getElementById('dates');                
	flatpickr(datesInput, {
		// plugins: [new rangePlugin({ input: endInput })],
		dateFormat: "Y-m-d",
		mode: "range",
		onReady: function(selectedDates, dateStr, instance) {
			// Establecer el valor si ya existe uno seleccionado en la base de datos
			const selectedDate = "{{ $selectedDate }}"; // Recoges esto desde el backend
			if (selectedDate) {
				instance.setDate(selectedDate);
			}
		},
	});

	$('#table').DataTable({
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