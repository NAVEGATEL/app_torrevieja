@extends('admin.layouts.private')

@section('content')
<div class="container-fluid p-3">
    <div class="row g-3">
        <!-- Panel lateral con selector de año -->
        <div class="col-md-2 mb-2">
            <div class="card shadow-sm" style="height: 710px;">
                <div class="card-header bg-white py-2">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="bi bi-sliders me-2 text-primary"></i>
                        Control
                    </h5>
                </div>
                <div class="card-body py-2">
                    <div class="mb-3">
                        <label for="mainYearSelector" class="form-label fw-bold mb-2">Año Seleccionado:</label>
                        <div class="d-flex mb-2">
                            <span id="mainYearValue" class="badge bg-primary fs-5 w-100 py-2">{{ $selectedYear }}</span>
                        </div>
                        <input type="range" class="form-range mt-2" id="mainYearSelector" min="{{ min($years->toArray()) }}" max="{{ max($years->toArray()) }}" value="{{ $selectedYear }}" step="1">
                        <div class="d-flex justify-content-between small text-muted">
                            @foreach($years as $year)
                                <span>{{ $year }}</span>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="alert alert-info p-2">
                        <i class="bi bi-info-circle-fill me-1"></i>
                        Deslice para cambiar el año y ver la evolución de los datos en todas las gráficas.
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Gráficas -->
        <div class="col-md-10">
            <div class="row g-2">
            <!-- Primera gráfica - Total de Ventas € -->
                <div class="col-md-6 mb-2">
                    <div class="card shadow-sm" style="height: 350px;">
                        <div class="card-header bg-white py-2">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="bi bi-graph-up-arrow me-1 text-primary"></i>
                                Ventas € Totales 
                                <span id="yearValue1Chart" class="badge bg-primary ms-1">{{ $selectedYear }}</span>
                            </h5>
                        </div>
                        <div class="card-body py-0 px-1 bg-white">
                            <canvas id="totalSalesChart" height="270"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Segunda gráfica - Reservas Totales -->
                <div class="col-md-6 mb-2">
                    <div class="card shadow-sm" style="height: 350px;">
                        <div class="card-header bg-white py-2">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="bi bi-calendar-check me-1 text-warning"></i>
                                Reservas Totales 
                                <span id="yearValue2Chart" class="badge bg-warning ms-1">{{ $selectedYear }}</span>
                            </h5>
            </div>
                        <div class="card-body py-0 px-1 bg-white">
                            <canvas id="reservationsByMonthChart" height="270"></canvas>
                    </div>
                </div>
            </div>
            
                <!-- Tercera gráfica - Distribución de Actividades -->
                <div class="col-md-6 mb-2">
                    <div class="card shadow-sm" style="height: 350px;">
                        <div class="card-header bg-white py-2">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="bi bi-pie-chart-fill me-1 text-success"></i>
                                Distribución de Actividades 
                                <span id="pieYearBadge" class="badge bg-success ms-1">{{ $selectedYear }}</span>
                            </h5>
                        </div>
                        <div class="card-body py-0 px-1 bg-white d-flex flex-column">
                            <div class="row flex-grow-1 g-1">
                                <div class="col-lg-7">
                                    <canvas id="statusDistributionChart" height="270"></canvas>
                                </div>
                                <div class="col-lg-5">
                                    <div class="legend-scroll" style="max-height: 270px;">
                                        <ul id="legend" class="list-unstyled mb-0"></ul>
                    </div>
                </div>
            </div>
        </div>
                    </div>
                    </div>
                    
                <!-- Cuarta gráfica - Distribución de Servicios por País -->
                <div class="col-md-6 mb-2">
                    <div class="card shadow-sm" style="height: 350px;">
                        <div class="card-header bg-white py-2">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="bi bi-pie-chart-fill me-1 text-info"></i>
                                Distribución de Servicios por País
                                <span id="countryYearBadge" class="badge bg-info ms-1">{{ $selectedYear }}</span>
                            </h5>
                        </div>
                        <div class="card-body py-0 px-1 bg-white d-flex flex-column">
                            <div class="row flex-grow-1 g-1">
                                <div class="col-lg-7">
                                    <canvas id="countryServiceChart" height="270"></canvas>
                                </div>
                                <div class="col-lg-5">
                                    <div class="legend-scroll" style="max-height: 270px;">
                                        <ul id="countryLegend" class="list-unstyled mb-0"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Añadimos estilos personalizados -->
