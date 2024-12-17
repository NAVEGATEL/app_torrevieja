@extends('../layouts/public') <!-- Extiende el layout public.blade.php -->
<script>  

    // JSON con textos en ES y EN
    const textos = {
    es: {
        titulo: "Consentimiento de Uso",
        granText: "Por el presente documento reconozco que la empresa ACTIVIDADES NÁUTICAS TORREVIEJA, S.L operadora de la actividad de iniciación a la moto náutica me ha explicado en qué consiste la actividad, me ha explicado las instrucciones de uso, las medidas de seguridad y todo el procedimiento a seguir durante el desarrollo de la excursión para su correcto desarrollo. Así mismo, he sido informado de las limitaciones y los supuestos en los que no se puede usar la moto acuática, tales como el estar bajo los efectos del alcohol, drogas, tener mermadas las capacidades físicas o mentales, etc... Me hago responsable de cualquier daño ocasionado al material que aquí se me presta y me comprometo a abonar la rotura del mismo, si éste se rompiera por no seguir las indicaciones de los monitores de la empresa. Igualmente reconozco que me ha sido traducido este texto, el cual firmo dándome por enterado de todo su contenido y otorgando mi plena conformidad y consentimiento. Eximo a la empresa de cualquier responsabilidad de la perdida de objetos realizando la actividad.",
        ticketPlaceholder: "Ticket Nº",
        enviar: "Enviar",
        numClientes: "Número de Clientes",
        actividades: "Actividades",
        parasailing: "PARASAILING",
        hinchable: "HINCHABLE",
        flyboard: "FLYBOARD",
        numPersonas: "Número de personas",
        tipoHinchable: "Tipo de Hinchable",
        tiempoFlyboard: "Tiempo en minutos",
        menores: "Consentimiento para Menores",
        menorEdad: "Menor de Edad",
        padreTutor: "Padre/Tutor Legal",
        firma: "Firma",
        fecha: "Fecha",
        enviarFormulario: "Enviar",
        nombreApellido: "Nombre y Apellido",
        dni: "DNI",
        telefono: "Teléfono",
        email: "Email",
        limpiarFirma: "Limpiar",
        cliente: "Cliente",
        fechaNacimiento: "Fecha de Nacimiento",

    },
    en: {
        titulo: "Usage Consent",
        granText: "By this document I acknowledge that the company ACTIVIDADES NÁUTICAS TORREVIEJA, S.L., operator of the jet ski initiation activity, has explained to me what the activity consists of, the instructions for use, safety measures, and the procedure to follow during the excursion for its proper development. I have also been informed about the limitations and cases where the jet ski cannot be used, such as being under the influence of alcohol, drugs, or having impaired physical or mental abilities, etc... I take responsibility for any damage caused to the material provided here and agree to pay for any breakages caused by not following the instructions given by the company's monitors. I also acknowledge that this text has been translated for me, which I sign to confirm my full understanding and consent. I release the company from any responsibility for the loss of objects during the activity.",
        ticketPlaceholder: "Ticket No.",
        enviar: "Send",
        numClientes: "Number of Clients",
        actividades: "Activities",
        parasailing: "PARASAILING",
        hinchable: "INFLATABLE",
        flyboard: "FLYBOARD",
        numPersonas: "Number of people",
        tipoHinchable: "Type of Inflatable",
        tiempoFlyboard: "Flyboard time (minutes)",
        menores: "Consent for Minors",
        menorEdad: "Minor",
        padreTutor: "Parent/Legal Guardian",
        firma: "Signature",
        fecha: "Date",
        enviarFormulario: "Submit",
        nombreApellido: "Name and Surname",
        dni: "ID Number",
        telefono: "Phone",
        email: "Email",
        limpiarFirma: "Clear",
        cliente: "Client",
        fechaNacimiento: "Bith date",

    }
};
</script>
@section('content')
<div class="container mb-5 pb-5 ">




    <!-- Botones de Idioma -->
    <div class="text-end mb-3">
        <button id="btnES" class="btn btn-outline-danger">ES</button>
        <button id="btnEN" class="btn btn-outline-primary">EN</button>
    </div>


    <h1 class="text-center">Consentimiento de Uso</h1>
    <p class="text-justify">
        Este es el contenido de consentimiento de acceso público. Puedes agregar aquí toda la información necesaria.
    </p>


    <div id="form-inicial" class="text-center row">
        <input type="text" id="inputText" placeholder="Ticket Nº" class="form-control col-2 mb-3" />
        <button type="submit" id="obtenerticketbtn" class="btn btn-outline-primary mt-2">Enviar</button>
    </div>

    <form id="formularioClientes" class="text-center row d-none">
        <button type="submit" id="fetchBtn" class="btn btn-outline-primary mt-2">Enviar</button>
    </form>

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

                fetch('https://jsonplaceholder.typicode.com/posts/1')
                    .then(response => {
                        if (!response.ok) throw new Error('Error en la solicitud');
                        return response.json();
                    })
                    .then(data => {
                        document.querySelector("#form-inicial").display = "none"
                        document.querySelector("#formularioClientes").display = "block"
                        crearFormularioNuevo(text); 
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Hubo un error: ' + error.message);
                    });
            });
    </script>



