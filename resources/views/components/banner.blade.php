@props(['message','type' => 'normal', 'class']);
@php
    $classes = "transition-opacity duration-500 opacity-100 flex items-center justify-between p-4 mb-4 text-sm font-semibold text-gray-100 rounded-lg shadow-md focus:outline-none ";
    $classes .= $class;
    if ($type == 'success'){
        $classes .= ' bg-blue-600';
    } elseif ($type == 'failed') {
        $classes .= ' bg-red-600 focus:shadow-outline-red';
    } else {        
        $classes .= ' bg-blue-600 focus:shadow-outline-blue';
    }
@endphp
<div id="banner" class="{{ $classes }}">
    <p class="text-sm text-white">{{ $message }}</p>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Selecciona el banner por su ID
        const banner = document.getElementById('banner');
        
        // Define el tiempo en milisegundos (5000 ms = 5 segundos)
        const hideAfter = 5000;
        
        // Usa setTimeout para ejecutar una función después de unos segundos
        setTimeout(() => {
            // Añade la clase de Tailwind para ocultar el banner
            banner.classList.add('hidden');
        }, hideAfter);
    });
    
    </script>