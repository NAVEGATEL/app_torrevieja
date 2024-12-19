@extends('admin.layouts.private')

@section('content')
<div class="container mt-4">


@foreach($bookings as $activity)
    {{$activity}}
@endforeach


    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="text-center">Dashboard Financiero y de Actividades</h1>
        </div>
    </div>

    <div class="row">
        <!-- Total de Ventas -->
        <div class="col-md-6 mb-4">

            <div class="card mb-4">
                <div class="card-body">
                    <canvas id="totalSalesChart"></canvas>
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

    <div class="row d-none">


        <!-- Ventas por Moneda -->
        <div class="col-md-6 mb-4">
            <div class="card mb-4">
                <div class="card-body">
                    <canvas id="salesByCurrencyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Ventas por Mes -->
        <div class="col-md-6 mb-4">
            <div class="card mb-4">
                <div class="card-body">
                    <canvas id="salesByMonthChart"></canvas>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <canvas id="topProductsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-none">
        <!-- Clientes Más Frecuentes -->
        <div class="col-md-6 mb-4">
            <div class="card mb-4">
                <div class="card-body">
                    <canvas id="frequentClientsChart"></canvas>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <canvas id="frequentClientsChart2"></canvas>
                </div>
            </div>
        </div>

 

        <!-- Ingresos por Producto -->
        <div class="col-md-6 mb-4">
            <div class="card mb-4">
                <div class="card-body">
                    <canvas id="revenueByProductChart"></canvas>
                </div>
            </div>
        </div>
    </div>


</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- <script src="resources\js\admin\obtencionDatos.js"></script> -->

<script>



    // init();
    // Total de Ventas
    const totalSalesCtx = document.getElementById('totalSalesChart').getContext('2d');
    new Chart(totalSalesCtx, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril'], // Ejemplo
            datasets: [{
                label: 'Ventas Totales',
                data: [1200, 1900, 3000, 5000], // Ejemplo
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    // Distribución de Estados
    const statusDistributionCtx = document.getElementById('statusDistributionChart').getContext('2d');
    new Chart(statusDistributionCtx, {
        type: 'pie',
        data: {
            labels: ['Pendiente', 'Confirmado', 'Cancelado'], // Ejemplo
            datasets: [{
                data: [10, 20, 5], // Ejemplo
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
            labels: ['Madrid', 'Barcelona', 'Valencia'], // Ejemplo
            datasets: [{
                label: 'Reservas',
                data: [20, 15, 10], // Ejemplo
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
@endsection