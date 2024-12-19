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
                    <div class="col">
                        <label for="searchQuery" class="form-label fw-bold">Buscar usuarios</label>
                        <input
                            type="text"
                            id="searchQuery"
                            name="searchQuery"
                            class="form-control form-control-lg pb-2 pt-3"
                            placeholder="Nombre, Teléfono, Email, Reserva y DNI"
                            value="{{ request('searchQuery') }}"
                        />
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
                <!-- Renderiza los enlaces de paginación -->
                 <!-- $listaFront->links()  -->
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
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Email</th> 
                                <th class="text-center">Teléfono</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Reserva</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Este Script partido de Hola es para mostrar por consola un resultado o los que se quieran para ver que obtenemos -->
                            
                            @foreach($listaFront as $client)
                            
                                <tr id={{ $client['short_id'] }}>
                                    <td>{{ $client['client_name'] }}</td>
                                    <td class="text-truncate" style="max-width: 150px;" data-bs-toggle="tooltip" title="{{ $client['client_email'] }}">
                                        {{ $client['client_email'] }}
                                    </td>
                                    <td>{{ $client['client_phone'] }}</td>
                                    <td>
                                    @if (!isset($client['client_kind']) || !$client['client_kind'])
                                        @php $client['client_kind'] = 'blue'; @endphp
                                    @endif 
                                        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-balloon-fill" viewBox="0 0 16 16">
                                            <path id="colorear{{ $client['short_id'] }}" style="color: {{ $client['client_kind'] }} !important;" fill-rule="evenodd" d="M8.48 10.901C11.211 10.227 13 7.837 13 5A5 5 0 0 0 3 5c0 2.837 1.789 5.227 4.52 5.901l-.244.487a.25.25 0 1 0 .448.224l.04-.08c.009.17.024.315.051.45.068.344.208.622.448 1.102l.013.028c.212.422.182.85.05 1.246-.135.402-.366.751-.534 1.003a.25.25 0 0 0 .416.278l.004-.007c.166-.248.431-.646.588-1.115.16-.479.212-1.051-.076-1.629-.258-.515-.365-.732-.419-1.004a2 2 0 0 1-.037-.289l.008.017a.25.25 0 1 0 .448-.224zM4.352 3.356a4 4 0 0 1 3.15-2.325C7.774.997 8 1.224 8 1.5s-.226.496-.498.542c-.95.162-1.749.78-2.173 1.617a.6.6 0 0 1-.52.341c-.346 0-.599-.329-.457-.644"/>
                                        </svg>
                                    </td>
                                    <td>{{ $client['short_id'] }}</td>
                                    <td>{{ $client['date_booking'] }}</td>
                                    <td id="{{ $client['filename'] }}">
                                        <button class="btn btn-outline-dark border-0 text-center" data-bs-toggle="modal" data-bs-target="#userActionModal" data-client="{{ json_encode($client) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-segmented-nav text-dar btn-hover-action" viewBox="0 0 16 16">
                                                <path d="M0 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm6 3h4V5H6zm9-1V6a1 1 0 0 0-1-1h-3v4h3a1 1 0 0 0 1-1"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            <style>
                                btn-hover-action:hover{
                                    color:white !important;
                                }
                            </style>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->

<div id="userActionModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clientModalLabel">Cambiar Tipo de Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userActionForm">
                    <div class="form-group">
                        <label for="clientKindSelect">Selecciona el tipo de cliente:</label>
                        <select id="clientKindSelect" class="form-control">
                            <option value="red" style="background-color:#ffc1c1">Problemático</option>
                            <option value="blue" style="background-color:#c1f1ff">Neutro</option>
                            <option value="green" style="background-color:#c1ffce">Habitual</option>
                        </select>
                    </div>
                </form>

                <div id="fileList" class="mt-3">
                        <h6>Contrato Firmados:</h6>
                        <iframe id="previewFrame" src="" style="width: 100%; height: 300px; border: none; margin-top: 10px;"></iframe>
                        <a id="enlaceDinamico" href="#"> </a> 
                </div>

            </div>
        </div>
    </div>
</div>

 

<script>
    // Agregar un event listener a todos los botones para abrir el modal con los datos específicos
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function() {
            const clientData = JSON.parse(this.getAttribute('data-client'));
            const clientKind = clientData.client_kind;
            const shortId = clientData.short_id;
            const fileName = this.closest('td').id;

            // Selecciona el valor correspondiente en el select
            const select = document.getElementById('clientKindSelect');
            select.value = clientKind;

            // Agregar el short_id al formulario para incluirlo en el fetch
            document.getElementById('userActionForm').setAttribute('data-short-id', shortId);

            // Actualizar enlace dinámico
            const enlaceDinamico = document.getElementById('enlaceDinamico');
            enlaceDinamico.href = `/storage/uploads/${fileName}`;
            enlaceDinamico.innerHTML = `Descargar contrato: ${fileName}`;

            // Mostrar vista previa del archivo
            const previewFrame = document.getElementById('previewFrame');
            previewFrame.src = `/storage/uploads/${fileName}`;
        });
    });

    // FETCH DEL MODAL
    document.getElementById('clientKindSelect').addEventListener('change', function() {
        const selectedValue = this.value;
        const clientKindText = this.options[this.selectedIndex].text;

        // Obtener el short_id del formulario
        const shortId = document.getElementById('userActionForm').getAttribute('data-short-id');

        fetch("{{ route('userActions') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').content
            },
            body: JSON.stringify({
                client_kind: clientKindText,
                new_client_kind: selectedValue,
                short_id: shortId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Error al actualizar el tipo de cliente");
            }
            return response.json();
        })
        .then(data => {
            document.querySelector(`#colorear${shortId}`).style.color = selectedValue;
        })
        .catch(error => {
            console.error("Error:", error);
            console.log("Hubo un problema al actualizar el tipo de cliente");
        });
    });

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
@endsection
