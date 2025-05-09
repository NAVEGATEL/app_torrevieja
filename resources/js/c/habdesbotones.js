console.log("Script de Control de botones cargado");
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

// Exponer funciones al ámbito global
window.toggleButtons = toggleButtons;