@props(['value' => '0','above'=>'red','below'=>'green','min'=> 33, 'max'=> 39,'size'=>'sm'])

@if ($value > $max)
    <span class="px-3 py-1 text-{{$size}} font-medium leading-5 text-white transition-colors duration-150 bg-{{ $above }}-700 dark:bg-{{ $above }}-600 border border-transparent rounded-md active:bg-{{ $above }}-600 hover:bg-{{ $above }}-800 dark:hover:bg-{{ $above }}-700 focus:outline-none focus:shadow-outline-{{$above}}}">
 
@elseif ($value < $min)
    <span class="px-3 py-1 text-{{$size}} font-medium leading-5 text-white transition-colors duration-150 bg-{{ $below }}-700 dark:bg-{{ $below }}-600 border border-transparent rounded-md active:bg-{{ $below }}-600 hover:bg-{{ $below }}-800 dark:hover:bg-{{ $above }}-700 focus:outline-none focus:shadow-outline-{{ $below }}">

@else
<span class="px-3 py-1 text-{{$size}} font-medium leading-5 text-gray-700 dark:text-gray-400 transition-colors duration-150 border border-transparent rounded-md focus:outline-none">
@endif
        {{$value . '%'}}
    </span>