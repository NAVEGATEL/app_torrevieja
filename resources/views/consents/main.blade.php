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
<script>
 
    function agregarEventosCanvasBloqueo(canvasId) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;

        let scrollX = 0;
        let scrollY = 0;
        let isDrawing = false;

        function bloquearScroll(e) {
            if (!isDrawing) return;
            e.preventDefault();
            
            scrollX = window.scrollX || document.documentElement.scrollLeft;
            scrollY = window.scrollY || document.documentElement.scrollTop;
            
            document.body.style.overflow = 'hidden'; 
        }

        function desbloquearScroll() {
            if (!isDrawing) return;
            
            document.body.style.overflow = ''; 
            
            isDrawing = false;
        }

        function handleStart(e) {
            isDrawing = true;
            bloquearScroll(e);
        }

        // Mouse events
        canvas.addEventListener('mousedown', handleStart);
        canvas.addEventListener('mouseup', desbloquearScroll);
        canvas.addEventListener('mouseleave', desbloquearScroll);
        
        // Touch events
        canvas.addEventListener('touchstart', handleStart, { passive: false });
        canvas.addEventListener('touchend', desbloquearScroll);
        canvas.addEventListener('touchcancel', desbloquearScroll);
        canvas.addEventListener('touchmove', (e) => {
            if (isDrawing) e.preventDefault();
        }, { passive: false });
        
        // Prevent scrolling on the whole document while drawing
        document.addEventListener('scroll', (e) => {
            if (isDrawing) e.preventDefault();
        }, { passive: false });
    }

</script>
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
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
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<script>
    // Obtener los elementos
    const acceptCheckbox = document.getElementById('acceptPolicies');
    const inputText2 = document.getElementById('inputText');
    const obtenerTicketBtn = document.getElementById('obtenerticketbtn');
    const generarTicketBtn = document.getElementById('generarTicket');

    // Función para habilitar o deshabilitar los botones e input
    function toggleButtons() {
        if (acceptCheckbox.checked) {
            inputText2.disabled = false;
            obtenerTicketBtn.disabled = false;
            generarTicketBtn.disabled = false;
        } else {
            inputText2.disabled = true;
            obtenerTicketBtn.disabled = true;
            generarTicketBtn.disabled = true;
        }
    }

    // Escuchar cambios en el checkbox
    acceptCheckbox.addEventListener('change', toggleButtons);

    // Inicializar el estado de los botones
    toggleButtons();
</script>
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- Generar el número de ticket de manera aleatoria -->
<script>
    document.getElementById('generarTicket').addEventListener('click', function() {
        // Obtener la fecha y hora actuales
        const now = new Date();

        // Formatear el valor NN-díaMesAñoHoraMinutosSegundos
        const formattedDate = 
            'NN-' +
            String(now.getDate()).padStart(2, '0') +
            String(now.getMonth() + 1).padStart(2, '0') +
            String(now.getFullYear()).slice(-2) +
            String(now.getHours()).padStart(2, '0') +
            String(now.getMinutes()).padStart(2, '0') +
            String(now.getSeconds()).padStart(2, '0');

        // Insertar el valor en el input
        document.getElementById('inputText').value = formattedDate;

        localStorage.setItem('short_id_eks', formattedDate)

        // Simular el clic en el botón "Enviar"
        document.getElementById('obtenerticketbtn').click();
    });
</script>
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- Aquí es donde se obtiene el número de ticket, se hace un fetch para buscar en turitop y luego se crea el form -->
<script>
        const inputText = document.getElementById('inputText');
        const obtenerticketbtn = document.getElementById('obtenerticketbtn');

        // función primera donde se pide el número de ticket
        obtenerticketbtn.addEventListener('click', () => {
            const text = inputText.value.trim();
            if (!text) {
                alert('Por favor, introduce un número de ticket.');
                return;
            }
            localStorage.setItem('short_id_eks', text)
            
            fetch('https://jsonplaceholder.typicode.com/posts/1')
                .then(response => {
                    if (!response.ok) throw new Error('Error en la solicitud');
                    return response.json();
                })
                .then(data => { 
                    crearFormularioNuevo(text); 
                })
                .catch(error => {
                    console.error(error);
                    alert('Hubo un error: ' + error.message);
                });
        });
