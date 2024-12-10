@extends('admin.layouts.private')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="text-center">Área de Clientes</h1>
        </div>
    </div>

    <div class="row">
        <!-- Formulario de búsqueda -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">Buscar Clientes</h5>
                </div>
                <div class="card-body">



                @php
                    function shouldCheckExactDate() {
                        // Si no hay variables en la URL o si exactDate=on está presente, devuelve true
                        $request = request()->except(['page']);
                        return empty($request) || request('exactDate') === 'on';
                    }
                @endphp





                <form id="searchForm" class="row g-4" method="GET" action="{{ route('users.index') }}">
                    <div class="col-md-3">
                        <label for="searchQuery" class="form-label fw-bold">Buscar usuarios</label>
                        <input
                            type="text"
                            id="searchQuery"
                            name="searchQuery"
                            class="form-control form-control-lg"
                            placeholder="Introduce el nombre, teléfono o email"
                            value="{{ request('searchQuery') }}"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="activityFilter" class="form-label fw-bold">Filtrar por actividad</label>
                        <select id="activityFilter" name="activityFilter" class="form-select form-select-lg">
                            <option value="">Seleccionar actividad</option>
                            @foreach($activities as $activity)
                                <option value="{{ $activity }}" {{ request('activityFilter') == $activity ? 'selected' : '' }}>
                                    {{ $activity }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="dateRange" class="form-label fw-bold">Filtrar por fechas</label>
                        <div class="d-flex gap-2">
                            <input
                                type="date"
                                id="startDate"
                                name="startDate"
                                class="form-control py-3"
                                value="{{ request('startDate') }}"
                            />
                            <input
                                type="date"
                                id="endDate"
                                name="endDate"
                                class="form-control py-3 {{ shouldCheckExactDate() ? 'd-none' : '' }}"
                                value="{{ request('endDate') }}"
                                {{ shouldCheckExactDate() ? 'disabled' : '' }}
                            />
                        </div>
                        <div class="form-check mt-2">
                            <input
                                type="checkbox"
                                id="exactDate"
                                name="exactDate"
                                class="form-check-input"
                                onclick="toggleEndDate(this)"
                                {{ shouldCheckExactDate() ? 'checked' : '' }}
                            />
                            <label for="exactDate" class="form-check-label">Búsqueda de fecha concreta</label>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <button type="submit" class="btn btn-outline-primary btn-lg px-5 py-0 shadow mt-md-4">
                            Buscar
                        </button>
                    </div>
                </form>






























                    <script>
                        function toggleEndDate(checkbox) {
                            const endDate = document.getElementById('endDate');
                            if (checkbox.checked) {
                                endDate.disabled = true;
                                endDate.classList.add('d-none');
                            } else {
                                endDate.disabled = false;
                                endDate.classList.remove('d-none');
                            }
                        }
                    </script>

                
                <!-- Renderiza los enlaces de paginación -->
                {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de clientes -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <table id="clientTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Edad</th>
                                <th>Tipo</th>
                                <th>Notas</th>
                                <th>Última Visita</th>
                                <th>Última Actividad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <script>
                                    let hola = 0
                            </script>
                            @foreach($bookings as $client)
                            <script> 
                                    if(hola == 0){
                                        let bookings = @json($bookings);
                                        console.log(bookings)
                                    }
                            </script>
                                <tr>
                                    <td>{{ $client['client_name'] }}</td>
                                    <td>{{ $client['client_email'] }}</td>
                                    <td>{{ $client['date_booking'] }}</td>
                                    <td>
                                        <i class="bi bi-balloon-fill text-center" style="color: {{ $client['client_status'] === 'red' ? 'red' : 'green' }};"></i>
                                    </td>
                                    <td>{{ $client['short_id'] }}</td>
                                    <td>{{ $client['location'] }}</td>
                                    <td>{{ $client['service_flow'] }}</td>
                                    <td>
                                        <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#clientModal" data-client="{{ json_encode($client) }}">
                                            <i class="bi bi-clipboard2-data"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clientModalLabel">Detalles del Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Los datos del cliente se cargarán dinámicamente aquí -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<script>
    const clientModal = document.getElementById('clientModal');
    clientModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const client = JSON.parse(button.getAttribute('data-client'));
        const modalBody = clientModal.querySelector('.modal-body');
        modalBody.innerHTML = `
            <p><strong>Nombre:</strong> ${client.name}</p>
            <p><strong>Apellido:</strong> ${client.lastName}</p>
            <p><strong>Edad:</strong> ${client.age}</p>
            <p><strong>Tipo:</strong> ${client.type}</p>
            <p><strong>Notas:</strong> ${client.notes}</p>
            <p><strong>Últimas Visitas:</strong> ${client.visitas.join(', ')}</p>
            <p><strong>Actividades:</strong> ${client.actividades.join(', ')}</p>
        `;
    });
</script>
@endsection
