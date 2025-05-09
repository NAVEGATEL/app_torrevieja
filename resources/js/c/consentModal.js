// Funcionalidad del modal y generación de PDFs
export function initConsentModal() {
    // Inicializa los event listeners
    document.getElementById('botonImprimir')?.addEventListener('click', () => {
        imprimirPDF();
    });

    document.getElementById('botonReescribir')?.addEventListener('click', () => {
        window.location.reload();
    });
}

// Función navidad para validar formulario y mostrar modal
export function navidad(event) {
    event.preventDefault();

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

export function copiarForm(modalContent) {
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
            formularioClonado.reportValidity();
            return false;
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
        contenedorA4.style.maxWidth = "210mm";
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
        return false;
    }
}

// Función para imprimir PDF
export function imprimirPDF() {
    const element = document.getElementById('imprimirAqui');
    const opt = {
        margin: 1,
        filename: 'consentimiento.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(element).save();
}

// Exponer las funciones al ámbito global
window.navidad = navidad;
window.copiarForm = copiarForm;
window.imprimirPDF = imprimirPDF; 