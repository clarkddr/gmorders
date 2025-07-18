<x-layout>
    @if(session('banner'))
        <x-banner message="{{session('banner.message')}}" type="success" class=""/>
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

    @php
        $defaultUrlParameters = ['category'=> $selectedCategory,'supplier'=> $selectedSupplier,'branch' => $selectedBranch,'family' => $selectedFamily,
        'sale_dates' => $selectedSaleDates, 'purchase_dates' => $selectedPurchaseDates];
    @endphp
    <x-titlePage title="Rendimiento">
        <div class="w-full">
            <form action="/performance" method="GET" class="flex space-x-4 justify-end">
            {{-- Proveedor --}}
            <div class="flex flex-col w-full">
                <label for="supplier" class="text-xs text-gray-400 mb-1">Proveedor</label>
                <select name="supplier" id="supplier" class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-gray-300 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400">
                    <option value="0" {{ $selectedSupplier ? '' : 'selected' }}>Proveedor</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->SupplierId }}" {{ $selectedSupplier == $supplier->SupplierId ? 'selected' : '' }}>
                            {{ $supplier->Name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sucursal --}}
            <div class="flex flex-col w-full">
                <label for="branch" class="text-xs text-gray-400 mb-1">Sucursal</label>
                <select name="branch" id="branch" class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-gray-300 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400">
                    <option value="0" {{ $selectedBranch ? '' : 'selected' }}>Sucursal</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->BranchId }}" {{ $selectedBranch == $branch->BranchId ? 'selected' : '' }}>
                            {{ $branch->Name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Familia --}}
            <div class="flex flex-col w-full">
                <label for="family" class="text-xs text-gray-400 mb-1">Familia</label>
                <select name="family" id="family" class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-gray-300 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400">
                    <option value="0" {{ $selectedFamily ? '' : 'selected' }}>Familia</option>
                    @foreach ($families as $category)
                        <optgroup label="{{ $category->Name }}">
                            @foreach ($category->families as $family)
                                <option value="{{ $family->FamilyId }}" {{ $selectedFamily == $family->FamilyId ? 'selected' : '' }}>
                                    {{ $family->Name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            {{-- Depto --}}
            <div class="flex flex-col w-full">
                <label for="category" class="text-xs text-gray-400 mb-1">Depto</label>
                <select name="category" id="category" class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-gray-300 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400">
                    <option value="0" {{ $selectedCategory ? '' : 'selected' }}>Depto</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->CategoryId }}" {{ $selectedCategory == $category->CategoryId ? 'selected' : '' }}>
                            {{ $category->Name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Preset de Fechas --}}
            <div class="flex flex-col w-full">
                <label for="presetSelect" class="text-xs text-gray-400 mb-1">Fechas</label>
                <select id="presetSelect" onchange="applyDates()" class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-gray-300 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400">
                    <option disabled selected>Fechas</option>
                    <option value="year">Anual</option>
                    <option value="summer">Verano</option>
                    <option value="winter">Invierno</option>
                    <option value="lastMonth">Mes Anterior</option>
                    <option value="thisMonth">Este Mes</option>
                    <option value="twoWeeks">Dos Semanas</option>
                    <option value="week">Semana</option>
                    <option value="sevenDays">7 días</option>
                    <option value="yesterday">Ayer</option>
                    <option value="today">Hoy</option>
                </select>
            </div>

            {{-- Fechas de venta --}}
            <div class="flex flex-col w-full">
                <label for="sale_dates" class="text-xs text-gray-400 mb-1">Fechas de venta</label>
                <input
                    id="sale_dates"
                    name="sale_dates"
                    value="{{ old('sale_dates') }}"
                    placeholder="Selecciona fechas"
                    class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-gray-300 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400"
                />
            </div>

            {{-- Fechas de compra --}}
            <div class="flex flex-col w-full">
                <label for="purchase_dates" class="text-xs text-gray-400 mb-1">Fechas de compra</label>
                <input
                    id="purchase_dates"
                    name="purchase_dates"
                    value="{{ old('purchase_dates') }}"
                    placeholder="Selecciona fechas"
                    class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-gray-300 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400"
                />
            </div>

            {{-- Botón --}}
            <div class="flex flex-col justify-end">
                <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Buscar
                </button>
            </div>
    </form>
        </div>

    </x-titlePage>

    <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
        <div class="rounded-lg">
            <!-- Categories Table -->
            @if(isset($categoriesData))
            <div class="w-full overflow-hidden rounded-lg shadow-xs mb-6">
                <div class="w-full overflow-x-auto rounded-lg">
                    <table id="categoriesTable" class="w-full whitespace-no-wrap rounded-lg shadow-xs">
                        <thead>
                        <tr	class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 text-center">Departamento</th>
                            <th class="px-4 py-3 text-right">Venta Periodo</th>
                            <th class="px-4 py-3 text-right">%</th>
                            <th class="px-4 py-3 text-right">Otra Venta</th>
                            <th class="px-4 py-3 text-right">%</th>
                            <th class="px-4 py-3 text-right">Total Venta</th>
                            <th class="px-4 py-3 text-right">Compra</th>
                            <th class="px-4 py-3 text-right">Compra PV</th>
                            <th class="px-4 py-3 dt-text-right">c/v</th>
                            <th class="px-4 py-3 dt-text-right">Rend</th>
                        </tr>
                        </thead>

                        @php
                            $urlParameters = $defaultUrlParameters;
                        @endphp
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($categoriesData['categories'] as $category)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-xl">
                                    <a href="{{route('performance.index',array_merge($urlParameters,['category' => $category['categoryid']]))}}" class="underline" target="_blank">
                                        {{ $category['categoryname'] }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col items-end">
                                        <span class="text-xl">{{number_format($category['purchaseSale'],0) }}</span>
                                        <span class="text-xs text-red-400">{{number_format($category['purchaseDiscount'],0) .' - '. number_format($category['purchaseDiscountRelation'])}}%</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3"> {{ number_format($category['purchaseSaleRelation'],0) }}% </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col items-end">
                                        <span class="text-xl">{{number_format($category['otherSale'],0) }}</span>
                                        <span class="text-xs text-red-400">{{number_format($category['otherDiscount'],0) .' - '. number_format($category['otherDiscountRelation'])}}%</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3"> {{ number_format($category['otherSaleRelation'],0) }}% </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col items-end">
                                        <span class="text-xl">{{number_format($category['totalSale'],0) }}</span>
                                        <span class="text-xs text-red-400">{{number_format($category['totalDiscount'],0) .' - '. number_format($category['totalDiscountRelation'])}}%</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xl"> {{ number_format($category['purchase'],0) }} </td>
                                <td class="px-4 py-3 text-xl"> {{ number_format($category['inventory'],0) }} </td>
                                <td class="px-4 py-3 text-xl"> {{ number_format($category['purchaseVsSale'],0) }}% </td>
                                <td class="px-4 py-3 text-xl"> {{ number_format($category['performance'],0) }}% </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot class="dark:divide-gray-700">
                        <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                            <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl font-bold">{{number_format($categoriesData['totalPurchaseSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($categoriesData['totalPurchaseDiscount'],0) .' - '. number_format($categoriesData['totalPurchaseDiscountRelation'])}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-xl font-bold"> {{ number_format($categoriesData['totalPurchaseSaleRelation'],0) }}% </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl font-bold">{{number_format($categoriesData['totalOtherSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($categoriesData['totalOtherDiscount'],0) .' - '. number_format($categoriesData['totalOtherDiscountRelation'])}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-xl font-bold"> {{ number_format($categoriesData['totalOtherSaleRelation'],0) }}% </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl font-bold">{{number_format($categoriesData['totalTotalSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($categoriesData['totalTotalDiscount'],0) .' - '. number_format($categoriesData['totalTotalDiscountRelation'])}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-bold text-xl"> {{ number_format($categoriesData['totalPurchase'],0) }} </td>
                            <td class="px-4 py-3 font-bold text-xl"> {{ number_format($categoriesData['totalInventory'],0) }} </td>
                            <td class="px-4 py-3 font-bold text-xl"> {{ number_format($categoriesData['totalPurchaseVsSale'],0) }}% </td>
                            <td class="px-4 py-3 font-bold text-xl"> {{ number_format($categoriesData['totalPerformance'],0) }}% </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endif
            <!-- Families Table -->
            @if(isset($familiesData))
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
                <table id="familiesTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Familia</th>
                        <th class="px-4 py-3">Venta Periodo</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">Otra Venta</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">Venta Total</th>
                        <th class="px-4 py-3">Compra Costo</th>
                        <th class="px-4 py-3">Compra Inventario</th>
                        <th class="px-4 py-3">V/C</th>
                        <th class="px-4 py-3">Rend</th>
                    </tr>
                    </thead>

                    @php
                    $urlParameters = $defaultUrlParameters;
                    @endphp
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($familiesData['families'] as $family)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-xl">
                                <a href="{{route('performance.index',array_merge($urlParameters,['family' => $family['familyid']]))}}" class="underline" target="_blank">
                                    {{ $family['familyname'] }}
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl">{{number_format($family['purchaseSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($family['purchaseDiscount'],0) .' - '. number_format($family['purchaseDiscountRelation'],0)}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3"> {{ number_format($family['purchaseSaleRelation'],0) }}% </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl">{{number_format($family['otherSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($family['otherDiscount'],0) .' - '. number_format($family['otherDiscountRelation'],0)}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3"> {{ number_format($family['otherSaleRelation'],0) }}% </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl">{{number_format($family['totalSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($family['totalDiscount'],0) .' - '. number_format($family['totalDiscountRelation'],0)}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($family['purchase'],0) }} </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($family['inventory'],0) }} </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($family['purchaseVsSale'],0) }}% </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($family['performance'],0) }}% </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-400 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col items-end">
                                <span class="text-xl">{{number_format($familiesData['totalPurchaseSale'],0) }}</span>
                                <span class="text-xs text-red-400">{{number_format($familiesData['totalPurchaseDiscount'],0) .' - '. number_format($familiesData['totalPurchaseDiscountRelation'],0)}}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-xl"> {{ number_format($familiesData['totalPurchaseSaleRelation'],0) }}% </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col items-end">
                                <span class="text-xl">{{number_format($familiesData['totalOtherSale'],0) }}</span>
                                <span class="text-xs text-red-400">{{number_format($familiesData['totalOtherDiscount'],0) .' - '. number_format($familiesData['totalOtherDiscountRelation'],0)}}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-xl"> {{ number_format($familiesData['totalOtherSaleRelation'],0) }}% </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col items-end">
                                <span class="text-xl">{{number_format($familiesData['totalTotalSale'],0) }}</span>
                                <span class="text-xs text-red-400">{{number_format($familiesData['totalTotalDiscount'],0) .' - '. number_format($familiesData['totalTotalDiscountRelation'],0)}}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($familiesData['totalPurchase'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($familiesData['totalInventory'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($familiesData['totalPurchaseVsSale'],0) }}% </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($familiesData['totalPerformance'],0) }}% </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            @endif

            @if(isset($branchesData))
            <!-- Branches Table -->
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
                <table id="branchesTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Sucursal</th>
                        <th class="px-4 py-3">Venta Periodo</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">Otra Venta</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">Venta Total</th>
                        <th class="px-4 py-3">Compra Costo</th>
                        <th class="px-4 py-3">Compra Inventario</th>
                        <th class="px-4 py-3">V/C</th>
                        <th class="px-4 py-3">Rend</th>
                    </tr>
                    </thead>

                    @php
                        $urlParameters = $defaultUrlParameters;
                    @endphp
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($branchesData['branches'] as $branch)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-xl">
{{--                                <a href="{{route('performance.index',$urlParameters + ['branch' => $branch['branchid']])}}" class="underline" target="_blank">--}}
                                <a href="{{route('performance.index',array_merge($urlParameters, ['branch' => $branch['branchid']]))}}" class="underline" target="_blank">
                                    {{ $branch['branchname'] }}
                                </a>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl">{{number_format($branch['purchaseSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($branch['purchaseDiscount'],0) .' - '. number_format($branch['purchaseDiscountRelation'],0)}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3"> {{ number_format($branch['purchaseSaleRelation'],0) }}% </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl">{{number_format($branch['otherSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($branch['otherDiscount'],0) .' - '. number_format($branch['purchaseDiscountRelation'],0)}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3"> {{ number_format($branch['otherSaleRelation'],0) }}% </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl">{{number_format($branch['totalSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($branch['totalDiscount'],0) .' - '. number_format($branch['purchaseDiscountRelation'],0)}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($branch['purchase'],0) }} </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($branch['inventory'],0) }} </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($branch['purchaseVsSale'],0) }}% </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($branch['performance'],0) }}% </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-400 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col items-end">
                                <span class="text-xl font-bold">{{number_format($branchesData['totalPurchaseSale'],0) }}</span>
                                <span class="text-xs text-red-400">{{number_format($branchesData['totalPurchaseDiscount'],0) .' - '. number_format($branchesData['totalPurchaseDiscountRelation'],0)}}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-xl"> {{ number_format($branchesData['totalPurchaseSaleRelation'],0) }}% </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col items-end">
                                <span class="text-xl font-bold">{{number_format($branchesData['totalOtherSale'],0) }}</span>
                                <span class="text-xs text-red-400">{{number_format($branchesData['totalOtherDiscount'],0) .' - '. number_format($branchesData['totalOtherDiscountRelation'],0)}}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-xl"> {{ number_format($branchesData['totalOtherSaleRelation'],0) }}% </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col items-end">
                                <span class="text-xl font-bold">{{number_format($branchesData['totalTotalSale'],0) }}</span>
                                <span class="text-xs text-red-400">{{number_format($branchesData['totalTotalDiscount'],0) .' - '. number_format($branchesData['totalTotalDiscountRelation'],0)}}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($branchesData['totalPurchase'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($branchesData['totalInventory'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($branchesData['totalPurchaseVsSale'],0) }}% </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($branchesData['totalPerformance'],0) }}% </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            @endif
            <!-- Results Table -->
            @if(isset($resultsData))
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
                <table id="resultsTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Familia</th>
                        <th class="px-4 py-3">Sucursal</th>
                        <th class="px-4 py-3">Venta Periodo</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">Otra Venta</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">Venta Total</th>
                        <th class="px-4 py-3">Compra Costo</th>
                        <th class="px-4 py-3">Compra Inventario</th>
                        <th class="px-4 py-3">C/V</th>
                        <th class="px-4 py-3">Rend</th>
                    </tr>
                    </thead>

                    @php
                        //$urlParameters = ['category'=> $selectedCategory,'branch' => $selectedBranch, 'dates1' => $selectedDate1, 'dates2' => $selectedDate2];
                    @endphp
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($resultsData['results'] as $row)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-xl">
                                <a href="{{route('performance.index',array_merge($urlParameters,['family' => $row['familyid']]))}}" class="underline" target="_blank">
                                    {{ $row['familyname'] }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-xl">
                                <a href="{{route('performance.index',array_merge($urlParameters,['branch' => $row['branchid']]))}}" class="underline" target="_blank">
                                    {{ $row['branchname'] }}
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl">{{number_format($row['purchaseSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($row['purchaseDiscount'],0) .' - '. number_format($row['purchaseDiscountRelation'],0)}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3"> {{ number_format($row['purchaseSaleRelation'],0) }}% </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl">{{number_format($row['otherSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($row['otherDiscount'],0) .' - '. number_format($row['otherDiscountRelation'],0)}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3"> {{ number_format($row['otherSaleRelation'],0) }}% </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl">{{number_format($row['totalSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($row['totalDiscount'],0) .' - '. number_format($row['totalDiscountRelation'],0)}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($row['purchase'],0) }} </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($row['inventory'],0) }} </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($row['purchaseVsSale'],0) }}% </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($row['performance'],0) }}% </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ '' }} </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col items-end">
                                <span class="text-xl font-bold">{{number_format($resultsData['totalPurchaseSale'],0) }}</span>
                                <span class="text-xs text-red-400">{{number_format($resultsData['totalPurchaseDiscount'],0) .' - '. number_format($resultsData['totalPurchaseDiscountRelation'],0)}}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-xl"> {{ number_format($resultsData['totalPurchaseSaleRelation'],0) }}% </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col items-end">
                                <span class="text-xl font-bold">{{number_format($resultsData['totalOtherSale'],0) }}</span>
                                <span class="text-xs text-red-400">{{number_format($resultsData['totalOtherDiscount'],0) .' - '. number_format($resultsData['totalOtherDiscountRelation'],0)}}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-xl"> {{ number_format($resultsData['totalOtherSaleRelation'],0) }}% </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col items-end">
                                <span class="text-xl font-bold">{{number_format($resultsData['totalTotalSale'],0) }}</span>
                                <span class="text-xs text-red-400">{{number_format($resultsData['totalTotalDiscount'],0) .' - '. number_format($resultsData['totalTotalDiscountRelation'],0)}}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($resultsData['totalPurchase'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($resultsData['totalInventory'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($resultsData['totalPurchaseVsSale'],0) }}% </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($resultsData['totalPerformance'],0) }}% </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            @endif
            <!-- Suppliers Table -->
            @if(isset($suppliersData))
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
                <table id="suppliersTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Proveedor</th>
                        <th class="px-4 py-3">Venta Periodo</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">Otra Venta</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">Venta Total</th>
                        <th class="px-4 py-3">Compra Costo</th>
                        <th class="px-4 py-3">Compra Inventario</th>
                        <th class="px-4 py-3">C/V</th>
                        <th class="px-4 py-3">Rend</th>
                    </tr>
                    </thead>

                    @php
                        //$urlParameters = ['category'=> $selectedCategory,'branch' => $selectedBranch, 'dates1' => $selectedDate1, 'dates2' => $selectedDate2];
                    @endphp
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($suppliersData['suppliers'] as $supplier)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-xl">
                                <a href="{{route('performance.index',array_merge($urlParameters,['supplier' => $supplier['suppliername']]))}}" class="underline" target="_blank">
                                    {{ $supplier['suppliername'] }}
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl">{{number_format($supplier['purchaseSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($supplier['purchaseDiscount'],0) .' - '. number_format($supplier['purchaseDiscountRelation'],0)}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3"> {{ number_format($supplier['purchaseSaleRelation'],0) }}% </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl">{{number_format($supplier['otherSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($supplier['otherDiscount'],0) .' - '. number_format($supplier['otherDiscountRelation'],0)}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3"> {{ number_format($supplier['otherSaleRelation'],0) }}% </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col items-end">
                                    <span class="text-xl">{{number_format($supplier['totalSale'],0) }}</span>
                                    <span class="text-xs text-red-400">{{number_format($supplier['totalDiscount'],0) .' - '. number_format($supplier['totalDiscountRelation'],0)}}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($supplier['purchase'],0) }} </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($supplier['inventory'],0) }} </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($supplier['purchaseVsSale'],0) }}% </td>
                            <td class="px-4 py-3 text-xl"> {{ number_format($supplier['performance'],0) }}% </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col items-end">
                                <span class="text-xl">{{number_format($suppliersData['totalPurchaseSale'],0) }}</span>
                                <span class="text-xs text-red-400">{{number_format($suppliersData['totalPurchaseDiscount'],0) .' - '. number_format($suppliersData['totalPurchaseDiscountRelation'],0)}}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-xl"> {{ number_format($suppliersData['totalPurchaseSaleRelation'],0) }}% </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col items-end">
                                <span class="text-xl">{{number_format($suppliersData['totalOtherSale'],0) }}</span>
                                <span class="text-xs text-red-400">{{number_format($suppliersData['totalOtherDiscount'],0) .' - '. number_format($suppliersData['totalOtherDiscountRelation'],0)}}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-xl"> {{ number_format($suppliersData['totalOtherSaleRelation'],0) }}% </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col items-end">
                                <span class="text-xl">{{number_format($suppliersData['totalTotalSale'],0) }}</span>
                                <span class="text-xs text-red-400">{{number_format($suppliersData['totalTotalDiscount'],0) .' - '. number_format($suppliersData['totalTotalDiscountRelation'],0)}}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($suppliersData['totalPurchase'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($suppliersData['totalInventory'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($suppliersData['totalPurchaseVsSale'],0) }}% </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($suppliersData['totalPerformance'],0) }}% </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            @endif

        </div>
    </div>