<style>
    /* Estilos optimizados para gráficas más grandes */
    .card {
        border-radius: 8px !important;
        box-shadow: 0 0 5px rgba(0,0,0,0.1) !important;
        border: none !important;
        background-color: #fff !important;
        overflow: hidden !important;
    }

    .card-header {
        padding: 8px 15px !important;
        border-bottom: 1px solid rgba(0,0,0,0.1) !important;
        background-color: #fff !important;
    }

    .card-body {
        padding: 10px 15px !important;
    }

    .card-title {
        font-size: 1rem !important;
    }

    .legend-scroll {
        max-height: 270px !important;
        overflow-y: auto;
        padding-right: 5px;
        font-size: 0.9rem !important;
    }

    .legend-scroll::-webkit-scrollbar {
        width: 5px;
    }

    .legend-scroll::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.2);
        border-radius: 5px;
    }

    #countryLegend li, #legend li {
        padding: 4px 8px !important;
        margin-bottom: 5px !important;
        border-radius: 4px !important;
        background-color: rgba(0,0,0,0.03) !important;
        display: flex;
        align-items: center;
        font-size: 0.85rem !important;
    }

    #countryLegend li div, #legend li div {
        width: 15px !important;
        height: 15px !important;
        border-radius: 3px !important;
        margin-right: 8px !important;
    }
    
    /* Estilos para los botones de año */
    .year-buttons {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
    }

    .year-button {
        min-width: 70px;
        transition: none !important;
    }

    .year-button.active {
        box-shadow: none !important;
        transform: none !important;
    }
    
    /* Activar los tooltips de Bootstrap */
    .tooltip {
        z-index: 1070;
    }
    
    /* Animación para cambios de datos */
    @keyframes fadeIn {
        from { opacity: 1; transform: none; }
        to { opacity: 1; transform: none; }
    }
    
    .card-body {
        position: relative;
    }
    
    .animated-change {
        animation: none !important;
    }

    /* Estilos para el selector principal */
    #mainYearSelector {
        -webkit-appearance: none;
        width: 100%;
        height: 8px;
        border-radius: 10px;
        background: #f0f0f0;
        outline: none;
        transition: none !important;
    }

    #mainYearSelector::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 22px;
        height: 22px;
        background: #0d6efd;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: none !important;
        transition: none !important;
    }

    #mainYearSelector::-moz-range-thumb {
        width: 22px;
        height: 22px;
        background: #0d6efd;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: none !important;
        transition: none !important;
    }

    /* Desactivar completamente todos los efectos hover */
    .card:hover,
    .btn:hover, 
    .badge:hover,
    .form-range:hover,
    .alert:hover,
    .form-control:hover,
    .year-button:hover,
    .list-unstyled li:hover,
    #mainYearSelector:hover,
    #mainYearSelector::-webkit-slider-thumb:hover,
    #mainYearSelector::-moz-range-thumb:hover,
    canvas:hover,
    *:hover {
        transform: none !important;
        box-shadow: none !important;
        filter: none !important;
        opacity: 1 !important;
        background-color: inherit !important;
        color: inherit !important;
        border-color: inherit !important;
        text-decoration: none !important;
        border-radius: inherit !important;
        outline: none !important;
    }

    /* Desactivar todas las transiciones */
    *, *::before, *::after {
        transition: none !important;
        animation: none !important;
    }

    .btn, .btn:hover, .btn:active, .btn:focus {
        transition: none !important;
        transform: none !important;
        box-shadow: none !important;
    }

    .btn-primary, .btn-primary:hover, .btn-primary:active, .btn-primary:focus {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: white !important;
    }

    .btn-outline-secondary, .btn-outline-secondary:hover, .btn-outline-secondary:active, .btn-outline-secondary:focus {
        background-color: transparent !important;
        border-color: #6c757d !important;
        color: #6c757d !important;
    }

    
