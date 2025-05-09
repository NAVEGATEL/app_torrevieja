 console.log("Script de PDF_to_BCK cargado");
   // Función para guardar el archivo en el backend
    async function guardarPDFEnBackend(pdfBlob, filenameEd) {
        // Mostrar el spinner
        startSpinner();

        const cantidadDeClientes = document.querySelector("#numClientes").value

        const fechaFirma = localStorage.getItem('printDate');


        for (let i = 1; i <= cantidadDeClientes; i++) {
            let nombreCliente = document.getElementById(`nombreCliente${i}copy`).innerHTML;
            let telCliente = document.getElementById(`telCliente${i}copy`).innerHTML;
            let dniCliente = document.getElementById(`dniCliente${i}copy`).innerHTML;
            let mailCliente = document.getElementById(`mailCliente${i}copy`).innerHTML;
            let fechaNacCliente = document.getElementById(`fechaNacCliente${i}copy`).innerHTML;
            console.log("Cliente "+i+ ": " +nombreCliente+telCliente+dniCliente+mailCliente+fechaNacCliente);
            
            try {
                const formData = new FormData();
                formData.append('file', pdfBlob);
                formData.append('filename', filenameEd);
                formData.append('nombre_cliente', nombreCliente);
                formData.append('dni', dniCliente);
                formData.append('email', mailCliente);
                formData.append('telefono', telCliente);
                formData.append('fechaFirma', fechaFirma);
                formData.append('anyoNacimiento', fechaNacCliente);
                formData.append('short_id', localStorage.getItem('short_id_eks'));
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch(`/upload-pdf?filename=${encodeURIComponent(filenameEd)}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: formData,
                });

    
                if (response.ok) {
                    console.log('Archivo guardado exitosamente en el backend.');
                } else {
                    console.error('Error al guardar el archivo en el backend:', await response.text());
                }
            } catch (error) {
                console.error('Error en la solicitud al backend:', error);
                        // Finalizar el spinner
                endSpinner();
            }
        }

        // Finalizar el spinner
        endSpinner();
    }
    
// Exponer funciones al ámbito global
window.guardarPDFEnBackend = guardarPDFEnBackend;