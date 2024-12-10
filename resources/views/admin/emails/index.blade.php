@extends('admin.layouts.private')

@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="text-center">NewsLetter</h1>
        </div>
    </div>







    <div class="row">
    <!-- Formulario de búsqueda -->
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0">Buscar Clientes</h5>
            </div>
            <div class="card-body align-items-center">
                <form id="searchForm" class="row g-4" method="GET" action="{{ route('emails.index') }}">
                    <!-- Campo de rango de fechas -->
                    <div class="col-md-2">
                        <label for="startDate" class="form-label fw-bold">Fecha Inicio</label>
                        <input
                            type="date"
                            id="startDate"
                            name="startDate"
                            class="form-control"
                            value="{{ request('startDate') }}"
                            required
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="endDate" class="form-label fw-bold">Fecha Fin</label>
                        <input
                            type="date"
                            id="endDate"
                            name="endDate"
                            class="form-control"
                            value="{{ request('endDate') }}"
                        />
                    </div>

                    <!-- Select dinámico: Producto -->
                    <div class="col-md-3">
                        <label for="activities" class="form-label fw-bold">Producto</label>
                        <select id="activities" name="activities[]" class="form-select">
                            <option value="">Seleccionar Producto</option>
                            @foreach($productNames as $productName)
                                <option value="{{ $productName }}" {{ is_array(request('activities')) && in_array($productName, request('activities')) ? 'selected' : '' }}>
                                    {{ $productName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select dinámico: Ubicación -->
                    <div class="col-md-3">
                        <label for="locations" class="form-label fw-bold">Ubicación</label>
                        <select id="locations" name="locations[]" class="form-select">
                            <option value="">Seleccionar Ubicación</option>
                            @foreach($locations as $location)
                                <option value="{{ $location }}" {{ is_array(request('locations')) && in_array($location, request('locations')) ? 'selected' : '' }}>
                                    {{ $location }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botón de búsqueda -->
                    <div class="col-md-2 mt-4">
                        <label for="filtrilloChiquillo" class="form-label fw-bold">Filtrar</label>
                        <button type="submit" id="filtrilloChiquillo" class="btn btn-outline-danger w-100">Buscar</button>
                    </div>
                </form>

                <!-- Contenedor de etiquetas seleccionadas -->
                <div class="mt-3">
                    <h6>Seleccionado</h6>
                    <div id="selectedTags" class="d-flex flex-wrap"></div>
                </div>

                <script>
                    const selectedTagsContainer = document.getElementById('selectedTags');
                    const locationsSelect = document.getElementById('locations');
                    const activitiesSelect = document.getElementById('activities');

                    function createTag(value, type) {
                        // Evitar duplicados
                        if ([...selectedTagsContainer.children].some(tag => tag.dataset.value === value)) return;

                        const tag = document.createElement('div');
                        tag.classList.add('badge', 'bg-danger', 'text-white', 'me-2', 'mb-2');
                        tag.style.cursor = 'pointer';
                        tag.dataset.value = value;
                        tag.dataset.type = type;
                        tag.innerHTML = `${value} <span>&times;</span>`;

                        // Eliminar etiqueta al hacer clic
                        tag.addEventListener('click', () => {
                            tag.remove();
                        });

                        selectedTagsContainer.appendChild(tag);
                    }

                    // Añadir etiqueta cuando se selecciona algo
                    locationsSelect.addEventListener('change', function () {
                        if (this.value) {
                            createTag(this.value, 'locations');
                            this.value = ''; // Resetear select
                        }
                    });

                    activitiesSelect.addEventListener('change', function () {
                        if (this.value) {
                            createTag(this.value, 'activities');
                            this.value = ''; // Resetear select
                        }
                    });


                    document.getElementById('searchForm').addEventListener('submit', function () {
                        // Limpiar campos ocultos previos
                        document.querySelectorAll('.hidden-input').forEach(input => input.remove());

                        // Agregar ubicaciones seleccionadas al formulario
                        Array.from(document.getElementById('selectedTags').children).forEach(tag => {
                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = `${tag.dataset.type}[]`; // 'locations[]' o 'activities[]'
                            hiddenInput.value = tag.dataset.value;
                            hiddenInput.classList.add('hidden-input');
                            this.appendChild(hiddenInput);
                        });
                    });

                        // Restaurar etiquetas seleccionadas al cargar la página
                    document.addEventListener('DOMContentLoaded', function () {
                        const selectedActivities = @json(request('activities', []));
                        const selectedLocations = @json(request('locations', []));

                        selectedActivities.forEach(activity => {
                            createTag(activity, 'activities');
                        });

                        selectedLocations.forEach(location => {
                            createTag(location, 'locations');
                        });
                    });

                    function createTag(value, type) {
                        // Evitar duplicados
                        if ([...selectedTagsContainer.children].some(tag => tag.dataset.value === value)) return;

                        const tag = document.createElement('div');
                        tag.classList.add('badge', 'bg-danger', 'text-white', 'me-2', 'mb-2');
                        tag.style.cursor = 'pointer';
                        tag.dataset.value = value;
                        tag.dataset.type = type;
                        tag.innerHTML = `${value} <span>&times;</span>`;

                        // Eliminar etiqueta al hacer clic
                        tag.addEventListener('click', () => {
                            tag.remove();
                        });
                        if (tag.dataset.value != "null") {
                            selectedTagsContainer.appendChild(tag);
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</div>





























    <!-- Tabla de correos electrónicos -->
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
            <button 
                class="accordion-button collapsed" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#collapseEmails" 
                aria-expanded="false" 
                aria-controls="collapseEmails">
                Correos Electrónicos Encontrados ({{ count($clientEmails) }})
            </button>

            </h2>
            <div id="collapseEmails" class="accordion-collapse collapse">
                <div class="accordion-body">
                    @if(!empty($clientEmails))
                        <ul class="list-group">
                            @foreach($clientEmails as $email)
                                <li class="list-group-item">{{ $email }}</li>
                            @endforeach
                        </ul>
                         
                    @else
                        <p class="text-muted">No se encontraron correos electrónicos.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Selector de plantillas -->
    <div class="container mt-4">
        <label for="templateSelector" class="form-label">Selecciona una plantilla</label>
        <select id="templateSelector" class="form-select">
            <!-- Aquí iria el nombre de la bariable de las plantillas de correos que tenemos en la base de datos y recuperamos desde el controlador -->
            @foreach ($clientEmails as $plantilla)
                <option value="{{ $plantilla }}">{{ $plantilla }}</option>
            @endforeach
        </select>
    </div>






    <!-- Formulario de composición de correo -->

    <div class="container email-form mt-4">
    <h2>Composición de Correo</h2>
    <form id="emailForm" method="POST" action="{{ route('send') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="to">Para:</label>
            <input 
                type="text" 
                id="to" 
                name="to" 
                class="form-control" 
                placeholder="Introduce el destinatario" 
                value="{{ implode(', ', $clientEmails) }}" 
                required>
        </div>
        <div class="form-group mb-3">
            <label for="subject">Asunto:</label>
            <input type="text" id="subject" name="subject" class="form-control" placeholder="Introduce el asunto" required>
        </div>
        <div class="form-group mb-3">
            <label for="editor">Mensaje:</label>
            <textarea id="editor" name="body" class="form-control"></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="attachments">Adjuntar Archivos:</label>
            <input type="file" id="attachments" name="attachments[]" class="form-control" multiple>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
    </div>

    <script>
        // Inicializar TinyMCE
        tinymce.init({
            selector: '#editor',
            plugins: 'image link table media lists code fullscreen',
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | fullscreen code',
            menubar: false,
            height: 300,
        });
    </script>























    <script>
 
    </script>
</div>

@endsection