</style>

<script src="{{ asset('js/admin/obtencionDatos.js') }}" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Script para activar los tooltips de Bootstrap -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Activar todos los tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Activar los alerts
        const alertList = document.querySelectorAll('.alert');
        alertList.forEach(function(alert) {
            new bootstrap.Alert(alert);
        });

        // Comprobar y mostrar todos los años disponibles
        const mainYearSelector = document.getElementById('mainYearSelector');
        const yearLabels = document.querySelector('.d-flex.justify-content-between.small.text-muted');
        
        // Verificar si hay datos para cada año en el rango
        for (let year = parseInt(mainYearSelector.min); year <= parseInt(mainYearSelector.max); year++) {
            if (!salesData[year]) {
                console.warn(`No hay datos de ventas para el año ${year}, creando array vacío`);
                salesData[year] = [['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'], [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]];
            }
            if (!reservationsData[year]) {
                console.warn(`No hay datos de reservas para el año ${year}, creando array vacío`);
                reservationsData[year] = [['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'], [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]];
            }
            if (!countryServiceData || !countryServiceData[year]) {
                console.warn(`No hay datos de países para el año ${year}, creando array vacío`);
                if (!countryServiceData) countryServiceData = {};
                countryServiceData[year] = [['España', 'Francia', 'Reino Unido', 'Alemania', 'Italia'], [0, 0, 0, 0, 0]];
            }
        }
    });
</script>

