@extends('admin.layouts.private')

@section('content')
<div class="container  mt-4">




    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="text-center">Dashboard Financiero y de Actividades</h1>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-6 mb-4">
            
            <!-- Primera gráfica - Total de Ventas € -->
            <div class="card mb-4">
                <div class="card-body">
                    <canvas id="totalSalesChart"></canvas>
                    <div class="d-flex align-items-center justify-content-between">
                        <div style="display: flex; align-items: center;">
                            <label for="yearSelector1" style="margin-right: 10px;">Año: </label>
                            <input type="range" id="yearSelector1" min="2014" max="{{ max($years->toArray()) }}" value="{{ $selectedYear }}" step="1" style="width: 300px;">
                            <span id="yearValue1" style="margin-left: 10px;">{{ $selectedYear }}</span>
                        </div>
                        <span data-toggle="tooltip" data-placement="top" title="Esta gráfica muestra las Ventas € totales durante cada mes de un año. En el eje X están los meses del año, y en el eje Y las Ventas € totales en dinero por cada mes.">
                            <i class="bi bi-info-circle" style="font-size: 1.5em; cursor: pointer; margin-left: 10px;"></i>
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Segunda gráfica - Resrvas Totales -->
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Canvas para el gráfico de reservas por mes -->
                    <canvas id="reservationsByMonthChart"></canvas>

                    <div class="d-flex align-items-center justify-content-between">
                        <div style="display: flex; align-items: center;">
                            <label for="yearSelector2" style="margin-right: 10px;">Año: </label>
                            <input type="range" id="yearSelector2" min="2014" max="{{ max($years->toArray()) }}" value="{{ $selectedYear }}" step="1" style="width: 300px;">
                            <span id="yearValue2" style="margin-left: 10px;">{{ $selectedYear }}</span>
                        </div>

                        <!-- Icono de información con tooltip -->
                        <span data-toggle="tooltip" data-placement="top" title="Esta gráfica muestra las reservas totales durante cada mes de un año. En el eje X están los meses del año, y en el eje Y el total de reservas realizadas en cada mes.">
                            <i class="bi bi-info-circle" style="font-size: 1.5em; cursor: pointer; margin-left: 10px;"></i>
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Tercera gráfica - Distribución de Actividades realizadas -->
        <!-- Contenedor para la gráfica y la leyenda -->


        <div class="col-md-6 mb-4">
            <div class="card mb-4">
               <!-- Contenedor para la gráfica y la leyenda -->
                <div class="d-wrap justify-content-between p-5 ">
                    <!-- Canvas para la gráfica de distribución de actividades -->
                    <div style="flex-grow: 1; margin-right: 20px;">
                        <canvas id="statusDistributionChart"></canvas>
                    </div>
                    
                    <!-- Contenedor de la leyenda (con scroll) -->
                    <div style="max-width: 100%; overflow-y: auto; height: 197px;">
                        <ul id="legend" class="list-unstyled">
                            <!-- La leyenda será generada aquí mediante JavaScript -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

 

    </div>
 


</div> 
<script src="{{ asset('js/admin/obtencionDatos.js') }}" type="module"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

 