</x-layout>

<link rel="stylesheet" href="{{ asset('flatpickr/dark.css') }}">
<script src="{{ asset('flatpickr/flatpickr.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const saleDatesInput = document.getElementById('sale_dates');
        const flatpickr1 = flatpickr(saleDatesInput, {
            // plugins: [new rangePlugin({ input: endInput })],
            dateFormat: "Y-m-d",
            mode: "range",
            altInput: true,
            altFormat: "d M y",
            locale: {firstDayOfWeek: 1},
            onReady: function(selectedDates1, dateStr, instance) {
                // Establecer el valor si ya existe uno seleccionado en la base de datos
                const selectedSaleDates = "{{ $selectedSaleDates }}"; // Recoges esto desde el backend
                if (selectedSaleDates) {
                    instance.setDate(selectedSaleDates);
                }
            },
        });
        const purchaseDatesInput = document.getElementById('purchase_dates');
        const flatpickr2 = flatpickr(purchaseDatesInput, {
            // plugins: [new rangePlugin({ input: endInput })],
            dateFormat: "Y-m-d",
            mode: "range",
            altInput: true,
            altFormat: "d M y",
            locale: {firstDayOfWeek: 1},
            onReady: function(selectedDates2, dateStr, instance) {
                // Establecer el valor si ya existe uno seleccionado en la base de datos
                const selectedPurchaseDates = "{{ $selectedPurchaseDates }}"; // Recoges esto desde el backend
                if (selectedPurchaseDates) {
                    instance.setDate(selectedPurchaseDates);
                }
            },
        });
        // Recoge todas las fechas desde Blade en una sola variable
        const predefinedDates = @json($dates);

        // Mapeo de cada opción del select a los pares de fecha a aplicar
        const thisYeardatePresets = {
            today: [predefinedDates.today, predefinedDates.today],
            yesterday: [predefinedDates.yesterday, predefinedDates.yesterday],
            thisMonth: [predefinedDates.thisMonthInitial, predefinedDates.yesterday],
            lastMonth: [predefinedDates.lastMonthInitial, predefinedDates.lastMonthEnd],
            week: [predefinedDates.initialWeekday, predefinedDates.yesterday],
            sevenDays: [predefinedDates.initialSevenDays, predefinedDates.finalSevenDays],
            twoWeeks: [predefinedDates.initialTwoWeeks, predefinedDates.yesterday],
            year: [predefinedDates.initialYear, predefinedDates.yesterday],
            winter: [predefinedDates.initialWinter, predefinedDates.finalWinter],
            summer: [predefinedDates.initialYear, predefinedDates.finalSummer],
        };

        const applyDates = () => {
            const selectedValue = document.getElementById("presetSelect").value;
            const saleDates = thisYeardatePresets[selectedValue];
            const purchaseDates = thisYeardatePresets[selectedValue];

            if(saleDates && purchaseDates){
                flatpickr2.setDate(saleDates);
                flatpickr1.setDate(purchaseDates);
            }
        }
        // Registrar la función en el ámbito global
        window.applyDates = applyDates;

        $('#categoriesTable').DataTable({
            paging:false,
            searching: false,
            info: false,
            "lenghtChange": false,
            "order": [[9, "desc"]],
        });
        $('#familiesTable').DataTable({
            paging:true,
            searching: false,
            info: false,
            "lenghtChange": false,
            "order": [[9, "desc"]],
        });
        $('#resultsTable').DataTable({
            paging:true,
            searching: true,
            info: false,
            "lenghtChange": false,
            "order": [[10, "desc"]],
        });
        $('#branchesTable').DataTable({
            dom: 't',
            paging:false,
            searching: false,
            info: false,
            "lenghtChange": false,
            "order": [[9, "desc"]],
        });
        $('#suppliersTable').DataTable({
            paging:true,
            searching: false,
            info: false,
            "lenghtChange": false,
            "order": [[9, "desc"]],
        });
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
    #familiesTable_wrapper .dt-input {
        color: #c4c4c4; /* Color similar a gray-400 */
    }
    #suppliersTable_wrapper .dt-input {
        color: #c4c4c4; /* Color similar a gray-400 */
    }
    #resultsTable_wrapper .dt-input {
        color: #c4c4c4; /* Color similar a gray-400 */
    }
    .dt-text-left {
        text-align: left !important;
    }
    th.text-right {
        text-align: right !important;
    }
</style>
