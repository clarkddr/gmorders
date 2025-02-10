<x-layout>
	@if(session('banner'))
	<x-banner message="{{session('banner.message')}}" type="success" class=""/>
	@endif
	<x-titlePage title="Proyección de {{($projection['name'] ?? '') . ' - ' . ($familyName ?? '')}}">
	<a href="{{ url()->previous() }}" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
		Regresar
	</a>
	</x-titlePage>
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
						<th class="px-4 py-3">Por Comprar Dlls</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
					@foreach ($thisYearSales as $tySales)
					<tr class="text-gray-700 dark:text-gray-400">
						<td class="px-4 py-3">
								{{ $tySales['name'] }}
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
							<x-projectionProgress :value="$tySales['totalVsProjection']"/>
						</td>
						<td class="px-4 py-3 ">
							{{ $tySales['purchase'] }}
						</td>
						<td class="px-4 py-3">
							{{$tySales['projection']['purchase']}}
						</td>
						<td class="px-4 py-3">
							<x-projectionProgress :value="$tySales['projection']['purchaseVsProjection']"/>
						</td>
						<td class="px-4 py-3">
							{{ $tySales['projection']['toPurchaseDlls']}}
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
							<x-projectionProgress :value="$projectionSalesTotal['totalVsProjection']" size="lg"/>
						</td>
						<td class="px-4 py-3 text-xl font-bold">
							{{$thisYearSalesTotal['purchase']}}
						</td>
						<td class="px-4 py-3 text-xl font-bold">
							{{$projectionSalesTotal['purchase']}}
						</td>
						<td class="px-4 py-3">
							<x-projectionProgress :value="$projectionSalesTotal['purchaseVsProjection']" size="lg"/>
						</td>
						<td class="px-4 py-3 text-xl font-bold">
							{{$projectionSalesTotal['toPurchaseDlls']}}
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
</div>
</x-layout>



<script>
	$(document).ready( function () {
		$('#salesTable').DataTable({
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
	} );
</script>
