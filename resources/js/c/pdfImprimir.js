 console.log("Script de PDF Imprimir cargado");
    function imprimirPDF() {
        console.log("Iniciando impresión...");
        const imprimirAqui = document.getElementById('imprimirAqui');

        if (!imprimirAqui) {
            console.error("El modal_content con ID 'imprimirAqui' no existe en el DOM.");
            return;
        }

        console.log("Elemento encontrado, iniciando html2pdf...");

        const filenameEd = `${localStorage.getItem('telPrint')}_${localStorage.getItem('dniPrint')}_${localStorage.getItem('printDate')}.pdf`.replace(/\s+/g, '_');

        const options = {
            margin: 0,
            filename: filenameEd,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        // Generar el PDF y guardarlo en el backend
        html2pdf()
            .set(options)
            .from(imprimirAqui)
            .outputPdf('blob') // Obtener el PDF como un blob
            .then(async (pdfBlob) => {
                console.log("PDF generado correctamente. Guardando en backend...");
                await guardarPDFEnBackend(pdfBlob, filenameEd); // Guardar en el backend
                console.log("PDF guardado en backend. Iniciando descarga local...");
                html2pdf().set(options).from(imprimirAqui).save(); // Descargar el PDF localmente
            })
            .catch((error) => {
                console.error("Error al generar el PDF:", error);
            });
    }
    
// Exponer funciones al ámbito global
window.imprimirPDF = imprimirPDF;