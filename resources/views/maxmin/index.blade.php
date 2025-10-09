<x-layout>
    @if(session('banner'))
        <x-banner message="{{session('banner.message')}}" type="{{session('banner.type')}}" class=""/>
    @endif
    {{-- Encabezado con título y espacio para dropdowns --}}
    @if ($errors->any())
        <div class="mb-4">
            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <x-titlePage title="Máximos/Mínimos">
        <form action ="/maxmin" method="GET" class="flex space-x-4 justify-end">
            {{-- Depto --}}
{{--            <div class="flex flex-col w-full">--}}
{{--                <label for="category" class="text-xs text-gray-400 mb-1">Depto</label>--}}
{{--                <select name="category" id="category" class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-gray-300 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400">--}}
{{--                    <option value="0" {{ $selectedCategory ? '' : 'selected' }}>Depto</option>--}}
{{--                    @foreach ($categories as $category)--}}
{{--                        <option value="{{ $category->CategoryId }}" {{ $selectedCategory == $category->CategoryId ? 'selected' : '' }}>--}}
{{--                            {{ $category->Name }}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
            {{-- Familia --}}
{{--            <div class="flex flex-col w-full">--}}
{{--                <label for="family" class="text-xs text-gray-400 mb-1">Familia</label>--}}
{{--                <select name="family" id="family" class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-gray-300 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400">--}}
{{--                    <option value="0" {{ $selectedFamily ? '' : 'selected' }}>Familia</option>--}}
{{--                    @foreach ($families as $category)--}}
{{--                        <optgroup label="{{ $category->Name }}">--}}
{{--                            @foreach ($category->families as $family)--}}
{{--                                <option value="{{ $family->FamilyId }}" {{ $selectedFamily == $family->FamilyId ? 'selected' : '' }}>--}}
{{--                                    {{ $family->Name }}--}}
{{--                                </option>--}}
{{--                            @endforeach--}}
{{--                        </optgroup>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
            {{-- Proveedor --}}
            <div class="flex flex-col w-full">
                <label for="visibility" class="text-xs text-gray-400 mb-1">Mostrar</label>
                <select name="visibility" id="visibility"
                        class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-gray-300 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400">
                    <option value="active"   @selected(request('visibility','active') === 'active')>Activos</option>
                    <option value="archived" @selected(request('visibility') === 'archived')>Archivados</option>
                    <option value="all"      @selected(request('visibility') === 'all')>Todos</option>
                </select>
            </div>


            <div class="flex flex-col w-full">
                <label for="branch" class="text-xs text-gray-400 mb-1">Sucursal</label>
                <select name="branch" id="branch" class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-gray-300 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400">
                    <option value="0" {{ request('branch') ? '' : 'selected' }}>Sucursal</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->BranchId }}" {{ request('branch') == $branch->BranchId ? 'selected' : '' }}>
                            {{ $branch->Name }}
                        </option>
                    @endforeach
                </select>
            </div>
{{--            --}}{{-- Fechas de venta --}}
            <div class="flex flex-col w-full">
                <label for="dates1" class="text-xs text-gray-400 mb-1">Desde</label>
                <input
                    id="dates1"
                    name="dates1"
                    value="{{ old('dates1') }}"
                    placeholder="Selecciona fechas"
                    class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-gray-300 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400"
                />
            </div>
            <div class="flex flex-col justify-end">
                <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Buscar
                </button>
            </div>
        </form>
    </x-titlePage>

    <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">

        @if(isset($maxmins))
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mt-1 mb-6"> <!-- Ocupa 8/12 -->
                <div class="w-full p-4 flex justify-between items-center bg-white dark:bg-gray-800 rounded-lg">
                    <div>
                        <h3 class="text-xl sm:text-xl font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400 my-2">
                            {{ 'Estilos' }}
                        </h3>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('maxmin.search') }}" class="px-3 py-1 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Agregar
                        </a>

                    </div>
                </div>


                <table id="table" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Proveedor</th>
                        <th class="px-4 py-3">Subcategoría</th>
                        <th class="px-4 py-3">Estilo</th>
                        <th class="px-4 py-3">Color</th>
                        <th class="px-4 py-3">Pz/Pack</th>
                        <th class="px-4 py-3">Max</th>
                        <th class="px-4 py-3">Min</th>
                        <th class="px-4 py-3">Inv</th>
                        <th class="px-4 py-3">Suc</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                    <tr class="filters text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                    </tr>
                    </thead>
                    @php
                        //                            $urlParameters = ['category'=> $selectedCategory,'branch' => $selectedBranch, 'dates1' => $selectedDate1, 'dates2' => $selectedDate2];
                    @endphp
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($maxmins as $row)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{ $row['supplier'] }}</td>
                            <td class="px-4 py-3">{{ $row['subcategory'] }}</td>
                            <td class="px-4 py-3">{{ $row['code'] }}</td>
                            <td class="px-4 py-3">{{ $row['color'] }}</td>
                            <td class="px-4 py-3">{{ $row['pack_quantity'] }}</td>
                            <td class="px-4 py-3">{{ $row['total_max'] }}</td>
                            <td class="px-4 py-3">{{ $row['total_min'] }}</td>
                            <td class="px-4 py-3 font-bold">{{ $row['total_inventory'] }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center">
                                    <button @click="openModal" data-details='@json($row)' class="btn-branches px-2 py-1 rounded-full bg-green-200 text-green-800 text-xs font-semibold flex items-center justify-center">
                                        {{ $row['stock_out_count'] }}
                                    </button>
                                </div>
                            </td>
                            <td class="px-4 py-3 ">
                                <div class="flex justify-center space-x-2 text-sm">
                                    <x-editButton href="/maxmin/{{$row['id']}}/edit" />
                                    <button
                                        @click="openModal"
                                        data-details='@json([$row, $row['trashed'] ? 'unarchive' : 'archive'])'
                                        class="btn-delete items-center justify-between px-2 py-2 text-sm font-medium leading-5 rounded-lg focus:outline-none focus:shadow-outline-gray bg-gray-100 hover:bg-gray-200 text-gray-600"
                                        aria-label="Archive">
                                        @if($row['trashed'])
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001m0 0V4.355m0 4.992L17.34 6.67a8.25 8.25 0 1 0 1.635 8.86" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                            </svg>
                                        @endif
                                    </button>
                                    <button @click="openModal" data-details='@json([$row,'delete'])'
                                        class="btn-delete bg-red-600 dark:text-white items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-white rounded-lg focus:outline-none focus:shadow-outline-gray"
                                        aria-label="Delete"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            aria-hidden="true"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"
                                            ></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <!-- termina Tabla de Estilos -->
            <div id="delete-modal">
                <x-modal title="">
                    <div id="modalBody"></div>
                </x-modal>

            </div>

    </div>
</x-layout>

<link rel="stylesheet" href="{{ asset('flatpickr/dark.css') }}">
<script src="{{ asset('flatpickr/flatpickr.js') }}"></script>
<script>
    const selectedDate1 = @json($selectedDate1);
    console.log(selectedDate1);
    const datesInput1 = document.getElementById('dates1') || null;
    flatpickr1 = flatpickr(datesInput1, {
        dateFormat: "Y-m-d",
        mode: "single",
        altInput: true,
        altFormat: "d M y",
        locale: {firstDayOfWeek: 1},
        onReady: function (selectedDates1, dateStr, instance) {
            if (selectedDate1) {
                instance.setDate(selectedDate1);
            }
        },
    });

    $('#table').on('click', '.btn-delete', function () {
        const details = JSON.parse(this.dataset.details);
        const id = details[0].id;
        const type = details[1];

        const modalBody = document.getElementById('modalBody');
        let description = '';
        let action = '';
        let method = '';
        let buttonClass = '';
        let buttonText = '';

        switch(type){
            case 'delete':
                description = 'Estas seguro de eliminar el estilo?';
                action = '/maxmin/'+id+'/delete';
                method = 'DELETE';
                buttonClass = 'bg-red-600 hover:bg-red-700 focus:shadow-outline-red';
                buttonText = 'Eliminar';
                break;
            case 'archive':
                description = 'Estas seguro de archivar el estilo?';
                action = '/maxmin/'+id+'/toggle';
                method = 'PATCH';
                buttonClass = 'bg-yellow-600 hover:bg-yellow-700 focus:shadow-outline-yellow';
                buttonText = 'Archivar';
                break;
            case 'unarchive':
                description = 'Estas seguro de desarchivar el estilo?';
                action = '/maxmin/'+id+'/toggle';
                method = 'PATCH';
                buttonClass = 'bg-green-600 hover:bg-green-700 focus:shadow-outline-green';
                buttonText = 'Desarchivar';
                break;
        }

        // Construir el HTML dinámico del modal
        let modalContent = `
        <h2 class="text-base font-normal text-gray-500 dark:text-gray-400">
            Máximo y mínimo
        </h2>
        <div class="text-gray-800 dark:text-gray-200 space-y-6 text-sm leading-relaxed">
            <p class="text-red-600 dark:text-red-300">
                ${description}
            </p>
        </div>
        <div class="flex justify-end mt-4">
            <button
                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 dark:border dark:border-gray-300 dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                @click="closeModal">
                Cancelar
            </button>
            <form method="POST" action="${action}">
                @csrf
        <input type="hidden" name="_method" value="${method}">
                <button class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150
                    border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2
                    ${buttonClass} ">
                    ${buttonText}
                </button>
            </form>
        </div>
    `;

        // Insertar contenido en el modal
        modalBody.innerHTML = modalContent;
    });


    var table = $('#table').DataTable({
        orderCellsTop: true,   // asegura que la primera fila del thead se use para ordenar
        fixedHeader: true,     // opcional, si quieres que el header quede fijo
        paging:true,
        searching: true,
        info: false,
        "lenghtChange": false,
        "order": [[2, "asc"],[3, "asc"]],
    });

    table.columns().every(function() {
        var column = this;
        var colIdx = column.index();
        // ❌ No poner filtro en la columna 1 (branches)
        if (colIdx > 3) {
            return; // saltamos esta columna
        }
        // Crea select en el segundo thead (fila .filters)
        var select = $('<select><option value="">Todos</option></select>')
            .appendTo($('.filters th').eq(column.index()).empty())
            .on('change', function() {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
            });
        // Llena con valores únicos de la columna
        column.data().unique().sort().each(function(d) {
            select.append('<option value="' + d + '">' + d + '</option>');
        });

    });
</script>
<script>
    function branchesTableHtml(details) {
        const { id, code, color, supplier, subcategory, pack_quantity, branches } = details;
        const totalMin = branches.reduce((sum, b) => sum + (b.min ?? 0), 0);
        const totalMax = branches.reduce((sum, b) => sum + (b.max ?? 0), 0);
        const totalInventory = branches.reduce((sum, b) => sum + Number(b.inventory ?? 0), 0);
        const totalShortage = branches.reduce((sum, b) => {
            const max = b.max ?? 0;
            const inv = b.inventory ?? 0;
            return sum + (max > inv ? max - inv : 0);
        }, 0);
        const totalShortagePacks = branches.reduce((sum, b) => {
            const max = b.max ?? null;
            const inv = Number(b.inventory ?? 0);
            const shortage = max != null && inv < max ? (max - inv) : 0;
            return sum + (shortage > 0 ? Math.round(shortage / pack_quantity) : 0);
        }, 0);

        const rows = branches.map(b => {
            const inv = Number(b.inventory ?? 0);
            const min = b.min ?? null;
            const max = b.max ?? null;
            const shortage = max != null && inv < max ? (max - inv) : 0;
            const shortagePacks = shortage > 0 ? Math.round(shortage / pack_quantity) : 0;
            const isOverMax = max != null && inv > max;
            const isBelowMin = !!b.stock_out || (min != null && inv < min);

            let statusIcon;
            if (isOverMax) {
                statusIcon = `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-800 text-xs font-semibold">Sobre máximo</span>`;
            } else if (isBelowMin) {
                statusIcon = `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 text-red-800 text-xs font-semibold">Bajo mínimo</span>`;
            } else {
                statusIcon = `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-800 text-xs font-semibold">OK</span>`;
            }
            return `
              <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="px-3 py-2 font-medium">${b.name}</td>
                <td class="px-3 py-2 text-right">${b.min ?? ''}</td>
                <td class="px-3 py-2 text-right">${b.max ?? ''}</td>
                <td class="px-3 py-2 text-right font-semibold">${b.inventory ?? 0}</td>
                <td class="px-3 py-2 text-right">${shortage > 0 ? shortage : ''}</td>
                <td class="px-3 py-2 text-right">${shortagePacks > 0 ? shortagePacks : ''}</td>
                <td class="px-3 py-2 text-right">${statusIcon}</td>
              </tr>
            `;
        }).join('');

        return `
    <div class="space-y-4">
      <div>
        <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">Máximo y mínimo</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">${code} • ${color} • ${supplier}  • ${subcategory} • Paquete de ${pack_quantity}</p>
      </div>

      <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
        <table id ="branchDetailTable" class="min-w-full text-sm">
          <thead class="bg-gray-50 dark:bg-gray-800/50 text-gray-600 dark:text-gray-300">
            <tr>
              <th class="px-3 py-2 text-left font-medium">Sucursal</th>
              <th class="px-3 py-2 text-right font-medium">Min</th>
              <th class="px-3 py-2 text-right font-medium">Max</th>
              <th class="px-3 py-2 text-right font-medium">Existencia</th>
              <th class="px-3 py-2 text-right font-medium">Faltante</th>
              <th class="px-3 py-2 text-right font-medium">F. Packs</th>
              <th class="px-3 py-2 text-right font-medium">Estatus</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
            ${rows}
          </tbody>
            <tfoot class="bg-gray-50 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 font-semibold">
              <tr>
                <td class="px-3 py-2 text-right">Totales:</td>
                <td class="px-3 py-2 text-right">${totalMin}</td>
                <td class="px-3 py-2 text-right">${totalMax}</td>
                <td class="px-3 py-2 text-right">${totalInventory}</td>
                <td class="px-3 py-2 text-right">${totalShortage}</td>
                <td class="px-3 py-2 text-right">${totalShortagePacks}</td>
                <td class="px-3 py-2"></td>
              </tr>
            </tfoot>

        </table>
      </div>
    </div>
  `;
    }





    // Ejemplo de uso: click en botón que abre modal e inyecta tabla
    $('#table').on('click', '.btn-branches', function () {
        // Aquí asumo que dataset.details trae algo estilo:
        // { id, code, color, supplier, stockout_count, branches:[{name,min,max,inventory,stock_out}, ...] }
        const details = JSON.parse(this.dataset.details);
        // Construye el HTML de la tabla
        const html = branchesTableHtml(details);

        // Inyecta en el modal
        const modalBody = document.getElementById('modalBody');
        modalBody.innerHTML = html;

        // Inicializa DataTable después de insertar el contenido
        setTimeout(() => {
            $('#branchDetailTable').DataTable({
                paging: false,
                info: false,
                searching: false,
                responsive: true
            });
        }, 10); // pequeño delay para asegurar que el DOM está renderizado
    });

</script>


<style>

    form {
        margin: 0;
        padding: 0;
        border: none;
    }
    input, button, select, textarea {
        border: none;
        outline: none;
        background: none; /* Quita el fondo predeterminado */
        padding: 0; /* Quita el padding */
    }
    .dt-length label {
        color: #9ca3af;
    }
    /* Estilo base para todos los botones de la paginación */
    .dt-paging .dt-paging-button {
        color: #9CA3AF; /* gray-400 */
        background-color: transparent; /* Fondo transparente */
        border: none; /* Sin bordes */
        font-weight: normal;
        padding: 0.5rem 0.75rem; /* Ajuste de tamaño */
        border-radius: 0.375rem; /* Bordes redondeados */
        cursor: pointer;
    }

    /* Estilo para el botón de la página activa */
    .dt-paging .dt-paging-button.current {
        color: #9CA3AF !important; /* Gray-400 para el texto */
        background-color: transparent !important; /* Fondo transparente */
        font-weight: bold; /* Resaltar el texto de la página activa */
        border: 1px solid #9CA3AF !important; /* Borde gris para destacarlo */
    }

    /* Estilo para los botones deshabilitados */
    .dt-paging .dt-paging-button.disabled {
        color: #9CA3AF; /* gray-400 */
        cursor: not-allowed; /* Cambiar cursor cuando el botón está deshabilitado */
        opacity: 0.6; /* Reducir opacidad para indicar que está deshabilitado */
    }

    /* Asegura que el fondo del botón activo no sea oscuro */
    .dt-paging .dt-paging-button.current {
        background-color: transparent !important; /* Fondo transparente */
        color: #9CA3AF !important; /* Texto gris */
    }
    /* Cambiar el color del texto del select */
    .dt-length {
        color: #9ca3af; /* gray-400 */
    }
    /* Seleccionamos todos los inputs de paginación de DataTables */
    /* Texto dentro de los inputs/selects (v2) */
    .dt-container .dt-input,
    .dt-container .dt-search input,
    .dt-container .dt-length select {
        color: #c4c4c4;
    }
    /* Texto escrito dentro del input de búsqueda */
    .dt-container .dt-search input.dt-input {
        color: #c4c4c4 !important;
    }

    .dt-container .dt-search > label {
        color: #c4c4c4;
    }
    .dt-text-left {
        text-align: left !important;
    }
    .dt-text-right {
        text-align: right !important;
    }
    .th.th-center {
        text-align: center !important;
    }
</style>


