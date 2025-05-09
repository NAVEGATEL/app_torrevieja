console.log("Script de Spinner cargado");
   
function endSpinner() {
            const overlay = document.getElementById('spinner-overlay');
            if (overlay) {
                document.body.removeChild(overlay);
            }
        }
    function startSpinner() {
        // Crear el fondo gris opaco
        const overlay = document.createElement('div');
        overlay.id = 'spinner-overlay';
        overlay.style.position = 'fixed';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        overlay.style.zIndex = '9999';
        overlay.style.display = 'flex';
        overlay.style.alignItems = 'center';
        overlay.style.justifyContent = 'center';

        // Crear el spinner
        const spinner = document.createElement('div');
        spinner.id = 'spinner';
        spinner.style.width = '50px';
        spinner.style.height = '50px';
        spinner.style.border = '6px solid #f3f3f3';
        spinner.style.borderTop = '6px solid #3498db';
        spinner.style.borderRadius = '50%';
        spinner.style.animation = 'spin 1s linear infinite';

        // Añadir animación al spinner
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);

        // Agregar el spinner al overlay
        overlay.appendChild(spinner);

        // Agregar el overlay al cuerpo del documento
        document.body.appendChild(overlay);
    }
    
// Exponer funciones al ámbito global
window.startSpinner = startSpinner;
window.endSpinner = endSpinner;