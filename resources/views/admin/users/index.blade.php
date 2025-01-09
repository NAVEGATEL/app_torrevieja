@extends('admin.layouts.private')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="text-center">Área de Clientes</h1>
        </div>
    </div>

    <div class="row">
        <!-- Formulario de búsqueda -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white border border-1 border-dark">
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

                <form id="searchForm" class="row g-4 py-4 mb-4" method="GET" action="{{ route('users.index') }}">
                    <div class="col-0 col-sm-1"></div>
                    <div class="col-4">
                        <label for="searchQuery" class="form-label fw-bold">Buscar usuarios</label>
                        <input
                            type="text"
                            id="searchQuery"
                            name="searchQuery"
                            class="form-control form-control-lg pb-2 pt-3"
                            placeholder="Nombre, Teléfono, Email, Reserva y DNI"
                            value="{{ request('searchQuery') }}"
                            minlength="3"
                            oninput="validateSearchQuery(this)"
                        />
                        <small id="searchQueryHelp" class="text-danger d-none">El campo debe tener al menos 3 caracteres.</small>

                    </div> 
                     
                    <div class="col-4">
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
                        <div class="form-check ">
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
                    <div class="col-1 mt-4">
                        <label for="" class="form-label fw-bold">Filtrar</label>
                        <button type="submit" class="btn btn-outline-primary btn-lg py-2 shadow">
                            Buscar
                        </button>
                    </div>

                </form>
                    {{ $paginatedData->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de clientes -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body table-responsive">
                    <table id="clientTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-start">Nombre</th>
                                <th class="text-start">Email</th> 
                                <th class="text-start">Teléfono</th>
                                <th class="text-start">Tipo</th>
                                <th class="text-start">Reserva</th>
                                <th class="text-start">Fecha</th>
                                <th class="text-start">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Este Script partido de Hola es para mostrar por consola un resultado o los que se quieran para ver que obtenemos -->
                            
                            @foreach($paginatedData as $client)
                            
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
                                    <td @if(!empty($client['filename'])) id="{{ $client['filename'] }}" @endif>

                                        <button class="btn {{ empty($client['filename']) ? 'btn-outline-danger' : 'btn-outline-dark' }} border-0 text-center" data-bs-toggle="modal" data-bs-target="#userActionModal" data-client="{{ json_encode($client) }}">
                                              
                                        <svg fill="currentColor" class="bi bi-segmented-nav text-dar btn-hover-action" width="27" height="27" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 237.783 237.783" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 237.783 237.783">
                                            <g>
                                                <path d="m42.735,50.071h96.959c3.313,0 6,2.687 6,6s-2.687,6-6,6h-96.959c-3.313,0-6-2.687-6-6s2.686-6 6-6zm0,25.934h96.959c3.313,0 6,2.687 6,6s-2.687,6-6,6h-96.959c-3.313,0-6-2.687-6-6s2.686-6 6-6zm0,25.935h96.959c3.313,0 6,2.687 6,6s-2.687,6-6,6h-96.959c-3.313,0-6-2.687-6-6s2.686-6 6-6zm0,25.935h96.959c3.313,0 6,2.687 6,6s-2.687,6-6,6h-96.959c-3.313,0-6-2.687-6-6s2.686-6 6-6z"/>
                                                <path d="m42.735,62.071h96.959c3.313,0 6-2.687 6-6s-2.687-6-6-6h-96.959c-3.313,0-6,2.687-6,6s2.686,6 6,6z"/>
                                                <path d="m42.735,88.005h96.959c3.313,0 6-2.687 6-6s-2.687-6-6-6h-96.959c-3.313,0-6,2.687-6,6s2.686,6 6,6z"/>
                                                <path d="m42.735,113.94h96.959c3.313,0 6-2.687 6-6s-2.687-6-6-6h-96.959c-3.313,0-6,2.687-6,6s2.686,6 6,6z"/>
                                                <path d="m42.735,139.875h96.959c3.313,0 6-2.687 6-6s-2.687-6-6-6h-96.959c-3.313,0-6,2.687-6,6s2.686,6 6,6z"/>
                                                <path d="m237.783,98.361c0-1.591-0.632-3.117-1.757-4.243l-16.356-16.355c-1.125-1.125-2.651-1.757-4.243-1.757s-3.117,0.632-4.243,1.757l-28.756,28.756v-88.117c0-3.313-2.686-6-6-6h-170.428c-3.314,0-6,2.687-6,6v200.979c0,3.313 2.686,6 6,6h170.429c3.314,0 6-2.687 6-6v-63.18l53.597-53.597c1.125-1.125 1.757-2.651 1.757-4.243zm-225.783,115.02v-188.979h158.429v94.117l-35.291,35.291h-92.403c-3.313,0-6,2.687-6,6s2.687,6 6,6h80.403l-1.033,1.033c-0.777,0.777-1.326,1.753-1.586,2.821l-4.157,17.05h-25.148c-3.313,0-6,2.687-6,6s2.687,6 6,6c0,0 29.714,0 29.86,0 0.473,0 0.95-0.056 1.421-0.171l21.629-5.273c1.068-0.26 2.044-0.809 2.821-1.586l23.482-23.482v45.181h-158.427zm127.649-31.374l-10.408,2.538 2.538-10.408 83.648-83.648 7.871,7.871-83.649,83.647z"/>
                                            </g>
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

                <div id="fileList" class="mt-3" >
                    <h6>Contrato Firmados:</h6>
                    <iframe id="previewFrame" src="" style="width: 100%; height: 300px; border: none; margin-top: 10px;"></iframe>
                    <a id="enlaceDinamico" href="#"> </a> 
                </div>

            </div>
        </div>
    </div>
</div>

 

<script>
    document.getElementById('userActionModal').addEventListener('show.bs.modal', function (event) {
        // Obtener el botón que activó el modal
        var button = event.relatedTarget;
        // Obtener los datos del cliente desde el atributo data-client
        var client = JSON.parse(button.getAttribute('data-client'));

        // Obtener el elemento #fileList
        var fileList = document.getElementById('fileList');

        // Verificar si el filename está vacío
        if (!client.filename || client.filename === "") {
            // Si está vacío, ocultar #fileList
            fileList.style.display = 'none';
        } else {
            // Si no está vacío, mostrar #fileList
            fileList.style.display = 'block';
        }
    });
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