</script>
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- Modulo cambiar idioma SCRIPT -->
<script> 
    // Obtener los botones
    const btnES = document.getElementById('btnES');
    const btnEN = document.getElementById('btnEN');

    // Función para cambiar los textos dinámicamente
    function cambiarIdioma(idioma) {
        const elementos = {
            titulo: document.querySelector('h1'),
            granText: document.querySelector('#granText'),
            ticketPlaceholder: document.getElementById('inputText'),
            actividades: document.querySelector('h5'),
            enviarFormulario: document.querySelector('#obtenerticketbtn'),
            numClientesLabel: document.querySelector('label[for="numClientes"]'),
            parasailingLabel: document.querySelector('label[for="parasailing"]'),
            hinchableLabel: document.querySelector('label[for="hinchable"]'),
            flyboardLabel: document.querySelector('label[for="flyboard"]'),
            menorEdadLabel: document.querySelector('label[for="menorEdad"]'),
            fechaLabel: document.querySelector('label[for="fecha"]'),
            padreTutorLabel: document.querySelector('#consentimientoMenor label:first-of-type'),
            firmaLabel: document.querySelector('#consentimientoMenor label:last-of-type'),
            nombreApellidoPlaceholder: document.querySelectorAll('input[placeholder*="Nombre y Apellido"]'),
            dniPlaceholder: document.querySelectorAll('input[placeholder*="DNI"]'),
            telefonoPlaceholder: document.querySelectorAll('input[placeholder*="Teléfono"]'),
            emailPlaceholder: document.querySelectorAll('input[placeholder*="Email"]'),
            fechaNacimientoLabel: document.querySelectorAll('label[for*="fechaNac"]'),
            consentimientoMenorTitulo: document.querySelectorAll('.h6baby'),
            generarTicket: document.querySelector('#generarTicket')
        };

        // Validar que los elementos existen antes de cambiar el contenido
        if (elementos.titulo) elementos.titulo.textContent = textos[idioma].titulo;
        if (elementos.granText) elementos.granText.textContent = textos[idioma].granText;
        if (elementos.ticketPlaceholder) elementos.ticketPlaceholder.placeholder = textos[idioma].ticketPlaceholder;
        if (elementos.actividades) elementos.actividades.textContent = textos[idioma].actividades;
        if (elementos.enviarFormulario) elementos.enviarFormulario.textContent = textos[idioma].enviarFormulario;
        if (elementos.numClientesLabel) elementos.numClientesLabel.textContent = textos[idioma].numClientes + ':';
        if (elementos.parasailingLabel) elementos.parasailingLabel.textContent = textos[idioma].parasailing;
        if (elementos.hinchableLabel) elementos.hinchableLabel.textContent = textos[idioma].hinchable;
        if (elementos.flyboardLabel) elementos.flyboardLabel.textContent = textos[idioma].flyboard;
        if (elementos.menorEdadLabel) elementos.menorEdadLabel.textContent = textos[idioma].menorEdad;
        if (elementos.fechaLabel) elementos.fechaLabel.textContent = textos[idioma].fecha + ':';
        if (elementos.padreTutorLabel) elementos.padreTutorLabel.textContent = textos[idioma].padreTutor + ':';
        if (elementos.firmaLabel) elementos.firmaLabel.textContent = textos[idioma].firma + ':';
        if (elementos.generarTicket) elementos.generarTicket.textContent = textos[idioma].generarTicket;

        elementos.nombreApellidoPlaceholder.forEach(el => el.placeholder = textos[idioma].nombreApellido);
        elementos.dniPlaceholder.forEach(el => el.placeholder = textos[idioma].dni);
        elementos.telefonoPlaceholder.forEach(el => el.placeholder = textos[idioma].telefono);
        elementos.emailPlaceholder.forEach(el => el.placeholder = textos[idioma].email);
        elementos.fechaNacimientoLabel.forEach(el => el.textContent = textos[idioma].fechaNacimiento + ':');
        elementos.consentimientoMenorTitulo.forEach(el => el.textContent = textos[idioma].menores);
        
        // Guardar el idioma actual en localStorage
        localStorage.setItem('idiomaActual', idioma);
    }

    // Función para cargar el idioma guardado
    function cargarIdiomaGuardado() {
        const idiomaGuardado = localStorage.getItem('idiomaActual') || 'es'; // Por defecto, español
        cambiarIdioma(idiomaGuardado);
    }

    // Asignar eventos a los botones
    btnES.addEventListener('click', () => cambiarIdioma('es'));
    btnEN.addEventListener('click', () => cambiarIdioma('en'));

    // Cargar idioma guardado al cargar la página
    document.addEventListener('DOMContentLoaded', cargarIdiomaGuardado);
</script>
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- Modulo menor de Edad Consentimiento Padres -->
<script>
    function esMenorDeEdad(fechaNacimiento) {
        const fechaNac = new Date(fechaNacimiento);
        const hoy = new Date();
        const edad = hoy.getFullYear() - fechaNac.getFullYear();
        const mes = hoy.getMonth() - fechaNac.getMonth();
        return (edad < 18) || (edad === 18 && mes < 0) || (edad === 18 && mes === 0 && hoy.getDate() < fechaNac.getDate());
    }
