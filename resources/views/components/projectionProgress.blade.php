@props(['value' => 0,'size' => 'xs'])
@php
$height = 4;
$width = $value > 100 ? 100 : $value;
if($size == 'lg'){
  $height = 7;
}
@endphp
<div class="w-full bg-gray-300 dark:bg-gray-700 rounded-full h-{{$height}} relative">
    <div class="h-{{$height}} rounded-full bg-green-700" :style="'width: {{$width}}%;'"></div>
    <div class="absolute inset-0 mx-3 flex dark:text-white text-gray-800 justify-end text-{{$size}} font-semibold">
      {{$value}}%
    </div>
</div>