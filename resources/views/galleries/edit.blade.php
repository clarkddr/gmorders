<x-layout >
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Galería {{$gallery->code}}
        </h2>   
        <a href="/galleries"
           class="px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 border border-gray-600 rounded-lg active:bg-sky-600 hover:bg-sky-700 focus:outline-none focus:shadow-outline-sky">
           Regresar
        </a>
    </div>
    <div class="flex flex-col justify-center md:flex-row mb-2">
        <div class="flex items-center justify-center p-2 w-full dark:bg-gray-800 rounded-lg">
            <div class="w-full p-4 md:w-1/2">                
                <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                    Editar
                </h1>
                <form method="POST" action="/galleries/{{$gallery->id}}" enctype="multipart/form-data" >
                    @csrf
                    @method('PATCH')
                    <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Nombre</span>
                    <input
                    class="@error('code') border-red-600 @else dark:border-gray-600 @enderror block w-full mt-1 text-sm  dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Código" name="code" value="{{ old('code',$gallery->code) }}" />
                    @error('code')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                    @enderror
                    </label>
                    <div class="flex justify-end space-x-4">
                        <button onclick="disableButton()"
                        class=" px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-sky-600 hover:bg-sky-700 focus:outline-none focus:shadow-outline-sky">
                        Guardar
                        </button>
                    </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col justify-center md:flex-row mb-2">
        <div class="flex items-center justify-center p-2 w-full dark:bg-gray-800 rounded-lg">
            <div class="w-full p-4 md:w-1/2">
                <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                    Agregar imágenes
                </h1>
                <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400"></span>
                <input id="images" name="images[]" type="file" multiple
                class="@error('images.*') border-red-600 @else dark:border-gray-600 @enderror block w-full mt-1 text-sm  dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="Proveedor" />
                @error('images.*')
                <span class="text-xs text-red-600 dark:text-red-400">
                    {{$message}}
                </span>
                @enderror

                </label>
                <div class="flex space-x-4 mt-2">
                    <label class="text-sm w-1/2 ">
                        <span class="text-gray-700 dark:text-gray-400">
                            Proveedor
                        </span>
                        <select name="supplier_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        <option selected value="{{NULL}}">{{'Seleccionar'}}</option>                            
                        @foreach ($suppliers as $supplier)
                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>                            
                        @endforeach
                        </select>
                    </label>
                    <label class="text-sm w-1/2">
                        <span class="text-gray-700 dark:text-gray-400">Subcategoría</span>
                        <input
                        class="@error('subcategory') border-red-600 @else dark:border-gray-600 @enderror block w-full mt-1 text-sm  dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Ejemplo: Zapatilla" name="subcategory" value="{{ old('subcategory') }}" />
                        @error('subcategory')
                        <span class="text-xs text-red-600 dark:text-red-400">
                            {{$message}}
                        </span>
                        @enderror
                        </label>
                </div>
                <div class="flex justify-end space-x-4">
                    <button id="submit" onclick="disableButton()"
                    class=" px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-sky-600 hover:bg-sky-700 focus:outline-none focus:shadow-outline-sky">
                    Agregar
                    </button>
                </div>
                </form>  
            </div>
        </div>
    </div>
    <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
        Imágenes
    </h1>                
    <div class="grid gap-6 mt-4 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Card -->
        @foreach ($gallery->images as $image)
        @php
        $line = ($image->supplier->name and $image->subcategory) ? ' | ' : '';
        @endphp
        <div class="items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">   
            <div class="flex mb-4 justify-between" >
                <p class="mx-4 text-xs text-gray-600 dark:text-gray-400">{{$image->supplier->name . $line . $image->subcategory}}</p>
                <button
                class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                aria-label="close"
                @click="openModal({{$image}})"
              >
                <svg
                  class="w-4 h-4"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  role="img"
                  aria-hidden="true"
                >
                  <path
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                    fill-rule="evenodd"
                  ></path>
                </svg>
              </button>
            </div>             

            <div class="flex items-center justify-center h-64">
                <div class="rounded-lg overflow-hidden">
                    <img class="object-cover w-48 h-48"
                    src="{{asset($image->url)}}"
                    alt="" loading="lazy"/>
                </div>
            </div>
        </div>
        @endforeach
    </div> 

    <x-deleteModal data="{{$gallery->code}}"/>

</x-layout>




<script>
    function disableButton() {
        const button = document.getElementById("submit");
        button.classList.add('opacity-50', 'cursor-not-allowed');
        button.classList.remove('active:bg-sky-600', 'hover:bg-sky-700', 'focus:outline-none', 'focus:shadow-outline-sky');
        //button.disabled = true; // Opcional: deshabilitar completamente el botón
    }
</script>