@props(['value' => 0,'active' => false])

<input class=" w-16 text-xs text-right border:gray-300 bg-gray-100 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input
        @if ($value > 0 & $active == true) dark:bg-green-800 bg-green-200  @endif
        @if ($value > 0 & $active == false) dark:bg-teal-900 bg-teal-300  @endif
        "
        value="{{$value}}"/>

