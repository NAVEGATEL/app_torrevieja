console.log("Script de Funciones Clientes Dinámicos cargado");
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

    // Exportar todas las funciones necesarias globalmente
    window.limpiarContenedorClientes = limpiarContenedorClientes;
    window.generarHTMLCliente = generarHTMLCliente;
    window.configurarEventosCliente = configurarEventosCliente;
    window.configurarFirmasYConsentimiento = configurarFirmasYConsentimiento;
    window.manejarConsentimientoMenor = manejarConsentimientoMenor;
    window.generarCamposClientes = generarCamposClientes;