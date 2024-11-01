@props(['title','subtitle'=>''])
<div class="w-full p-4  shadow-md mb-4 flex justify-between items-center bg-white dark:bg-gray-800 rounded-lg">
    <div>
        <h1 class="text-3xl font-semibold text-gray-700 dark:text-gray-200"> {{ $title }} </h1>
        <p class="text-xs font-semibold text-gray-700 dark:text-gray-200"> {{ $subtitle }} </p>
    </div>
    <div class="flex space-x-4">
        {{ $slot }}
    </div>
</div>