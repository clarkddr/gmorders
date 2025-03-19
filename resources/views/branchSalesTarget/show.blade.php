<x-guestLayout>
    <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg mt-16">
        <div class="rounded-lg space-y-2 sm:space-y-6">
            <p class="text-gray-700 dark:text-gray-200">
                <span id="todaySpan" class="font-semibold text-6xl">{{$month}}</span><br>
                <span id="todaySpan" class="font-semibold">{{$today}}</span>
                <span class="font-semibold"> VS </span>
                <span id="lastYearSpan" class="font-semibold">{{$lastYear}}</span>
                <span class="font-semibold">{{'Sucursal: ' . $branchid}}</span>
            </p>
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg dark:bg-gray-800 w-full md:w-[calc(25%-1rem)]">
                    <span class="text-gray-500 dark:text-gray-400 text-left">% En el Año</span>
                    <span id="lastYearTotal" class="text-lg font-semibold text-gray-900 dark:text-white text-right">
                      <x-percentageButton below="red" above="green" :min="99" :max="100" :value="number_format($yearRelation,0)" size="xl"/>
                    </span>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg dark:bg-gray-800 w-full md:w-[calc(25%-1rem)]">
                    <span class="text-gray-500 dark:text-gray-400 text-left">% En el Mes</span>
                    <span id="lastYearAccumulated" class="text-lg font-semibold text-gray-900 dark:text-white text-right">
                        <x-percentageButton below="red" above="green" :min="99" :max="100" :value="number_format($monthRelation,0)" size="xl"/>
                    </span>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg dark:bg-gray-800 w-full md:w-[calc(25%-1rem)]">
                    <span class="text-gray-500 dark:text-gray-400 text-left">% Dia Anterior </span>
                    <span id="todayAccumulated" class="text-lg font-semibold text-gray-900 dark:text-white text-right">
                        <x-percentageButton below="red" above="green" :min="99" :max="100" :value="number_format($yesterdayRelation,0,'.','')" size="xl"/>
                    </span>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg dark:bg-gray-800 w-full md:w-[calc(25%-1rem)]">
                    <span class="text-gray-500 dark:text-gray-400 text-left">% Hoy</span>
                    <span id="relationSpanContainer" class="text-lg font-semibold text-gray-900 dark:text-white text-right">
                        <x-percentageButton below="red" above="green" :min="99" :max="100" :value="number_format($todayRelation,0,',','')" size="xl"/>
                    </span>
                </div>
            </div>
            <!-- Gráfico de Barras -->
            <div class="rounded-lg shadow-xs mt-8">
                <div class="min-w-0 p-2 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <canvas height="350" id="bars-chart" class="w-full max-w-full"></canvas>
                </div>
            </div>
        </div>
    </div>
</x-guestLayout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let amounts = @json($results->values()->toArray());
        console.log(amounts);
        // Función para obtener el color dependiendo de la comparación con la línea de anotación
        const getBorderColor = (value) => {
            return Number(value) < 100 ? 'rgba(255, 99, 132, 0.9)' : 'rgba(34, 197, 94, 0.9)'; // Rojo si está por debajo, azul si no
        };
        const getBgColor = (value) => {
            return Number(value) < 100 ? 'rgba(255, 99, 132, 0.9)' : 'rgba(34, 197, 94, 0.9)'; // Rojo si está por debajo, azul si no
        };


        const barSalesConfig = {
            type: 'bar',
            data: {
                labels: amounts.map(amount => amount.day),
                datasets: [
                    {
                        label: 'Año Pasado',
                        // Aplica el color dinámicamente para cada barra
                        backgroundColor: amounts.map(amount => getBgColor(amount.relation)),
                        // backgroundColor: 'rgba(255, 99, 132, 0.8)',
                        backgroundColor: amounts.map(amount => getBorderColor(amount.relation)),
                        borderWidth: 2,
                        data: amounts.map(amount => amount.relation),
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
                                return (value).toFixed(0) + '%'; // Convierte a porcentaje
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
                        // suggestedMax: Math.max(...amounts.map(amount => Math.max(amount.lastYear, amount.today))) * 1.1, // Incrementa un 10% el máximo
                        ticks: {
                            callback: function(value) {
                                return (value) + '%'; // Convierte a porcentaje
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
                    annotation: {
                        annotations: [
                            {
                                type: 'line',
                                mode: 'horizontal',
                                scaleID: 'y',
                                value: 100,
                                borderColor: 'rgba(128, 128, 128, 0.6)',
                                borderWidth: 2,
                            }
                        ],
                    },
                },
            },
            // Habilitar el plugin datalabels globalmente
            plugins: [ChartDataLabels]
        };

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
                    relationSpan.classList.add('bg-red-700');
                    relationSpan.classList.add('dark:bg-red-600');
                } else {
                    relationSpan.classList.remove('bg-red-700');
                    relationSpan.classList.remove('dark:bg-red-600');
                    relationSpan.classList.add('bg-green-700');
                    relationSpan.classList.add('dark:bg-green-600');
                }

                console.log(data.hourNow);
                console.log(thisHourInfo);

                console.log('Datos actualizados');
            } catch (error) {
                console.error('Error al traer los datos: ', error);
            }
        }
        // setInterval(fetchData, 60000);

    });
</script>
