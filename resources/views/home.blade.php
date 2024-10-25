<x-layout>
    <x-titlePage title="Proyecciones">
    </x-titlePage>

    <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
		<div class="rounded-lg">
			<div class="grid gap-6 mb-8 md:grid-cols-8">
				{{-- Table --}}
				<div class="md:col-span-3 rounded-lg shadow-xs"> <!-- Ocupa 4/12 -->
					<table id="table" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs">
						<thead>
							<tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
								<th class="px-4 py-3">Familia</th>
								<th class="px-4 py-3">2024</th>
								<th class="px-4 py-3">2023</th>
								<th class="px-4 py-3">2022</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
							@foreach ($sales as $family)
								
							<tr class="text-gray-700 dark:text-gray-400">
								<td class="px-4 py-3">{{ $family['name'] }}</td>
								<td class="px-4 py-3">{{ $family['sale0'] }}</td>
								<td class="px-4 py-3">{{ $family['sale1'] }}</td>
								<td class="px-4 py-3">{{ $family['sale2'] }}</td>								
							</tr>
							@endforeach							
						</tbody>
						<tfoot>
					
							<tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
								<td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>		
								<td class="px-4 py-3 text-xl font-bold">
									{{$totalSales['sale0']}}
								</td>
								<td class="px-4 py-3 text-xl font-bold">
									{{$totalSales['sale1']}}
								</td>
								<td class="px-4 py-3 text-xl font-bold">
									{{$totalSales['sale2']}}
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
				{{-- End Table --}}
			</div>
		</div>
	</div>

</x-layout>