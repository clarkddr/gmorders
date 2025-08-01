<x-layout>
    <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
        <div class="rounded-lg space-y-2 sm:space-y-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <p class="text-gray-700 dark:text-gray-200">
                    <span id="todaySpan" class="font-semibold">{{$todayFormatted}}</span>
                    <span class="font-semibold"> VS </span>
                    <span id="lastYearSpan" class="font-semibold">{{$lastYearFormatted}}</span>
                </p>
                <form action ="/" method="GET" class="flex space-x-4 justify-end">
                    <input id="dates1" name="dates1" value="{{old('dates1')}}" class="block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />
                    <button	type="submit" class="px-3 mt-1 py-1 text-sm text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        Buscar
                    </button>
                </form>

            </div>
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg dark:bg-gray-800 w-full md:w-[calc(25%-1rem)]">
                    <span class="text-gray-500 dark:text-gray-400 text-left">Total Año Anterior</span>
                    <span id="lastYearTotal" class="text-lg font-semibold text-gray-900 dark:text-white text-right">
                      ${{number_format($amounts->sum('lastYear'),0)}}
                    </span>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg dark:bg-gray-800 w-full md:w-[calc(25%-1rem)]">
                    <span class="text-gray-500 dark:text-gray-400 text-left">A la hora Año Anterior</span>
                    <span id="lastYearAccumulated" class="text-lg font-semibold text-gray-900 dark:text-white text-right">
                        ${{ number_format($amounts->where('hour', $hourNow + 1)->first()['lastYearAccumulated'] ?? 0, 0) }}
                    </span>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg dark:bg-gray-800 w-full md:w-[calc(25%-1rem)]">
                    <span class="text-gray-500 dark:text-gray-400 text-left">Año Actual </span>
                    <span id="todayAccumulated" class="text-lg font-semibold text-gray-900 dark:text-white text-right">
                        ${{number_format($amounts->where('hour',$hourNow+1)->first()['todayAccumulated'] ?? 0,0)}}
                    </span>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg dark:bg-gray-800 w-full md:w-[calc(25%-1rem)]">
                    <span class="text-gray-500 dark:text-gray-400 text-left">Porcentaje</span>
                    <span id="relationSpanContainer" class="text-lg font-semibold text-gray-900 dark:text-white text-right">
                        <x-percentageButton below="red" above="green" :min="99" :max="100" :value="number_format($amounts->where('hour',$hourNow+1)->first()['relation'] ?? 0,0)" size="xl"/>
                    </span>
                </div>
            </div>
            <!-- Gráfico de Ventas -->
            <div class="rounded-lg shadow-xs">
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <h3 class="text-center text-lg sm:text-xl font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400 my-2">
                        {{ 'Ventas' }}
                    </h3>
                    <canvas height="250" id="sales-chart" class="w-full max-w-full"></canvas>
                </div>
            </div>
            <!-- Gráfico de Barras -->
            <div class="rounded-lg shadow-xs">
                <div class="min-w-0 p-2 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <h3 class="text-center text-lg sm:text-xl font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400 my-2">
                        {{ 'Barras' }}
                    </h3>
                    <canvas height="250" id="bars-chart" class="w-full max-w-full"></canvas>
                </div>
            </div>
        </div>
    </div>
