<style>
    /* Asegura que los contenedores no se corten en el PDF */
    .clienteContainer {
        min-height: 80mm; /* Ajusta el valor según el tamaño necesario */
        page-break-inside: avoid; /* Evita el corte dentro del div */ 
     
    }
    .text-dangerr{
        color: #fe0104 !important;
    }
    canvas {
        border: 1px solid #ccc;
        display: block;
        margin: 20px auto;
        cursor: crosshair; /* Cambia el cursor para indicar acción */
    }
</style>

<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

@vite('resources/js/main.js')

<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<div class="container mb-5 py-5 ">
    <!-- Modal para confirmación y vista previa -->
    <div class="modal fade py-5" id="modalTodoListo" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl py-5">
            <div class="modal-content position-relative">
                <!-- Modal Header -->
                <div class="modal-header border-bottom">
                    <h5 class="modal-titles fw-bold" id="modalLabels">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        Vista Previa del Documento
                    </h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body - Preview Area -->
                <div class="modal-body p-4">
                    <div id="imprimirAqui" class="bg-white rounded shadow-sm">
                        <!-- Content will be dynamically inserted here -->
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-top d-flex justify-content-center gap-3">
                    <button id="botonImprimir" class="btn btn-primary px-4 py-2">
                        <i class="bi bi-send me-2"></i>
                        Enviar
                    </button>
                    <button id="botonReescribir" class="btn btn-outline-danger px-4 py-2">
                        <i class="bi bi-x-circle me-2"></i>
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Language Selector -->
    <div class="container">
        <div class="d-flex justify-content-center align-items-center gap-2 ">
            <div class="btn-group" role="group" aria-label="Language selector">
                <button id="btnES" class="btn btn-outline-danger px-3 fw-bold">
                    <i class="bi bi-globe me-1"></i>ES
                </button>
                <button id="btnEN" class="btn btn-outline-primary px-3 fw-bold">
                    <i class="bi bi-globe me-1"></i>EN
                </button>
            </div>
        </div>
    </div>


    <div id="login-form-inicial" class="card shadow-lg mx-auto my-5" style="max-width: 400px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <img src="img/LOGOS-ACTIVIDADES-NAUTICAS-TORREVIEJA-01.webp" alt="Logo" class="mb-4" style="width: 200px;">
                <h4 class="card-title mb-4">Acceso al consentimiento de uso</h4>
            </div>

            <div id="form-inicial" class="text-center">
                <div class="form-floating mb-3">
                    <input type="text" id="inputText" class="form-control" placeholder="Ticket Nº" disabled>
                    <label for="inputText">Ticket Nº</label>
                </div>

                <div class="d-grid gap-2 mb-4">
                    <button id="obtenerticketbtn" class="btn btn-primary" disabled>
                        <i class="bi bi-box-arrow-in-right me-2"></i>Enviar
                    </button>
                    <button id="generarTicket" class="btn btn-outline-secondary" disabled>
                        <i class="bi bi-ticket-perforated me-2"></i>Generar Ticket
                    </button>
                </div>

                <div class="form-check text-start mb-3">
                    <input type="checkbox" class="form-check-input" id="acceptPolicies">
                    <label class="form-check-label small" for="acceptPolicies">
                        Acepto las <a href="https://actividadestorrevieja.com/politica-de-privacidad/" target="_blank">políticas de privacidad</a>, 
                        <a href="https://actividadestorrevieja.com/politica-de-cookies/" target="_blank">políticas de cookies</a> y el 
                        <a href="https://actividadestorrevieja.com/en/legal-warning/" target="_blank">tratamiento de datos</a>.
                    </label>
                </div>
            </div>
        </div>
    </div>

</div>

