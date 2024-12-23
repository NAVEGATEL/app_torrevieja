@extends('admin.layouts.private')

@section('content')
<div class="container mt-4">




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
                            <label for="yearSelector" style="margin-right: 10px;">Año: </label>
                            <input type="range" id="yearSelector" min="2014" max="{{ max($years->toArray()) }}" value="{{ $selectedYear }}" step="1" style="width: 300px;">
                            <span id="yearValue" style="margin-left: 10px;">{{ $selectedYear }}</span>
                        </div>
                            <!-- Icono de información con tooltip -->
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
        <div class="col-md-6 mb-4">
            <div class="card mb-4">
                <div class="card-body">
                    <canvas id="statusDistributionChart"></canvas>
                </div>
            </div>
        </div>


    </div>
 


</div> 
<script src="{{ asset('js/admin/obtencionDatos.js') }}" type="module"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

 

<!-- Primera gráfica - Cantidad de Ventas € por año y mes -->
<script>
    const salesData = @json($salesData); // Datos de Ventas € para todos los años
    const years = Object.keys(salesData).sort((a, b) => b - a); // Años disponibles

    let currentYear = '{{ $selectedYear }}'; // Año inicial

    const updateChart = (chart, year) => {
        const data = salesData[year];
        chart.data.labels = data[0]; // Meses del año
        chart.data.datasets[0].data = data[1]; // Ventas € del año
        chart.data.datasets[0].label = `Ventas € Totales (${year})`;
        chart.update();
    };

    const totalSalesCtx = document.getElementById('totalSalesChart').getContext('2d');
    const totalSalesChart = new Chart(totalSalesCtx, {
        type: 'bar',
        data: {
            labels: salesData[currentYear][0], // Meses del año inicial
            datasets: [{
                label: `Ventas € Totales (${currentYear})`,
                data: salesData[currentYear][1], // Ventas € del año inicial
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
        }
    });

    // Actualizar el año seleccionado al mover el slider
    const yearSlider = document.getElementById('yearSelector');
    const yearValue = document.getElementById('yearValue');

    // Función para actualizar el color de la barra del slider
    function updateSliderColor() {
        const value = yearSlider.value;
        const percentage = (value - yearSlider.min) / (yearSlider.max - yearSlider.min) * 100;
        yearSlider.style.background = `linear-gradient(to right, rgba(75, 192, 192, 1) ${percentage}%, #ddd ${percentage}%)`;
    }

    yearSlider.addEventListener('input', (e) => {
        currentYear = e.target.value;
        yearValue.textContent = currentYear; // Mostrar el año seleccionado
        updateChart(totalSalesChart, currentYear); // Actualizar el gráfico
        updateSliderColor(); // Cambiar el color de la barra
    });

    // Inicializar el tooltip de Bootstrap
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();  // Habilita los tooltips en todos los elementos con esta propiedad
    });

    // Establecer el color inicial del slider
    updateSliderColor();


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

</script>


@endsection