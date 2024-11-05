@php
	use Carbon\Carbon;
//	Carbon::setLocale('es');
@endphp
<x-layout>	
	@if(session('banner'))
	<x-banner message="{{session('banner.message')}}" type="success" class=""/>
	@endif
    {{-- Encabezado con título y espacio para dropdowns --}}
	<x-titlePage title="Proyección {{$projection->name}} de {{$family->Name}}" subtitle="Del {{Carbon::parse($projection->start)->isoFormat('DD MMM YY') }} al {{Carbon::parse($projection->end)->isoFormat('DD MMM YY')}}">
		@if (session('success'))
		<p id="flash-message" class="dark:text-gray-200 text-gray-500 px-4 py-1 rounded text-center">			
			Los cambios se han guardado exitosamente.
		</p>
		@endif
		<x-backButton :url="'/projections/'.$projection->id.'/edit'"/>
		<button type="submit" form="amounts" 
			class="px-4 py-2 text-sm font-medium leading-5 text-gray-200 dark:text-gray-300 transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:shadow-outline-blue">
			Guardar
		</button>
		
	</x-titlePage>
	<div class="w-full overflow-hidden rounded-lg shadow-xs mb-6">
		<div class="w-full overflow-x-auto">
			<table id="table" class="w-full whitespace-no-wrap rounded-lg shadow-xs">
				<thead>
					<tr	class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
						<th class="px-2 py-3 whitespace-normal text-center border-r border-gray-700">Familia</th>
						<th class="px-2 py-3 whitespace-normal text-right">Venta Nuevo {{$beforelast_year}}</th>
						<th class="px-2 py-3 whitespace-normal text-right">Venta Viejo {{$beforelast_year}}</th>						
						<th class="px-2 py-3 whitespace-normal text-right">Compra {{$beforelast_year}}</th>
						<th class="px-2 whitespace-normal text-center border-r border-gray-700">%</th>						
						<th class="px-2 py-3 whitespace-normal text-right">Venta Nuevo {{$last_year}}</th>
						<th class="px-2 py-3 whitespace-normal text-right">Venta Viejo {{$last_year}}</th>						
						<th class="px-2 py-3 whitespace-normal text-right">Compra {{$last_year}}</th>
						<th class="px-2 whitespace-normal text-center border-r border-gray-700">%</th>
						<th class="px-2 py-3 whitespace-normal text-right">Proyección Venta Nuevo</th>						
						<th class="px-2 py-3 whitespace-normal text-right">Proyección Venta Viejo</th>						
						<th class="px-2 py-3 whitespace-normal text-right">Proyección Compra Costo</th>						
						<th class="px-2 whitespace-normal text-center">%</th>						
					</tr>
				</thead>
				<form name="amounts" id="amounts" action="/projectionamount" method="POST"> @csrf
				<input type="hidden" name="projectionid" value="{{$projection->id}}">
				<input type="hidden" name="familyid" value="{{$family->FamilyId}}">
				
				<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
					@foreach($amounts as $branch)
					<input type="hidden" name="data[{{$loop->index}}][id]" value="{{$branch['current_year']['projection_amount_id']}}">
					<input type="hidden" name="data[{{$loop->index}}][branchid]" value="{{$branch['branchid']}}">
					<tr class="text-gray-700 dark:text-gray-400">
						<td class="px-4 py-3 text-center border-r border-gray-700">{{$branch['name']}}</td>		
						<td class="px-4 py-3 text-right">{{$branch['beforelast_year']['new_sale']}}</td>
						<td class="px-4 py-3 text-right">{{$branch['beforelast_year']['old_sale']}}</td>
						<td>
							<div class="flex flex-col items-end">
								<span class="text">{{$branch['beforelast_year']['purchase_sale']}}</span>
								<span class="text-xs text-gray-500">{{$branch['beforelast_year']['purchase_cost']}}</span>
							</div>
						</td>						
						<td class="px-4 py-3 text-right border-r border-gray-700">
							<x-percentageButton below="red" above="green" min="50" max="60" :value="$branch['beforelast_year']['relation']" />
						</td>
						<td class="px-4 py-3 text-right">{{$branch['last_year']['new_sale']}}</td>
						<td class="px-4 py-3 text-right">{{$branch['last_year']['old_sale']}}</td>
						<td>
							<div class="flex flex-col items-end">
								<span class="text">{{$branch['last_year']['purchase_sale']}}</span>
								<span class="text-xs text-gray-500">{{$branch['last_year']['purchase_cost']}}</span>
							</div>
						</td>
						<td class="px-4 py-3 text-right border-r border-gray-700">
							<x-percentageButton below="red" above="green" min="50" max="60" :value="$branch['last_year']['relation']" />
						</td>
						<td class="py-3 text-right">							
							<input class="w-24 text-sm text-right border:gray-300 bg-gray-100 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
							value="{{$branch['current_year']['new_sale']}}" placeholder="Venta Nuevo" 
							name="data[{{$loop->index}}][new_sale]"/>
						</td>
						<td class="py-3 text-right">
							<input class="w-24 text-sm text-right border:gray-300 bg-gray-100 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
							value="{{$branch['current_year']['old_sale']}}" placeholder="Venta Viejo" 
							name="data[{{$loop->index}}][old_sale]"/>
						</td>
						<td class="py-3 text-right">
							<input class="w-24 text-sm text-right border:gray-300 bg-gray-100 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
							value="{{$branch['current_year']['purchase_cost']}}" placeholder="Compra" 
							name="data[{{$loop->index}}][purchase]"/>
						</td>
						<td class="py-3 text-center ">
							<x-percentageButton below="red" above="green" min="50" max="60" :value="$branch['current_year']['relation']" />							
						</td>
					</tr>
					@endforeach
					
				</tbody>

				<tfoot>					
					<tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
						<td class="px-4 py-3 font-bold text-center text-xl border-r border-gray-700">Total</td>		
						<td class="px-4 py-3 font-bold text-right text-xl">{{$total['yearBeforeLast_new_sale']}}</td>		
						<td class="px-4 py-3 font-bold text-right text-xl">{{$total['yearBeforeLast_old_sale']}}</td>		
						<td>
							<div class="flex flex-col items-end">
								<span class="text-xl font-bold">{{$total['yearBeforeLast_purchase_sale']}}</span>
								<span class="text-xs text-gray-500">{{$total['yearBeforeLast_purchase_cost']}}</span>
							</div>
						</td>
						<td class="px-4 py-3 font-bold text-right text-xl border-r border-gray-700">						
							<x-percentageButton size="xl" below="red" above="green" min="50" max="60" :value="$total['yearBeforeLast_relation']" />
						</td>		
						<td class="px-4 py-3 font-bold text-right text-xl">{{$total['yearLast_new_sale']}}</td>		
						<td class="px-4 py-3 font-bold text-right text-xl">{{$total['yearLast_old_sale']}}</td>		
						<td>
							<div class="flex flex-col items-end">
								<span class="text-xl font-bold">{{$total['yearLast_purchase_sale']}}</span>
								<span class="text-xs text-gray-500">{{$total['yearLast_purchase_cost']}}</span>
							</div>
						</td>	
						<td class="px-4 py-3 font-bold text-right text-xl border-r border-gray-700">						
							<x-percentageButton size="xl" below="red" above="green" min="50" max="60" :value="$total['yearLast_relation']" />
						</td>			
						<td class="px-4 py-3 font-bold text-xl text-right">{{$total['projection_new_sale']}}</td>
						<td class="px-4 py-3 font-bold text-xl text-right">{{$total['projection_old_sale']}}</td>
						<td class="px-4 py-3 font-bold text-xl text-right">{{$total['projection_purchase']}}</td>
						<td class="px-4 py-3 font-bold text-xl">
							<x-percentageButton size="xl" below="red" above="green" min="50" max="60" :value="$total['projection_relation']" />
						</td>
					</tr>
			
				</tfoot>
			</table>
		</form>			
		</div>
	</div>	

	
	
	
</x-layout>

<script>
	setTimeout(() => {
		const flashMessage = document.getElementById('flash-message');
		if (flashMessage) {
			flashMessage.style.transition = 'opacity 0.5s ease';
			flashMessage.style.opacity = '0';
			setTimeout(() => flashMessage.remove(), 500); // Elimina el elemento después de la transición
		}
	}, 3000);	
</script>
<script>

document.addEventListener('DOMContentLoaded', function () {
	$('#table').DataTable({	
		dom: 't',
		responsive: true,
		// language: {
		// 	url: 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json'
		// },
		paging:false,
		searching: false,
		info: false,
		lenghtChange: false,        
		ordering: false
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

	/* Quitar spinners en Chrome, Safari, Edge, Opera */
	input[type="number"]::-webkit-outer-spin-button,
	input[type="number"]::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}

	/* Quitar spinners en Firefox */
	input[type="number"] {
		-moz-appearance: textfield;
	}	

</style>