</div>

<!-- Modulo cambiar idioma SCRIPT 
asdf@asd.es 
-->
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
            enviarFormulario: document.querySelector('button[type="submit"]'),
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
            consentimientoMenorTitulo: document.querySelectorAll('.h6baby')
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
            <div class="container border rounded p-3 mb-3" id="clienteContainer${index}">
                <h5>${textos[idioma].cliente} ${index}</h5>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <input required type="text" class="form-control my-1" placeholder="${textos[idioma].nombreApellido}" />
                        <input required type="text" class="form-control my-1" placeholder="${textos[idioma].dni}" />
                        <input required type="tel" class="form-control my-1" placeholder="${textos[idioma].telefono}" />
                        <input required type="email" class="form-control my-1" placeholder="${textos[idioma].email}" />
                        <label class="form-label mt-2">${textos[idioma].fechaNacimiento}:</label>
                        <input required type="date" id="fechaNacCliente${index}"  class="form-control mb-2 fechaNacimiento" />
                    </div>
                    <div class="col-12 col-md-6  d-flex align-items-start justify-content-around ">
                        <label>${textos[idioma].firma}:</label>
                        <canvas required id="firmaCliente${index}" class="border mb-2 firmaCanvas" width="300" height="150"></canvas>
                        <button type="button" id="limpiarFirmaCliente${index}" class="btn btn-secondary limpiarFirma">
                            ${textos[idioma].limpiarFirma}
                        </button>
                    </div>
                </div>
                <div id="consentimientoMenor${index}" style="display:none;">
                    <hr>
                    <h6 class="h6baby">${textos[idioma].menores}</h6>
                    <div class="row">

                        <div class="col-1 d-flex align-items-start justify-content-center "> 
                            <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" fill="orange" class="bi bi-exclamation-diamond-fill" viewBox="0 0 16 16">
                                <path d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                            </svg>
                        </div>
                        <div class="col-5">
                            <label>${textos[idioma].padreTutor}:</label>
                            <input type="text" class="form-control mb-2" placeholder="${textos[idioma].padreTutor}" />
                        </div>
                        <div class="col-6 d-flex align-items-start justify-content-around ">
                            <label>${textos[idioma].firma}:</label>
                            <canvas id="firmaPadreCliente${index}" class="border mb-2 firmaCanvas" width="300" height="150"></canvas>
                            <button type="button" id="limpiarFirmaPadreCliente${index}" class="btn btn-secondary limpiarFirma">
                                ${textos[idioma].limpiarFirma}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    function configurarEventosCliente(index) {
        inicializarCanvasFirma(`firmaCliente${index}`, `limpiarFirmaCliente${index}`);
        inicializarCanvasFirma(`firmaPadreCliente${index}`, `limpiarFirmaPadreCliente${index}`);

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

<!-- Modulo main donde ocurre la magia -->
<script>

    const container = document.querySelector('.container');

    function crearFormularioNuevo(ticketNumber) {
        // Eliminar el formulario inicial
        const formularioInicial = document.getElementById('formularioClientes');
        formularioInicial.remove();

        // Crear nuevo formulario
        const nuevoFormulario = document.createElement('form');
        nuevoFormulario.innerHTML = `
            <h3 class="mt-4">${textos.es.ticketPlaceholder}: ${ticketNumber}</h3>
            <input type="text" class="form-control mb-3" value="${ticketNumber}" disabled />

            <p id="granText">${textos.es.granText}</p>

            <!-- Campo para elegir el número de clientes -->
            <label for="numClientes">${textos.es.numClientes}:</label>
            <input type="number" id="numClientes" class="form-control mb-3" min="1" value="1" placeholder="${textos.es.numClientes}" />
            <div id="clientesContainer"></div>

            <!-- Checkbox Actividades -->
            <h5 class="mt-4">${textos.es.actividades}</h5>
            <div class="form-check">
                <input type="checkbox" id="parasailing" class="form-check-input">
                <label for="parasailing">${textos.es.parasailing}</label>
                <input type="number" id="parasailingNum" class="form-control mt-2" placeholder="${textos.es.numPersonas}" disabled />
            </div>
            <div class="form-check">
                <input type="checkbox" id="hinchable" class="form-check-input">
                <label for="hinchable">${textos.es.hinchable}</label>
                <input type="text" id="hinchableString" class="form-control mt-2" placeholder="${textos.es.tipoHinchable}" disabled />
                <input type="number" id="hinchableNum" class="form-control mt-2" placeholder="${textos.es.numPersonas}" disabled />
            </div>
            <div class="form-check">
                <input type="checkbox" id="flyboard" class="form-check-input">
                <label for="flyboard">${textos.es.flyboard}</label>
                <input type="number" id="flyboardTime" class="form-control mt-2" placeholder="${textos.es.tiempoFlyboard}" disabled />
                <input type="number" id="flyboardNum" class="form-control mt-2" placeholder="${textos.es.numPersonas}" disabled />
            </div>
 

            <!-- Fecha -->
            <label for="fecha">${textos.es.fecha}:</label>
            <input type="date" id="fecha" class="form-control mb-3" value="${new Date().toISOString().split('T')[0]}" />

            <!-- Botón de enviar -->
            <button type="submit" class="btn btn-success">${textos.es.enviarFormulario}</button>
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

    crearFormularioNuevo("as")

</script>


<!-- Modulo modal e impresion --> 
<div class="modal fade" id="modalTodoListo" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Todo listo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>¿Qué deseas hacer ahora?</p>
                <button id="botonImprimir" class="btn btn-primary m-2">Imprimir</button>
                <button id="botonGuardar" class="btn btn-success m-2">Guardar</button>
                <button id="botonReescribir" class="btn btn-warning m-2">Reescribir Documento</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Validar formulario y canvas
    document.getElementById('fetchBtn').addEventListener('click', function (event) {
        alert("stop")
        event.preventDefault(); 

        let formularioValido = true;
        
        const firmas = document.querySelectorAll('.firmaCanvas');

        firmas.forEach((canvas) => {
            const ctx = canvas.getContext('2d');
            if (esCanvasVacio(ctx, canvas)) {
                formularioValido = false;
                canvas.classList.add('border-danger'); 
            } else {
                canvas.classList.remove('border-danger');
            }
        });

        if (!formularioValido) {
            alert('Por favor, asegúrate de firmar todos los campos obligatorios antes de continuar.');
            return;
        }

        // Mostrar modal si todo está correcto
        const modal = new bootstrap.Modal(document.getElementById('modalTodoListo'));
        modal.show();
    });

    // Función para validar si el canvas está vacío
    function esCanvasVacio(ctx, canvas) {
        const pixelData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
        return pixelData.every((value, index) => index % 4 === 3 && value === 0);
    }

    // Funcionalidad de los botones del modal
    document.getElementById('botonImprimir').addEventListener('click', () => {
        window.print();
    });

    document.getElementById('botonGuardar').addEventListener('click', () => {
        alert('Funcionalidad de guardar aún no implementada.');
    });

    document.getElementById('botonReescribir').addEventListener('click', () => {
        alert('Funcionalidad de reescribir documento aún no implementada.');
    });
</script>
@endsection