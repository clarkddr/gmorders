<x-layout>	
	@if(session('banner'))
	<x-banner message="{{session('banner.message')}}" type="success" class=""/>
	@endif
	
	<div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg">
		<div class="rounded-lg">
			<div class="grid gap-6 mb-8 md:grid-cols-8">
				{{-- bars Chart --}}
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