</x-layout>
<link rel="stylesheet" href="{{ asset('flatpickr/dark.css') }}">
<script src="{{ asset('flatpickr/flatpickr.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const datesInput1 = document.getElementById('dates1') || null;
        const selectedDate1 = @json($selectedDate1);
        const isLive = @json($isLive);
        const flatpickr1 = flatpickr(datesInput1, {
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


        // Trabajamos las graficas
        let amounts = @json($amounts->values()->toArray());
        let hourNow = @json($hourNow);

        // Función para obtener el color dependiendo de la comparación con la línea de anotación
        const getBorderColor = (value) => {
            return Number(value) < 100 ? 'rgba(255, 99, 132, 0.9)' : 'rgba(28, 100, 242, 0.9)'; // Rojo si está por debajo, azul si no
        };

        const salesConfig = {
            type: 'line',
            data: {
                labels: amounts.map(amount => amount.hour),
                datasets: [
                    {
                        label: 'Ventas',
                        // Aplica el color dinámicamente para cada barra
                        backgroundColor: amounts.map(amount => getBorderColor(amount.relation)),
                        borderWidth: 2,
                        data: amounts.map(amount => amount.relation),
                        borderRadius: 5,
                        tension : 0.4,
                        segment: {
                            borderColor: (ctx) => {
                                // Obtiene los datos actuales y siguientes
                                const value = ctx.p1.parsed.y;
                                return getBorderColor(value);
                            }
                        },
                        // Habilitar el plugin para mostrar las etiquetas
                        datalabels: {
                            anchor: 'start', // Coloca las etiquetas al final de las barras
                            align: 'top', // Alineación en la parte superior de las barras
                            color: '#9ca3af',
                            font: {
                                size: 12, // Tamaño de la fuente
                            },
                            clip:false,
                            offset: 10 // Mover las etiquetas hacia abajo para evitar que se encimen con las leyendas del eje x
                        }
                    },
                ],
            },
            options: {
                layout: {
                    padding: {
                        top: 30
                    }
                },
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: false,
                        suggestedMax: Math.max(...amounts.map(amount => Math.max(amount.lastYear, amount.today))) * 1.1, // Incrementa un 10% el máximo
                        suggestedMax: 120,
                    },
                },
                plugins: {
                    // Habilitar el plugin de datos
                    datalabels: {
                        display: true,
                        align: 'top', // Alineación en la parte superior de las lineas
                        font: {
                            size: 12,
                        },
                        color: '#9ca3af',
                        formatter: function(value) {
                            return value.toFixed(0) + '%'; // Formatear los valores a 2 decimales
                        },
                        clip: false,
                        offset: 10 // Mover las etiquetas hacia abajo para evitar que se encimen con las leyendas del eje x
                    },
                    legend: {
                        display: false,
                    },
                    annotation: {
                        annotations: [
                            {
                                type: 'line',
                                mode: 'horizontal',
                                scaleID: 'y',
                                value: 100,
                                borderColor: 'rgba(255, 99, 132, 0.8)', // Color de la linea roja suave (compatible con dark mode y light mode)
                                borderWidth: 2,
                            }
                        ],
                    },
                },
            },
            // Habilitar el plugin datalabels globalmente
            plugins: [ChartDataLabels]
        };
        const barSalesConfig = {
            type: 'bar',
            data: {
                labels: amounts.map(amount => amount.hour),
                datasets: [
                    {
                        label: 'Año Pasado',
                        // Aplica el color dinámicamente para cada barra
                        // backgroundColor: relation.map(value => getBarColor(value)),
                        backgroundColor: 'rgba(255, 99, 132, 0.8)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        data: amounts.map(amount => amount.lastYear),
                        borderRadius: 5,
                        // Habilitar el plugin para mostrar las etiquetas
                        datalabels: {
                            anchor: 'end',
                            align: 'end',
                            color: '#9ca3af',
                            font: {
                                // weight: 'bold', // Estilo de fuente
                                size: 12, // Tamaño de la fuente
                            },
                            formatter: function(value) {
                                return (value / 1000).toFixed(0) + 'K'; // Convierte a porcentaje
                            },
                            clip: false,
                            offset: 0 // Mover las etiquetas hacia abajo para evitar que se encimen con las leyendas del eje x
                        }
                    },{
                        label: 'Este Año',
                        backgroundColor: 'rgba(28, 100, 242, 0.9)',
                        borderColor: 'rgba(28, 100, 242, 1)',
                        borderWidth: 2,
                        data: amounts.map(amount => amount.today),
                        borderRadius: 5,
                        // Habilitar el plugin para mostrar las etiquetas
                        datalabels: {
                            anchor: 'end', // Coloca las etiquetas al final de las barras
                            align: 'end', // Alineación en la parte superior de las barras
                            color: '#9ca3af',
                            font: {
                                // weight: 'bold', // Estilo de fuente
                                size: 12, // Tamaño de la fuente
                            },
                            formatter: function(value) {
                                return (value / 1000).toFixed(0) + 'K'; // Convierte a porcentaje
                            },
                            clip: false,
                            offset: 0 // Mover las etiquetas hacia abajo para evitar que se encimen con las leyendas del eje x
                        }
                    }
                ],
            },
            options: {
                layout: {
                    padding: {
                        top: 20
                    }
                },
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: Math.max(...amounts.map(amount => Math.max(amount.lastYear, amount.today))) * 1.1, // Incrementa un 10% el máximo
                        ticks: {
                            callback: function(value) {
                                return (value / 1000) + 'K'; // Convierte a porcentaje
                            },

                        },
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
                        clip: false,
                        offset: 10 // Mover las etiquetas hacia abajo para evitar que se encimen con las leyendas del eje x
                    },
                    legend: {
                        display: false,
                    },
                },
            },
            // Habilitar el plugin datalabels globalmente
            plugins: [ChartDataLabels]
        };
        salesChart = new Chart(document.getElementById('sales-chart').getContext('2d'), salesConfig);
        barsChart = new Chart(document.getElementById('bars-chart').getContext('2d'), barSalesConfig);

        async function fetchData() {
            try {
                const response = await fetch('/',
                    {headers: {'X-Requested-With': 'XMLHttpRequest','Content-Type': 'application/json'}});
                data = await response.json();
                const amountsArray = Array.isArray(data.amounts) ? data.amounts : Object.values(data.amounts);

                // Actualiza los datos del gráfico
                salesChart.data.labels = amountsArray.map(amount => amount.hour);
                salesChart.data.datasets[0].data = amountsArray.map(amount => amount.relation);
                salesChart.data.datasets[0].backgroundColor = amountsArray.map(amount => getBorderColor(amount.relation));
                salesChart.data.datasets[0].borderColor = amountsArray.map(amount => getBorderColor(amount.relation));
                salesChart.update();
                barsChart.data.labels = amountsArray.map(amount => amount.hour);
                barsChart.data.datasets[0].data = amountsArray.map(amount => amount.lastYear);
                barsChart.data.datasets[1].data = amountsArray.map(amount => amount.today);
                barsChart.update();
                // Se actualizan las fechas
                let thisYearSpan = document.getElementById('todaySpan');
                let lastYearSpan = document.getElementById('lastYearSpan');
                todaySpan.textContent = data.todayFormatted;
                lastYearSpan.textContent = data.lastYearFormatted;
                // Se capturan los elementos html
                let lastYearTotalSpan = document.getElementById('lastYearTotal');
                let lastYearAccumulatedSpan = document.getElementById('lastYearAccumulated');
                let todayAccumulatedSpan = document.getElementById('todayAccumulated');
                const relationSpanContainer = document.getElementById('relationSpanContainer');
                const relationSpan = relationSpanContainer.querySelector('span');
                // Se localiza la hora actual en el array de horas
                let thisHourInfo = amountsArray.find(amount => amount.hour === data.hourNow +1);
                // captura cada valor
                let lastYearAccumulatedValue = thisHourInfo.lastYearAccumulatedFormatted;
                let todayAccumulatedValue = thisHourInfo.todayAccumulatedFormatted;
                var relation = thisHourInfo.relation;
                // Se actualizan los valores en los elementos html
                lastYearAccumulatedSpan.textContent = '$'+lastYearAccumulatedValue;
                todayAccumulatedSpan.textContent = '$'+todayAccumulatedValue;
                relationSpan.textContent = relation+'%';

                const isRelationLowerThan100 = relation < 100;
                // Cambiar la clase de Tailwind del boton de porcentaje
                if (isRelationLowerThan100) {
                    relationSpan.classList.remove('bg-green-700');
                    relationSpan.classList.remove('dark:bg-green-600');
                    relationSpan.classList.remove('text-gray-700');
                    relationSpan.classList.remove('dark:text-gray-400');
                    relationSpan.classList.add('bg-red-700');
                    relationSpan.classList.add('dark:bg-red-600');
                    relationSpan.classList.add('dark:text-white');
                    relationSpan.classList.add('text-gray-900');
                } else {
                    relationSpan.classList.remove('text-gray-700');
                    relationSpan.classList.remove('dark:text-gray-400');
                    relationSpan.classList.remove('bg-red-700');
                    relationSpan.classList.remove('dark:bg-red-600');
                    relationSpan.classList.add('bg-green-700');
                    relationSpan.classList.add('dark:bg-green-600');
                    relationSpan.classList.add('dark:text-white');
                    relationSpan.classList.add('text-gray-900');
                }

                console.log(data.hourNow);
                console.log(thisHourInfo);

                console.log('Datos actualizados');
            } catch (error) {
                console.error('Error al traer los datos: ', error);
            }
        }
        if (isLive) setInterval(fetchData, 60000);
    });
</script>