<!-- Primera gráfica - Cantidad de Ventas € por año y mes -->
<script>
    // Obtener el contexto del canvas donde se renderizará el gráfico de ventas
    const totalSalesCtx = document.getElementById('totalSalesChart').getContext('2d');

    // Datos de ventas pasados desde el controlador
    const salesData = @json($salesData);  // Los datos de ventas por mes por año
    const selectedYear1 = '{{ $selectedYear }}';  // Año seleccionado

    // Extraemos los meses y las ventas para el año seleccionado
    const months1 = salesData[selectedYear1][0];  // Los meses
    const sales = salesData[selectedYear1][1];  // Ventas € por mes

    // Color usado para las barras del gráfico y el slider
    const sliderColor1 = 'rgb(75, 192, 192)';
    
    // Crear el gráfico de barras para las ventas totales
    const totalSalesChart = new Chart(totalSalesCtx, {
        type: 'bar',  // Tipo de gráfico: Barras
        data: {
            labels: months1,  // Los meses del año
            datasets: [{
                label: `Ventas € Totales (${selectedYear1})`,  // Etiqueta del gráfico
                data: sales,  // Ventas € por mes
                backgroundColor: 'rgba(75, 192, 192, 0.2)',  // Color de fondo de las barras
                borderColor: sliderColor1,  // Color del borde de las barras
                borderWidth: 1  // Ancho del borde
            }]
        },
        options: {
            responsive: true,  // Hacer que el gráfico sea responsivo
            scales: {
                y: {
                    beginAtZero: true  // Asegurarse de que el eje Y comience en 0
                }
            }
        }
    });

    // Función para actualizar el color del slider
    function updateSliderColor1() {
        const value = yearSlider1.value;  // Obtener el valor del slider
        const percentage = (value - yearSlider1.min) / (yearSlider1.max - yearSlider1.min) * 100;
        yearSlider1.style.background = `linear-gradient(to right, ${sliderColor1} ${percentage}%, #ddd ${percentage}%)`;
    }

    // Función para actualizar el gráfico cuando se cambie el año usando el slider
    const yearSlider1 = document.getElementById('yearSelector1');
    const yearValue1 = document.getElementById('yearValue1');

    yearSlider1.addEventListener('input', (e) => {
        const newYear = e.target.value;
        yearValue1.textContent = newYear;  // Mostrar el año seleccionado
        updateChart(newYear); // Actualizar el gráfico con el nuevo año seleccionado
        updateSliderColor1();  // Actualizar el color del slider
    });

    // Función para actualizar el gráfico de ventas por mes cuando se cambia el año
    function updateChart(year) {
        // Extraemos las nuevas ventas y meses para el año seleccionado
        const newSales = salesData[year][1];  // Nuevas ventas por mes para el año seleccionado
        const newMonths = salesData[year][0];  // Nuevos meses para el año seleccionado

        // Actualizar los datos del gráfico
        totalSalesChart.data.datasets[0].data = newSales;
        totalSalesChart.data.labels = newMonths;

        // Redibujar el gráfico
        totalSalesChart.update();
    }

    // Inicializar el color del slider al cargar la página
    updateSliderColor1();
</script>