</script>
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- Modulo creación de clientes dinámico -->
<script>
    function obtenerIdiomaActual() {
        let idioma = localStorage.getItem('idiomaActual');
        if (!idioma) {
            idioma = 'es'; // Idioma por defecto
            localStorage.setItem('idiomaActual', idioma);
        }
        return idioma;
    }

    function limpiarContenedorClientes() {
        const clientesContainer = document.getElementById('clientesContainer');
        clientesContainer.innerHTML = ''; // Limpiar campos previos
        return clientesContainer;
    }

    function generarHTMLCliente(idioma, index) {
        return ` 
        <div class="container border rounded clienteContainer p-3 my-3 row" id="clienteContainer${index}">
            <h5 class="text-dangerr mb-4">${textos[idioma].cliente} ${index}</h5>
                        
            <div class="col-12 col-md-5 mb-4">
                <div class="form-group mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light w-25 text-wrap text-start">${textos[idioma].nombreApellido}</span>
                        <input required type="text" id="nombreCliente${index}" 
                            class="form-control shadow-sm" 
                            placeholder="${textos[idioma].nombreApellido}" />
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light w-25 text-wrap text-start">${textos[idioma].dni}</span>
                        <input required type="text" id="dniCliente${index}" 
                            class="form-control shadow-sm" 
                            placeholder="${textos[idioma].dni}" />
                    </div>
                </div>

                <div class="form-group mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light w-25 text-wrap text-start">${textos[idioma].telefono}</span>
                        <input required type="tel" id="telCliente${index}" 
                            class="form-control shadow-sm" 
                            placeholder="${textos[idioma].telefono}" />
                    </div>
                </div>

                <div class="form-group mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light w-25 text-wrap text-start">${textos[idioma].email}</span>
                        <input required type="email" id="mailCliente${index}" 
                            class="form-control shadow-sm" 
                            placeholder="${textos[idioma].email}" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text bg-light w-25 text-wrap text-start">${textos[idioma].fechaNacimiento}</span>
                        <input required type="date" id="fechaNacCliente${index}"  
                            class="form-control shadow-sm fechaNacimiento" />
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-5">
                <div class="d-flex flex-column align-items-center justify-content-center ms-0 ms-sd-5  bg-dagner">
                    <label class="form-label mb-2 fw-bold">${textos[idioma].firma}</label>
                    <div class="position-relative w-100 d-flex justify-content-center">
                        <canvas required id="firmaCliente${index}" class="border mb-2 firmaCanvas" width="300" height="150"></canvas>
                        
                        <button type="button" id="limpiarFirmaCliente${index}"  class="btn btn-sm btn-secondary">
                            <i class="bi bi-eraser"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div id="consentimientoMenor${index}" style="display:none;" class="col-12">
                <hr>
                <h6 class="h6baby">${textos[idioma].menores}</h6>
                <div class="row g-3"> 
                    <div class="col-12 col-md-1 d-flex align-items-start justify-content-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" fill="orange" class="bi bi-exclamation-diamond-fill" viewBox="0 0 16 16">
                        <path d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                    </svg>
                    </div>

                    <div class="col-12 col-md-5 mb-3">
                    <label class="form-label">${textos[idioma].padreTutor}:</label>
                    <input type="text" class="form-control" placeholder="${textos[idioma].padreTutor}" />
                    </div>

                    <div class="col-12 col-md-6 d-flex flex-column align-items-center ms-0 ms-sd-5 ">
                        <label class="form-label mb-2 fw-bold">${textos[idioma].firma}</label>
                        <div class="position-relative w-100 d-flex justify-content-center">
                            <canvas id="firmaPadreCliente${index}" class="border mb-2 firmaCanvas" width="300" height="150"></canvas>
                            <button type="button" id="limpiarFirmaPadreCliente${index}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-eraser"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>  
        `; 
    }
        
    function configurarEventosCliente(index) {
        inicializarCanvasFirma(`firmaCliente${index}`, `limpiarFirmaCliente${index}`);
        inicializarCanvasFirma(`firmaPadreCliente${index}`, `limpiarFirmaPadreCliente${index}`);

        // Agregar eventos para bloquear el scroll en canvas
        agregarEventosCanvasBloqueo(`firmaCliente${index}`);
        agregarEventosCanvasBloqueo(`firmaPadreCliente${index}`);

        const fechaNacInput = document.getElementById(`fechaNacCliente${index}`);
        fechaNacInput.addEventListener('change', () => {
            const esMenor = esMenorDeEdad(fechaNacInput.value);
            const consentimientoDiv = document.getElementById(`consentimientoMenor${index}`);
            consentimientoDiv.style.display = esMenor ? 'block' : 'none';
        });
    }

    function configurarFirmasYConsentimiento(index) {
        inicializarCanvasFirma(`firmaCliente${index}`, `limpiarFirmaCliente${index}`);
        inicializarCanvasFirma(`firmaPadreCliente${index}`, `limpiarFirmaPadreCliente${index}`);

        // Agregar eventos para bloquear el scroll en canvas
        agregarEventosCanvasBloqueo(`firmaCliente${index}`);
        agregarEventosCanvasBloqueo(`firmaPadreCliente${index}`);

        const fechaNacInput = document.getElementById(`fechaNacCliente${index}`);
        fechaNacInput.addEventListener('change', () => {
            manejarConsentimientoMenor(index, fechaNacInput.value);
        });
    }

    function manejarConsentimientoMenor(index, fechaNacimiento) {
        const esMenor = esMenorDeEdad(fechaNacimiento);
        const consentimientoDiv = document.getElementById(`consentimientoMenor${index}`);
        consentimientoDiv.style.display = esMenor ? 'flex' : 'none';
    }

    function generarCamposClientes(event) {
        const idioma = obtenerIdiomaActual();
        const numClientes = event.target.value || 1;
        const clientesContainer = limpiarContenedorClientes();

        for (let i = 1; i <= numClientes; i++) {
            const clienteHTML = generarHTMLCliente(idioma, i);
            clientesContainer.insertAdjacentHTML('beforeend', clienteHTML);
            configurarEventosCliente(i);
        }
    }
