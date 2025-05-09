console.log("Script de Formulario Dinámico cargado");

const container = document.querySelector(".container");

function crearFormularioNuevo(ticketNumber) {
    // Eliminar el formulario inicial
    const formularioInicial = document.getElementById("form-inicial");
    formularioInicial.remove();

    // Obtener la fecha y hora actual formateada
    const now = new Date();
    const fechaHoraActual = now.toISOString().slice(0, 16); // Formato YYYY-MM-DDTHH:MM

    // Crear nuevo formulario
    const nuevoFormulario = document.createElement("div");
    nuevoFormulario.innerHTML = `

            <form id="formularioClientes" class="text-center mb-5" >


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
                <input type="number" id="numClientes" class="form-control mb-3" min="1" value="1" placeholder="${textos.es.numClientes}" required />

                <div id="clientesContainer"></div>

                <!-- Checkbox Actividades -->
                <div class="row mb-4 clienteContainer">
                <hr class="my-4">
                    <h5 class="my-4 co-12 text-dangerr"><b>${textos.es.actividades}</b></h5>
                    <div class="form-check col-4 text-start">
                        <h5 class="text-dangerr">${textos.es.parasailing}</h5>
                        <input type="checkbox" id="parasailing" class="form-check-input">
                        <label for="parasailingNum" style="font-weight:600">${textos.es.numPersonas}</label>
                        <input type="number" id="parasailingNum" class="form-control my-2" placeholder="${textos.es.numPersonas}" disabled required />
                        <div class="row mt-2">
                            <div class="col-6">
                                <label for="parasailingParticipantes" style="font-weight:600">Participantes</label>
                                <input type="number" id="parasailingParticipantes" class="form-control" placeholder="Participantes" disabled required />
                            </div>
                            <div class="col-6">
                                <label for="parasailingAcompanantes" style="font-weight:600">Acompañantes</label>
                                <input type="number" id="parasailingAcompanantes" class="form-control" placeholder="Acompañantes" disabled required />
                            </div>
                        </div>
                    </div>
                    <div class="form-check col-4 text-start">
                        <h5 class="text-dangerr">${textos.es.hinchable}</h5>
                        <input type="checkbox" id="hinchable" class="form-check-input">
                        <label for="hinchableString"  style="font-weight:600">${textos.es.tipoHinchable}</label>
                        <input type="text" id="hinchableString" class="form-control my-2" placeholder="${textos.es.tipoHinchable}" disabled required />
                        <label for="hinchableNum" style="font-weight:600">${textos.es.numPersonas}</label>
                        <input type="number" id="hinchableNum" class="form-control mt-2" placeholder="${textos.es.numPersonas}" disabled required />
                        <div class="row mt-2">
                            <div class="col-6">
                                <label for="hinchableParticipantes" style="font-weight:600">Participantes</label>
                                <input type="number" id="hinchableParticipantes" class="form-control" placeholder="Participantes" disabled required />
                            </div>
                            <div class="col-6">
                                <label for="hinchableAcompanantes" style="font-weight:600">Acompañantes</label>
                                <input type="number" id="hinchableAcompanantes" class="form-control" placeholder="Acompañantes" disabled required />
                            </div>
                        </div>
                    </div>
                    <div class="form-check col-4 text-start">
                        <h5 class="text-dangerr">${textos.es.flyboard}</h5>
                        <input type="checkbox" id="flyboard" class="form-check-input">
                        <label for="flyboardTime" style="font-weight:600">${textos.es.tiempoFlyboard}</label>
                        <input type="number" id="flyboardTime" class="form-control my-2" placeholder="${textos.es.tiempoFlyboard}" disabled required />
                        <label for="flyboardNum" style="font-weight:600">${textos.es.numPersonas}</label>
                        <input type="number" id="flyboardNum" class="form-control mt-2" placeholder="${textos.es.numPersonas}" disabled required />
                        <div class="row mt-2">
                            <div class="col-6">
                                <label for="flyboardParticipantes" style="font-weight:600">Participantes</label>
                                <input type="number" id="flyboardParticipantes" class="form-control" placeholder="Participantes" disabled required />
                            </div>
                            <div class="col-6">
                                <label for="flyboardAcompanantes" style="font-weight:600">Acompañantes</label>
                                <input type="number" id="flyboardAcompanantes" class="form-control" placeholder="Acompañantes" disabled required />
                            </div>
                        </div>
                    </div>
                </div>
    

                <hr class="my-4">


                <div class="d-flex justify-content-center align-items-center flex-column clienteContainer">
                    <!-- Fecha -->
                    <div class="mx-5 w-100">
                        <label for="fecha">${textos.es.fecha} :</label>
                        <input type="datetime-local" id="fecha" class="form-control mb-3" value="${fechaHoraActual}" readonly required />
                    </div>

                    <!-- Checkbox para aceptar términos -->
                    <div class="form-check w-100 text-start mb-4">
                        <input type="checkbox" class="form-check-input" id="acceptTerms">
                        <label class="form-check-label" for="acceptTerms">
                            Acepto los términos y condiciones del contrato
                        </label>
                    </div>

                    <!-- Botón de enviar -->
                    <button type="submit" id="fetchBtn" class="mb-5 btn btn-outline-primary" disabled onclick="navidad(event)">Enviar</button>

                    <p id="granText" class="p-4 border" style="font-size:11px; background-color:rgb(211, 211, 211); border-color: #dee2e6;">${textos.es.granText2}</p>
                </div>
           </form>
           
           `;

    container.appendChild(nuevoFormulario);
    document
        .getElementById("numClientes")
        .addEventListener("change", generarCamposClientes);
    generarCamposClientes({ target: { value: 1 } }); // Genera los campos para 1 cliente por defecto
    agregarCheckboxListeners();
    
    // Agregar listener para el checkbox de términos
    document.getElementById("acceptTerms").addEventListener("change", validarFormulario);
    
    // Agregar validación al enviar el formulario
    document.getElementById("formularioClientes").addEventListener("input", validarFormulario);
}

