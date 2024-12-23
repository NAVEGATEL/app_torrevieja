@extends('admin.layouts.private')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<section id="sec1" class="container-fluid mt-4">
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
                        <div class="col">
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
                        <div class="col">
                            <label for="endDate" class="form-label fw-bold">Fecha Fin</label>
                            <input
                                type="date"
                                id="endDate"
                                name="endDate"
                                class="form-control"
                                value="{{ request('endDate') }}"
                            />
                        </div>

                        <!-- Botón de búsqueda -->
                        <div class="col mt-4">
                            <label for="filtrilloChiquillo" class="form-label fw-bold">Filtrar</label>
                            <button type="submit" id="filtrilloChiquillo" class="btn btn-outline-danger w-100">Buscar</button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>

</section>


@if(request()->isMethod('get') && count(request()->query()) > 0)
    <section id="sec2" class="container-fluid my-4">
        <!-- Tabla de correos electrónicos -->
        <div class="accordion d-none">
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
            <select id="templateSelect" class="form-control">
                    <option value="" selected>Seleccione una plantilla...</option>
                    @foreach ($emailTemplates as $template)
                        <option value="{{ $template->id }}" 
                                data-subject="{{ $template->subject }}" 
                                data-body="{{ $template->body }}">
                            {{ $template->subject }} ({{ $template->created_at->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
        </div>


        <!-- Formulario de composición de correo -->
        <h2 class="text-center mt-5">Composición de Correo</h2>
        <div class="email-form mt-4 card">

            <div class="card-header bg-dark text-white">
            Correos Electrónicos Encontrados (<b class="text-danger"> {{ count($clientEmails) }} </b>)
            </div>
        
            <form id="emailForm" method="POST" action="{{ route('send') }}" enctype="multipart/form-data" class="pb-5">
                @csrf
                <div class="form-group mb-3 d-none">
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
                    <textarea id="editor" name="body" class="form-control"  rows="17" cols="80"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="attachments">Adjuntar Archivos:</label>
                    <input type="file" id="attachments" name="attachments[]" class="form-control" multiple>
                </div>
                <button type="submit" class="btn btn-primary m-2  float-end">Enviar</button>
                <a id="saveTemplateButton" class="btn btn-outline-success m-2 float-end">Guardar</a>
            </form>
        </div>

        <!-- CDN de Tiny -->
        <script src="https://cdn.tiny.cloud/1/a9t2hiq0if3a81dy68yynw9tzrryktp1bs9atbu27tm5ciem/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

        <script>
            // Inicialización del elemento tiny para escritura de correos
            tinymce.init({
                selector: 'textarea',
                height: 500, // Altura del editor
                plugins: [
                    'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists',
                    'media', 'searchreplace', 'table', 'visualblocks', 'wordcount', 'align'
                ],
                toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | removeformat',
                menubar: 'file edit view insert format tools table',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px; line-height:1.6 }'
            });

            // Guardado de plantillas
            document.getElementById('saveTemplateButton').addEventListener('click', async () => {
                const formData = new FormData();
                const subject = document.getElementById('subject').value;
                const body = tinymce.get('editor').getContent();
                const attachment = document.getElementById('attachments').files[0];

                formData.append('subject', subject);
                formData.append('body', body);
                if (attachment) {
                    formData.append('attachments', attachment);
                }

                try {
                    const response = await fetch('/panel/email-templates', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: formData,
                    });

                    const result = await response.json();
                    if (result.success) {
                        alert('Plantilla guardada con éxito.');
                    } else {
                        alert('Error al guardar la plantilla.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Ocurrió un error al guardar la plantilla.');
                }
            });

            // Manejar cambios en el select de plantillas
            document.getElementById('templateSelect').addEventListener('change', (event) => {
                const selectedOption = event.target.options[event.target.selectedIndex];
                const subject = selectedOption.getAttribute('data-subject') || '';
                const body = selectedOption.getAttribute('data-body') || '';

                // Actualizar los campos del formulario
                document.getElementById('subject').value = subject;
                tinymce.get('editor').setContent(body);
            });
        </script>


    </section>
@endif




@endsection
