<x-layout>
	<div class="flex justify-between items-center mb-6 ">
		<h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
			Proveedores
		</h2>
		<a href="{{route('suppliers.create')}}" class="py-2 px-2 bg-blue-600 inline-flex items-center text-sm font-medium text-center hover:text-gray-800  rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
			<svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
			<p class="text-white pl-1.5">Agregar</p>			  
		</a>
	</div>
	
	<div class="w-full overflow-hidden rounded-lg shadow-xs">
		<div class="w-full overflow-x-auto">
			<table class="w-full whitespace-no-wrap">
				<thead>
					<tr	class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
						<th class="px-4 py-3">Nombre</th>
						<th class="px-4 py-3">Creado</th>
						<th class="px-4 py-3"></th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
					@foreach ($suppliers as $supplier)
					<tr class="text-gray-700 dark:text-gray-400">
						<td class="px-4 py-3"> {{ $supplier->name }} </td>		
						<td class="px-4 py-3"> {{ $supplier->created_at->locale('es')->diffForHumans() }} </td>
						<td class="px-4 py-3"> 
							<button class="py-1 px-1 bg-blue-600 inline-flex items-center p-1 text-sm font-medium text-center text-gray-500 hover:text-gray-800 dark:hover:text-gray-900 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
									<svg aria-hidden="true" class="w-5 h-5 text-gray-800 dark:text-white dark:hover:text-red-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
							</button>
							<button class="py-1 px-1 bg-red-600 inline-flex items-center p-1 text-sm font-medium text-center text-gray-500 hover:text-gray-800 dark:hover:text-gray-900 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
								<svg class="w-5 h-5 text-gray-800 dark:text-white dark:hover:text-red-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
									<path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
								</svg>
							</button>
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