<!-- Segunda gráfica - Distribución de cantidad de Ventas € por actividad -->
<script>
    // Obtener el contexto del canvas donde se renderizará el gráfico de reservas
    const reservationsByMonthCtx = document.getElementById('reservationsByMonthChart').getContext('2d');

    // Datos de reservas pasados desde el controlador
    const reservationsData = @json($reservationsData);  // Los datos de reservas por mes por año
    const selectedYear = '{{ $selectedYear }}';  // Año seleccionado

    // Extraemos los meses y las reservas para el año seleccionado
    const months = reservationsData[selectedYear][0];  // Los meses
    const reservations = reservationsData[selectedYear][1];  // Total de reservas por mes

    // Color usado para las barras del gráfico y el slider
    const sliderColor = 'rgb(255, 191, 1)';
    
    // Crear el gráfico de barras
    const reservationsChart = new Chart(reservationsByMonthCtx, {
        type: 'bar',  // Tipo de gráfico: Barras
        data: {
            labels: months,  // Los meses del año
            datasets: [{
                label: `Reservas Totales (${selectedYear})`,  // Etiqueta del gráfico
                data: reservations,  // Total de reservas por mes
                backgroundColor: 'rgba(254, 72, 0, 0.2)',  // Color de fondo de las barras
                borderColor: sliderColor,  // Color del borde de las barras
                borderWidth: 1  // Ancho del borde
            }]
        },
        options: {
            responsive: true,  // Hacer que el gráfico sea responsivo
            scales: {
                y: {
                    beginAtZero: true  // Asegurarse de que el eje Y comience en 0
                }
            }
        }
    });

    // Función para actualizar el color del slider
    function updateSliderColor() {
        const value = yearSlider2.value;
        const percentage = (value - yearSlider2.min) / (yearSlider2.max - yearSlider2.min) * 100;
        yearSlider2.style.background = `linear-gradient(to right, ${sliderColor} ${percentage}%, #ddd ${percentage}%)`;
    }

    // Función para actualizar el gráfico cuando se cambie el año usando el slider
    const yearSlider2 = document.getElementById('yearSelector2');
    const yearValue2 = document.getElementById('yearValue2');

    yearSlider2.addEventListener('input', (e) => {
        const newYear = e.target.value;
        yearValue2.textContent = newYear;  // Mostrar el año seleccionado
        updateChart2(newYear); // Actualizar el gráfico con el nuevo año seleccionado
        updateSliderColor();  // Actualizar el color del slider
    });

    // Función para actualizar el gráfico de reservas por mes cuando se cambia el año
    function updateChart2(year) {
        // Extraemos las nuevas reservas y meses para el año seleccionado
        const newReservations = reservationsData[year][1];  // Nuevas reservas por mes para el año seleccionado
        const newMonths = reservationsData[year][0];  // Nuevos meses para el año seleccionado

        // Actualizar los datos del gráfico
        reservationsChart.data.datasets[0].data = newReservations;
        reservationsChart.data.labels = newMonths;

        // Redibujar el gráfico
        reservationsChart.update();
    }

    // Inicializar el color del slider al cargar la página
    updateSliderColor();
</script>

<!-- Tercera gráfica - Distribución de cantidad de Ventas € por actividad -->
<script>
    // Obtener el contexto del canvas donde se renderizará el gráfico de actividades
    const statusDistributionCtx = document.getElementById('statusDistributionChart').getContext('2d');

    // Datos de actividades pasados desde el controlador
    const statusData = @json($statusData);  // Los datos de actividades por tipo
    const activities = statusData[0];  // Tipos de actividades (service_flow)
    const activityCounts = statusData[1];  // Cantidad de actividades por tipo

    // Función para generar colores aleatorios (sin repetirse)
    function generateRandomColors(n) {
        const colors = [];
        for (let i = 0; i < n; i++) {
            const color = `rgb(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)})`;
            colors.push(color);
        }
        return colors;
    }

    // Generar colores aleatorios para cada actividad
    const colors = generateRandomColors(activities.length);

    // Inicializar el gráfico de distribución de actividades
    const statusDistributionChart = new Chart(statusDistributionCtx, {
        type: 'pie',  // Tipo de gráfico: Pastel
        data: {
            labels: activities,  // Tipos de actividades
            datasets: [{
                label: 'Distribución de Actividades',
                data: activityCounts,  // Cantidad de actividades por tipo
                backgroundColor: colors,  // Colores aleatorios de las secciones
                borderColor: colors.map(color => color.replace('0.2', '1')),  // Colores más intensos para los bordes
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false // Desactivar la leyenda automática de Chart.js
                }
            }
        }
    });

    // Función para actualizar la leyenda con los nombres de actividades
    function updateLegend() {
        const legendContainer = document.getElementById('legend');
        
        // Limpiar la leyenda antes de agregar nuevos elementos
        legendContainer.innerHTML = '';

        // Crear la lista de leyenda
        activities.forEach((activity, index) => {
            const li = document.createElement('li');
            const div = document.createElement('div');
            div.style.backgroundColor = colors[index];  // Asignar color de la sección
            const span = document.createElement('span');
            span.textContent = activity;  // Nombre de la actividad

            li.appendChild(div);
            li.appendChild(span);
            legendContainer.appendChild(li);
        });
    }

    // Llamamos a la función para actualizar la leyenda al cargar la página
    updateLegend();
</script>




@endsection