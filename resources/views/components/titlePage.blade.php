@props(['title'])
<div class="w-full p-4  shadow-md mb-4 flex justify-between items-center bg-white dark:bg-gray-800 rounded-lg">
    <h1 class="text-3xl font-semibold text-gray-700 dark:text-gray-200"> {{ $title }} </h1>
    <div class="flex space-x-4">
        {{ $slot }}
    </div>
</div>