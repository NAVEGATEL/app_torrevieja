// resources/js/main.js
import './c/bloqueocanva.js';
import './c/cambiarIdioma.js';
import './c/crearNumTicket.js';
import './c/customer.js';
import './c/edad.js';
import './c/formDinamico.js';
import './c/getTicketNumber.js';
import './c/habdesbotones.js';
import './c/pdfBackend.js';
import './c/pdfImprimir.js';
import './c/spin.js';
import { initConsentModal, navidad, imprimirPDF, copiarForm } from './c/consentModal.js';

// Inicializar el modal de consentimientos cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    console.log("Inicializando aplicación...");
    
    // Aseguramos que las funciones importantes estén disponibles globalmente
    window.navidad = navidad;
    window.imprimirPDF = imprimirPDF;
    window.copiarForm = copiarForm;
    
    // Inicializar componentes
    initConsentModal();
    
    console.log("Aplicación inicializada correctamente");
});
