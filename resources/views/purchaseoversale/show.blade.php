<x-layout>	
    @if(session('banner'))
    <x-banner message="{{session('banner.message')}}" type="success" class=""/>
    @endif
    {{-- Encabezado con título y espacio para dropdowns --}}
    <x-titlePage title="Ventas/Compras de {{$family['name']?? ''}}">
        <a class="flex items-center px-3 mt-1 py-1  text-gray-600 dark:text-gray-300 text-sm transition-colors duration-150 bg-transparent border border-gray-500 outline-gray-500 rounded-md  hover:bg-gray-700 focus:outline-gray focus:shadow-outline-gray"
        href="{{ route('purchaseoversale.index',['goal'=>$vars['goal'], 'tc'=>$vars['tc'], 'max'=>$vars['max'], 'min'=>$vars['min'], 'dates'=>$selectedDate])}}"	>
            Regresar
        </a>
        <form action ="{{route('purchaseoversale.show', $family['familyId'])}}" method="GET" class="flex flex-col md:flex-row md:space-x-4 justify-end">
            <div class="flex items-center space-x-2">
                <select id="dropdown" onchange="redirect()" class="bg-gray-100 block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">                    				
                    @foreach ($familiesList as $familyList)						
                    <option {{ ($family['familyId'] ?? null) == $familyList->FamilyId ? 'selected' : '' }}						
                    value="{{$familyList->FamilyId}}">{{$familyList['Name']}}</option>
                    @endforeach
                </select>
            </div>        
            <div class="flex items-center space-x-2">
                <label for="goal" class="text-sm dark:text-gray-300">Meta</label>
                <input id="goal" name="goal" value="{{old('goal', $vars['goal'])}}" placeholder="Meta"
                class="w-16 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input 
					   bg-gray-100 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
            </div>
            <div class="flex items-center space-x-2">
                <label for="tc" class="text-sm dark:text-gray-300">TC</label>
                <input id="tc" name="tc" value="{{old('tc', $vars['tc'])}}" placeholder="TC"
                class="w-16 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input 
					   bg-gray-100 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
            </div>
            <div class="flex items-center space-x-2">
                <label for="max" class="text-sm dark:text-gray-300">Max</label>
                <input id="max" name="max" value="{{old('max', $vars['max'])}}" placeholder="Maximo"
                class="w-12 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input 
					   bg-gray-100 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
            </div>
            <div class="flex items-center space-x-2">
                <label for="min" class="text-sm dark:text-gray-300">Min</label>
                <input id="min" name="min" value="{{old('min', $vars['min'])}}" placeholder="Minimo"
                class="w-12 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input 
					   bg-gray-100 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
            </div>
            <div class="flex items-center space-x-2">
                <input id="dates" name="dates" value="{{old('dates')}}" class="bg-gray-100 block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />
            </div>
            <button	type="submit" class="px-3 mt-1 py-1 text-sm text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-blue focus:shadow-outline-blue">
                Buscar
            </button>
        </form>        		
    </x-titlePage>
    
    <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
        <div class="rounded-lg">
            @if (isset($branches))			
            <div class="rounded-lg shadow-xs mb-4">
                <div class="min-w-0 p-4bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <h3 class="text-center text-lg font-semibold tracking-wide text-left text-gray-500 uppercase dark:text-gray-400 my-1">{{ 'Compra vs Venta %' }}</h3>
                    <canvas height="250" id="relation-chart" class="w-full"></canvas>
                </div> 
            </div>
            <div class="rounded-lg shadow-xs mb-4">
                <div class="min-w-0 p-4bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <h3 class="text-center text-lg font-semibold tracking-wide text-left text-gray-500 uppercase dark:text-gray-400 my-1">{{ 'Compra vs Venta $' }}</h3>
                    <canvas height="250" id="salepurchase-chart" class="w-full"></canvas>
                </div> 
            </div>
            
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-6"> 
                <table id="table" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs mb-6">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Sucursal</th>
                            <th class="px-4 py-3">Venta</th>
                            <th class="px-4 py-3">Compra Costo</th>
                            <th class="px-4 py-3">Compra P.Venta</th>
                            <th class="px-4 py-3">C/V%</th>							
                            <th class="px-4 py-3">Por Comprar Dlls</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">						
                        @foreach ($branches as $branch)				
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{ $branch['name'] }}</td>
                            <td class="px-4 py-3">{{ $branch['sale'] }}</td>
                            <td class="px-4 py-3">{{ $branch['purchaseCost'] }}</td>
                            <td class="px-4 py-3">{{ $branch['purchaseSale'] }}</td>
                            <td class="px-4 py-3">
                                <x-percentageButton below="green" above="red" :min="$vars['min']" :max="$vars['max']" :value="$branch['relation']" />
                            </td> 							
                            <td class="px-4 py-3 text-sm">{{ $branch['toPurchaseDlls'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="dark:divide-gray-700">				
                        <tr class="px-4 py-3 mb-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                            <td class="px-4 py-3 font-bold text-xl"> {{ 'Total' }} </td>		
                            <td class="px-4 py-3 font-bold text-xl"> {{ $family['sale'] }} </td>		
                            <td class="px-4 py-3 font-bold text-xl"> {{ $family['purchaseCost'] }} </td>		
                            <td class="px-4 py-3 font-bold text-xl"> {{ $family['purchaseSale'] }} </td>		
                            <td class="px-4 py-3 font-bold text-xl">
                                <x-percentageButton size="xl" below="green" above="red" :min="$vars['min']" :max="$vars['max']" :value="$family['relation']" /></td>		
                                <td class="px-4 py-3 font-bold text-xl"> {{ $family['toPurchaseDlls'] }} </td>		
                            </tr>
                        </tfoot>
                    </table>				
                </div>						
                @endif			
            </div>
        </div>
    </div>
    
    
    
</x-layout>

<link rel="stylesheet" href="{{ asset('flatpickr/dark.css') }}">
<script src="{{ asset('flatpickr/flatpickr.js') }}"></script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const datesInput = document.getElementById('dates');                
        flatpickr(datesInput, {		
            dateFormat: "Y-m-d",
            mode: "range",
            onReady: function(selectedDates, dateStr, instance) {
                const selectedDate = "{{ $selectedDate }}"; // Recoges esto desde el backend
                if (selectedDate) {
                    instance.setDate(selectedDate);
                }
            },
        });
        
        $('#table').DataTable({
            dom: 't',
            paging:false,
            searching: false,
            info: false,
            lenghtChange: false,
            "order": [[]],
            "columnDefs": [{
                //"targets": 3, "orderable": false,                
            }]
        });
    });	
    
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        
        branches = @json($branches);
        const annotationValue = @json($vars['goal']);
        
        // Función para obtener el color dependiendo de la comparación con la línea de anotación
        const getBarColor = (value) => {
            return Number(value) < Number(annotationValue) ? 'rgba(255, 99, 132, 0.8)' : 'rgba(28, 100, 242, 0.8)'; // Rojo si está por debajo, azul si no
        };
        const getBorderColor = (value) => {
            return Number(value) < Number(annotationValue) ? 'rgba(255, 99, 132, 0.9)' : 'rgba(28, 100, 242, 0.9)'; // Rojo si está por debajo, azul si no
        };
        
        const relationConfig = {
            type: 'bar',
            data: {
                labels: branches.map(branch => branch.name),
                datasets: [
                {
                    label: 'Ventas',
                    // Aplica el color dinámicamente para cada barra
                    // backgroundColor: relation.map(value => getBarColor(value)),
                    backgroundColor: branches.map(branch => getBarColor(branch.relation)),
                    borderColor: branches.map(branch => getBorderColor(branch.relation)),
                    // borderColor: relation.map(value => getBorderColor(value)),                        
                    borderWidth: 2,
                    data: branches.map(branch => branch.relation),
                    borderRadius: 5,
                    // barThickness: 35,
                    // Habilitar el plugin para mostrar las etiquetas
                    datalabels: {
                        anchor: 'start', // Coloca las etiquetas al final de las barras
                        align: 'top', // Alineación en la parte superior de las barras
                        color: 'white', // Color de las etiquetas (blanco)
                        font: {
                            // weight: 'bold', // Estilo de fuente
                            size: 12, // Tamaño de la fuente
                        },
                        formatter: function(value) {
                            return (value * 1).toFixed(0) + '%'; // Convierte a porcentaje
                        },
                        offset: 10 // Mover las etiquetas hacia abajo para evitar que se encimen con las leyendas del eje x
                    }
                },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return (value * 1).toFixed(0) + '%'; // Convierte a porcentaje
                            }
                        }
                    },
                    x: {
                        type: 'category',
                        labels: branches.map(branch => branch.name),
                        position: 'bottom', // Asegura que las etiquetas se alineen correctamente
                        stacked: false,
                    },
                },
                plugins: {
                    // Habilitar el plugin de datos
                    datalabels: {
                        display: true,
                        align: 'top', // Alineación en la parte superior de las barras
                        font: {
                            // weight: 'bold',
                            size: 12,
                        },
                        color: 'white', // Color de las etiquetas (blanco)
                        formatter: function(value) {
                            return value.toFixed(2); // Formatear los valores a 2 decimales
                        },
                        offset: 10 // Mover las etiquetas hacia abajo para evitar que se encimen con las leyendas del eje x
                    },
                    annotation: {
                        annotations: [
                        {                   
                            type: 'line',
                            mode: 'horizontal',
                            scaleID: 'y',
                            value: annotationValue,
                            borderColor: 'rgba(255, 99, 132, 0.8)', // Color de la linea roja suave (compatible con dark mode y light mode)
                            borderWidth: 2,
                        }
                        ],
                    },
                    legend: {
                        display: false,
                    },
                },
            },
            // Habilitar el plugin datalabels globalmente
            plugins: [ChartDataLabels]
        };
        new Chart(document.getElementById('relation-chart').getContext('2d'), relationConfig);	
        
        
        const sale = branches.map(branch => parseInt(branch.sale.replace(/,/g, ''))); // Convertir a número		
        const purchase = branches.map(branch => parseInt(branch.purchaseCost.replace(/,/g, ''))); // Convertir a número	
        const salepurchaseConfig = {
            type: 'bar',
            data: {
                labels: branches.map(branch => branch.name),
                datasets: [
                {
                    label: 'Ventas',						
                    backgroundColor: 'rgba(28, 100, 242, 0.3)',
                    borderColor: 'rgba(28, 100, 242, 0.8)',
                    borderWidth: 2,
                    data: sale,
                    borderRadius: 5,					
                },
                {
                    label: 'Compras',
                    type: 'line',
                    backgroundColor: 'rgba(52, 211, 153, 0.3)',
                    borderColor: 'rgba(52, 211, 153, 0.8)',					
                    borderWidth: 2,
                    data: purchase,
                    borderRadius: 5,					
                },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                    x: {
                        type: 'category',
                        labels: branches.map(branch => branch.name),
                        position: 'bottom', // Asegura que las etiquetas se alineen correctamente
                        stacked: false,
                    },
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
            
            
        };	
        new Chart(document.getElementById('salepurchase-chart').getContext('2d'), salepurchaseConfig);
        
    });
    
    
</script>
<script>
    function redirect() {
        var dropdown = document.getElementById("dropdown");
        var selectedFamilyId = dropdown.value;

        if (selectedFamilyId) {
            // Obtener la URL actual
            var currentUrl = new URL(window.location.href);

            // Cambiar el segmento de path al nuevo familyid seleccionado
            var newUrl = `${currentUrl.origin}/purchaseoversale/${selectedFamilyId}${currentUrl.search}`;

            // Redirigir a la nueva URL
            window.location.href = newUrl;
        }
    }
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
</style>