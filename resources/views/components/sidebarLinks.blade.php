<li class="relative px-6 py-3">
    @if (request()->path() == '/')
    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif

    <a
    class="@if(request()->path() == '/') text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
    href="/"
    >
    <svg
        class="w-5 h-5"
        aria-hidden="true"
        fill="none"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        viewBox="0 0 24 24"
        stroke="currentColor"
    >
        <path
        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
        ></path>
    </svg>
    <span class="ml-4">Dashboard</span>
    </a>
</li>
</ul>
<ul>
{{-- <li class="relative px-6 py-3">
    @if (Route::is('suppliers.*'))
    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a
    class="@if(Route::is('suppliers.*')) text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "

    href="{{route('suppliers.index')}}"
    >
    <svg
        class="w-5 h-5"
        aria-hidden="true"
        fill="none"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        viewBox="0 0 24 24"
        stroke="currentColor"
    >
        <path
        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
        ></path>
    </svg>
    <span class="ml-4">Proveedores</span>
    </a>
</li> --}}
{{-- <li class="relative px-6 py-3">
    @if (Route::is('galleries.*'))
    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a
    class="@if(Route::is('galleries.*')) text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
    href="{{route('galleries.index')}}"
    >
    <svg
        class="w-5 h-5"
        aria-hidden="true"
        fill="none"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        viewBox="0 0 24 24"
        stroke="currentColor"
    >
        <path
        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
        ></path>
    </svg>
    <span class="ml-4">Galerias</span>
    </a>
</li> --}}
{{-- <li class="relative px-6 py-3">
    @if (Route::is('plan'))
    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a
    class="@if(Route::is('plan')) text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
    href="{{route('plan')}}"
    >
    <svg
        class="w-5 h-5"
        aria-hidden="true"
        fill="none"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        viewBox="0 0 24 24"
        stroke="currentColor"
    >
        <path
        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
        ></path>
    </svg>
    <span class="ml-4">C/V Familia</span>
    </a>
</li> --}}
{{-- Proyecciones --}}
<li class="relative px-6 py-3">
    @if (Route::is('projections.*') || Request::is('projections/amounts*'))
    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a class="@if (Route::is('projections.*') || Request::is('projections/amounts*')) text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
     href="{{route('projections.index')}}">
        <svg class ="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" /></svg>
        <span class="ml-4">Proyecciones</span>
    </a>
