<x-layout>
    @if(session('banner'))
        <x-banner message="{{session('banner.message')}}" type="success" class=""/>
    @endif

    <x-titlePage title="Ventas por Hora">
        <form action ="/purchaseoversale" method="GET" class="flex flex-col md:flex-row md:space-x-4 justify-end">
            <div class="flex items-center space-x-2">
                <input id="dates" name="dates" value="{{old('dates')}}" class="bg-gray-100 block mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" placeholder="Fechas" />
            </div>
            <button	type="submit" class="px-3 mt-1 py-1 text-sm text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-blue focus:shadow-outline-blue">
                Buscar
            </button>
        </form>
    </x-titlePage>


        <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
            <div class="rounded-lg space-y-4 sm:space-y-6 p-4">

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
                    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                        <h3 class="text-center text-lg sm:text-xl font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400 my-2">
                            {{ 'Barras' }}
                        </h3>
                        <canvas height="250" id="bars-chart" class="w-full max-w-full"></canvas>
                    </div>
                </div>

            </div>
        </div>




</x-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let amounts = @json($amounts);

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
                    // backgroundColor: relation.map(value => getBarColor(value)),
                    // borderColor: amounts.map(amount => getBorderColor(amount.relation)),
                    // borderColor: amounts.map(amount => getBorderColor(amount.relation)),
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
                    // barThickness: 35,
                    // Habilitar el plugin para mostrar las etiquetas
                    datalabels: {
                        anchor: 'start', // Coloca las etiquetas al final de las barras
                        align: 'top', // Alineación en la parte superior de las barras
                        color: '#9ca3af',
                        font: {
                            // weight: 'bold', // Estilo de fuente
                            size: 12, // Tamaño de la fuente
                        },
                        // formatter: function(value) {
                        //     return (value * 1).toFixed(0) + '%'; // Convierte a porcentaje
                        // },
                        offset: 10 // Mover las etiquetas hacia abajo para evitar que se encimen con las leyendas del eje x
                    }
                },
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
                    beginAtZero: false,
                    suggestedMax: 120,
                    // ticks: {
                    //     callback: function(value) {
                    //         return (value * 1).toFixed(0) + '%'; // Convierte a porcentaje
                    //     }
                    // }
                },
                // x: {
                //     type: 'category',
                //     labels: branches.map(branch => branch.name),
                //     position: 'bottom', // Asegura que las etiquetas se alineen correctamente
                //     stacked: false,
                // },
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
                    color: '#9ca3af',
                    formatter: function(value) {
                        return value.toFixed(0) + '%'; // Formatear los valores a 2 decimales
                    },
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
                        clip: false
                        // offset: 10 // Mover las etiquetas hacia abajo para evitar que se encimen con las leyendas del eje x
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
                        offset: 10 // Mover las etiquetas hacia abajo para evitar que se encimen con las leyendas del eje x
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
                    ticks: {
                        callback: function(value) {
                            return (value / 1000) + 'K'; // Convierte a porcentaje
                        }
                    }
                },
                // x: {
                //     type: 'category',
                //     labels: branches.map(branch => branch.name),
                //     position: 'bottom', // Asegura que las etiquetas se alineen correctamente
                //     stacked: false,
                // },
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
                // annotation: {
                //     annotations: [
                //         {
                //             type: 'line',
                //             mode: 'horizontal',
                //             scaleID: 'y',
                //             value: 100,
                //             borderColor: 'rgba(255, 99, 132, 0.8)', // Color de la linea roja suave (compatible con dark mode y light mode)
                //             borderWidth: 2,
                //         }
                //     ],
                // },
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
            amounts = await response.json();
            console.log(amounts);
            // Actualiza los datos del gráfico
            salesChart.data.labels = amounts.map(amount => amount.hour);
            salesChart.data.datasets[0].data = amounts.map(amount => amount.relation);
            salesChart.data.datasets[0].backgroundColor = amounts.map(amount => getBorderColor(amount.relation));
            salesChart.data.datasets[0].borderColor = amounts.map(amount => getBorderColor(amount.relation));
            salesChart.update();
            barsChart.data.labels = amounts.map(amount => amount.hour);
            barsChart.data.datasets[0].data = amounts.map(amount => amount.lastYear);
            barsChart.data.datasets[1].data = amounts.map(amount => amount.today);
            barsChart.update();
            console.log(amounts.map(amount => amount.lastYear));
            console.log(amounts.map(amount => amount.today));
            console.log('Datos actualizados');
        } catch (error) {
            console.error('Error al traer los datos: ', error);
        }
    }
    setInterval(fetchData, 120000);
});
</script>
