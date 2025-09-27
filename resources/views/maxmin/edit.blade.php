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

    <x-titlePage title="Editar Máximo-Mínimo {{ $maxmin->code ?? '' }} - {{ $maxmin['color']['ColorName']  }}">

    </x-titlePage>

    <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">

        {{--        @if(isset($codes))--}}
        <!-- Tabla -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mt-1 mb-6 max-w-md mx-auto">

            <div class="w-full p-4 flex justify-between items-center bg-white dark:bg-gray-800 rounded-lg">
                <div>

                </div>
            </div>

            <form name="branches_maxmin" id="branches_maxmin" action="{{route('maxmin.update', $maxmin->id)}}"
                  method="POST">
                  @csrf @method('PATCH')
                <input type="hidden" name="subcategoryid" value="{{ $maxmin['SubcategoryId'] }}">
                <input type="hidden" name="supplierid" value="{{ $maxmin['SupplierId'] }}">
                <input type="hidden" name="colorid" value="{{ $maxmin['ColorId'] }}">
                <input type="hidden" name="code" value="{{ $maxmin['code'] }}">
                <table id="table" class="py-0  mx-auto whitespace-no-wrap rounded-lg shadow-xs mb-6">

                    <thead>
                    <tr class=" text-center font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Sucursal</th>
                        <th class="px-4 py-3">Mínimo</th>
                        <th class="px-4 py-3">Máximo</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($branches as $branch)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-1">{{ $branch->Name }}</td>
                            <td class="px-4 py-1">
                                <input value="{{old('branches.'.$branch->BranchId.'.min',$maxmin->branches->where('branch_id',$branch->BranchId)->first()->min ?? null)}}" name="branches[{{$branch->BranchId}}][min]"
                                       class="w-24 text-sm
                                       bg-gray-100 dark:bg-gray-700
                                       dark:text-gray-300 form-input
                                       focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray
                                       border {{ $errors->has('branches.'.$branch->BranchId.'.min') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }}">
                            </td>
                            <td class="px-4 py-1">
                                <input value="{{old('branches.'.$branch->BranchId.'.max',$maxmin->branches->where('branch_id',$branch->BranchId)->first()->max ?? null)}}" name="branches[{{$branch->BranchId}}][max]"
                                       class="w-24 text-sm
                                       bg-gray-100 dark:bg-gray-700
                                       dark:text-gray-300 form-input
                                       focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray
                                       border {{ $errors->has('branches.'.$branch->BranchId.'.max') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }}">
                            </td>

                        </tr>
                    @endforeach
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-1">Piezas/Paquete</td>
                        <td class="px-4 py-1">
                            <input value="{{old('pack_quantity',$maxmin->pack_quantity)}}" name="pack_quantity"
                                   class="w-24 text-sm
                                   bg-gray-100 dark:bg-gray-700
                                   dark:text-gray-300 form-input
                                   focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray
                                   border {{ $errors->has('pack_quantity') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }}">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <button type="submit" class="px-3 mt-1 py-1 text-sm text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                    Guardar
                </button>
            </form>
        </div>
        {{--        @endif--}}
        <!-- termina Tabla de Estilos -->
    </div>
</x-layout>


