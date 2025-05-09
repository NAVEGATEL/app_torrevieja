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

    // Validar que el formulario sea válido antes de mostrar el modal
    const formulario = document.getElementById("formularioClientes");
    if (!formulario.checkValidity()) {
        formulario.reportValidity();
        return false;
    }

    // Verificar firmas
    const numClientes = parseInt(document.getElementById("numClientes").value);
    for (let i = 1; i <= numClientes; i++) {
        // Verificar firma del cliente
        const firmaCanvas = document.getElementById(`firmaCliente${i}`);
        if (firmaCanvas) {
            const ctx = firmaCanvas.getContext("2d");
            const pixeles = ctx.getImageData(0, 0, firmaCanvas.width, firmaCanvas.height).data;
            const hayFirma = pixeles.some(pixel => pixel !== 0);
            if (!hayFirma) {
                document.querySelector(`.firma-requerida-${i}`).style.display = 'block';
                return false;
            } else {
                document.querySelector(`.firma-requerida-${i}`).style.display = 'none';
            }
        }
        
        // Verificar firma del padre/tutor si es menor de edad
        const fechaNacInput = document.getElementById(`fechaNacCliente${i}`);
        if (fechaNacInput && esMenorDeEdad(fechaNacInput.value)) {
            const firmaPadreCanvas = document.getElementById(`firmaPadreCliente${i}`);
            if (firmaPadreCanvas) {
                const ctxPadre = firmaPadreCanvas.getContext("2d");
                const pixelesPadre = ctxPadre.getImageData(0, 0, firmaPadreCanvas.width, firmaPadreCanvas.height).data;
                const hayFirmaPadre = pixelesPadre.some(pixel => pixel !== 0);
                if (!hayFirmaPadre) {
                    document.querySelector(`.firma-padre-requerida-${i}`).style.display = 'block';
                    return false;
                } else {
                    document.querySelector(`.firma-padre-requerida-${i}`).style.display = 'none';
                }
            }
        }
    }

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

// Función para mostrar toasts en lugar de alertas
function showToast(message, type = 'success') {
    // Crear el contenedor de toasts si no existe
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        document.body.appendChild(toastContainer);
    }
    
    // Crear ID único para este toast
    const toastId = 'toast-' + new Date().getTime();
    
    // Determinar el color del toast según el tipo
    let bgClass = 'bg-success';
    if (type === 'error') {
        bgClass = 'bg-danger';
    } else if (type === 'warning') {
        bgClass = 'bg-warning';
    } else if (type === 'info') {
        bgClass = 'bg-info';
    }
    
    // Crear el HTML del toast
    const toastHtml = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header ${bgClass} text-white">
                <strong class="me-auto">${type === 'error' ? 'Error' : 'Éxito'}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    // Añadir el toast al contenedor
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    
    // Inicializar y mostrar el toast
    const toast = new bootstrap.Toast(document.getElementById(toastId), {
        delay: 5000
    });
    toast.show();
    
    // Eliminar el toast del DOM después de ocultarse
    const toastEl = document.getElementById(toastId);
    toastEl.addEventListener('hidden.bs.toast', () => {
        toastEl.remove();
    });
}

// Función para obtener el token CSRF de manera segura
function getCsrfToken() {
    // Primero intentar obtenerlo de la variable global que definimos en main.blade.php
    if (window.csrfToken) {
        return window.csrfToken;
    }
    
    // Luego intentar desde el meta tag
    const metaToken = document.querySelector('meta[name="csrf-token"]');
    if (metaToken) {
        return metaToken.getAttribute('content');
    }
    
    // Si no se encuentra, registrar el error y devolver cadena vacía
    console.error('CSRF token no encontrado. Las peticiones pueden fallar.');
    return '';
}

