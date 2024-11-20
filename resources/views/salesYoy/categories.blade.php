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
	<x-titlePage title="Reporte de ventas de {{$selectedCategory->Name ?? ''}}">
		<form action ="/salesyearoy/categories" method="GET" class="flex space-x-4 justify-end">				
			<select id="dropdown" name="category" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
				<option>Departamento</option>					
				@foreach ($categories as $category)						
				<option {{ request()->query('category') == $category->CategoryId ? 'selected' : '' }}						
				value="{{$category->CategoryId}}">{{$category->Name}}</option>
				@endforeach
			</select>
			{{-- <input id="datess" class="text-xs px-2 border border-gray-600 dark:bg-gray-700 form-input text-white rounded-md" placeholder="Fechas" /> --}}
			<input id="dates1" name="dates1" value="{{old('dates1')}}" class="block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />
			<input id="dates2" name="dates2" value="{{old('dates2')}}" class="block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />
			<button	type="submit" class="px-3 mt-1 py-1 text-sm text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
				Buscar
			</button>
		</form>
	</x-titlePage>
	
	<div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
		<div class="rounded-lg">
			
			<div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
				
			</div>
			
			<div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
				<table id="table" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
					<thead>
						<tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
							<th class="px-4 py-3">Familia</th>
							<th class="px-4 py-3">Data</th>
							<th class="px-4 py-3">Data</th>
							<th class="px-4 py-3">Data</th>
				
						</tr>
					</thead>
					<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
												
						<tr class="text-gray-700 dark:text-gray-400">
							<td class="px-4 py-3">Data</td>
							<td class="px-4 py-3">Data</td>
							<td class="px-4 py-3">Data</td>
							<td class="px-4 py-3">Data</td>
						</tr>
											
					</tbody>
					<tfoot class="dark:divide-gray-700">				
						<tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
							<td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>		
							<td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>		
							<td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>		
							<td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>								
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
	
	const datesInput1 = document.getElementById('dates1');                
	flatpickr(datesInput1, {
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
	const datesInput2 = document.getElementById('dates2');                
	flatpickr(datesInput2, {
		// plugins: [new rangePlugin({ input: endInput })],
		dateFormat: "Y-m-d",
		mode: "range",
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