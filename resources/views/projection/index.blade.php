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
                                        <a class="flex bg-green-600 items-center justify-between px-2 py-2 text-sm leading-5 rounded-lg text-white focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Edit Percentage"
                                            href="/projectionmonth/{{ $projection->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.99 14.993 6-6m6 3.001c0 1.268-.63 2.39-1.593 3.069a3.746 3.746 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043 3.745 3.745 0 0 1-3.068 1.593c-1.268 0-2.39-.63-3.068-1.593a3.745 3.745 0 0 1-3.296-1.043 3.746 3.746 0 0 1-1.043-3.297 3.746 3.746 0 0 1-1.593-3.068c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 0 1 1.043-3.297 3.745 3.745 0 0 1 3.296-1.042 3.745 3.745 0 0 1 3.068-1.594c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.297 3.746 3.746 0 0 1 1.593 3.068ZM9.74 9.743h.008v.007H9.74v-.007Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                            </svg>
                                        </a>
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