// Función para imprimir PDF
export function imprimirPDF() {
    // Mostrar spinner de carga
    document.body.insertAdjacentHTML('beforeend', '<div id="loading-spinner" class="position-fixed w-100 h-100 d-flex justify-content-center align-items-center bg-white bg-opacity-75" style="top: 0; left: 0; z-index: 9999;"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
    
    const element = document.getElementById('imprimirAqui');
    const shortId = localStorage.getItem('short_id_eks') || 'ticket';
    const timestamp = Math.floor(Date.now() / 1000);
    const pdfFileName = `consent_${shortId}_${timestamp}.pdf`;
    
    const opt = {
        margin: 1,
        filename: pdfFileName,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    // Recopilar datos para enviar al backend
    const formData = new FormData();
    
    // Obtener CSRF Token
    const csrfToken = getCsrfToken();
    
    // Datos básicos
    formData.append('short_id', shortId);
    formData.append('fecha', document.getElementById('fecha').value);
    
    // Información de clientes
    const numClientes = parseInt(document.getElementById('numClientes').value);
    formData.append('num_clientes', numClientes);
    
    for (let i = 1; i <= numClientes; i++) {
        formData.append(`nombre_${i}`, document.getElementById(`nombreCliente${i}`).value);
        formData.append(`dni_${i}`, document.getElementById(`dniCliente${i}`).value);
        formData.append(`telefono_${i}`, document.getElementById(`telCliente${i}`).value);
        formData.append(`email_${i}`, document.getElementById(`mailCliente${i}`).value);
        formData.append(`fecha_nacimiento_${i}`, document.getElementById(`fechaNacCliente${i}`).value);
        
        // Verificar si es menor de edad
        const fechaNac = document.getElementById(`fechaNacCliente${i}`).value;
        if (esMenorDeEdad(fechaNac)) {
            formData.append(`es_menor_${i}`, 'true');
            formData.append(`padre_tutor_${i}`, document.getElementById(`padreTutorCliente${i}`).value);
        } else {
            formData.append(`es_menor_${i}`, 'false');
        }
    }
    
    // Actividades seleccionadas
    const actividades = ['parasailing', 'hinchable', 'flyboard'];
    actividades.forEach(act => {
        const checkbox = document.getElementById(act);
        if (checkbox && checkbox.checked) {
            formData.append(`actividad_${act}`, 'true');
            
            if (act === 'parasailing') {
                formData.append('parasailing_num', document.getElementById('parasailingNum').value);
                formData.append('parasailing_participantes', document.getElementById('parasailingParticipantes').value);
                formData.append('parasailing_acompanantes', document.getElementById('parasailingAcompanantes').value);
            } 
            else if (act === 'hinchable') {
                formData.append('hinchable_tipo', document.getElementById('hinchableString').value);
                formData.append('hinchable_num', document.getElementById('hinchableNum').value);
                formData.append('hinchable_participantes', document.getElementById('hinchableParticipantes').value);
                formData.append('hinchable_acompanantes', document.getElementById('hinchableAcompanantes').value);
            }
            else if (act === 'flyboard') {
                formData.append('flyboard_tiempo', document.getElementById('flyboardTime').value);
                formData.append('flyboard_num', document.getElementById('flyboardNum').value);
                formData.append('flyboard_participantes', document.getElementById('flyboardParticipantes').value);
                formData.append('flyboard_acompanantes', document.getElementById('flyboardAcompanantes').value);
            }
        }
    });

    // Generar el PDF primero como data URL para enviarlo como base64
    html2pdf().set(opt).from(element).outputPdf('datauristring').then(function(pdfAsString) {
        try {
            // Agregar el PDF como dato base64 (data URL)
            formData.append('pdf_file', pdfAsString);
            
            console.log('PDF generado correctamente');
            
            // Enviar los datos al backend
            fetch('/consent/submit', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => {
                console.log('Respuesta del servidor:', response.status);
                if (!response.ok) {
                    throw new Error(`Error ${response.status}`);
                }
                return response.json().catch(() => response.text());
            })
            .then(data => {
                console.log('Formulario enviado exitosamente', data);
                // Eliminar el spinner
                document.getElementById('loading-spinner')?.remove();
                
                // Guardar el PDF localmente
                html2pdf().set(opt).from(element).save();
                
                // Mostrar toast de éxito
                showToast('¡Formulario enviado correctamente!', 'success');
                
                // Recargar después de un momento
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                document.getElementById('loading-spinner')?.remove();
                
                // Guardar el PDF de todos modos
                html2pdf().set(opt).from(element).save();
                
                // Mostrar toast de error
                showToast('Se ha producido un error al enviar el formulario, pero se ha guardado el PDF localmente.', 'error');
            });
        } catch (error) {
            console.error('Error al procesar el PDF:', error);
            document.getElementById('loading-spinner')?.remove();
            html2pdf().set(opt).from(element).save();
            showToast('Error al procesar el PDF, pero se ha guardado localmente.', 'error');
        }
    });
}

// Exponer las funciones al ámbito global
window.navidad = navidad;
window.copiarForm = copiarForm;
window.imprimirPDF = imprimirPDF; 