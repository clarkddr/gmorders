@props(['percentaje' => '0'])

@if ($percentaje > 39)
    <span class="px-3 py-1 text-sm font-medium leading-5 text-gray-700 dark:text-gray-400 transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
 
@elseif ($percentaje < 33)
    <span class="px-3 py-1 text-sm font-medium leading-5 text-gray-700 dark:text-gray-400 transition-colors duration-150 bg-green-700 dark:bg-green-700 border border-transparent rounded-md active:bg-green-700 hover:bg-green-800 focus:outline-none focus:shadow-outline-green">
@endif
        {{$percentaje . '%'}}
    </span>