@props(['title' => '','subtitle'=>''])
<div class="w-full p-4  shadow-md flex justify-between items-center bg-white dark:bg-gray-800 rounded-lg">
    <div>
        @if(isset($title))
        <h1 class="text-3xl font-semibold text-gray-700 dark:text-gray-200"> {{ $title }} </h1>
        @endif
        <p class="text-xs font-semibold text-gray-700 dark:text-gray-200"> {{ $subtitle }} </p>
    </div>
    <div class="flex space-x-4">
        {{ $slot }}
    </div>
</div>
