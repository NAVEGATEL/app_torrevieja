@push("scripts")

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
            <div class="container border rounded clienteContainer p-3 my-3" id="clienteContainer${index}">
                <h5 class="text-dangerr mb-4">${textos[idioma].cliente} ${index}</h5>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="d-flex w-100">
                            <label class="form-label mt-2 text-start w-25">${textos[idioma].nombreApellido}:</label>
                            <input required type="text" class="form-control my-1" placeholder="${textos[idioma].nombreApellido}" />
                        </div>
                        <div class="d-flex w-100">
                            <label class="form-label mt-2 text-start w-25">${textos[idioma].dni}:</label>
                            <input required type="text" class="form-control my-1" placeholder="${textos[idioma].dni}" />
                        </div>
                        <div class="d-flex w-100">
                            <label class="form-label mt-2 text-start w-25">${textos[idioma].telefono}:</label>
                            <input required type="tel" class="form-control my-1" placeholder="${textos[idioma].telefono}" />
                        </div>
                        <div class="d-flex w-100">
                            <label class="form-label mt-2 text-start w-25">${textos[idioma].email}:</label>
                            <input required type="email" class="form-control my-1" placeholder="${textos[idioma].email}" />
                        </div>
                        <div class="d-flex w-100">
                            <label class="form-label mt-2 text-start w-25">${textos[idioma].fechaNacimiento}:</label>
                            <input required type="date" id="fechaNacCliente${index}"  class="form-control mb-2 fechaNacimiento" />
                        </div>
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


                    <h5 class="my-3"><b>${textos.es.ticketPlaceholder}: ${ticketNumber}</b></h5> 
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
                        <input type="date" id="fecha" class="form-control mb-3" value="${new Date().toISOString().split('T')[0]}" />
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

    crearFormularioNuevo("as")

</script>



<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<script>
    // Validar formulario y canvas
    function navidad(event) {
        event.preventDefault(); // Evita que se envíe el formulario

        // Verificar si todos los campos requeridos están completos
        const formulario = document.getElementById("formularioClientes");  
        const camposRequeridos = formulario.querySelectorAll("[required]");  
        let todosCompletos = true;

        // Iterar sobre los campos requeridos para comprobar si están vacíos
        camposRequeridos.forEach(campo => {
            if (campo.value != undefined){  
                console.log(campo.value);
                if (campo.value.trim()){  
                    todosCompletos = false;
                }
            }
        });

        // Si algún campo requerido está vacío, mostrar un alert y evitar abrir el modal
        if (!todosCompletos) {
            alert("Por favor, completa todos los campos requeridos.");
            return; // Detener la ejecución de la función
        }

        // Si todos los campos están completos, abrir el modal
        const modalElement = document.querySelector("#modalTodoListo");
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            modal.show(); 
            const modalContent = document.getElementById("imprimirAqui");
            if (modalContent) {
                copiarForm(modalContent);
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
            // Clonar el formulario
            const formularioClonado = formularioClientes.cloneNode(true);
            formularioClonado.removeAttribute("id"); // Elimina el ID para evitar duplicados

            // Eliminar todos los botones dentro del formulario clonado
            const botones = formularioClonado.querySelectorAll("button");
            botones.forEach(boton => boton.remove());

            // Eliminar todos los checkboxes
            const checkboxes = formularioClonado.querySelectorAll("input[type=checkbox]");
            checkboxes.forEach(checkbox => checkbox.remove());

            // Convertir todos los input en texto
            const inputs = formularioClonado.querySelectorAll("input, textarea, select");
            let n = 0;
            inputs.forEach(input => {
                const texto = document.createElement("p");
                texto.textContent = input.value || "N/A"; // Obtener el valor del input
                texto.style.marginRight = "5px";
                if (n!=0){
                    texto.classList.add("text-start"); 
                    texto.classList.add("mt-3");
                }
                    
                    // Reemplazar el input con el texto
                    input.parentNode.replaceChild(texto, input);
                n++
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
            contenedorA4.style.width = "174mm";
            contenedorA4.style.minHeight = "297mm";
            contenedorA4.style.margin = "0 auto";
            contenedorA4.style.padding = "0mm";
            contenedorA4.style.backgroundColor = "#fff";
            contenedorA4.style.boxShadow = "0 0 0px rgba(0, 0, 0, 0.5)";
            contenedorA4.style.overflow = "hidden";
            contenedorA4.style.boxSizing = "border-box";

            // Insertar el formulario clonado en el contenedor A4
            contenedorA4.appendChild(formularioClonado);

            // Limpiar el contenido previo y agregar el contenedor con formato A4
            modalContent.innerHTML = "";
            modalContent.appendChild(contenedorA4);
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

        // Obtener los datos del primer cliente
        const nombreCliente = "NombreEjemplo"; // Reemplazar con la lógica para obtener el nombre
        const telefonoCliente = "123456789"; // Reemplazar con la lógica para obtener el teléfono

        const options = {
            margin: 10,
            filename: `${nombreCliente}_${telefonoCliente}_${new Date().toLocaleString('es-ES', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            }).replace(/[:/]/g, '-')}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().set(options).from(imprimirAqui).save();
    }


</script>

@endpush