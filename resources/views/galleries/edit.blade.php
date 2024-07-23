<x-layout >

	<h2 class="mb-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
		Galerías
	</h2>    
    <div class="flex flex-col justify-center md:flex-row ">
        <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2 dark:bg-gray-800 rounded-lg">
            <div class="w-full">
                <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                    Editar
                </h1>                
                <form method="POST" action="/galleries/{{$gallery->id}}" >
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
                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">
                          Selecciona proveedor(es)
                        </span><br>
                        <span class="text-gray-700 dark:text-gray-400 text-xs">
                          Presiona SHIFT/CMD/CTRL para seleccionar varios
                        </span>
                        <select
                          class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                          multiple name="suppliers[]"
                        >
                        @foreach ($suppliers as $supplier)
                        <option @if ($gallery->suppliers->contains($supplier->id)) selected @endif value="{{$supplier->id}}">{{$supplier->name}}</option>
                        @endforeach
                        </select>
                    </label>
                    <div class="flex justify-end space-x-4">
                        <a href="/galleries"
                        class=" px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150  border border-gray-600 rounded-lg active:bg-sky-600 hover:bg-sky-700 focus:outline-none focus:shadow-outline-sky">
                        Regresar
                        </a>
                        <button id="submit" onclick="disableButton()"
                        class=" px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-sky-600 hover:bg-sky-700 focus:outline-none focus:shadow-outline-sky">
                        Guardar
                        </button>

                    </div>
                </form>  
            </div>
        </div>
    </div>


    
</x-layout>

<script>
    function disableButton() {
        const button = document.getElementById("submit");
        button.classList.add('opacity-50', 'cursor-not-allowed');
        button.classList.remove('active:bg-sky-600', 'hover:bg-sky-700', 'focus:outline-none', 'focus:shadow-outline-sky');
        //button.disabled = true; // Opcional: deshabilitar completamente el botón
    }
</script>