<!-- Primera gráfica - Cantidad de Ventas € por año y mes -->
<script>
    // Obtener el contexto del canvas donde se renderizará el gráfico de ventas
    const totalSalesCtx = document.getElementById('totalSalesChart').getContext('2d');

    // Datos de ventas reales provenientes del controlador
    const salesData = @json($salesData);

    // Extraer los datos para el año seleccionado por defecto
    const selectedYear = {{ $selectedYear }};  // Año seleccionado por defecto
    const initialMonths = salesData[selectedYear][0];  // Meses para el año seleccionado
    const initialSales = salesData[selectedYear][1];  // Ventas por mes para el año seleccionado

    // Color personalizado para las barras del gráfico según el año
    function getChartColors(year) {
        const yearColors = {
            2025: {
                bar: 'rgba(75, 192, 192, 0.7)',
                border: 'rgba(75, 192, 192, 1)'
            },
            2024: {
                bar: 'rgba(255, 159, 64, 0.7)',
                border: 'rgba(255, 159, 64, 1)'
            },
            2023: {
                bar: 'rgba(54, 162, 235, 0.7)',
                border: 'rgba(54, 162, 235, 1)'
            },
            2022: {
                bar: 'rgba(255, 99, 132, 0.7)',
                border: 'rgba(255, 99, 132, 1)'
            }
        };
    
        // Si no hay un color específico para este año, usamos un color por defecto basado en el módulo 4
        if (!yearColors[year]) {
            const yearMod = year % 4;
            switch(yearMod) {
                case 0: return yearColors[2024];
                case 1: return yearColors[2025];
                case 2: return yearColors[2022];
                case 3: return yearColors[2023];
            }
        }
        
        return yearColors[year];
    }

    const initialColors = getChartColors(selectedYear);
    
    // Opciones comunes para todas las gráficas sin efectos hover
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 0 // Desactivar animaciones
        },
        hover: {
            mode: null // Desactivar efecto hover
        },
        plugins: {
            tooltip: {
                enabled: false // Desactivar tooltips
            },
            legend: {
                display: false // Ocultar la leyenda
            }
        },
        layout: {
            padding: 0 // Eliminar padding interno
        }
    };

    // Inicializar el gráfico de ventas por mes
    const totalSalesChart = new Chart(totalSalesCtx, {
        type: 'bar',
        data: {
            labels: initialMonths,
            datasets: [{
                label: 'Ventas € Totales',
                data: initialSales,
                backgroundColor: initialColors.bar,
                borderColor: initialColors.border,
                borderWidth: 1
            }]
        },
        options: {
            ...chartOptions,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Referencias a elementos del DOM para actualización de año
    const mainYearSelector = document.getElementById('mainYearSelector');
    const mainYearValue = document.getElementById('mainYearValue');
    const yearHeader = document.getElementById('yearHeader');
    const yearValue1Chart = document.getElementById('yearValue1Chart');
    const yearValue2Chart = document.getElementById('yearValue2Chart');
    const pieYearBadge = document.getElementById('pieYearBadge');
    const countryYearBadge = document.getElementById('countryYearBadge');

    // Actualizar el listener del selector principal
    mainYearSelector.addEventListener('input', (e) => {
        const newYear = e.target.value;
        
        // Verificar si el año existe en los datos
        if (!salesData[newYear]) {
            console.warn(`No hay datos para el año ${newYear}`);
            return;
        }
        
        // Actualizar todos los indicadores de año
        mainYearValue.textContent = newYear;
        yearValue1Chart.textContent = newYear;
        yearValue2Chart.textContent = newYear;
        pieYearBadge.textContent = newYear;
        countryYearBadge.textContent = newYear;
        
        if (yearHeader) {
            yearHeader.textContent = newYear;
        }
        
        // Actualizar todas las gráficas
        updateChart(newYear);
        updateChart2(newYear);
        updatePieChart(newYear);
        updateCountryChart(newYear);
    });

    function updateChart(year) {
        // Verificar si el año existe en los datos
        if (!salesData[year]) {
            console.warn(`No hay datos para el año ${year}`);
            return;
        }
        
        // Extraemos las nuevas ventas y meses para el año seleccionado
        const newSales = salesData[year][1];  // Nuevas ventas por mes para el año seleccionado
        const newMonths = salesData[year][0];  // Nuevos meses para el año seleccionado

        // Actualizar colores según el año
        const newColors = getChartColors(parseInt(year));
        totalSalesChart.data.datasets[0].backgroundColor = newColors.bar;
        totalSalesChart.data.datasets[0].borderColor = newColors.border;

        // Actualizar los datos del gráfico
        totalSalesChart.data.datasets[0].data = newSales;
        totalSalesChart.data.labels = newMonths;

        // Redibujar el gráfico
        totalSalesChart.update();
    }
</script>

<!-- Segunda gráfica - Distribución de cantidad de Reservas por mes -->
<script>
    // Obtener el contexto del canvas donde se renderizará el gráfico de reservas
    const reservationsCtx = document.getElementById('reservationsByMonthChart').getContext('2d');

    // Datos de reservas reales provenientes del controlador
    const reservationsData = @json($reservationsData);

    // Extraer los datos para el año seleccionado por defecto
    const initialReservationMonths = reservationsData[selectedYear][0];  // Meses para el año seleccionado
    const initialReservations = reservationsData[selectedYear][1];  // Reservas por mes para el año seleccionado

    // Función para obtener colores por año para las reservas
    function getReservationColors(year) {
        const yearColors = {
            2025: {
                bar: 'rgba(255, 191, 0, 0.7)',
                border: 'rgba(255, 191, 0, 1)'
            },
            2024: {
                bar: 'rgba(255, 99, 132, 0.7)',
                border: 'rgba(255, 99, 132, 1)'
            },
            2023: {
                bar: 'rgba(54, 162, 235, 0.7)',
                border: 'rgba(54, 162, 235, 1)'
            },
            2022: {
                bar: 'rgba(75, 192, 192, 0.7)',
                border: 'rgba(75, 192, 192, 1)'
            }
        };
        
        // Si no hay un color específico para este año, usamos un color por defecto basado en el módulo 4
        if (!yearColors[year]) {
            const yearMod = year % 4;
            switch(yearMod) {
                case 0: return yearColors[2024];
                case 1: return yearColors[2025];
                case 2: return yearColors[2022];
                case 3: return yearColors[2023];
            }
        }
        
        return yearColors[year];
    }

    const initialReservationColors = getReservationColors(selectedYear);
    
    // Inicializar el gráfico de reservas por mes
    const reservationsChart = new Chart(reservationsCtx, {
        type: 'bar',
        data: {
            labels: initialReservationMonths,
            datasets: [{
                label: 'Reservas Totales',
                data: initialReservations,
                backgroundColor: initialReservationColors.bar,
                borderColor: initialReservationColors.border,
                borderWidth: 1
            }]
        },
        options: {
            ...chartOptions,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Función para actualizar el gráfico de reservas por mes cuando se cambia el año
    function updateChart2(year) {
        // Verificar si el año existe en los datos
        if (!reservationsData[year]) {
            console.warn(`No hay datos de reservas para el año ${year}`);
            return;
        }
        
        // Extraemos las nuevas reservas y meses para el año seleccionado
        const newReservations = reservationsData[year][1];  // Nuevas reservas por mes para el año seleccionado
        const newMonths = reservationsData[year][0];  // Nuevos meses para el año seleccionado

        // Actualizar colores según el año
        const newColors = getReservationColors(parseInt(year));
        reservationsChart.data.datasets[0].backgroundColor = newColors.bar;
        reservationsChart.data.datasets[0].borderColor = newColors.border;

        // Actualizar los datos del gráfico
        reservationsChart.data.datasets[0].data = newReservations;
        reservationsChart.data.labels = newMonths;

        // Redibujar el gráfico
        reservationsChart.update();
    }
</script>

<!-- Tercera gráfica - Distribución de Actividades y Servicios por País -->
<script>
    // Obtener el contexto del canvas donde se renderizará el gráfico de actividades
    const statusDistributionCtx = document.getElementById('statusDistributionChart').getContext('2d');

    // Datos de actividades reales provenientes del controlador
    const statusData = @json($statusData);

    // Filtrar actividades eliminadas y eliminar duplicados
    function filtrarActividades(actividades, cantidades) {
        const actividadesUnicas = {};
        const actividadesFiltradas = [];
        const cantidadesFiltradas = [];

        // Iterar los datos para filtrar y eliminar duplicados
        for (let i = 0; i < actividades.length; i++) {
            const nombre = actividades[i];
            const cantidad = cantidades[i];
            
            // Si la actividad no está eliminada (cantidad > 0)
            if (cantidad > 0) {
                // Si ya existe esta actividad, sumamos la cantidad
                if (actividadesUnicas[nombre]) {
                    actividadesUnicas[nombre] += cantidad;
                } else {
                    // Si es nueva, la registramos
                    actividadesUnicas[nombre] = cantidad;
                    actividadesFiltradas.push(nombre);
                    cantidadesFiltradas.push(cantidad);
                }
            }
        }
        
        // Si queremos recalcular las cantidades en caso de haber sumado duplicados
        for (let i = 0; i < actividadesFiltradas.length; i++) {
            const nombre = actividadesFiltradas[i];
            cantidadesFiltradas[i] = actividadesUnicas[nombre];
        }
        
        return [actividadesFiltradas, cantidadesFiltradas];
    }

    // Extraer datos de actividades y filtrarlos
    let [activities, activityCounts] = filtrarActividades(statusData[0], statusData[1]);
    
    // Paleta de colores predefinida para mayor coherencia visual
    const colorPalette = [
        'rgba(103, 71, 183, 0.8)',    // Morado
        'rgba(233, 76, 138, 0.8)',    // Rosa
        'rgba(32, 201, 151, 0.8)',    // Verde
        'rgba(255, 159, 64, 0.8)',    // Naranja
        'rgba(75, 192, 192, 0.8)',    // Turquesa
        'rgba(255, 99, 132, 0.8)',    // Rojo claro
        'rgba(54, 162, 235, 0.8)',    // Azul
        'rgba(255, 206, 86, 0.8)',    // Amarillo
        'rgba(153, 102, 255, 0.8)',   // Lila
        'rgba(201, 203, 207, 0.8)',   // Gris
        'rgba(0, 168, 133, 0.8)',     // Verde esmeralda
        'rgba(139, 69, 19, 0.8)'      // Marrón
    ];

    // Generar colores para cada actividad (usando la paleta o generando aleatorios si hay más actividades que colores)
    function generateColors(count) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            if (i < colorPalette.length) {
                colors.push(colorPalette[i]);
            } else {
                // Si tenemos más actividades que colores en la paleta, generamos colores aleatorios
                const color = `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.8)`;
            colors.push(color);
            }
        }
        return colors;
    }

    // Generar colores para las actividades
    let pieColors = generateColors(activities.length);

    // Inicializar el gráfico de distribución de actividades
    const statusDistributionChart = new Chart(statusDistributionCtx, {
        type: 'pie',
        data: {
            labels: activities,
            datasets: [{
                label: 'Distribución de Actividades',
                data: activityCounts,
                backgroundColor: pieColors,
                borderColor: pieColors.map(color => color.replace('0.8', '1')),
                borderWidth: 1
            }]
        },
        options: {
            ...chartOptions,
            maintainAspectRatio: false
        }
    });
    
    // Función para actualizar el gráfico circular
    // Como no tenemos datos específicos por año, simplemente actualizamos los colores para mantener coherencia
    function updatePieChart(year) {
        // No necesitamos actualizar los datos ya que no cambian con el año
        // pero podemos refrescar la vista para mantener coherencia
        
        // Filtrar actividades eliminadas y duplicados
        let [updatedActivities, updatedCounts] = filtrarActividades(statusData[0], statusData[1]);

        // Asegurarse de tener suficientes colores
        let updatedColors = generateColors(updatedActivities.length);
        
        // Actualizar los datos del gráfico
        statusDistributionChart.data.labels = updatedActivities;
        statusDistributionChart.data.datasets[0].data = updatedCounts;
        statusDistributionChart.data.datasets[0].backgroundColor = updatedColors;
        statusDistributionChart.data.datasets[0].borderColor = updatedColors.map(color => color.replace('0.8', '1'));
        
        // Redibujar el gráfico
        statusDistributionChart.update();
        
        // Actualizar la leyenda
        generateLegend();
    }
    
    // Función para generar la leyenda personalizada
    function generateLegend() {
        const legendContainer = document.getElementById('legend');
        legendContainer.innerHTML = ''; // Limpiar la leyenda actual
        
        // Filtrar actividades eliminadas y duplicados
        let [currentActivities, currentCounts] = filtrarActividades(statusData[0], statusData[1]);
        let currentColors = generateColors(currentActivities.length);
        
        // Calcular el total para los porcentajes
        const total = currentCounts.reduce((a, b) => a + b, 0);
        
        currentActivities.forEach((activity, index) => {
            const li = document.createElement('li');
            const colorBox = document.createElement('div');
            colorBox.style.backgroundColor = currentColors[index];
            
            const percentage = ((currentCounts[index] / total) * 100).toFixed(1);
            const activityName = document.createElement('span');
            activityName.textContent = `${activity}: ${currentCounts[index]} (${percentage}%)`;
            
            li.appendChild(colorBox);
            li.appendChild(activityName);
            legendContainer.appendChild(li);
        });
    }
    
    // Generar la leyenda al cargar la página
    generateLegend();
</script>

<!-- Cuarta gráfica - Estadísticas por País/Servicio -->
<script>
    // Obtener el contexto del canvas donde se renderizará el gráfico de país/servicio
    const countryServiceCtx = document.getElementById('countryServiceChart').getContext('2d');

    // Datos de ejemplo definidos directamente en JavaScript
    // Estructura: [países, servicios por país]
    const countryServiceData = {
        '2022': [
            ['España', 'Francia', 'Reino Unido', 'Alemania', 'Italia'],
            [120, 85, 65, 45, 30]
        ],
        '2023': [
            ['España', 'Francia', 'Reino Unido', 'Alemania', 'Países Bajos'],
            [150, 95, 75, 55, 40]
        ],
        '2024': [
            ['España', 'Francia', 'Reino Unido', 'Alemania', 'Portugal'],
            [180, 110, 85, 65, 50]
        ],
        '2025': [
            ['España', 'Francia', 'Reino Unido', 'Italia', 'Bélgica'],
            [200, 130, 95, 70, 60]
        ]
    };

    // Si no hay datos para el año seleccionado, usar datos de ejemplo
    if (!countryServiceData[selectedYear]) {
        countryServiceData[selectedYear] = [['España', 'Francia', 'Reino Unido', 'Alemania', 'Italia'], [100, 80, 60, 40, 20]];
    }

    // Extraer los datos para el año seleccionado por defecto
    const initialCountries = countryServiceData[selectedYear][0];
    const initialServices = countryServiceData[selectedYear][1];

    // Generar colores para los países
    function getCountryColors() {
        return [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(201, 203, 207, 0.7)',
            'rgba(103, 71, 183, 0.7)',
            'rgba(233, 76, 138, 0.7)',
            'rgba(32, 201, 151, 0.7)'
        ];
    }

    const countryColors = getCountryColors();
    const countryBorderColors = countryColors.map(color => color.replace('0.7', '1'));

    // Inicializar el gráfico de servicios por país
    const countryServiceChart = new Chart(countryServiceCtx, {
        type: 'pie',
        data: {
            labels: initialCountries,
            datasets: [{
                label: 'Servicios por País',
                data: initialServices,
                backgroundColor: countryColors,
                borderColor: countryBorderColors,
                borderWidth: 1
            }]
        },
        options: {
            ...chartOptions,
            maintainAspectRatio: false
        }
    });

    // Función para generar la leyenda de países/servicios
    function generateCountryLegend() {
        const legendContainer = document.getElementById('countryLegend');
        legendContainer.innerHTML = '';

        // Calcular el total para los porcentajes
        const total = initialServices.reduce((a, b) => a + b, 0);
        
        initialCountries.forEach((country, index) => {
            const li = document.createElement('li');
            const colorBox = document.createElement('div');
            colorBox.style.backgroundColor = countryColors[index];
            
            const percentage = ((initialServices[index] / total) * 100).toFixed(1);
            const countryName = document.createElement('span');
            countryName.textContent = `${country}: ${initialServices[index]} (${percentage}%)`;
            
            li.appendChild(colorBox);
            li.appendChild(countryName);
            legendContainer.appendChild(li);
        });
    }

    // Función para actualizar el gráfico de país/servicio cuando cambia el año
    function updateCountryChart(year) {
        if (!countryServiceData[year]) {
            console.warn(`No hay datos de país/servicio para el año ${year}`);
            return;
        }
        
        const newCountries = countryServiceData[year][0];
        const newServices = countryServiceData[year][1];
        
        // Actualizar datos del gráfico
        countryServiceChart.data.labels = newCountries;
        countryServiceChart.data.datasets[0].data = newServices;
        
        // Asegurarnos de tener colores suficientes
        const colors = getCountryColors();
        const borderColors = colors.map(color => color.replace('0.7', '1'));
        
        // Actualizar colores
        countryServiceChart.data.datasets[0].backgroundColor = colors;
        countryServiceChart.data.datasets[0].borderColor = borderColors;
        
        // Redibujar el gráfico
        countryServiceChart.update();
        
        // Actualizar la leyenda con los nuevos datos
        const legendContainer = document.getElementById('countryLegend');
        legendContainer.innerHTML = '';

        // Calcular el total para los porcentajes
        const total = newServices.reduce((a, b) => a + b, 0);
        
        newCountries.forEach((country, index) => {
            const li = document.createElement('li');
            const colorBox = document.createElement('div');
            colorBox.style.backgroundColor = colors[index];
            
            const percentage = ((newServices[index] / total) * 100).toFixed(1);
            const countryName = document.createElement('span');
            countryName.textContent = `${country}: ${newServices[index]} (${percentage}%)`;

            li.appendChild(colorBox);
            li.appendChild(countryName);
            legendContainer.appendChild(li);
        });
    }

    // Generar la leyenda al cargar la página
    generateCountryLegend();
</script>
@endsection