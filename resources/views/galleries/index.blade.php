<x-layout>	
	@if(session('banner'))
	<x-banner message="{{session('banner.message')}}" type="success" class=""/>
	@endif
	<div class="flex justify-between items-center mb-6 ">
		<h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
			Galerías
		</h2>		
		<a href="{{route('galleries.create')}}" class="py-2 px-2 bg-blue-600 inline-flex items-center text-sm font-medium text-center hover:text-gray-800  rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
			<svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
			<p class="text-white pl-1.5">Agregar</p>			  
		</a>
	</div>
	
	<div class="w-full overflow-hidden rounded-lg shadow-xs">
		<div class="w-full overflow-x-auto">
			<table class="w-full whitespace-no-wrap">
				<thead>
					<tr	class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
						<th class="px-4 py-3">Código</th>
						<th class="px-4 py-3">Proveedor(es)</th>
						<th class="px-4 py-3">Creado</th>
						<th class="px-4 py-3"></th>
						<th class="px-4 py-3"></th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
					@foreach ($galleries as $gallery)
					<tr class="text-gray-700 dark:text-gray-400">
						<td class="px-4 py-3"> {{ $gallery->code }} </td>		
						<td class="px-4 py-3">
							@php
							$suppliers = $gallery->images->pluck('supplier.name')->unique()->values();
							@endphp
							<div class="flex items-center text-sm wrap-text">								
							@foreach ($suppliers as $supplier)
								{{$supplier . ','}}
							@endforeach
							</div>

						</td>
						<td class="px-4 py-3"> {{ $gallery->created_at->locale('es')->diffForHumans() }} </td>
						<td class="px-4 py-3">
							<button	class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
							Activar
	   						</button>
						</td>
						<td class="px-4 py-3 flex justify-end "> 
							<div class="flex items-center space-x-4 text-sm">
								<x-editButton href="/galleries/{{$gallery->id}}/edit" />
								<x-deleteButton action="galleries" id="{{$gallery->id}}"/>
								
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	<div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800" >
		<span class="flex items-center col-span-3">
		Showing 21-30 of 100
		</span>
		<span class="col-span-2"></span>
<!-- Pagination -->
<span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
	<nav aria-label="Table navigation">
		<ul class="inline-flex items-center">
			<li>
				<button
				class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
				aria-label="Previous"
				>
				<svg
				aria-hidden="true"
				class="w-4 h-4 fill-current"
				viewBox="0 0 20 20"
				>
				<path
				d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
				clip-rule="evenodd"
				fill-rule="evenodd"
				></path>
			</svg>
		</button>
	</li>
	<li>
		<button
		class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
		>
		1
	</button>
</li>
<li>
	<button
	class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
	>
	2
</button>
</li>
<li>
	<button
	class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple"
	>
	3
</button>
</li>
<li>
	<button
	class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
	>
	4
</button>
</li>
<li>
	<span class="px-3 py-1">...</span>
</li>
<li>
	<button
	class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
	>
	8
</button>
</li>
<li>
	<button
	class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
	>
	9
</button>
</li>
<li>
	<button
	class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
	aria-label="Next"
	>
	<svg
	class="w-4 h-4 fill-current"
	aria-hidden="true"
	viewBox="0 0 20 20"
	>
	<path
	d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
	clip-rule="evenodd"
	fill-rule="evenodd"
	></path>
</svg>
</button>
</li>
</ul>
</nav>
</span>
</div>
</div>



</x-layout>

<style>
	.wrap-text {
  white-space: normal; /* Permite que el texto se envuelva */
  word-break: break-word; /* Rompe las palabras largas si es necesario */
}
</style>