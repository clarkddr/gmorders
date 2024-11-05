@php
	use Carbon\Carbon;
	Carbon::setLocale('es');
@endphp
<x-layout>	
	@if(session('banner'))
	<x-banner message="{{session('banner.message')}}" type="success" class=""/>
	@endif
    {{-- Encabezado con título y espacio para dropdowns --}}
	<x-titlePage title="Proyecciones" >
		
	</x-titlePage>
	<div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg mb-6">
		<div class="rounded-lg">
			<div class="grid gap-6 md:grid-cols-8">
				{{-- Table --}}
				<div class="md:col-span-8 rounded-lg shadow-xs"> <!-- Ocupa 4/12 -->
					<table id="table" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs">
						<thead>
							<tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
								<th class="px-4 py-3">Codigo</th>
								<th class="px-4 py-3 text-right">Fecha de inicio</th>
								<th class="px-4 py-3 text-right">Fecha final</th>								
								<th class="px-4 py-3"></th>								
							</tr>
						</thead>
						<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
							@foreach ($projections as $projection)
							<tr class="text-gray-700 dark:text-gray-400">
								<td class="px-4 py-3">{{ $projection->name }}</td>
								<td class="px-4 py-3 text-right">{{ Carbon::parse($projection->start)->isoFormat('DD MMMM Y') }}</td>
								<td class="px-4 py-3 text-right">{{ Carbon::parse($projection->end)->isoFormat('DD MMMM Y') }}</td>
								<td class="px-4 py-3 flex justify-end "> 
									<div class="flex items-center space-x-4 text-sm">
										<x-editButton href="/projections/{{$projection->id}}/edit" />
										<x-deleteButton action="projections" id="{{$projection->id}}"/>
										
									</div>
								</td>								
							</tr>
                            @endforeach
						</tbody>
						<tfoot class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                            <tr>
                                <td class=""></td>
								<td class=""></td>
								<td class=""></td>
                            </tr>					
						</tfoot>
					</table>
				</div>
				{{-- End Table --}}
			</div>
			{{-- <x-pagination/> --}}
		</div>
	</div>
	
	
	
</x-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
	$('#tables').DataTable({
		// dom: 't',
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