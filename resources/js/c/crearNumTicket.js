console.log("Script de Crear Número Ticket cargado");
    document.getElementById('generarTicket').addEventListener('click', function() {
        generarNumeroTicket();
    });
    
    function generarNumeroTicket() {
        // Obtener la fecha y hora actuales
        const now = new Date();

        // Formatear el valor NN-díaMesAñoHoraMinutosSegundos
        const formattedDate = 
            'NN-' +
            String(now.getDate()).padStart(2, '0') +
            String(now.getMonth() + 1).padStart(2, '0') +
            String(now.getFullYear()).slice(-2) +
            String(now.getHours()).padStart(2, '0') +
            String(now.getMinutes()).padStart(2, '0') +
            String(now.getSeconds()).padStart(2, '0');

        // Insertar el valor en el input
        document.getElementById('inputText').value = formattedDate;

        localStorage.setItem('short_id_eks', formattedDate)

        // Simular el clic en el botón "Enviar"
        document.getElementById('obtenerticketbtn').click();
    }
    
    // Exponer funciones al ámbito global
    window.generarNumeroTicket = generarNumeroTicket;