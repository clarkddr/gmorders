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
    <x-titlePage title="Resultados de Gastos">
        <form action ="/expensesresults" method="GET" class="flex space-x-4 justify-end">
            <select id="presetSelect" onchange="applyDates()" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option disabled selected>Fechas</option>
            </select>
            <input id="dates1" name="dates1" value="{{old('dates1')}}" class="block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />
{{--            <input id="dates2" name="dates2" value="{{old('dates2')}}" class="block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />--}}
            <button	type="submit" class="px-3 mt-1 py-1 text-sm text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                Buscar
            </button>
        </form>
    </x-titlePage>
        @if($expenses)
        <div class="grid gap-6 mt-2  md:grid-cols-2 xl:grid-cols-4">
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"	clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-1 text-sm font-medium text-gray-600 dark:text-gray-400">Total Gastos</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        {{$expenses['total']->first()->P1}}
                    </p>
                    <div class="space-y-1 text-xs">
                        <p class="font-normal text-gray-500 dark:text-gray-400">
                            {{$year-1}}: {{$expenses['total']->first()->P2}}
                            <span class="ml-2 font-semibold {{($expenses['total']->first()->P1vsP2 > 100 ? 'text-red-400' : 'text-green-400')}}">
                                {{$expenses['total']->first()->P1vsP2}}%
                            </span>
                        </p>
                        <p class="font-normal text-gray-500 dark:text-gray-400">
                            {{$year-2}}: {{$expenses['total']->first()->P3}}
                            <span class="ml-2 font-semibold {{($expenses['total']->first()->P1vsP3 > 100 ? 'text-red-400' : 'text-green-400')}}">
                                {{$expenses['total']->first()->P1vsP3}}%
                            </span>
                        </p>
                    </div>
                </div>



            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-1 text-sm font-medium text-gray-600 dark:text-gray-400">Operativos</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        {{$expenses['byType']->where('Type','Operativos')->first()->P1}}
                    </p>
                    <div class="space-y-1 text-xs">
                        <p class="font-normal text-gray-500 dark:text-gray-400">
                            {{$year-1}}: {{$expenses['byType']->where('Type','Operativos')->first()->P2}}
                            <span class="ml-2 font-semibold {{($expenses['byType']->where('Type','Operativos')->first()->P1vsP2 > 100 ? 'text-red-400' : 'text-green-400')}}">
                                {{$expenses['byType']->where('Type','Operativos')->first()->P1vsP2}}%
                            </span>
                        </p>
                        <p class="font-normal text-gray-500 dark:text-gray-400">
                            {{$year-2}}: {{$expenses['byType']->where('Type','Operativos')->first()->P3}}
                            <span class="ml-2 font-semibold {{($expenses['byType']->where('Type','Operativos')->first()->P1vsP3 > 100 ? 'text-red-400' : 'text-green-400')}}">
                                {{$expenses['byType']->where('Type','Operativos')->first()->P1vsP3}}%
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.99 14.993 6-6m6 3.001c0 1.268-.63 2.39-1.593 3.069a3.746 3.746 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043 3.745 3.745 0 0 1-3.068 1.593c-1.268 0-2.39-.63-3.068-1.593a3.745 3.745 0 0 1-3.296-1.043 3.746 3.746 0 0 1-1.043-3.297 3.746 3.746 0 0 1-1.593-3.068c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 0 1 1.043-3.297 3.745 3.745 0 0 1 3.296-1.042 3.745 3.745 0 0 1 3.068-1.594c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.297 3.746 3.746 0 0 1 1.593 3.068ZM9.74 9.743h.008v.007H9.74v-.007Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="mb-1 text-sm font-medium text-gray-600 dark:text-gray-400">Administrativos</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        {{$expenses['byType']->where('Type','Administrativos')->first()->P1}}
                    </p>
                    <div class="space-y-1 text-xs">
                        <p class="font-normal text-gray-500 dark:text-gray-400">
                            {{$year-1}}: {{$expenses['byType']->where('Type','Administrativos')->first()->P2}}
                            <span class="ml-2 font-semibold {{($expenses['byType']->where('Type','Administrativos')->first()->P1vsP2 > 100 ? 'text-red-400' : 'text-green-400')}}">
                                {{$expenses['byType']->where('Type','Administrativos')->first()->P1vsP2}}%
                            </span>
                        </p>
                        <p class="font-normal text-gray-500 dark:text-gray-400">
                            {{$year-2}}: {{$expenses['byType']->where('Type','Administrativos')->first()->P3}}
                            <span class="ml-2 font-semibold {{($expenses['byType']->where('Type','Administrativos')->first()->P1vsP3 > 100 ? 'text-red-400' : 'text-green-400')}}">
                                {{$expenses['byType']->where('Type','Administrativos')->first()->P1vsP3}}%
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                </div>
                <div>
                    <p class="mb-1 text-sm font-medium text-gray-600 dark:text-gray-400">Diversos</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        {{$expenses['byType']->where('Type','Diversos')->first()->P1}}
                    </p>
                    <div class="space-y-1 text-xs">
                        <p class="font-normal text-gray-500 dark:text-gray-400">
                            {{$year-1}}: {{$expenses['byType']->where('Type','Diversos')->first()->P2}}
                            <span class="ml-2 font-semibold {{($expenses['byType']->where('Type','Diversos')->first()->P1vsP2 > 100 ? 'text-red-400' : 'text-green-400')}}">
                                {{$expenses['byType']->where('Type','Diversos')->first()->P1vsP2}}%
                            </span>
                        </p>
                        <p class="font-normal text-gray-500 dark:text-gray-400">
                            {{$year-2}}: {{$expenses['byType']->where('Type','Diversos')->first()->P3}}
                            <span class="ml-2 font-semibold {{($expenses['byType']->where('Type','Diversos')->first()->P1vsP3 > 100 ? 'text-red-400' : 'text-green-400')}}">
                                {{$expenses['byType']->where('Type','Diversos')->first()->P1vsP3}}%
                            </span>
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg mt-2">
        <div class="rounded-lg">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-2"> <!-- Ocupa 8/12 -->
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Operativos por Sucursal</h2>
                <table id="byBranchTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Sucursal</th>
                        <th class="px-4 py-3">{{$year}}</th>
                        <th class="px-4 py-3">{{$year-1}}</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">{{$year-2}}</th>
                        <th class="px-4 py-3">%</th>

                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($expenses['byBranch'] as $branch)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                    {{ $branch->Branch }}

                            </td>
                            <td class="px-4 py-3">{{ $branch->P1 }}</td>
                            <td class="px-4 py-3">{{ $branch->P2 }}</td>
                            <td class="px-4 py-3">
                                <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$branch->P1vsP2" />
                            </td>
                            <td class="px-4 py-3">{{ $branch->P3 }}</td>
                            <td class="px-4 py-3">
                                <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$branch->P1vsP3" />
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $expenses['byType']->where('Type','Operativos')->first()->P1 }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $expenses['byType']->where('Type','Operativos')->first()->P2 }} </td>
                        <td class="px-4 py-3 font-bold text-xl">
                            <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$expenses['byType']->where('Type','Operativos')->first()->P1vsP2" size="xl"/>
                        </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $expenses['byType']->where('Type','Operativos')->first()->P3 }} </td>
                        <td class="px-4 py-3 font-bold text-xl">
                            <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$expenses['byType']->where('Type','Operativos')->first()->P1vsP3" size="xl"/>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-2 mt-2"> <!-- Ocupa 8/12 -->
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Operativos por Subcategoría</h2>
                <table id="bySubcategoryTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Subcategoría</th>
                        <th class="px-4 py-3">{{$year}}</th>
                        <th class="px-4 py-3">{{$year-1}}</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">{{$year-2}}</th>
                        <th class="px-4 py-3">%</th>

                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($expenses['bySubcategory'] as $subcategory)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                {{ $subcategory->Subcategory }}
                            </td>
                            <td class="px-4 py-3">{{ $subcategory->P1 }}</td>
                            <td class="px-4 py-3">{{ $subcategory->P2 }}</td>
                            <td class="px-4 py-3">
                                <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$subcategory->P1vsP2" />
                            </td>
                            <td class="px-4 py-3">{{ $subcategory->P3 }}</td>
                            <td class="px-4 py-3">
                                <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$subcategory->P1vsP3" />
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $expenses['byType']->where('Type','Operativos')->first()->P1 }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $expenses['byType']->where('Type','Operativos')->first()->P2 }} </td>
                        <td class="px-4 py-3 font-bold text-xl">
                            <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$expenses['byType']->where('Type','Operativos')->first()->P1vsP2" size="xl"/>
                        </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $expenses['byType']->where('Type','Operativos')->first()->P3 }} </td>
                        <td class="px-4 py-3 font-bold text-xl">
                            <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$expenses['byType']->where('Type','Operativos')->first()->P1vsP3" size="xl"/>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
                <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">Administrativos</h2>
                <table id="administrativesTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Subcategoría</th>
                        <th class="px-4 py-3">{{$year}}</th>
                        <th class="px-4 py-3">{{$year-1}}</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">{{$year-2}}</th>
                        <th class="px-4 py-3">%</th>

                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($expenses['administratives'] as $admin)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                {{ $admin->Subcategory }}
                            </td>
                            <td class="px-4 py-3">{{ $admin->P1 }}</td>
                            <td class="px-4 py-3">{{ $admin->P2 }}</td>
                            <td class="px-4 py-3">
                                <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$admin->P1vsP2" />
                            </td>
                            <td class="px-4 py-3">{{ $admin->P3 }}</td>
                            <td class="px-4 py-3">
                                <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$admin->P1vsP3" />
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $expenses['byType']->where('Type','Administrativos')->first()->P1 }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $expenses['byType']->where('Type','Administrativos')->first()->P2 }} </td>
                        <td class="px-4 py-3 font-bold text-xl">
                            <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$expenses['byType']->where('Type','Administrativos')->first()->P1vsP2" size="xl"/>
                        </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $expenses['byType']->where('Type','Administrativos')->first()->P3 }} </td>
                        <td class="px-4 py-3 font-bold text-xl">
                            <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$expenses['byType']->where('Type','Administrativos')->first()->P1vsP3" size="xl"/>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
                <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">Diversos</h2>
                <table id="diversesTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Subcategoría</th>
                        <th class="px-4 py-3">{{$year}}</th>
                        <th class="px-4 py-3">{{$year-1}}</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">{{$year-2}}</th>
                        <th class="px-4 py-3">%</th>

                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($expenses['diverses'] as $div)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                {{ $div->Subcategory }}
                            </td>
                            <td class="px-4 py-3">{{ $div->P1 }}</td>
                            <td class="px-4 py-3">{{ $div->P2 }}</td>
                            <td class="px-4 py-3">
                                <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$div->P1vsP2" />
                            </td>
                            <td class="px-4 py-3">{{ $div->P3 }}</td>
                            <td class="px-4 py-3">
                                <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$div->P1vsP3" />
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">
                    <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $expenses['byType']->where('Type','Diversos')->first()->P1 }} </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $expenses['byType']->where('Type','Diversos')->first()->P2 }} </td>
                        <td class="px-4 py-3 font-bold text-xl">
                            <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$expenses['byType']->where('Type','Diversos')->first()->P1vsP2" size="xl"/>
                        </td>
                        <td class="px-4 py-3 font-bold text-xl"> {{ $expenses['byType']->where('Type','Diversos')->first()->P3 }} </td>
                        <td class="px-4 py-3 font-bold text-xl">
                            <x-percentageButton below="green" above="red" :min="99" :max="100" :value="$expenses['byType']->where('Type','Diversos')->first()->P1vsP3" size="xl"/>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> <!-- Ocupa 8/12 -->
                <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">Diversos</h2>
                <table id="detailTable" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Tipo</th>
                        <th class="px-4 py-3">Sucursal</th>
                        <th class="px-4 py-3">Subcategoría</th>
                        <th class="px-4 py-3">Descripción</th>
                        <th class="px-4 py-3">Importe</th>
                        <th class="px-4 py-3">Fecha</th>
                    </tr>
                    <tr class="filters text-xs font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3"></th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($expenses['detail'] as $row)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{ $row->Type }}</td>
                            <td class="px-4 py-3">{{ $row->Branch }}</td>
                            <td class="px-4 py-3">{{ $row->Subcategory }}</td>
                            <td class="px-4 py-3">{{ $row->Description }}</td>
                            <td class="px-4 py-3">{{ $row->AmountFormatted }}</td>
                            <td class="px-4 py-3">{{ $row->Date }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        @endif


</x-layout>

<link rel="stylesheet" href="{{ asset('flatpickr/dark.css') }}">
<script src="{{ asset('flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('js/dateRanges.js') }}"></script>
<script> // Definimos las variables que pasaremos al script de DateRanges
    window.selectedDate1 = @json($selectedDate1);
    window.dates = @json($dates)
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#byBranchTable').DataTable({
            paging:true,
            searching: false,
            info: false,
            // language: {
            //     url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-MX.json"
            // },
            "lenghtChange": false,
            "order": [[1, "desc"]],
        });
        $('#bySubcategoryTable').DataTable({
            // dom: 't',
            paging:true,
            searching: false,
            info: false,
            "lenghtChange": false,
            "order": [[1, "desc"]],
        });
        $('#administrativesTable').DataTable({
            // dom: 't',
            paging:true,
            searching: false,
            info: false,
            // language: {
            //     url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
            // },
            "lenghtChange": false,
            "order": [[1, "desc"]],
        });
        $('#diversesTable').DataTable({
            // dom: 't',
            paging:true,
            searching: false,
            info: false,
            // language: {
            //     url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
            // },
            "lenghtChange": false,
            "order": [[1, "desc"]],
        });
    });

    var table = $('#detailTable').DataTable({
        orderCellsTop: true,   // asegura que la primera fila del thead se use para ordenar
        fixedHeader: true,     // opcional, si quieres que el header quede fijo
        paging:true,
        searching: true,
        info: false,
        "lenghtChange": false,
        "order": [[5, "desc"]],
    });

    table.columns().every(function() {
        var column = this;
        var colIdx = column.index();
        // ❌ No poner filtro en la columna 1 (branches)
        if (colIdx > 2 && colIdx < 5) {
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
    #byBranchTable_wrapper .dt-input,
    #bySubcategoryTable_wrapper .dt-input,
    #administrativesTable_wrapper .dt-input,
    #diversesTable_wrapper .dt-input,
    #detailTable_wrapper .dt-input{
        color: #c4c4c4; /* Color similar a gray-400 */
    }
    .dt-text-left {
        text-align: left !important;
    }
</style>
