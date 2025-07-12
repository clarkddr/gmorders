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
        //$selectedCategory = request('category', old('category'));
    @endphp
    <x-titlePage title="Ventas/Compras {{$selectedCategory->name ?? ''}}">
{{--        <form action ="/saleandpurchase" method="GET" class="flex space-x-4 justify-end">--}}
{{--            <select name="branch" id="branch" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">--}}
{{--                <option value="0"  {{ $selectedBranch ? '' : 'selected' }}>Sucursal</option>--}}
{{--                @foreach ($branchesList as $branch)--}}
{{--                    <option value="{{ $branch->BranchId }}"--}}
{{--                        {{ $selectedBranch == $branch->BranchId ? 'selected' : '' }}>--}}
{{--                        {{ $branch->Name }}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--            <select name="family" id="family" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">--}}
{{--                <option value="0"  {{ $selectedFamily ? '' : 'selected' }}>Familia</option>--}}
{{--                @foreach ($familiesList as $category)--}}
{{--                    <optgroup label="{{ $category->Name }}">--}}
{{--                        @foreach ($category->families as $family)--}}
{{--                            <option value="{{ $family->FamilyId }}"--}}
{{--                                {{ $selectedFamily == $family->FamilyId ? 'selected' : '' }}>--}}
{{--                                {{ $family->Name }}--}}
{{--                            </option>--}}
{{--                @endforeach--}}
{{--                @endforeach--}}


{{--            </select>--}}
{{--            <select name="category" id="category" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">--}}
{{--                <option value="0"  {{ $selectedCategory ? '' : 'selected' }}>Depto</option>--}}
{{--                @foreach ($categoriesList as $category)--}}
{{--                    <option value="{{ $category->CategoryId }}"--}}
{{--                        {{ $selectedCategory == $category->CategoryId ? 'selected' : '' }}>--}}
{{--                        {{ $category->Name }}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--            <select id="presetSelect" onchange="applyDates()" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">--}}
{{--                <option disabled selected>Fechas</option>--}}
{{--                <option value="year">Anual</option>--}}
{{--                <option value="summer">Verano</option>--}}
{{--                <option value="winter">Invierno</option>--}}
{{--                <option value="lastMonth">Mes Anterior</option>--}}
{{--                <option value="thisMonth">Este Mes</option>--}}
{{--                <option value="twoWeeks">Dos Semanas</option>--}}
{{--                <option value="week">Semana</option>--}}
{{--                <option value="sevenDays">7 dias</option>--}}
{{--                <option value="yesterday">Ayer</option>--}}
{{--                <option value="today">Hoy</option>--}}
{{--            </select>--}}
{{--            <input id="dates2" name="dates2" value="{{old('dates2')}}" class="block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />--}}
{{--            <input id="dates1" name="dates1" value="{{old('dates1')}}" class="block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />--}}
{{--            <button	type="submit" class="px-3 mt-1 py-1 text-sm text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">--}}
{{--                Buscar--}}
{{--            </button>--}}
{{--        </form>--}}
    </x-titlePage>

    <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
        <div class="rounded-lg">

            <!-- Categories Table -->
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
                <table id="categoriesTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Departamento</th>
                        <th class="px-4 py-3">Venta Periodo</th>
                        <th class="px-4 py-3">Otra Venta</th>
                        <th class="px-4 py-3">Venta Total</th>
                        <th class="px-4 py-3">Descuento Periodo</th>
                        <th class="px-4 py-3">Otro Descuento</th>
                        <th class="px-4 py-3">Descuento Total</th>
                        <th class="px-4 py-3">Compra Costo</th>
                        <th class="px-4 py-3">Compra Inventario</th>
                        <th class="px-4 py-3">V/C</th>
                        <th class="px-4 py-3">Rend</th>
                    </tr>
                    </thead>

                    @php
                        //$urlParameters = ['category'=> $selectedCategory,'branch' => $selectedBranch, 'dates1' => $selectedDate1, 'dates2' => $selectedDate2];
                    @endphp
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($categoriesData['categories'] as $category)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 font-bold text-xl"> {{ $category['categoryname'] }} </td>
                            <td class="px-4 py-3 "> {{ number_format($category['purchaseSale'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($category['otherSale'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($category['totalSale'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($category['purchaseDiscount'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($category['otherDiscount'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($category['totalDiscount'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($category['purchase'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($category['inventory'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($category['purchaseVsSale'],0) }}% </td>
                            <td class="px-4 py-3 "> {{ number_format($category['performance'],0) }}% </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($categoriesData['totalPurchaseSale'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($categoriesData['totalOtherSale'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($categoriesData['totalTotalSale'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($categoriesData['totalPurchaseDiscount'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($categoriesData['totalOtherDiscount'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($categoriesData['totalTotalDiscount'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($categoriesData['totalPurchase'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($categoriesData['totalInventory'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($categoriesData['totalPurchaseVsSale'],0) }}% </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($categoriesData['totalPerformance'],0) }}% </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- Families Table -->
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
                <table id="familiesTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Familia</th>
                        <th class="px-4 py-3">Venta Periodo</th>
                        <th class="px-4 py-3">Otra Venta</th>
                        <th class="px-4 py-3">Venta Total</th>
                        <th class="px-4 py-3">Descuento Periodo</th>
                        <th class="px-4 py-3">Otro Descuento</th>
                        <th class="px-4 py-3">Descuento Total</th>
                        <th class="px-4 py-3">Compra Costo</th>
                        <th class="px-4 py-3">Compra Inventario</th>
                        <th class="px-4 py-3">V/C</th>
                        <th class="px-4 py-3">Rend</th>
                    </tr>
                    </thead>

                    @php
                        //$urlParameters = ['category'=> $selectedCategory,'branch' => $selectedBranch, 'dates1' => $selectedDate1, 'dates2' => $selectedDate2];
                    @endphp
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($familiesData['families'] as $family)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 font-bold text-xl whitespace-normal break-words"> {{ $family['familyname'] }} </td>
                            <td class="px-4 py-3 "> {{ number_format($family['purchaseSale'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($family['otherSale'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($family['totalSale'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($family['purchaseDiscount'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($family['otherDiscount'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($family['totalDiscount'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($family['purchase'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($family['inventory'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($family['purchaseVsSale'],0) }}% </td>
                            <td class="px-4 py-3 "> {{ number_format($family['performance'],0) }}% </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($familiesData['totalPurchaseSale'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($familiesData['totalOtherSale'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($familiesData['totalTotalSale'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($familiesData['totalPurchaseDiscount'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($familiesData['totalOtherDiscount'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($familiesData['totalTotalDiscount'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($familiesData['totalPurchase'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($familiesData['totalInventory'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($familiesData['totalPurchaseVsSale'],0) }}% </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($familiesData['totalPerformance'],0) }}% </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- Branches Table -->
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
                <table id="branchesTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Sucursal</th>
                        <th class="px-4 py-3">Venta Periodo</th>
                        <th class="px-4 py-3">Otra Venta</th>
                        <th class="px-4 py-3">Venta Total</th>
                        <th class="px-4 py-3">Descuento Periodo</th>
                        <th class="px-4 py-3">Otro Descuento</th>
                        <th class="px-4 py-3">Descuento Total</th>
                        <th class="px-4 py-3">Compra Costo</th>
                        <th class="px-4 py-3">Compra Inventario</th>
                        <th class="px-4 py-3">V/C</th>
                        <th class="px-4 py-3">Rend</th>
                    </tr>
                    </thead>

                    @php
                        //$urlParameters = ['category'=> $selectedCategory,'branch' => $selectedBranch, 'dates1' => $selectedDate1, 'dates2' => $selectedDate2];
                    @endphp
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($branchesData['branches'] as $branch)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 font-bold text-xl"> {{ $branch['branchname'] }} </td>
                            <td class="px-4 py-3 "> {{ number_format($branch['purchaseSale'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($branch['otherSale'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($branch['totalSale'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($branch['purchaseDiscount'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($branch['otherDiscount'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($branch['totalDiscount'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($branch['purchase'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($branch['inventory'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($branch['purchaseVsSale'],0) }}% </td>
                            <td class="px-4 py-3 "> {{ number_format($branch['performance'],0) }}% </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($branchesData['totalPurchaseSale'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($branchesData['totalOtherSale'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($branchesData['totalTotalSale'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($branchesData['totalPurchaseDiscount'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($branchesData['totalOtherDiscount'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($branchesData['totalTotalDiscount'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($branchesData['totalPurchase'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($branchesData['totalInventory'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($branchesData['totalPurchaseVsSale'],0) }}% </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($branchesData['totalPerformance'],0) }}% </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- Results Table -->
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
                <table id="resultsTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Familia</th>
                        <th class="px-4 py-3">Sucursal</th>
                        <th class="px-4 py-3">Venta Periodo</th>
                        <th class="px-4 py-3">Otra Venta</th>
                        <th class="px-4 py-3">Venta Total</th>
{{--                        <th class="px-4 py-3">Descuento Periodo</th>--}}
{{--                        <th class="px-4 py-3">Otro Descuento</th>--}}
{{--                        <th class="px-4 py-3">Descuento Total</th>--}}
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
                            <td class="px-4 py-3 font-bold text-xl whitespace-normal break-words"> {{ $row['familyname'] }} </td>
                            <td class="px-4 py-3 font-bold text-xl whitespace-normal break-words"> {{ $row['branchname'] }} </td>
                            <td class="px-4 py-3 "> {{ number_format($row['purchaseSale'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($row['otherSale'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($row['totalSale'],0) }} </td>
{{--                            <td class="px-4 py-3 "> {{ number_format($row['purchaseDiscount'],0) }} </td>--}}
{{--                            <td class="px-4 py-3 "> {{ number_format($row['otherDiscount'],0) }} </td>--}}
{{--                            <td class="px-4 py-3 "> {{ number_format($row['totalDiscount'],0) }} </td>--}}
                            <td class="px-4 py-3 "> {{ number_format($row['purchase'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($row['inventory'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($row['purchaseVsSale'],0) }}% </td>
                            <td class="px-4 py-3 "> {{ number_format($row['performance'],0) }}% </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ '' }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($resultsData['totalPurchaseSale'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($resultsData['totalOtherSale'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($resultsData['totalTotalSale'],0) }} </td>
{{--                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($resultsData['totalPurchaseDiscount'],0) }} </td>--}}
{{--                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($resultsData['totalOtherDiscount'],0) }} </td>--}}
{{--                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($resultsData['totalTotalDiscount'],0) }} </td>--}}
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($resultsData['totalPurchase'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($resultsData['totalInventory'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($resultsData['totalPurchaseVsSale'],0) }}% </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($resultsData['totalPerformance'],0) }}% </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Suppliers Table -->
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
                <table id="suppliersTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Proveedor</th>
                        <th class="px-4 py-3">Venta Periodo</th>
                        <th class="px-4 py-3">Otra Venta</th>
                        <th class="px-4 py-3">Venta Total</th>
                        <th class="px-4 py-3">Descuento Periodo</th>
                        <th class="px-4 py-3">Otro Descuento</th>
                        <th class="px-4 py-3">Descuento Total</th>
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
                            <td class="px-4 py-3 font-bold text-xl whitespace-normal break-words"> {{ $supplier['suppliername'] }} </td>
                            <td class="px-4 py-3 "> {{ number_format($supplier['purchaseSale'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($supplier['otherSale'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($supplier['totalSale'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($supplier['purchaseDiscount'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($supplier['otherDiscount'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($supplier['totalDiscount'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($supplier['purchase'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($supplier['inventory'],0) }} </td>
                            <td class="px-4 py-3 "> {{ number_format($supplier['purchaseVsSale'],0) }}% </td>
                            <td class="px-4 py-3 "> {{ number_format($supplier['performance'],0) }}% </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($suppliersData['totalPurchaseSale'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($suppliersData['totalOtherSale'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($suppliersData['totalTotalSale'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($suppliersData['totalPurchaseDiscount'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($suppliersData['totalOtherDiscount'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($suppliersData['totalTotalDiscount'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($suppliersData['totalPurchase'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($suppliersData['totalInventory'],0) }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($suppliersData['totalPurchaseVsSale'],0) }}% </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ number_format($suppliersData['totalPerformance'],0) }}% </td>
                    </tr>
                    </tfoot>
                </table>
            </div>


        </div>
    </div>



</x-layout>

<link rel="stylesheet" href="{{ asset('flatpickr/dark.css') }}">
<script src="{{ asset('flatpickr/flatpickr.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

{{--        const datesInput1 = document.getElementById('dates1');--}}
{{--        const flatpickr1 = flatpickr(datesInput1, {--}}
{{--            // plugins: [new rangePlugin({ input: endInput })],--}}
{{--            dateFormat: "Y-m-d",--}}
{{--            mode: "range",--}}
{{--            altInput: true,--}}
{{--            altFormat: "d M y",--}}
{{--            locale: {firstDayOfWeek: 1},--}}
{{--            onReady: function(selectedDates1, dateStr, instance) {--}}
{{--                // Establecer el valor si ya existe uno seleccionado en la base de datos--}}
{{--                const selectedDate1 = "{{ $selectedDate1 }}"; // Recoges esto desde el backend--}}
{{--                if (selectedDate1) {--}}
{{--                    instance.setDate(selectedDate1);--}}
{{--                }--}}
{{--            },--}}
{{--        });--}}
{{--        const datesInput2 = document.getElementById('dates2');--}}
{{--        const flatpickr2 = flatpickr(datesInput2, {--}}
{{--            // plugins: [new rangePlugin({ input: endInput })],--}}
{{--            dateFormat: "Y-m-d",--}}
{{--            mode: "range",--}}
{{--            altInput: true,--}}
{{--            altFormat: "d M y",--}}
{{--            locale: {firstDayOfWeek: 1},--}}
{{--            onReady: function(selectedDates2, dateStr, instance) {--}}
{{--                // Establecer el valor si ya existe uno seleccionado en la base de datos--}}
{{--                const selectedDate2 = "{{ $selectedDate2 }}"; // Recoges esto desde el backend--}}
{{--                if (selectedDate2) {--}}
{{--                    instance.setDate(selectedDate2);--}}
{{--                }--}}
{{--            },--}}
{{--        });--}}



{{--        // Recoge todas las fechas desde Blade en una sola variable--}}
{{--        const predefinedDates = @json($dates);--}}

{{--        // Mapeo de cada opción del select a los pares de fecha a aplicar--}}
{{--        const thisYeardatePresets = {--}}
{{--            today: [predefinedDates.today, predefinedDates.today],--}}
{{--            yesterday: [predefinedDates.yesterday, predefinedDates.yesterday],--}}
{{--            thisMonth: [predefinedDates.thisMonthInitial, predefinedDates.yesterday],--}}
{{--            lastMonth: [predefinedDates.lastMonthInitial, predefinedDates.lastMonthEnd],--}}
{{--            week: [predefinedDates.initialWeekday, predefinedDates.yesterday],--}}
{{--            sevenDays: [predefinedDates.initialSevenDays, predefinedDates.finalSevenDays],--}}
{{--            twoWeeks: [predefinedDates.initialTwoWeeks, predefinedDates.yesterday],--}}
{{--            year: [predefinedDates.initialYear, predefinedDates.yesterday],--}}
{{--            winter: [predefinedDates.initialWinter, predefinedDates.finalWinter],--}}
{{--            summer: [predefinedDates.initialYear, predefinedDates.finalSummer],--}}
{{--        };--}}
{{--        const lastYeardatePresets = {--}}
{{--            today: [predefinedDates.todaySameWeekdayLastYear, predefinedDates.todaySameWeekdayLastYear],--}}
{{--            yesterday: [predefinedDates.sameWeekdayLastYear, predefinedDates.sameWeekdayLastYear],--}}
{{--            thisMonth: [predefinedDates.thisMonthInitialLastYear, predefinedDates.yesterdayLastYear],--}}
{{--            lastMonth: [predefinedDates.lastMonthInitialLastYear, predefinedDates.lastMonthEndLastYear],--}}
{{--            week: [predefinedDates.initialWeekdayLastYear, predefinedDates.finalWeekdayLastYear],--}}
{{--            sevenDays: [predefinedDates.initialSevenDaysLastYear, predefinedDates.finalSevenDaysLastYear],--}}
{{--            twoWeeks: [predefinedDates.initialTwoWeeksLastYear, predefinedDates.finalTwoWeeksLastYear],--}}
{{--            year: [predefinedDates.initialLastYear, predefinedDates.finalLastYear],--}}
{{--            summer: [predefinedDates.initialLastYear, predefinedDates.finalSummerLastYear],--}}
{{--            winter: [predefinedDates.initialWinterLastYear, predefinedDates.finalWinterLastYear],--}}
{{--        };--}}

{{--        const applyDates = () => {--}}
{{--            const selectedValue = document.getElementById("presetSelect").value;--}}
{{--            const firstDates = thisYeardatePresets[selectedValue];--}}
{{--            const secondDates = lastYeardatePresets[selectedValue];--}}

{{--            if(firstDates && secondDates){--}}
{{--                flatpickr2.setDate(firstDates);--}}
{{--                flatpickr1.setDate(secondDates);--}}
{{--            }--}}
{{--        }--}}
{{--        // Registrar la función en el ámbito global--}}
{{--        window.applyDates = applyDates;--}}

        $('#categoriesTable').DataTable({
            paging:false,
            searching: false,
            info: false,
            "lenghtChange": false,
            "order": [[10, "desc"]],
        });
        $('#familiesTable').DataTable({
            paging:true,
            searching: false,
            info: false,
            "lenghtChange": false,
            "order": [[10, "desc"]],
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
            paging:true,
            searching: false,
            info: false,
            "lenghtChange": false,
            "order": [[10, "desc"]],
        });
        $('#suppliersTable').DataTable({
            paging:true,
            searching: false,
            info: false,
            "lenghtChange": false,
            "order": [[10, "desc"]],
        });
{{--        $('#suppliersTable').DataTable({--}}
{{--            // dom: 't',--}}
{{--            paging:true,--}}
{{--            searching: false,--}}
{{--            info: false,--}}
{{--            // language: {--}}
{{--            //     url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"--}}
{{--            // },--}}
{{--            "lenghtChange": false,--}}
{{--            "order": [[1, "desc"]],--}}
{{--        });--}}

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
</style>
