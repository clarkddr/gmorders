<x-layout>	
	@if(session('banner'))
	<x-banner message="{{session('banner.message')}}" type="success" class=""/>
	@endif
	<div class="flex justify-between items-center">
		<h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 ">
			Proyección de {{ $categoryName }} Invierno 2024
		</h2>		
	</div>	
	<div class="w-full overflow-hidden rounded-lg shadow-xs mb-6">
		<div class="w-full overflow-x-auto">
			<table id="salesTable" class="w-full whitespace-no-wrap">
				<thead>
					<tr	class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
						<th class="px-4 py-3 text-center">Familia</th>
						<th class="px-4 py-3 text-right">Venta</th>
						<th class="px-4 py-3 text-right">Proyección Venta</th>						
						<th class="px-4 py-3">Avance Proyección Venta</th>
						<th class="px-4 py-3 text-right">Compra</th>
						<th class="px-4 py-3 text-right">Proyección Compra</th>						
						<th class="px-4 py-3">Avance Proyección Compra</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
					@foreach ($thisYearSales as $tySales)
					<tr class="text-gray-700 dark:text-gray-400">
						<td class="px-4 py-3">
							<a href="{{route('projection.show',$tySales['id'])}}" class="text-blue-600 hover:underline">
								{{ $tySales['name'] }} 
							</a>
						</td>		
						<td class="px-4 py-3 " data-order="{{$tySales['total']}}">
							<div class="flex flex-col items-end">
								<span class="text">{{$tySales['total']}}</span>
								<span class="text-xs text-gray-500">{{$tySales['current'].' / '.$tySales['old']}}</span>
							</div>
						</td>
						<td class="px-4 py-3 " data-order="{{$tySales['projection']['amount']}}">
							<div class="flex flex-col items-end">
								<span class="text">{{$tySales['projection']['amount']}}</span>
								<span class="text-xs text-gray-500">{{$tySales['projection']['current'].' / '.$tySales['projection']['old']}}</span>
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
						<td class="px-4 py-3 ">
							{{ $tySales['purchase'] }}
						</td>
						<td class="px-4 py-3">
							{{$tySales['projection']['purchase']}}
						</td>		
						<td class="px-4 py-3">
							<div class="w-full bg-gray-800 rounded-full h-4 relative">
								<div class="h-4 rounded-full bg-green-700" :style="'width: {{$tySales['projection']['purchaseVsProjection']*100}}%;'"></div>
								<div class="absolute inset-0 mx-3 flex justify-end text-white text-xs font-semibold">
								  {{$tySales['projection']['purchaseVsProjection']*100}}%
								</div>
							</div>
						</td>		
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					
					<tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
						<td class="px-4 py-3 font-bold text-xl"> {{ $thisYearSalesTotal['name'] }} </td>		
						<td class="px-4 py-3">
							<div class="flex flex-col items-end">
								<span class="text-xl font-bold">{{$thisYearSalesTotal['total']}}</span>
								<span class="text-xs text-gray-500">{{$thisYearSalesTotal['current'].' / '.$thisYearSalesTotal['old']}}</span>
							</div>
						</td>
						<td class="px-4 py-3">
							<div class="flex flex-col items-end">
								<span class="text-xl font-bold">{{$projectionSalesTotal['total']}}</span>
								<span class="text-xs text-gray-500">{{$projectionSalesTotal['current'].' / '.$projectionSalesTotal['old']}}</span>
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
						<td class="px-4 py-3 text-xl font-bold">
							{{$thisYearSalesTotal['purchase']}}
						</td>
						<td class="px-4 py-3 text-xl font-bold">
							{{$projectionSalesTotal['purchase']}}
						</td>						
						<td class="px-4 py-3">
							<div class="w-full bg-gray-800 rounded-full h-7 relative">
								<div class="h-7 rounded-full bg-green-700" :style="'width: {{$projectionSalesTotal['purchaseVsProjection']}}%;'"></div>
								<div class="absolute inset-0 mx-3 flex text-white justify-end text-lg font-semibold">
								  {{$projectionSalesTotal['purchaseVsProjection']}}%								  
								</div>
							</div>
						</td>
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
                //"targets": 3, "orderable": false,                
            }]
		});
	} );
</script>