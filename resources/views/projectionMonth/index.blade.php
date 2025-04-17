<x-layout>
    @if(session('banner'))
        <x-banner message="{{session('banner.message')}}" type="success" class=""/>
    @endif
    {{-- Encabezado con título y espacio para dropdowns --}}
    <x-titlePage title="Proyección {{ 2025 }} Porcentajes">
        @if (session('success'))
            <p id="flash-message" class="dark:text-gray-200 text-gray-500 px-4 py-1 rounded text-center">
                Los cambios se han guardado exitosamente.
            </p>
        @endif
        <x-backButton :url="'/projections'"/>
        <button type="submit" form="amounts"
                class="px-4 py-2 text-sm font-medium leading-5 text-gray-200 dark:text-gray-300 transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:shadow-outline-blue">
            Guardar
        </button>
    </x-titlePage>
        {{$percentages->where('projection_id',2)->where('FamilyId',2)->where('month',1)->first()->percentage ?? 0}}
    <form name="amounts" id="amounts" action="/projectionmonth" method="POST"> @csrf
        <input type="hidden" name="projectionid" value="{{1}}">
        @foreach ($categories as $category)

    <div class="w-full overflow-hidden rounded-lg shadow-xs mb-6">
        <div class="w-full overflow-x-auto">
            <table id="table" class="w-full whitespace-no-wrap rounded-lg shadow-xs">
                <thead>
                <tr	class="text-sm font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="py-3 px-2 text-center border-r border-gray-700">Familia</th>
                    <th class="py-3 px-2 text-center border-r border-gray-700">Ene</th>
                    <th class="py-3 px-2 text-center border-r border-gray-700">Feb</th>
                    <th class="py-3 px-2 text-center border-r border-gray-700">Mar</th>
                    <th class="py-3 px-2 text-center border-r border-gray-700">Abr</th>
                    <th class="py-3 px-2 text-center border-r border-gray-700">May</th>
                    <th class="py-3 px-2 text-center border-r border-gray-700">Jun</th>
                    <th class="py-3 px-2 text-center border-r border-gray-700">Jul</th>
                    <th class="py-3 px-2 text-center border-r border-gray-700">Ago</th>
                    <th class="py-3 px-2 text-center border-r border-gray-700">Sep</th>
                    <th class="py-3 px-2 text-center border-r border-gray-700">Oct</th>
                    <th class="py-3 px-2 text-center border-r border-gray-700">Nov</th>
                    <th class="py-3 px-2 text-center border-r border-gray-700">Dic</th>
                </tr>
                </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($category['families'] as $family)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm text-center border-r border-gray-700"> {{$family->Name}} </td>
                            @foreach(range(1,12) as $month)

                            <td class="py-2 text-center border-r border-gray-700">
                                <input type="hidden" name="data[{{$family->FamilyId}}][{{$month}}][month]" value="{{$month}}">
                                <input type="hidden" name="data[{{$family->FamilyId}}][{{$month}}][id]" value="{{$family->FamilyId}}">
                                @php $value = $percentages->where('projection_id',2)->where('FamilyId',$family->FamilyId)->where('month',$month)->first()->percentage ?? '' @endphp
                                @php $active = $percentages->where('projection_id',2)->where('FamilyId',$family->FamilyId)->where('month',$month)->first()->is_active ?? false @endphp
                                <x-input_percentage_color active="{{$active}}" value="{{$value}}" name="data[{{$family->FamilyId}}][{{$month}}][percentage]"/>
                                <span class="text-xs">%</span>

                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-center text-xl border-r border-gray-700"> {{$category->Name}} </td>
                        @for($i=0;$i<12;$i++)
                        <td class="px-4 py-3 font-bold text-center text-xl border-r border-gray-700">  </td>
                        @endfor
                    </tr>
                    </tfoot>
            </table>
        </div>
    </div>

@endforeach
    </form>
</x-layout>

<script>
    setTimeout(() => {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.style.transition = 'opacity 0.5s ease';
            flashMessage.style.opacity = '0';
            setTimeout(() => flashMessage.remove(), 500); // Elimina el elemento después de la transición
        }
    }, 3000);
</script>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        $('.table').DataTable({
            dom: 't',
            responsive: true,
            paging:false,
            searching: false,
            info: false,
            lenghtChange: false,
            ordering: false,
            "order": [[]],
            "columnDefs": [{
            }]
        });
    });
</script>

<style>
    div.dt-container div.dt-layout-row {
        margin: 0 !important;
    }
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

    /* Quitar spinners en Chrome, Safari, Edge, Opera */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Quitar spinners en Firefox */
    input[type="number"] {
        -moz-appearance: textfield;
    }

</style>
