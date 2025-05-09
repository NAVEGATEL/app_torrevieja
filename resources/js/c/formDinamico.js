console.log("Script de Formulario Dinámico cargado");

const container = document.querySelector(".container");

function crearFormularioNuevo(ticketNumber) {
    // Eliminar el formulario inicial
    const formularioInicial = document.getElementById("form-inicial");
    formularioInicial.remove();

    // Crear nuevo formulario
    const nuevoFormulario = document.createElement("div");
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


                class="d-flex justify-content-center align-items-center flex-column clienteContainer">
                    <!-- Fecha -->
                    <div class="mx-5">
                        <label for="fecha">${textos.es.fecha} :</label>
                        <input  type="datetime-local"  id="fecha"  class="form-control mb-3"  value="{{ now()->timezone('Europe/Madrid')->format('Y-m-d\TH:i:s') }}"  required/>
                    </div>

                    <!-- Botón de enviar -->
                    <button  type="submit"  id="fetchBtn"  class="mb-5 btn btn-outline-primary"  onclick="navidad(event)">Enviar</button>

                    <p id="granText"  class="p-4 border"  style="font-size:11px; background-color:rgb(211, 211, 211); border-color: #dee2e6;">${textos.es.granText2}</p>
                </div>
           </form>
           
           `;

    container.appendChild(nuevoFormulario);
    document
        .getElementById("numClientes")
        .addEventListener("change", generarCamposClientes);
    generarCamposClientes({ target: { value: 1 } }); // Genera los campos para 1 cliente por defecto
    agregarCheckboxListeners();
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
        { id: "parasailing", input: "parasailingNum" },
        { id: "hinchable", input: ["hinchableString", "hinchableNum"] },
        { id: "flyboard", input: ["flyboardTime", "flyboardNum"] },
    ];

    actividades.forEach((actividad) => {
        document
            .getElementById(actividad.id)
            .addEventListener("change", (e) => {
                const isChecked = e.target.checked;
                if (Array.isArray(actividad.input)) {
                    actividad.input.forEach(
                        (id) =>
                            (document.getElementById(id).disabled = !isChecked)
                    );
                } else {
                    document.getElementById(actividad.input).disabled =
                        !isChecked;
                }
            });
    });
}

// Exponer funciones al ámbito global
window.crearFormularioNuevo = crearFormularioNuevo;
window.inicializarCanvasFirma = inicializarCanvasFirma;
window.agregarCheckboxListeners = agregarCheckboxListeners;
