<x-guestLayout>
    <div>
    {{--    <p class="text-gray-700 dark:text-gray-200">Instrucciones de uso</p>--}}
        <button @click="openModal" class="text-white bg-green-700  px-2 py-2 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            👁️ Instrucciones para leer esta información
        </button>

    </div>
    <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg mt-8">
        <div class="rounded-lg space-y-2 sm:space-y-6">
            <p class="text-gray-700 dark:text-gray-200">
                <span id="todaySpan" class="font-semibold text-6xl">{{ucfirst($month)}}</span><br>
                <span id="todaySpan" class="font-semibold">{{$today}}</span>
                <span class="font-semibold"> VS </span>
                <span id="lastYearSpan" class="font-semibold">{{$lastYear}}</span>
                <span class="font-semibold">{{'Sucursal: ' . $name}}</span>
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
<x-modal title="">
    <div class="text-gray-800 dark:text-gray-200 space-y-6 text-sm leading-relaxed">

        <h2 class="text-lg font-semibold flex items-center gap-2">📘 INSTRUCCIONES PARA LEER ESTA INFORMACIÓN</h2>

        <p>La información mostrada es <strong>SOLO de tu tienda</strong>.</p>

        <h3 class="text-base font-semibold mt-4">🟩 PARTE I: Cuatro recuadros</h3>
        <p>Cada cuadrito tiene un número con el símbolo %. Ese número dice cómo vamos con las ventas en tu tienda. Vamos uno por uno:</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4">
                <div class="flex items-center text-lg font-semibold mb-2">
                    <span class="mr-2">📅</span> % En el Año – Color verde o rojo
                </div>
                <p>
                    Nos dice cómo vamos este año comparado con el año pasado.<br>
                    Si es menos de 100%, significa que vamos vendiendo menos que la meta del año.<br>
                    Está en rojo porque hay que mejorar, está en verde es porque vamos bien en el año.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4">
                <div class="flex items-center text-lg font-semibold mb-2">
                    <span class="mr-2">📆</span> % En el Mes – Color verde o rojo
                </div>
                <p>
                    Nos dice cómo vamos en el mes comparado con lo meta que tenemos en dicho mes.<br>
                    Si es menos de 100% está en rojo, está en verde es porque vamos bien en el año.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4">
                <div class="flex items-center text-lg font-semibold mb-2">
                    <span class="mr-2">📉</span> % Día Anterior – Color verde o rojo
                </div>
                <p>
                    Nos dice cómo vendimos ayer comparado con la meta de ese día.<br>
                    Más de 100% quiere decir que ayer fue un buen día.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4">
                <div class="flex items-center text-lg font-semibold mb-2">
                    <span class="mr-2">📈</span> % Hoy – Color verde o rojo
                </div>
                <p>
                    Nos dice cómo vamos hoy, hasta el momento, contra la meta del día actual.
                </p>
            </div>
        </div>

        <h3 class="text-base font-semibold mt-6">📊 PARTE II: Gráfica de barras</h3>

        <div class="space-y-2">
            <p><strong>📍 ¿Qué es una barra?</strong><br>
                Cada barra es un día del mes en turno.</p>

            <p><strong🔢> El número abajo</strong> (1, 2, 3, etc.) es el día del mes.</p>

            <p><strong>🎨 El color de la barra</strong> te dice si lograste la meta o no:</p>
            <ul class="list-disc list-inside ml-4">
                <li>🟢 Verde: sí se logró o se pasó</li>
                <li>🔴 Rojo: no se logró</li>
            </ul>

            <p><strong>🔝 ¿Qué significa el número arriba de cada barra?</strong><br>
                Es el porcentaje comparado con la meta.<br>
                Ejemplo: si por ejemplo, el día 1 tiene 200%, significa que ese día vendiste el doble de lo que tenías que vender.</p>

            <p><strong>❓ ¿Y los días con 0%?</strong><br>
                Son días donde no se ha vendido nada todavía o aún no llegan.</p>
        </div>

    </div>


</x-modal>

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