function inicializarCanvasFirma(canvasId, botonLimpiarId) {
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext("2d");
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
        ctx.lineCap = "round";
        ctx.strokeStyle = "black";
        ctx.lineTo(x, y);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(x, y);
    }

    // Eventos
    canvas.addEventListener("mousedown", startPosition);
    canvas.addEventListener("mouseup", endPosition);
    canvas.addEventListener("mousemove", draw);
    canvas.addEventListener("touchstart", startPosition);
    canvas.addEventListener("touchend", endPosition);
    canvas.addEventListener("touchmove", draw);

    // Botón para limpiar
    document.getElementById(botonLimpiarId).addEventListener("click", () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    });
}

function agregarCheckboxListeners() {
    const actividades = [
        { 
            id: "parasailing", 
            input: ["parasailingNum", "parasailingParticipantes", "parasailingAcompanantes"] 
        },
        { 
            id: "hinchable", 
            input: ["hinchableString", "hinchableNum", "hinchableParticipantes", "hinchableAcompanantes"] 
        },
        { 
            id: "flyboard", 
            input: ["flyboardTime", "flyboardNum", "flyboardParticipantes", "flyboardAcompanantes"] 
        },
    ];

    actividades.forEach((actividad) => {
        document
            .getElementById(actividad.id)
            .addEventListener("change", (e) => {
                const isChecked = e.target.checked;
                if (Array.isArray(actividad.input)) {
                    actividad.input.forEach(
                        (id) => {
                            const elemento = document.getElementById(id);
                            if (elemento) {
                                elemento.disabled = !isChecked;
                            }
                        }
                    );
                } else {
                    document.getElementById(actividad.input).disabled = !isChecked;
                }
                validarFormulario(); // Validar el formulario cuando cambian las actividades
            });
    });
}

