@extends('admin.layouts.private')

@section('content')
<div class="container mt-4">




    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="text-center">Dashboard Financiero y de Actividades</h1>
        </div>
    </div>

    <div class="row">
        
        <!-- Total de reservas -->
        <div class="col-md-6 mb-4">
            
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
                        <span data-toggle="tooltip" data-placement="top" title="Esta gráfica muestra las reservas totales durante cada mes de un año. En el eje X están los meses del año, y en el eje Y las reservas totales en dinero por cada mes.">
                            <i class="bi bi-info-circle" style="font-size: 1.5em; cursor: pointer; margin-left: 10px;"></i>
                        </span>
                    </div>
                        

                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <canvas id="reservationsByLocationChart"></canvas>
                </div>
            </div>

        </div>

        <!-- Distribución de Estados -->
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

<script>
    // Distribución de Estados
    const statusDistributionCtx = document.getElementById('statusDistributionChart').getContext('2d');
    new Chart(statusDistributionCtx, {
        type: 'pie',
        data: {
            labels: @json($statusData[0]), // Estados
            datasets: [{
                data: @json($statusData[1]), // Cantidad por estado
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    // Reservas por Ubicación
    const reservationsByLocationCtx = document.getElementById('reservationsByLocationChart').getContext('2d');
    new Chart(reservationsByLocationCtx, {
        type: 'bar',
        data: {
            labels: @json($reservationsData[0]), // Ciudades
            datasets: [{
                label: 'Reservas',
                data: @json($reservationsData[1]), // Reservas por ciudad
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

<script>
    const salesData = @json($salesData); // Datos de Reservas para todos los años
    const years = Object.keys(salesData).sort((a, b) => b - a); // Años disponibles

    let currentYear = '{{ $selectedYear }}'; // Año inicial

    const updateChart = (chart, year) => {
        const data = salesData[year];
        chart.data.labels = data[0]; // Meses del año
        chart.data.datasets[0].data = data[1]; // Reservas del año
        chart.data.datasets[0].label = `Reservas Totales (${year})`;
        chart.update();
    };

    const totalSalesCtx = document.getElementById('totalSalesChart').getContext('2d');
    const totalSalesChart = new Chart(totalSalesCtx, {
        type: 'bar',
        data: {
            labels: salesData[currentYear][0], // Meses del año inicial
            datasets: [{
                label: `Reservas Totales (${currentYear})`,
                data: salesData[currentYear][1], // Reservas del año inicial
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


@endsection