// Aquí es donde se obtiene el número de ticket, se hace un fetch para buscar en turitop y luego se crea el form
console.log("Script de GET Ticket cargado");

const inputText = document.getElementById("inputText");
const obtenerticketbtn = document.getElementById("obtenerticketbtn");

// función primera donde se pide el número de ticket
obtenerticketbtn.addEventListener("click", () => {
    obtenerTicket();
});

function obtenerTicket() {
    const text = inputText.value.trim();
    if (!text) {
        alert("Por favor, introduce un número de ticket.");
        return;
    }
    localStorage.setItem("short_id_eks", text);

    fetch("https://jsonplaceholder.typicode.com/posts/1")
        .then((response) => {
            if (!response.ok) throw new Error("Error en la solicitud");
            return response.json();
        })
        .then((data) => {
            crearFormularioNuevo(text);
        })
        .catch((error) => {
            console.error(error);
            alert("Hubo un error: " + error.message);
        });
}

// Exponer funciones al ámbito global
window.obtenerTicket = obtenerTicket;