</script>
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- Modulo main donde ocurre la magia -->
<script>

    const container = document.querySelector('.container');
    
    function crearFormularioNuevo(ticketNumber) {
        // Eliminar el formulario inicial
        const formularioInicial = document.getElementById('form-inicial');
        formularioInicial.remove();

        // Crear nuevo formulario
        const nuevoFormulario = document.createElement('div');
        nuevoFormulario.innerHTML = `

            <form id="formularioClientes" class="text-center  mb-5" >


                <div class="d-flex justify-content-center flex-column align-items-center">
                
                    <div class="d-flex justify-content-between flex-row align-items-center">
                        <h2><b> ${textos.es.actividades} <b style="color:#fe0104;"> ${textos.es.city} </b> </b></h2>
                        <img src="img/LOGOS-ACTIVIDADES-NAUTICAS-TORREVIEJA-01.webp" alt="" srcset="" class="w-25">
                    </div>


                    <h5 class="my-3"><b id="shot_id_imp">${textos.es.ticketPlaceholder}: ${ticketNumber}</b></h5> 
                </div>


                <p id="granText" class="p-4 border" style="  font-size:11px  ;background-color:rgb(211, 211, 211); border-color: #dee2e6;"">${textos.es.granText}</p>

                <!-- Campo para elegir el número de clientes -->
                <label for="numClientes"><b> ${textos.es.numClientes}: </b></label>
                <input type="number" id="numClientes" class="form-control mb-3" min="1" value="1" placeholder="${textos.es.numClientes}" />

                <div id="clientesContainer"></div>

                <!-- Checkbox Actividades -->
                <div class="row mb-4 clienteContainer">
                <hr class="my-4">
                    <h5 class="my-4 co-12 text-dangerr"><b>${textos.es.actividades}</b></h5>
                    <div class="form-check col-4 text-start">
                        <h5 class="text-dangerr">${textos.es.parasailing}</h5>
                        <input type="checkbox" id="parasailing" class="form-check-input">
                        <label for="parasailingNum"  style="font-weight:600">${textos.es.numPersonas}</label>
                        <input type="number" id="parasailingNum" class="form-control my-2 " placeholder="${textos.es.numPersonas}" disabled />
                    </div>
                    <div class="form-check col-4 text-start">
                        <h5 class="text-dangerr">${textos.es.hinchable}</h5>
                        <input type="checkbox" id="hinchable" class="form-check-input">
                        <label for="hinchableString"  style="font-weight:600">${textos.es.tipoHinchable}</label>
                        <input type="text" id="hinchableString" class="form-control my-2" placeholder="${textos.es.tipoHinchable}" disabled />
                        <label for="hinchableNum" style="font-weight:600">${textos.es.numPersonas}</label>
                        <input type="number" id="hinchableNum" class="form-control mt-2" placeholder="${textos.es.numPersonas}" disabled />
                    </div>
                    <div class="form-check col-4 text-start">
                        <h5 class="text-dangerr">${textos.es.flyboard}</h5>
                        <input type="checkbox" id="flyboard" class="form-check-input">
                        <label for="flyboardTime" style="font-weight:600">${textos.es.tiempoFlyboard}</label>
                        <input type="number" id="flyboardTime" class="form-control my-2" placeholder="${textos.es.tiempoFlyboard}" disabled />
                        <label for="flyboardNum" style="font-weight:600">${textos.es.numPersonas}</label>
                        <input type="number" id="flyboardNum" class="form-control mt-2" placeholder="${textos.es.numPersonas}" disabled />
                    </div>
                </div>
    

                <hr class="my-4">


                <div class="d-flex justify-content-center align-items-center flex-column clienteContainer">
                    <!-- Fecha -->
                    
                    <div class="mx-5">
                        <label for="fecha">${textos.es.fecha}:</label>
                        <input type="datetime-local" 
                            id="fecha" 
                            class="form-control mb-3" 
                            value="${new Date().toLocaleString('sv-SE', { timeZone: 'Europe/Madrid' }).replace(' ', 'T').slice(0, 19)}" />
                    </div>


                    <!-- Botón de enviar -->
                    <button type="submit" id="fetchBtn" onclick="navidad(event)" class=" mb-5 btn btn-outline-primary">Enviar</button>
                


                    <p id="granText" class="p-4 border " style="  font-size:11px  ;background-color:rgb(211, 211, 211); border-color: #dee2e6;"">${textos.es.granText2}</p>


                
                </div>
           </form>
           
           `;

        container.appendChild(nuevoFormulario);
        document.getElementById('numClientes').addEventListener('change', generarCamposClientes);
        generarCamposClientes({ target: { value: 1 } }); // Genera los campos para 1 cliente por defecto
        agregarCheckboxListeners();
    }

    function inicializarCanvasFirma(canvasId, botonLimpiarId) {
        const canvas = document.getElementById(canvasId);
        const ctx = canvas.getContext('2d');
        let painting = false;

        function startPosition(e) {
            painting = true;
            draw(e);
        }

        function endPosition() {
            painting = false;
            ctx.beginPath();
        }

        function draw(e) {
            if (!painting) return;
            const rect = canvas.getBoundingClientRect();
            const x = (e.clientX || e.touches[0].clientX) - rect.left;
            const y = (e.clientY || e.touches[0].clientY) - rect.top;

            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = 'black';
            ctx.lineTo(x, y);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(x, y);
        }

        // Eventos
        canvas.addEventListener('mousedown', startPosition);
        canvas.addEventListener('mouseup', endPosition);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('touchstart', startPosition);
        canvas.addEventListener('touchend', endPosition);
        canvas.addEventListener('touchmove', draw);

        // Botón para limpiar
        document.getElementById(botonLimpiarId).addEventListener('click', () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        });
    }

    function agregarCheckboxListeners() {
        const actividades = [
            { id: 'parasailing', input: 'parasailingNum' },
            { id: 'hinchable', input: ['hinchableString', 'hinchableNum'] },
            { id: 'flyboard', input: ['flyboardTime', 'flyboardNum'] }
        ];

        actividades.forEach(actividad => {
            document.getElementById(actividad.id).addEventListener('change', (e) => {
                const isChecked = e.target.checked;
                if (Array.isArray(actividad.input)) {
                    actividad.input.forEach(id => document.getElementById(id).disabled = !isChecked);
                } else {
                    document.getElementById(actividad.input).disabled = !isChecked;
                }
            });
        });

    
    }

    // crearFormularioNuevo("as")

