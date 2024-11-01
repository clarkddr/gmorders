<x-layout>	
	@if(session('banner'))
	<x-banner message="{{session('banner.message')}}" type="success" class=""/>
	@endif
    {{-- Encabezado con título y espacio para dropdowns --}}
	<x-titlePage title="Proyección {{$projection['name']}}" subtitle="{{'Del '.$projection['start'].' al '.$projection['end'].''}}" >
		<x-backButton :url="'/projections'" />
	</x-titlePage>

	<div class="w-full overflow-hidden rounded-lg shadow-xs mb-6 grid gap-4">
		@foreach ($categories as $category)	
		<div class="w-full overflow-x-auto"> 
			<h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200"> {{ $category['Name'] }} </h1>
			<table id="table{{$category['CategoryId']}}" class="w-full whitespace-no-wrap rounded-lg shadow-xs">
				<thead>
					<tr	class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
						<th class="px-4 py-3">Familia</th>
						<th class="px-4 py-3 text-right">Proyección Venta</th>						
						<th class="px-4 py-3 text-right">Proyección Compra</th>
						<th class="px-4 py-3 text-right">%</th>
						<th class="px-4 py-3 text-right"></th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">					
				@foreach ($category['families'] as $family)					
					<tr class="text-gray-700 dark:text-gray-400">
						<td class="px-4 py-3">{{$family['Name']}}</td>
						<td class="px-4 py-3 text-right">{{$family['total_sale']}}</td>
						<td class="px-4 py-3 text-right">{{$family['total_purchase']}}</td>
						<td class="px-4 py-3 text-right">{{$family['relation']}}%</td>
						<td class="px-4 py-3 flex justify-end "> 
							<div class="flex items-center space-x-4 text-sm">
								@if ($family['has_projection'])
								<a href="{{'/projections/amounts?familyid='.$family['FamilyId']}}&projectionid={{$projection['id']}}"	class="flex bg-blue-600  items-center justify-between px-2 py-2 text-sm leading-5 rounded-lg text-white focus:outline-none focus:shadow-outline-blue">
									<svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
								</a>									
								@else
								<a href="{{'/projections/amounts?familyid='.$family['FamilyId']}}&projectionid={{$projection['id']}}"	class="flex bg-green-600  items-center justify-between px-2 py-2 text-sm leading-5 rounded-lg text-white focus:outline-none focus:shadow-outline-green">
									<svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
								</a>									
								@endif
							</div>
						</td>	
					</tr>					
				@endforeach
				</tbody>
				<tfoot>					
					<tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
						<td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>		
						<td class="px-4 py-3 font-bold text-xl text-right"> {{ $category['sale'] }} </td>		
						<td class="px-4 py-3 font-bold text-xl text-right"> {{ $category['purchase'] }} </td>		
						<td class="px-4 py-3 font-bold text-xl"> {{ $category['relation'] }}% </td>								
						<td class="px-4 py-3 font-bold text-xl"> {{ '' }} </td>								
					</tr>
				</tfoot>
			</table>
		</div>
		@endforeach
	</div>

	
	
	
</x-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
	$('#table12').DataTable({
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
	$('#table1').DataTable({
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
	$('#table4').DataTable({
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