@php
    use Carbon\Carbon;
@endphp
<x-layout>
	@if(session('banner'))
	<x-banner message="{{session('banner.message')}}" type="success" class=""/>
	@endif
    @if ($errors->any())
        <div class="mb-4">
            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <x-titlePage title="Proyección {{$selectedProjection['name']?? ''}}">
        <form action ="{{route('projectionamount.index')}}" method="GET" class="flex flex-col md:flex-row md:space-x-4 justify-end">
            <select name="projection" id="projection" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option value="0"  {{ $selectedProjection ? '' : 'selected' }}>Proyección</option>
                @foreach ($projectionList as $projection)
                    <option value="{{ $projection->id }}"
                        {{ $selectedProjection['id'] == $projection->id ? 'selected' : '' }}>
                        {{ $projection->name }}
                    </option>
                @endforeach
            </select>
            <button	type="submit" class="px-3 mt-1 py-1 text-sm text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-blue focus:shadow-outline-blue">
                Buscar
            </button>
        </form>
	</x-titlePage>
    @if($categories->count() > 0)
    <div class="w-full overflow-hidden rounded-lg shadow-xs mb-6">
        <div class="w-full overflow-x-auto">
            <table id="tablehead" class="w-full whitespace-no-wrap rounded-lg shadow-xs">
                <thead>
                <tr	class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3 text-center">Familia</th>
                    <th class="px-4 py-3 text-right">Venta</th>
                    <th class="px-4 py-3">vs Meta</th>
                    <th class="px-4 py-3 text-right">Proyección Venta</th>
                    <th class="px-4 py-3">Avance Proyección Venta</th>
                    <th class="px-4 py-3 text-right">Compra</th>
                    <th class="px-4 py-3 dt-text-left">c/v</th>
                    <th class="px-4 py-3 text-right">Proyección Compra</th>
                    <th class="px-4 py-3 dt-text-left">c/v</th>
                    <th class="px-4 py-3">Avance Proyección Compra</th>
                </tr>
                </thead>
                <tfoot>
                <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                    <td class="px-4 py-3 font-bold text-xl"> {{ 'Global' }} </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col items-end">
                            <span class="text-xl font-bold">{{$totals['total']}}</span>
                            <span class="text-xs text-gray-500">{{$totals['current'].' / '.$totals['old']}}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-bold text-xl">
                        <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$totals['saleVsGoal']" size="xl"/>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col items-end">
                            <span class="text-xl font-bold">{{$totals['projection']['total']}}</span>
                            <span class="text-xs text-gray-500">{{$totals['projection']['current'].' / '.$totals['projection']['old']}}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <x-projectionProgress :value="$totals['totalVsProjection']" size="lg"/>
                    </td>
                    <td class="px-4 py-3 text-xl font-bold text-right">
                        {{$totals['purchase']}}
                    </td>
                    <td class="px-4 py-3 font-bold text-xl dt-text-left"> {{ $totals['purchaseVsSale'] }}% </td>
                    <td class="px-4 py-3 text-xl font-bold text-right">
                        {{$totals['projection']['purchase']}}
                    </td>
                    <td class="px-4 py-3 font-bold text-xl dt-text-left"> {{ $totals['projection']['purchaseVsSale'] }}% </td>
                    <td class="px-4 py-3">
                        <x-projectionProgress :value="$totals['projection']['purchaseVsProjection']" size="lg"/>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endif

    @foreach($categories as $category)
	<div class="w-full overflow-hidden rounded-lg shadow-xs mb-6">
		<div class="w-full overflow-x-auto">
			<table id="salesTable" class="projectionTable w-full whitespace-no-wrap rounded-lg shadow-xs">
				<thead>
					<tr	class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
						<th class="px-4 py-3 text-center">Familia</th>
						<th class="px-4 py-3 text-right">Venta</th>
						<th class="px-4 py-3">vs Meta</th>
						<th class="px-4 py-3 text-right">Proyección Venta</th>
						<th class="px-4 py-3">Avance Proyección Venta</th>
						<th class="px-4 py-3 text-right">Compra</th>
                        <th class="px-4 py-3 dt-text-left">c/v</th>
						<th class="px-4 py-3 text-right">Proyección Compra</th>
                        <th class="px-4 py-3 dt-text-left">c/v</th>
						<th class="px-4 py-3">Avance Proyección Compra</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($category['families'] as $family)
					<tr class="text-gray-700 dark:text-gray-400">
						<td class="px-4 py-3">
							<a  href="{{route('projectionamount.branches',['family'=>$family['id'],'projection'=>$selectedProjection['id']])}}" class="text-blue-600 hover:underline" target="_blank">
								{{ $family['name'] }}
							</a>
						</td>
						<td class="px-4 py-3 " data-order="{{$family['total']}}">
							<div class="flex flex-col items-end">
								<span class="text">{{$family['total']}}</span>
								<span class="text-xs text-gray-500">{{$family['current'] .' / '. $family['old']}}</span>
							</div>
						</td>
                        <td class="px-4 py-3">
                            <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$family['saleVsGoal']" />
                        </td>
						<td class="px-4 py-3 " data-order="{{$family['projection']['total']}}">
							<div class="flex flex-col items-end">
								<span class="text">{{$family['projection']['total']}}</span>
								<span class="text-xs text-gray-500">{{$family['projection']['current'] .' / '. $family['projection']['old']}}</span>
							</div>
						</td>
						<td class="px-4 py-3">
							<x-projectionProgress :value="$family['totalVsProjection']"/>
						</td>
						<td class="px-4 py-3 text-right ">
							{{ $family['purchase'] }}
						</td>
                        <td class="px-4 py-3 dt-text-left text-sm">{{ $family['purchaseVsSale'] }}%</td>
						<td class="px-4 py-3 text-right">
							{{ $family['projection']['purchase'] }}
						</td>
                        <td class="px-4 py-3 dt-text-left text-sm">{{ $family['projection']['purchaseVsSale'] }}%</td>
						<td class="px-4 py-3">
							<x-projectionProgress :value="$family['projection']['purchaseVsProjection']"/>
						</td>
					</tr>
                    @endforeach
				</tbody>
				<tfoot>
					<tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
						<td class="px-4 py-3 font-bold text-xl"> {{ $category['name'] }} </td>
						<td class="px-4 py-3">
							<div class="flex flex-col items-end">
								<span class="text-xl font-bold">{{$category['total']}}</span>
								<span class="text-xs text-gray-500">{{$category['current'].' / '.$category['old']}}</span>
							</div>
						</td>
                        <td class="px-4 py-3 font-bold text-xl">
                            <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$category['saleVsGoal']" size="xl"/>
                        </td>
						<td class="px-4 py-3">
							<div class="flex flex-col items-end">
								<span class="text-xl font-bold">{{$category['projection']['total']}}</span>
								<span class="text-xs text-gray-500">{{$category['projection']['current'].' / '.$category['projection']['old']}}</span>
							</div>
						</td>
						<td class="px-4 py-3">
							<x-projectionProgress :value="$category['totalVsProjection']" size="lg"/>
						</td>
						<td class="px-4 py-3 text-xl text-right font-bold">
							{{ $category['purchase'] }}
						</td>
                        <td class="px-4 py-3 font-bold text-xl dt-text-left"> {{ $category['purchaseVsSale'] }}% </td>
						<td class="px-4 py-3 text-xl text-right font-bold">
							{{$category['projection']['purchase']}}
						</td>
                        <td class="px-4 py-3 font-bold text-xl dt-text-left"> {{ $category['projection']['purchaseVsSale'] }}% </td>
						<td class="px-4 py-3">
							<x-projectionProgress :value="$category['projection']['purchaseVsProjection']" size="lg"/>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
    @endforeach
        <!-- Tabla de totales por sucursal -->
        <h1 class="text-xl font-bold text-gray-700 dark:text-gray-200 ">Por Sucursal</h1>
        <div class="w-full overflow-hidden rounded-lg shadow-xs mb-6">
            <div class="w-full overflow-x-auto">
                <table id="salesTable" class="projectionTable w-full whitespace-no-wrap rounded-lg shadow-xs">
                    <thead>
                    <tr	class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3 text-center">Familia</th>
                        <th class="px-4 py-3 text-right">Venta</th>
                        <th class="px-4 py-3">vs Meta</th>
                        <th class="px-4 py-3 text-right">Proyección Venta</th>
                        <th class="px-4 py-3">Avance Proyección Venta</th>
                        <th class="px-4 py-3 text-right">Compra</th>
                        <th class="px-4 py-3 dt-text-left">c/v</th>
                        <th class="px-4 py-3 text-right">Proyección Compra</th>
                        <th class="px-4 py-3 dt-text-left">c/v</th>
                        <th class="px-4 py-3">Avance Proyección Compra</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($branches as $branch)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <a  href="{{route('projectionamount.branches',1)}}" class="text-blue-600 hover:underline" target="_blank">
                                    {{ $branch['name'] }}
                                </a>
                            </td>
                            <td class="px-4 py-3 " data-order="{{$branch['total']}}">
                                <div class="flex flex-col items-end">
                                    <span class="text">{{$branch['total']}}</span>
                                    <span class="text-xs text-gray-500">{{$branch['current'] .' / '. $branch['old']}}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$branch['saleVsGoal']" />
                            </td>
                            <td class="px-4 py-3 " data-order="{{$branch['projection']['total']}}">
                                <div class="flex flex-col items-end">
                                    <span class="text">{{$branch['projection']['total']}}</span>
                                    <span class="text-xs text-gray-500">{{$branch['projection']['current'] .' / '. $branch['projection']['old']}}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <x-projectionProgress :value="$branch['totalVsProjection']"/>
                            </td>
                            <td class="px-4 py-3 text-right ">
                                {{ $branch['purchase'] }}
                            </td>
                            <td class="px-4 py-3 dt-text-left text-sm">{{ $branch['purchaseVsSale'] }}%</td>
                            <td class="px-4 py-3 text-right">
                                {{ $branch['projection']['purchase'] }}
                            </td>
                            <td class="px-4 py-3 dt-text-left text-sm">{{ $branch['projection']['purchaseVsSale'] }}%</td>
                            <td class="px-4 py-3">
                                <x-projectionProgress :value="$branch['projection']['purchaseVsProjection']"/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Todas' }} </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col items-end">
                                <span class="text-xl font-bold">{{$totals['total']}}</span>
                                <span class="text-xs text-gray-500">{{$totals['current'].' / '.$totals['old']}}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-bold text-xl">
                            <x-percentageButton below="red" above="green" :min="99" :max="100" :value="$totals['saleVsGoal']" size="xl"/>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col items-end">
                                <span class="text-xl font-bold">{{$totals['projection']['total']}}</span>
                                <span class="text-xs text-gray-500">{{$totals['projection']['current'].' / '.$totals['projection']['old']}}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <x-projectionProgress :value="$totals['totalVsProjection']" size="lg"/>
                        </td>
                        <td class="px-4 py-3 text-xl font-bold text-right">
                            {{$totals['purchase']}}
                        </td>
                        <td class="px-4 py-3 font-bold text-xl dt-text-left"> {{ $totals['purchaseVsSale'] }}% </td>
                        <td class="px-4 py-3 text-xl font-bold text-right">
                            {{$totals['projection']['purchase']}}
                        </td>
                        <td class="px-4 py-3 font-bold text-xl dt-text-left"> {{ $totals['projection']['purchaseVsSale'] }}% </td>
                        <td class="px-4 py-3">
                            <x-projectionProgress :value="$totals['projection']['purchaseVsProjection']" size="lg"/>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
</x-layout>

<script>
	$(document).ready( function () {
		$('.projectionTable').DataTable({
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
<style>
    .dt-text-left {
        text-align: left !important;
    }
</style>
