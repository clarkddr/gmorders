<x-layout>	
	@if(session('banner'))
	<x-banner message="{{session('banner.message')}}" type="success" class=""/>
	@endif
	<div class="flex justify-between items-center mb-6 ">
		<h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
			Compra vs Venta Anual de {{$family}}
		</h2>
        <p class="text-white">Min: {{$minimum}}% </p>
        <p class="text-white">Max: {{$maximum}}% </p>
        <p class="text-white">TC: {{$tc}} </p>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400">
              Familia
            </span>
            <select id="dropdown" onchange="redirect()" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option>Seleccionar</option>
                @foreach ($families as $family)
                <option>{{$family}}</option>
                @endforeach
            </select>
          </label>	

		{{-- <a href="{{route('galleries.create')}}" class="py-2 px-2 bg-blue-600 inline-flex items-center text-sm font-medium text-center hover:text-gray-800  rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
			<svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
			<p class="text-white pl-1.5">Agregar</p>			  
		</a> --}}
	</div>
	
	<div class="w-full overflow-hidden rounded-lg shadow-xs">
		<div class="w-full overflow-x-auto">
			<table class="w-full whitespace-no-wrap">
				<thead>
					<tr	class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
						<th class="px-4 py-3">Familia</th>
						<th class="px-4 py-3 " style="text-align:right;">Venta</th>
						<th class="px-4 py-3 " style="text-align:right;">Compra</th>						
						<th class="px-4 py-3 text-center">%</th>
						<th class="px-4 py-3" style="text-align:right;">Compra Dlls</th>
						<th class="px-4 py-3"></th>
					</tr>
				</thead>
                
				<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
					@foreach ($rows as $row)
					<tr class="text-gray-700 dark:text-gray-400">
						<td class="px-4 py-3"> {{$row['sucursal']}} </td>		
						<td class="px-4 py-3 " style="text-align: right;">													
                            {{$row['venta']}}
						</td>
						<td class="px-4 py-3 " style="text-align: right;">													
                            {{$row['compra']}}
						</td>
                        
						<td class="px-4 py-3 text-center">
                            <x-percentajeButton percentaje="{{$row['relation']}}" />
						</td>
                        <td class="px-4 py-3 " style="text-align: right;">													
                            {{$row['sugested']}}
                        </td>
                        <td class="px-4 py-3 text-xs">

                          </td>
					</tr>                    
					@endforeach
                    <tr class="text-gray-700 dark:text-gray-400 text-xl">
                        <td></td>
                        <td class="px-4 py-3 " style="text-align: right;">	
                            {{$totalSale}}
                        </td>
                        <td class="px-4 py-3 " style="text-align: right;">	
                            {{$totalPurchase}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <x-percentajeButton percentaje="{{$totalRelation}}" />
                        </td>
                        <td class="px-4 py-3 " style="text-align: right;">	
                            {{$totalSugested}}
                        </td>  
                        <td></td>

                    </tr>
				</tbody>
			</table>
		</div>
	<div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800" >

		
<!-- Pagination -->
    </div>
</div>
</x-layout>

<style>
	.wrap-text {
  white-space: normal; /* Permite que el texto se envuelva */
  word-break: break-word; /* Rompe las palabras largas si es necesario */
}
</style>
<script>
    function redirect() {
        var dropdown = document.getElementById("dropdown");
        var selectedOption = dropdown.value;
        if (selectedOption) {
            // Redirigir a una nueva URL con el valor seleccionado
            window.location.href = '/plan?family=' + encodeURIComponent(selectedOption);
        }
    }
</script>