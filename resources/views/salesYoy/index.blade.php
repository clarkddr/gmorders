<x-layout>	
	@if(session('banner'))
	<x-banner message="{{session('banner.message')}}" type="success" class=""/>
	@endif
    {{-- Encabezado con título y espacio para dropdowns --}}
    <div class="w-full p-4  shadow mb-4 flex justify-between items-center dark:bg-gray-800 rounded-lg">
        <h1 class="text-3xl font-semibold text-white ">Reporte de Ventas {{ $selectedCategory->Name ?? '' }} </h1>
        <div class="flex space-x-4">
            {{-- Aquí puedes agregar los dropdowns que necesites --}}
			<form action ="/getsalesyearoy" method="GET" class="flex space-x-4 justify-end">				
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
		</div>
			
    </div>
	
	<div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
		<div class="rounded-lg">
			<div class="grid gap-6 mb-8 md:grid-cols-8">
				{{-- bars Chart --}}
				<div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 md:col-span-5"> <!-- Ocupa 8/12 -->
					<canvas id="bars_salesYoy"></canvas>
				</div>
				{{-- End bars --}}
				{{-- Table --}}
				<div class="md:col-span-3"> <!-- Ocupa 4/12 -->
					<table id="table" class="py-0 w-full whitespace-no-wrap mx-0">
						<thead>
							<tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
								<th class="px-4 py-3">Familia</th>
								<th class="px-4 py-3">2024</th>
								<th class="px-4 py-3">2023</th>
								<th class="px-4 py-3">2022</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
							@foreach ($sales as $family)
								
							<tr class="text-gray-700 dark:text-gray-400">
								<td class="px-4 py-3">{{ $family['name'] }}</td>
								<td class="px-4 py-3">{{ $family['sale0'] }}</td>
								<td class="px-4 py-3">{{ $family['sale1'] }}</td>
								<td class="px-4 py-3">{{ $family['sale2'] }}</td>								
							</tr>
							@endforeach							
						</tbody>
						<tfoot>
					
							<tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
								<td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>		
								<td class="px-4 py-3 text-xl font-bold">
									{{$totalSales['sale0']}}
								</td>
								<td class="px-4 py-3 text-xl font-bold">
									{{$totalSales['sale1']}}
								</td>
								<td class="px-4 py-3 text-xl font-bold">
									{{$totalSales['sale2']}}
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

<script>
document.addEventListener('DOMContentLoaded', function () {
	const salesData = @json($sales);
	const labels = salesData.map(item => item.name);	
	const sale0 = salesData.map(item => parseInt(item.sale0.replace(/,/g, ''))); // Convertir a número
	const sale1 = salesData.map(item => parseInt(item.sale1.replace(/,/g, ''))); // Convertir a número
	const sale2 = salesData.map(item => parseInt(item.sale2.replace(/,/g, '')));
	
	const barConfig = {
		type: 'bar',
		data: {
			labels: labels,
			datasets: [
			{
				label: '2022',
				backgroundColor: '#1c64f2',
				// borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: sale2,
			},
			{
				label: '2023',
				backgroundColor: '#7e3af2',
				// borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: sale1,
			},
			{
				label: '2024',
				backgroundColor: '#0694a2',        
				borderWidth: 1,
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