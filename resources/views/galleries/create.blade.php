<x-layout >    
    <h2 class="mb-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Agregar Galería
    </h2>
    
    <div class="flex flex-col justify-center md:flex-row ">
        
        <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2 dark:bg-gray-800 rounded-lg">
            <div class="w-full">
                <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                Agregar
                </h1>                
                <form method="POST" action="/galleries" >
                    @csrf

                    <button
                    class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-sky-600 hover:bg-sky-700 focus:outline-none focus:shadow-outline-sky">
                    Guardar
                    </button>
                </form>                
            </div>
        </div>
    </div>   

</x-layout>