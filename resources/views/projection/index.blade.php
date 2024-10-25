<x-layout>	
	@if(session('banner'))
	<x-banner message="{{session('banner.message')}}" type="success" class=""/>
	@endif
    {{-- Encabezado con título y espacio para dropdowns --}}
	<x-titlePage title="Reporte de ventas de {{''}}">
		
	</x-titlePage>
	
	<div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
		<div class="rounded-lg">
			<div class="grid gap-6 mb-8 md:grid-cols-8">
				{{-- Table --}}
				<div class="md:col-span-8 rounded-lg shadow-xs"> <!-- Ocupa 4/12 -->
					<table id="table" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs">
						<thead>
							<tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
								<th class="px-4 py-3">Codigo</th>
								<th class="px-4 py-3">Fecha de inicio</th>
								<th class="px-4 py-3">Fecha final</th>								
							</tr>
						</thead>
						<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
							@foreach ($projections as $projection)
							<tr class="text-gray-700 dark:text-gray-400">
								<td class="px-4 py-3">{{ $projection->name }}</td>
								<td class="px-4 py-3">{{ $projection->start }}</td>
								<td class="px-4 py-3">{{ $projection->end }}</td>								
							</tr>
                            @endforeach
						</tbody>
						<tfoot>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
					
							{{-- <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
								<td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>		
								<td class="px-4 py-3 text-xl font-bold">
									{{ 'sale0' }}
								</td>
								<td class="px-4 py-3 text-xl font-bold">
									{{ 'sale1' }}
								</td>
							</tr> --}}
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
	$('#table').DataTable({
		// dom: 't',
		paging:true,
		searching: true,
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
        /* Estiliza los botones del paginador */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        @apply bg-blue-500 text-white rounded-md px-4 py-2 mx-1;
    }

    /* Estiliza los botones al pasar el cursor */
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        @apply bg-blue-700;
    }

    /* Estiliza el botón activo */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        @apply bg-blue-600 text-white font-bold;
    }
</style>