<x-layout>	
    @if(session('banner'))
    <x-banner message="{{session('banner.message')}}" type="success" class=""/>
    @endif
    
    <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
        <div class="rounded-lg">
            <div class="grid gap-6 mb-8 md:grid-cols-8">
                {{-- bars Chart --}}
                <div class="min-w-0 p-4 h-72 flex justify-center items-center bg-white rounded-lg shadow-xs dark:bg-gray-800 md:col-span-5"> <!-- Ocupa 8/12 -->
                    <canvas id="myChart2" class="w-full h-full"></canvas>
                </div>
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 md:col-span-5"> <!-- Ocupa 8/12 -->
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    
    
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels = ['Blusa', 'Pantalon', 'Vestido', 'Falda'];
        const sale0 = [2300, 1500, 6500, 4500]; // Datos de ventas 2024
        const sale1 = [1536, 6523, 4578, 4200]; // Datos de ventas 2023
        const sale2 = [2544, 4566, 5211, 5000]; // Datos de ventas 2022
        
        const purchase0 = [1200, 800, 4000, 2500]; // Datos de compra 2024
        const purchase1 = [800, 3000, 2500, 1800]; // Datos de compra 2023
        const purchase2 = [1000, 2200, 3000, 2300]; // Datos de compra 2022
        
        const barConfig = {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                
                {
                    label: '2024 Ventas',
                    backgroundColor: 'rgba(28, 100, 242, 0.3)', // Color de las ventas
                    borderColor: 'rgba(28, 100, 242)', // Color de las ventas
                    borderWidth: 2,
                    data: sale0,
                    borderRadius: 5,
                    
                },
                
                {
                    label: '2024 Compra',
                    type: 'line',
                    borderColor: 'rgba(28, 100, 242)', // Color de las compras con más transparencia
                    borderWidth: 1,
                    data: purchase1,
                    borderRadius: 5,
                },
                {
                    label: '2023 Ventas',
                    backgroundColor: 'rgba(126, 58, 242, 0.3)',                    
                    borderColor: 'rgba(126, 58, 242, 1)',                    
                    borderWidth: 2,
                    borderRadius: 5,
                    data: sale1,
                },
                
                {
                    label: '2023 Compra',
                    type: 'line',
                    borderColor: 'rgba(126, 58, 242, 1)', // Color de las compras con más transparencia
                    borderWidth: 1,
                    data: purchase0,
                    borderRadius: 5,
                },			
                
                
                
                
                
                
                
                
                ],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                    x: {
                        type: 'category',
                        labels: labels,
                        position: 'bottom', // Asegura que las etiquetas se alineen correctamente
                        stacked: false,
                    },
                },
                plugins: {
                    annotation:{
                        annotations: [
                        {                   
                            type: 'line',
                            mode: 'horizontal',
                            scaleID: 'y',
                            value: 2000,                       
                            
                            borderColor: 'rgba(255, 0, 0, 1)', // Color de la linea roja
                            borderWidth: 2,
                        }
                        ],
                    },
                    legend: {
                        display: true,
                    },
                },
            },
        };
        
        // Crear la gráfica
        const myChart = new Chart(document.getElementById('myChart'), barConfig);
        
    });
    
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels = ['Basico', 'Blusa', 'Bodysuit', 'Chamarra', 'Falda', 'Kimono', 'Monoshort', 'Pantalon', 'Saco/Sueter', 'Short', 'Vestido'];
        const sale2 = [1.3, 0.51, 1.17, 1.82, 0.59, 0, 0.32, 0.79, 1.78, 0.62, 0.54];
        const annotationValue = 0.6; // Valor de la línea de anotación
        
        // Función para obtener el color dependiendo de la comparación con la línea de anotación
        const getBarColor = (value) => {
            return value < annotationValue ? 'rgba(255, 99, 132, 0.6)' : 'rgba(28, 100, 242, 0.3)'; // Rojo si está por debajo, azul si no
        };
        const getBorderColor = (value) => {
            return value < annotationValue ? 'rgba(255, 99, 132, 0.9)' : 'rgba(28, 100, 242, 0.8)'; // Rojo si está por debajo, azul si no
        };
    
        const barConfig = {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: '2024 Ventas',
                        // Aplica el color dinámicamente para cada barra
                        backgroundColor: sale2.map(value => getBarColor(value)),
                        borderColor: sale2.map(value => getBorderColor(value)),                        
                        borderWidth: 2,
                        data: sale2,
                        borderRadius: 5,
                        barThickness: 35,
                        // Habilitar el plugin para mostrar las etiquetas
                        datalabels: {
                            anchor: 'start', // Coloca las etiquetas al final de las barras
                            align: 'top', // Alineación en la parte superior de las barras
                            color: 'white', // Color de las etiquetas (blanco)
                            font: {
                                // weight: 'bold', // Estilo de fuente
                                size: 11, // Tamaño de la fuente
                            },
                            formatter: function(value) {
                                return (value * 100).toFixed(0) + '%'; // Convierte a porcentaje
                            },
                            offset: 10 // Mover las etiquetas hacia abajo para evitar que se encimen con las leyendas del eje x
                        }
                    },
                ],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return (value * 100).toFixed(0) + '%'; // Convierte a porcentaje
                            }
                        }
                    },
                    x: {
                        type: 'category',
                        labels: labels,
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
        
        // Crear la gráfica
        const myChart = new Chart(document.getElementById('myChart2'), barConfig);
    });
    </script>
    