console.log("Script de Cabmio Idioma cargado");
// Obtener los botones
const btnES = document.getElementById("btnES");
const btnEN = document.getElementById("btnEN");

// Función para cambiar los textos dinámicamente
function cambiarIdioma(idioma) {
    const elementos = {
        titulo: document.querySelector("h1"),
        granText: document.querySelector("#granText"),
        ticketPlaceholder: document.getElementById("inputText"),
        actividades: document.querySelector("h5"),
        enviarFormulario: document.querySelector("#obtenerticketbtn"),
        numClientesLabel: document.querySelector('label[for="numClientes"]'),
        parasailingLabel: document.querySelector('label[for="parasailing"]'),
        hinchableLabel: document.querySelector('label[for="hinchable"]'),
        flyboardLabel: document.querySelector('label[for="flyboard"]'),
        menorEdadLabel: document.querySelector('label[for="menorEdad"]'),
        fechaLabel: document.querySelector('label[for="fecha"]'),
        padreTutorLabel: document.querySelector(
            "#consentimientoMenor label:first-of-type"
        ),
        firmaLabel: document.querySelector(
            "#consentimientoMenor label:last-of-type"
        ),
        nombreApellidoPlaceholder: document.querySelectorAll(
            'input[placeholder*="Nombre y Apellido"]'
        ),
        dniPlaceholder: document.querySelectorAll('input[placeholder*="DNI"]'),
        telefonoPlaceholder: document.querySelectorAll(
            'input[placeholder*="Teléfono"]'
        ),
        emailPlaceholder: document.querySelectorAll(
            'input[placeholder*="Email"]'
        ),
        fechaNacimientoLabel: document.querySelectorAll(
            'label[for*="fechaNac"]'
        ),
        consentimientoMenorTitulo: document.querySelectorAll(".h6baby"),
        generarTicket: document.querySelector("#generarTicket"),
    };

    // Validar que los elementos existen antes de cambiar el contenido
    if (elementos.titulo) elementos.titulo.textContent = textos[idioma].titulo;
    if (elementos.granText)
        elementos.granText.textContent = textos[idioma].granText;
    if (elementos.ticketPlaceholder)
        elementos.ticketPlaceholder.placeholder =
            textos[idioma].ticketPlaceholder;
    if (elementos.actividades)
        elementos.actividades.textContent = textos[idioma].actividades;
    if (elementos.enviarFormulario)
        elementos.enviarFormulario.textContent =
            textos[idioma].enviarFormulario;
    if (elementos.numClientesLabel)
        elementos.numClientesLabel.textContent =
            textos[idioma].numClientes + ":";
    if (elementos.parasailingLabel)
        elementos.parasailingLabel.textContent = textos[idioma].parasailing;
    if (elementos.hinchableLabel)
        elementos.hinchableLabel.textContent = textos[idioma].hinchable;
    if (elementos.flyboardLabel)
        elementos.flyboardLabel.textContent = textos[idioma].flyboard;
    if (elementos.menorEdadLabel)
        elementos.menorEdadLabel.textContent = textos[idioma].menorEdad;
    if (elementos.fechaLabel)
        elementos.fechaLabel.textContent = textos[idioma].fecha + ":";
    if (elementos.padreTutorLabel)
        elementos.padreTutorLabel.textContent = textos[idioma].padreTutor + ":";
    if (elementos.firmaLabel)
        elementos.firmaLabel.textContent = textos[idioma].firma + ":";
    if (elementos.generarTicket)
        elementos.generarTicket.textContent = textos[idioma].generarTicket;

    elementos.nombreApellidoPlaceholder.forEach(
        (el) => (el.placeholder = textos[idioma].nombreApellido)
    );
    elementos.dniPlaceholder.forEach(
        (el) => (el.placeholder = textos[idioma].dni)
    );
    elementos.telefonoPlaceholder.forEach(
        (el) => (el.placeholder = textos[idioma].telefono)
    );
    elementos.emailPlaceholder.forEach(
        (el) => (el.placeholder = textos[idioma].email)
    );
    elementos.fechaNacimientoLabel.forEach(
        (el) => (el.textContent = textos[idioma].fechaNacimiento + ":")
    );
    elementos.consentimientoMenorTitulo.forEach(
        (el) => (el.textContent = textos[idioma].menores)
    );

    // Guardar el idioma actual en localStorage
    localStorage.setItem("idiomaActual", idioma);
}

// Función para cargar el idioma guardado
function cargarIdiomaGuardado() {
    const idiomaGuardado = localStorage.getItem("idiomaActual") || "es"; // Por defecto, español
    cambiarIdioma(idiomaGuardado);
}

// Asignar eventos a los botones
btnES.addEventListener("click", () => cambiarIdioma("es"));
btnEN.addEventListener("click", () => cambiarIdioma("en"));

// Cargar idioma guardado al cargar la página
document.addEventListener("DOMContentLoaded", cargarIdiomaGuardado);

function obtenerIdiomaActual() {
    let idioma = localStorage.getItem("idiomaActual");
    if (!idioma) {
        idioma = "es"; // Idioma por defecto
        localStorage.setItem("idiomaActual", idioma);
    }
    return idioma;
}

// Exponer funciones al ámbito global
window.cambiarIdioma = cambiarIdioma;
window.obtenerIdiomaActual = obtenerIdiomaActual;