// Función para validar que todas las firmas y campos requeridos estén completos
function validarFormulario() {
    const formulario = document.getElementById("formularioClientes");
    const enviarBtn = document.getElementById("fetchBtn");
    const acceptTerms = document.getElementById("acceptTerms");
    
    // Contar clientes
    const numClientes = parseInt(document.getElementById("numClientes").value);
    let formValido = formulario.checkValidity();
    let errores = [];
    
    // Verificar firmas de todos los clientes
    for (let i = 1; i <= numClientes; i++) {
        const canvas = document.getElementById(`firmaCliente${i}`);
        if (canvas) {
            const ctx = canvas.getContext("2d");
            const pixeles = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
            const hayFirma = pixeles.some(pixel => pixel !== 0);
            
            if (!hayFirma) {
                formValido = false;
                document.querySelector(`.firma-requerida-${i}`).style.display = 'block';
                errores.push(`Falta firma del cliente ${i}`);
            } else {
                document.querySelector(`.firma-requerida-${i}`).style.display = 'none';
            }
            
            // Verificar firma de padres/tutores para menores
            const fechaNacInput = document.getElementById(`fechaNacCliente${i}`);
            if (fechaNacInput && esMenorDeEdad(fechaNacInput.value)) {
                const canvasPadre = document.getElementById(`firmaPadreCliente${i}`);
                if (canvasPadre) {
                    const ctxPadre = canvasPadre.getContext("2d");
                    const pixelesPadre = ctxPadre.getImageData(0, 0, canvasPadre.width, canvasPadre.height).data;
                    const hayFirmaPadre = pixelesPadre.some(pixel => pixel !== 0);
                    
                    if (!hayFirmaPadre) {
                        formValido = false;
                        document.querySelector(`.firma-padre-requerida-${i}`).style.display = 'block';
                        errores.push(`Falta firma del padre/tutor del cliente ${i}`);
                    } else {
                        document.querySelector(`.firma-padre-requerida-${i}`).style.display = 'none';
                    }
                }
            }

            // Verificar campos del cliente
            ['nombre', 'dni', 'tel', 'mail', 'fechaNac'].forEach(campo => {
                const elemento = document.getElementById(`${campo}Cliente${i}`);
                if (elemento && !elemento.value) {
                    errores.push(`Falta ${elemento.placeholder || campo} del cliente ${i}`);
                }
            });
        }
    }
    
    // Verificar actividades
    const actividades = ["parasailing", "hinchable", "flyboard"];
    let algunaActividadSeleccionada = false;
    
    for (const act of actividades) {
        const checkbox = document.getElementById(act);
        if (checkbox && checkbox.checked) {
            algunaActividadSeleccionada = true;
            // Verificar que los campos de esta actividad estén completos
            const campos = document.querySelectorAll(`input[id^=${act}]:not([type=checkbox])`);
            for (const campo of campos) {
                if (!campo.value && !campo.disabled) {
                    formValido = false;
                    errores.push(`Falta completar ${campo.placeholder || campo.id} de ${act}`);
                }
            }
        }
    }
    
    if (!algunaActividadSeleccionada) {
        formValido = false;
        errores.push("Debe seleccionar al menos una actividad");
    }
    
    if (!acceptTerms.checked) {
        errores.push("Debe aceptar los términos y condiciones");
    }
    
    // Actualizar el texto del botón para indicar qué falta
    if (!formValido || !acceptTerms.checked) {
        enviarBtn.disabled = true;
        enviarBtn.innerHTML = `<i class="bi bi-exclamation-triangle me-2"></i>Faltan campos por completar`;
        // Mostrar hasta 3 errores como tooltip
        if (errores.length > 0) {
            enviarBtn.setAttribute('title', errores.slice(0, 3).join('\n') + (errores.length > 3 ? `\n... y ${errores.length - 3} más` : ''));
            enviarBtn.setAttribute('data-bs-toggle', 'tooltip');
            enviarBtn.setAttribute('data-bs-placement', 'top');
            // Inicializar el tooltip si Bootstrap está disponible
            if (typeof bootstrap !== 'undefined') {
                new bootstrap.Tooltip(enviarBtn);
            }
        }
    } else {
        enviarBtn.disabled = false;
        enviarBtn.innerHTML = `<i class="bi bi-check-circle me-2"></i>Enviar`;
        enviarBtn.removeAttribute('title');
        enviarBtn.removeAttribute('data-bs-toggle');
    }
}

// Exponer funciones al ámbito global
window.crearFormularioNuevo = crearFormularioNuevo;
window.inicializarCanvasFirma = inicializarCanvasFirma;
window.agregarCheckboxListeners = agregarCheckboxListeners;
window.validarFormulario = validarFormulario;