</script>
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
 <!-- CREAR, Guardar e Imprimir el PDF -->
<script>
    // Validar formulario y canvas
    function navidad(event) {
        event.preventDefault(); // Evita que se envíe el formulario

        const modalElement = document.querySelector("#modalTodoListo");
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            const modalContent = document.getElementById("imprimirAqui");
            if (modalContent) {
                if(copiarForm(modalContent)){
                    modal.show(); 
                }
            } else {
                console.error("El contenedor 'imprimirAqui' no existe en el DOM.");
            }
        } else {
            console.error("El modal 'modalTodoListo' no existe en el DOM.");
        }
    }

    // Funcionalidad de los botones del modal
    document.getElementById('botonImprimir').addEventListener('click', () => {

        imprimirPDF()
    });

    document.getElementById('botonReescribir').addEventListener('click', () => {
        window.location.reload();
    });


    function copiarForm(modalContent) {
        const formularioClientes = document.getElementById("formularioClientes");

        if (formularioClientes) {
            // Clonar el formulario y eliminar el ID para evitar duplicados
            const formularioClonado = formularioClientes.cloneNode(true);
            formularioClonado.removeAttribute("id");

            // Eliminar todos los botones y checkboxes del formulario clonado
            formularioClonado.querySelectorAll("button, input[type=checkbox]").forEach(elemento => elemento.remove());

            // Aplicar estilos para ajustar el contenido y evitar solapamientos
            formularioClonado.classList.add("wrap");

            // Obtener todos los inputs, textareas y selects del formulario clonado
            const inputs = formularioClonado.querySelectorAll("input, textarea, select");

            // Validar los campos usando el método nativo checkValidity()
            if (!formularioClonado.checkValidity()) {
                formularioClonado.reportValidity(); // Muestra los mensajes de validación nativos
                return; // Detener la ejecución si algún campo requerido no es válido
            }

            // Convertir todos los inputs en texto con formato adecuado
            inputs.forEach((input) => {
                const previousSibling = input.previousElementSibling;
                if (previousSibling && (previousSibling.tagName.toLowerCase() === "label" || previousSibling.tagName.toLowerCase() === "span")) {
                    previousSibling.remove();
                }

                const contenedorTexto = document.createElement("div");
                contenedorTexto.style.marginBottom = "10px";
                contenedorTexto.style.fontSize = "12px";
                contenedorTexto.style.lineHeight = "1.5";

                const nuevoLabel = document.createElement("b");
                nuevoLabel.textContent = input.placeholder || "Campo";
                nuevoLabel.textContent += ": ";
                nuevoLabel.style.marginRight = "5px";

                const valor = document.createElement("i");
                valor.textContent = input.value || "N/A";
                valor.style.marginLeft = "5px";

                // Asignar el ID del input al <i> con el sufijo "copy"
                valor.id = input.id ? `${input.id}copy` : "unknownCopy";

                contenedorTexto.appendChild(nuevoLabel);
                contenedorTexto.appendChild(valor);

                input.parentNode.replaceChild(contenedorTexto, input);
            });

            // Clonar canvas de firma si existe
            const canvasOriginales = formularioClientes.querySelectorAll("canvas");
            canvasOriginales.forEach((canvasOriginal, index) => {
                const canvasClonado = document.createElement("canvas");
                canvasClonado.width = canvasOriginal.width;
                canvasClonado.height = canvasOriginal.height;

                const contextoOriginal = canvasOriginal.getContext("2d");
                const contextoClonado = canvasClonado.getContext("2d");
                const imagenData = contextoOriginal.getImageData(0, 0, canvasOriginal.width, canvasOriginal.height);
                contextoClonado.putImageData(imagenData, 0, 0);

                const canvasPadre = formularioClonado.querySelectorAll("canvas")[index].parentNode;
                canvasPadre.replaceChild(canvasClonado, formularioClonado.querySelectorAll("canvas")[index]);
            });

            // Crear un contenedor con formato A4
            const contenedorA4 = document.createElement("div");
            contenedorA4.style.width = "100%";
            contenedorA4.style.maxWidth = "210mm"; // Máximo tamaño de A4
            contenedorA4.style.margin = "0 auto";
            contenedorA4.style.padding = "15mm";
            contenedorA4.style.backgroundColor = "#fff";
            contenedorA4.style.boxShadow = "0 0 5px rgba(0, 0, 0, 0.1)";
            contenedorA4.style.boxSizing = "border-box";

            // Insertar el formulario clonado en el contenedor A4
            contenedorA4.appendChild(formularioClonado);

            // Ajustar estilos para evitar solapamientos
            formularioClonado.style.display = "flex";
            formularioClonado.style.flexDirection = "column";
            formularioClonado.style.gap = "15px";
            formularioClonado.style.overflowWrap = "break-word";

            // Limpiar el contenido previo y agregar el contenedor con formato A4
            modalContent.innerHTML = "";
            modalContent.appendChild(contenedorA4);

            // Almacenar información relevante en el almacenamiento local
            localStorage.setItem("telPrint", document.getElementById("telCliente1").value);
            localStorage.setItem("dniPrint", document.getElementById("dniCliente1").value);

            const currentDate = new Date();
            const formattedDate = `${currentDate.getDate()}/${currentDate.getMonth() + 1}/${currentDate.getFullYear()} ${currentDate.getHours()}:${currentDate.getMinutes()}`;
            localStorage.setItem("printDate", formattedDate);

            // Añadir estilos específicos para impresión
            const styleTag = document.createElement("style");
            styleTag.textContent = `
                @media print {
                    div[style] {
                        width: 210mm !important;
                        height: auto;
                        padding: 15mm !important;
                        box-shadow: none !important;
                        margin: 0 !important;
                    }
                }
            `;
            document.head.appendChild(styleTag);

            return true;
        } else {
            console.error("El formulario 'formularioClientes' no existe en el DOM.");
        }
    }



    function _copiarForm(modalContent) {
        const formularioClientes = document.getElementById("formularioClientes");
        // Buscar el div específico por su ID o clase 
        if (formularioClientes) {
            // Clonar el formulario y eliminar el ID para evitar duplicados
            const formularioClonado = formularioClientes.cloneNode(true);
            formularioClonado.removeAttribute("id");

            // Eliminar todos los botones y checkboxes del formulario clonado
            formularioClonado.querySelectorAll("button, input[type=checkbox]").forEach(elemento => elemento.remove());

            // Aplicar estilos de envoltura para evitar desbordamientos
            formularioClonado.classList.add("wrap");

            // Obtener todos los inputs, textareas y selects del formulario clonado
            const inputs = formularioClonado.querySelectorAll("input, textarea, select");

            // Validar los campos usando el método nativo checkValidity()
            if (!formularioClonado.checkValidity()) {
                formularioClonado.reportValidity(); // Muestra los mensajes de validación nativos
                return; // Detener la ejecución si algún campo requerido no es válido
            }

            // Convertir todos los inputs en texto con formato adecuado
            inputs.forEach((input) => {
                // Buscar y eliminar cualquier label o span asociado al input
                const previousSibling = input.previousElementSibling;
                if (previousSibling && (previousSibling.tagName.toLowerCase() === "label" || previousSibling.tagName.toLowerCase() === "span")) {
                    previousSibling.remove();
                }

                // Crear el contenedor de texto
                const contenedorTexto = document.createElement("div");
                contenedorTexto.style.marginBottom = "10px"; // Separación entre elementos
                contenedorTexto.style.fontSize = "12px"; // Tamaño adecuado para documentos A4
                contenedorTexto.style.lineHeight = "1.5"; // Espaciado entre líneas para mejorar la legibilidad

                // Crear el nuevo label (en formato bold)
                const nuevoLabel = document.createElement("b");
                nuevoLabel.textContent = input.placeholder || "Campo"; // Usar el placeholder como label si no hay label o span
                nuevoLabel.textContent += ": ";
                nuevoLabel.style.marginRight = "5px"; // Espaciado entre el label y el valor

                // Crear el nuevo valor (en formato italic)
                const valor = document.createElement("i");
                valor.textContent = input.value || "N/A"; // Obtener el valor del input
                valor.style.marginLeft = "5px"; // Espaciado para mejorar la legibilidad

                // Asignar el ID del input al <i> con el sufijo "copy"
                valor.id = input.id ? `${input.id}copy` : "unknownCopy";

                // Añadir el nuevo label y valor al contenedor
                contenedorTexto.appendChild(nuevoLabel);
                contenedorTexto.appendChild(valor);

                // Reemplazar el input con el contenedor de texto
                input.parentNode.replaceChild(contenedorTexto, input);
            });



            // Clonar canvas de firma si existe
            const canvasOriginales = formularioClientes.querySelectorAll("canvas");
            canvasOriginales.forEach((canvasOriginal, index) => {
                const canvasClonado = document.createElement("canvas");
                canvasClonado.width = canvasOriginal.width;
                canvasClonado.height = canvasOriginal.height;

                // Copiar el contenido del canvas
                const contextoOriginal = canvasOriginal.getContext("2d");
                const contextoClonado = canvasClonado.getContext("2d");
                const imagenData = contextoOriginal.getImageData(0, 0, canvasOriginal.width, canvasOriginal.height);
                contextoClonado.putImageData(imagenData, 0, 0);

                // Reemplazar el canvas original clonado con el nuevo
                const canvasPadre = formularioClonado.querySelectorAll("canvas")[index].parentNode;
                canvasPadre.replaceChild(canvasClonado, formularioClonado.querySelectorAll("canvas")[index]);
            });

            // Crear un contenedor con formato A4
            const contenedorA4 = document.createElement("div");
            contenedorA4.style.width = "210mm"; // Ancho de A4
            contenedorA4.style.minHeight = "297mm"; // Altura de A4
            contenedorA4.style.margin = "0 auto";
            contenedorA4.style.padding = "15mm"; // Márgenes internos estándar
            contenedorA4.style.backgroundColor = "#fff";
            contenedorA4.style.boxShadow = "0 0 5px rgba(0, 0, 0, 0.1)";
            contenedorA4.style.boxSizing = "border-box";

            // Insertar el formulario clonado en el contenedor A4
            contenedorA4.appendChild(formularioClonado);

            // Ajustar estilos para evitar solapamientos
            formularioClonado.style.display = "flex";
            formularioClonado.style.flexDirection = "column";
            formularioClonado.style.gap = "15px"; // Separación uniforme entre elementos
            formularioClonado.style.overflowWrap = "break-word"; // Evitar textos desbordados

            // Limpiar el contenido previo y agregar el contenedor con formato A4
            modalContent.innerHTML = "";
            modalContent.appendChild(contenedorA4);

            // Almacenar información relevante en el almacenamiento local
            localStorage.setItem("telPrint", document.getElementById("telCliente1").value);
            localStorage.setItem("dniPrint", document.getElementById("dniCliente1").value);

            const currentDate = new Date();
            const formattedDate = `${currentDate.getDate()}/${currentDate.getMonth() + 1}/${currentDate.getFullYear()} ${currentDate.getHours()}:${currentDate.getMinutes()}`;
            localStorage.setItem("printDate", formattedDate);

            return true;
        } else {
            console.error("El formulario 'formularioClientes' no existe en el DOM.");
        }
    }

  
    function imprimirPDF() {
        console.log("Iniciando impresión...");
        const imprimirAqui = document.getElementById('imprimirAqui');

        if (!imprimirAqui) {
            console.error("El modal_content con ID 'imprimirAqui' no existe en el DOM.");
            return;
        }

        console.log("Elemento encontrado, iniciando html2pdf...");

        const filenameEd = `${localStorage.getItem('telPrint')}_${localStorage.getItem('dniPrint')}_${localStorage.getItem('printDate')}.pdf`.replace(/\s+/g, '_');

        const options = {
            margin: 0,
            filename: filenameEd,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        // Generar el PDF y guardarlo en el backend
        html2pdf()
            .set(options)
            .from(imprimirAqui)
            .outputPdf('blob') // Obtener el PDF como un blob
            .then(async (pdfBlob) => {
                console.log("PDF generado correctamente. Guardando en backend...");
                await guardarPDFEnBackend(pdfBlob, filenameEd); // Guardar en el backend
                console.log("PDF guardado en backend. Iniciando descarga local...");
                html2pdf().set(options).from(imprimirAqui).save(); // Descargar el PDF localmente
            })
            .catch((error) => {
                console.error("Error al generar el PDF:", error);
            });
    }

    // Función para guardar el archivo en el backend
    async function guardarPDFEnBackend(pdfBlob, filenameEd) {
        // Mostrar el spinner
        startSpinner();

        const cantidadDeClientes = document.querySelector("#numClientes").value

        const fechaFirma = localStorage.getItem('printDate');


        for (let i = 1; i <= cantidadDeClientes; i++) {
            let nombreCliente = document.getElementById(`nombreCliente${i}copy`).innerHTML;
            let telCliente = document.getElementById(`telCliente${i}copy`).innerHTML;
            let dniCliente = document.getElementById(`dniCliente${i}copy`).innerHTML;
            let mailCliente = document.getElementById(`mailCliente${i}copy`).innerHTML;
            let fechaNacCliente = document.getElementById(`fechaNacCliente${i}copy`).innerHTML;
            console.log("Cliente "+i+ ": " +nombreCliente+telCliente+dniCliente+mailCliente+fechaNacCliente);
            
            try {
                const formData = new FormData();
                formData.append('file', pdfBlob);
                formData.append('filename', filenameEd);
                formData.append('nombre_cliente', nombreCliente);
                formData.append('dni', dniCliente);
                formData.append('email', mailCliente);
                formData.append('telefono', telCliente);
                formData.append('fechaFirma', fechaFirma);
                formData.append('anyoNacimiento', fechaNacCliente);
                formData.append('short_id', localStorage.getItem('short_id_eks'));
    
                const response = await fetch(`/upload-pdf?filename=${encodeURIComponent(filenameEd)}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData,
                });
    
                if (response.ok) {
                    console.log('Archivo guardado exitosamente en el backend.');
                } else {
                    console.error('Error al guardar el archivo en el backend:', await response.text());
                }
            } catch (error) {
                console.error('Error en la solicitud al backend:', error);
                        // Finalizar el spinner
                endSpinner();
            }
        }

        // Finalizar el spinner
        endSpinner();
    }


</script>
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- SPINERS -->
<script>
    function endSpinner() {
            const overlay = document.getElementById('spinner-overlay');
            if (overlay) {
                document.body.removeChild(overlay);
            }
        }



    function startSpinner() {
        // Crear el fondo gris opaco
        const overlay = document.createElement('div');
        overlay.id = 'spinner-overlay';
        overlay.style.position = 'fixed';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        overlay.style.zIndex = '9999';
        overlay.style.display = 'flex';
        overlay.style.alignItems = 'center';
        overlay.style.justifyContent = 'center';

        // Crear el spinner
        const spinner = document.createElement('div');
        spinner.id = 'spinner';
        spinner.style.width = '50px';
        spinner.style.height = '50px';
        spinner.style.border = '6px solid #f3f3f3';
        spinner.style.borderTop = '6px solid #3498db';
        spinner.style.borderRadius = '50%';
        spinner.style.animation = 'spin 1s linear infinite';

        // Añadir animación al spinner
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);

        // Agregar el spinner al overlay
        overlay.appendChild(spinner);

        // Agregar el overlay al cuerpo del documento
        document.body.appendChild(overlay);
    }
</script>