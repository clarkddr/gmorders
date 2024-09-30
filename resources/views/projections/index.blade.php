<x-layout>	
	@if(session('banner'))
	<x-banner message="{{session('banner.message')}}" type="success" class=""/>
	@endif
	<div class="flex justify-between items-center">
		<h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 ">
			Proyección de {{'Calzado'}} Invierno 2024
		</h2>		
	</div>	
	<div class="w-full overflow-hidden rounded-lg shadow-xs mb-6">
		<div class="w-full overflow-x-auto">
			<table id="salesTable" class="w-full whitespace-no-wrap">
				<thead>
					<tr	class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
						<th class="px-4 py-3 text-center">Sucursal</th>
						<th class="px-4 py-3">Venta</th>
						<th class="px-4 py-3">Avance Proyección</th>
						<th class="px-4 py-3">Proyección</th>
						<th class="px-4 py-3"></th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
					@foreach ($thisYearSales as $tySales)
					<tr class="text-gray-700 dark:text-gray-400">
						<td class="px-4 py-3"> {{ $tySales['name'] }} </td>		
						<td class="px-4 py-3 flex justify-end" data-order="{{$tySales['total']}}">
							<div class="flex flex-col items-end">
								<span class="text">{{$tySales['total']}}</span>
								<span class="text-xs text-gray-500">{{$tySales['current'].' / '.$tySales['old']}}</span>
							</div>
						</td>
						<td class="px-4 py-3">
							<div class="w-full bg-gray-800 rounded-full h-4 relative">
								<div class="h-4 rounded-full bg-green-700" :style="'width: {{$tySales['totalVsProjection']*100}}%;'"></div>
								<div class="absolute inset-0 mx-3 flex justify-end text-white text-xs font-semibold">
								  {{number_format($tySales['totalVsProjection']*100,1)}}%
								</div>
							</div>
						</td>		
						<td class="px-4 py-3 flex justify-end" data-order="{{$tySales['projection']['amount']}}">
							<div class="flex flex-col items-end">
								<span class="text">{{$tySales['projection']['amount']}}</span>
								<span class="text-xs text-gray-500">{{$tySales['projection']['current'].' / '.$tySales['projection']['old']}}</span>
							</div>
						</td>
						<td class="px-4 py-3 text-center">
							<a href="{{route('projection.show',$tySales['id'])}}" class="px-3 py-1 text-xs font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                                Ver Sucursales
                            </a>							
						</td>					
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					{{-- <tr class="text-gray-700 dark:text-gray-400"> --}}
					<tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
						<td class="px-4 py-3 font-bold text-xl"> {{ $thisYearSalesTotal['name'] }} </td>		
						<td class="px-4 py-3">
							<div class="flex flex-col items-end">
								<span class="text-xl font-bold">{{$thisYearSalesTotal['total']}}</span>
								<span class="text-xs text-gray-500">{{$thisYearSalesTotal['current'].' / '.$thisYearSalesTotal['old']}}</span>
							</div>
						</td>
                        <td class="px-4 py-3">
							<div class="w-full bg-gray-800 rounded-full h-7 relative">
								<div class="h-7 rounded-full bg-green-700" :style="'width: {{$projectionSalesTotal['totalVsProjection']}}%;'"></div>
								<div class="absolute inset-0 mx-3 flex text-white justify-end text-lg font-semibold">
								  {{$projectionSalesTotal['totalVsProjection']}}%
								</div>
							</div>
						</td>
                        {{-- <td class="px-4 py-3 text-xl font-bold text-left table-cell">{{$projectionSalesTotal['totalVsProjection']}}%</td>						 --}}
						<td class="px-4 py-3">
							<div class="flex flex-col items-end">
								<span class="text-xl font-bold">{{$projectionSalesTotal['total']}}</span>
								<span class="text-xs text-gray-500">{{$projectionSalesTotal['current'].' / '.$projectionSalesTotal['old']}}</span>
							</div>
						</td>
						<td class="px-4 py-3"></td>
					</tr>
				</tfoot>
			</table>
		</div>
</div>
</x-layout>



<script>
	// import DataTable from 'datatables.net-dt';
	// import 'datatables.net-responsive-dt';
	// console.log('este si funciona');
	// let table = new DataTable('#salesTable', {
	// 	responsive: true
	// });
	$(document).ready( function () {
		$('#salesTable').DataTable({
			paging:false,
			searching: false,
			info: false,
			lenghtChange: false,
			"order": [[]],
            "columnDefs": [{
                "targets": 4, "orderable": false
            }]
		});
	} );
</script>