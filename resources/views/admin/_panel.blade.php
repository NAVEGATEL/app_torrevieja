@extends('admin.layouts.private')

@section('content')
<main class="app-main">
    <div class="app-content-header bg-light py-3 border-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-end bg-transparent m-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Reservas</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Producto</th>
                                        <th>Cliente</th>
                                        <th>Ubicación</th>
                                        <th>Fecha Reserva</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td>{{ $booking->short_id }}</td>
                                            <td>{{ $booking->product_name }}</td>
                                            <td>{{ $booking->client_name }}</td>
                                            <td>{{ $booking->location }}</td>
                                            <td>{{ $booking->date_booking }}</td>
                                            <td>{{ $booking->status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $bookings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