</li>
{{-- Reportes Encargadas --}}
<li class="relative px-6 py-3">
    @if (Route::is('branchTarget.*'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a class="@if(Route::is('branchTarget.*')) text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
       href="{{route('branchTarget.index')}}">
        <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.6 16.733c.234.269.548.456.895.534a1.4 1.4 0 0 0 1.75-.762c.172-.615-.446-1.287-1.242-1.481-.796-.194-1.41-.861-1.241-1.481a1.4 1.4 0 0 1 1.75-.762c.343.077.654.26.888.524m-1.358 4.017v.617m0-5.939v.725M4 15v4m3-6v6M6 8.5 10.5 5 14 7.5 18 4m0 0h-3.5M18 4v3m2 8a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z"/></svg>
        <span class="ml-4">Encargadas</span>
    </a>
</li>
{{-- Compra vs Venta --}}
<li class="relative px-6 py-3">
    @if (Route::is('purchaseoversale.*'))
    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a class="@if(Route::is('purchaseoversale.*')) text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
     href="{{route('purchaseoversale.index')}}">
     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
      </svg>
        <span class="ml-4">Compra vs Venta</span>
    </a>
</li>
{{-- Venta vs Proyeccion --}}
<li class="relative px-6 py-3">
    @if (Route::is('projectionamount.*'))
    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a class="@if(Route::is('projectionamount.*')) text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
     href="{{route('projectionamount.index')}}">
        <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.6 16.733c.234.269.548.456.895.534a1.4 1.4 0 0 0 1.75-.762c.172-.615-.446-1.287-1.242-1.481-.796-.194-1.41-.861-1.241-1.481a1.4 1.4 0 0 1 1.75-.762c.343.077.654.26.888.524m-1.358 4.017v.617m0-5.939v.725M4 15v4m3-6v6M6 8.5 10.5 5 14 7.5 18 4m0 0h-3.5M18 4v3m2 8a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z"/></svg>
        <span class="ml-4">Avance Proyección</span>
    </a>
</li>
{{-- Venta de Familias --}}
<li class="relative px-6 py-3">
    @if (Route::is('salesyearoy.*'))
    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a class="@if(Route::is('salesyearoy.*')) text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
     href="{{route('salesyearoy.index')}}">
     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
     <span class="ml-4">Venta/Compra vs Años</span>
    </a>
</li>
{{-- Ventas y Compras --}}
<li class="relative px-6 py-3">
    @if (Route::is('saleandpurchase.*'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a class="@if(Route::is('saleandpurchase.*')) text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
       href="{{route('saleandpurchase.index')}}">
        <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.6 16.733c.234.269.548.456.895.534a1.4 1.4 0 0 0 1.75-.762c.172-.615-.446-1.287-1.242-1.481-.796-.194-1.41-.861-1.241-1.481a1.4 1.4 0 0 1 1.75-.762c.343.077.654.26.888.524m-1.358 4.017v.617m0-5.939v.725M4 15v4m3-6v6M6 8.5 10.5 5 14 7.5 18 4m0 0h-3.5M18 4v3m2 8a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z"/></svg>
        <span class="ml-4">Ventas y Compras Periodos</span>
    </a>
</li>
<li class="relative px-6 py-3">
    @if (Route::is('yearsales.*'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a class="@if(Route::is('yearsales.*')) text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
       href="{{route('yearsales.index')}}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
        </svg>
        <span class="ml-4">Ventas Por Año</span>
    </a>
</li>
<li class="relative px-6 py-3">
    @if (Route::is('performance.*'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a class="@if(Route::is('performance.*')) text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
       href="{{route('performance.index')}}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
        </svg>
        <span class="ml-4">Rendimiento</span>
    </a>
</li>
<li class="relative px-6 py-3">
    @if (Route::is('stylesresults.*'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a class="@if(Route::is('stylesresults.*')) text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
       href="{{route('stylesresults.index')}}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.242 5.992h12m-12 6.003H20.24m-12 5.999h12M4.117 7.495v-3.75H2.99m1.125 3.75H2.99m1.125 0H5.24m-1.92 2.577a1.125 1.125 0 1 1 1.591 1.59l-1.83 1.83h2.16M2.99 15.745h1.125a1.125 1.125 0 0 1 0 2.25H3.74m0-.002h.375a1.125 1.125 0 0 1 0 2.25H2.99" />
        </svg>

        <span class="ml-4">Estilos</span>
    </a>
</li>




    {{-- <li class="relative px-6 py-3">
        <a
        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
        href="charts.html"
        >
        <svg
            class="w-5 h-5"
            aria-hidden="true"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"
            ></path>
            <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
        </svg>
        <span class="ml-4">Charts</span>
        </a>
    </li> --}}
    {{-- <li class="relative px-6 py-3">
        <a
        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
        href="buttons.html"
        >
        <svg
            class="w-5 h-5"
            aria-hidden="true"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
            d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"
            ></path>
        </svg>
        <span class="ml-4">Buttons</span>
        </a>
    </li> --}}
    {{-- <li class="relative px-6 py-3">
        <a
        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
        href="modals.html"
        >
        <svg
            class="w-5 h-5"
            aria-hidden="true"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
            ></path>
        </svg>
        <span class="ml-4">Modals</span>
        </a>
    </li> --}}
    {{-- <li class="relative px-6 py-3">
        <a
        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
        href="tables.html"
        >
        <svg
            class="w-5 h-5"
            aria-hidden="true"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
        </svg>
        <span class="ml-4">Tables</span>
        </a>
    </li> --}}
    {{-- <li class="relative px-6 py-3">
        <button
        class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
        @click="togglePagesMenu"
        aria-haspopup="true"
        >
        <span class="inline-flex items-center">
            <svg
            class="w-5 h-5"
            aria-hidden="true"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            viewBox="0 0 24 24"
            stroke="currentColor"
            >
            <path
                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"
            ></path>
            </svg>
            <span class="ml-4">Pages</span>
        </span>
        <svg
            class="w-4 h-4"
            aria-hidden="true"
            fill="currentColor"
            viewBox="0 0 20 20"
        >
            <path
            fill-rule="evenodd"
            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
            clip-rule="evenodd"
            ></path>
        </svg>
        </button>
        <template x-if="isPagesMenuOpen">
        <ul
            x-transition:enter="transition-all ease-in-out duration-300"
            x-transition:enter-start="opacity-25 max-h-0"
            x-transition:enter-end="opacity-100 max-h-xl"
            x-transition:leave="transition-all ease-in-out duration-300"
            x-transition:leave-start="opacity-100 max-h-xl"
            x-transition:leave-end="opacity-0 max-h-0"
            class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
            aria-label="submenu"
        >
            <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
            >
            <a class="w-full" href="pages/login.html">Login</a>
            </li>
            <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
            >
            <a class="w-full" href="pages/create-account.html">
                Create account
            </a>
            </li>
            <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
            >
            <a class="w-full" href="pages/forgot-password.html">
                Forgot password
            </a>
            </li>
            <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
            >
            <a class="w-full" href="pages/404.html">404</a>
            </li>
            <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
            >
            <a class="w-full" href="pages/blank.html">Blank</a>
            </li>
        </ul>
        </template>
    </li>
    </ul>
    <div class="px-6 my-6">
    <button
        class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue"
    >
        Create account
        <span class="ml-2" aria-hidden="true">+</span>
    </button>
    </div> --}}
