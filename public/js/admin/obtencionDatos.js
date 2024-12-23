async function fetchAccessToken() {
    try {
        const tokenResponse = await fetch("https://app.turitop.com/v1/authorization/grant", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                short_id: "F83",
                secret_key: "1jLrCT9A1ebKMZHcnGqaOZTYQsiZtMwb"
            }),
        });

        const tokenData = await tokenResponse.json();
        if (tokenData.status !== "SUCCESS") {
            throw new Error("Failed to fetch access token: " + tokenData.message);
        }
        return tokenData.data.access_token;
    } catch (error) {
        console.error("Error fetching access token:", error);
        throw error;
    }
}
async function fetchBookingsWeekly8(accessToken) { 
    try {
        let allBookings = [];
        const oneDayInSeconds = 86400;

        // Función auxiliar para validar y convertir fechas
        const safeDate = (timestamp) => {
            return timestamp && !isNaN(new Date(timestamp * 1000)) ? new Date(timestamp * 1000).toISOString() : null;
        };

        // Función auxiliar para formatear datos JSON
        const formatJSON = (data) => {
            try {
                return JSON.stringify(JSON.parse(data));
            } catch {
                return data; // Devolver la cadena original si no es un JSON válido
            }
        };

        // Función recursiva para manejar divisiones
        async function fetchWithDynamicRange(startDate, endDate, rangeDescription = "rango original") {
            const formattedStart = new Date(startDate * 1000).toISOString();
            const formattedEnd = new Date(endDate * 1000).toISOString();

            console.log(`🔍 [Consulta] Rango: ${formattedStart} a ${formattedEnd} (${rangeDescription})`);

            const response = await fetch("https://app.turitop.com/v1/booking/getbookings", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    access_token: accessToken,
                    data: {
                        filter: {
                            bookings_date_from: startDate,
                            bookings_date_to: endDate,
                            show_deleted: 1
                        }
                    }
                }),
            });

            const data = await response.json();

            if (data.status === "SUCCESS" && data.data.bookings.length > 0) {
                console.log(`✅ [Resultados] ${data.data.bookings.length} reservas encontradas en el rango: ${formattedStart} a ${formattedEnd} (${rangeDescription})`);
                console.log(data.data.bookings);
                
                if (data.data.bookings.length === 100) {
                    console.log(
                        `⚠️ [Alerta] Más de 100 datos en el rango ${formattedStart} a ${formattedEnd}. Dividiendo rango...`
                    );

                    const midDate = Math.floor((startDate + endDate) / 2);

                    // Llamada recursiva para la primera mitad
                    await fetchWithDynamicRange(
                        startDate,
                        midDate,
                        `${formattedStart} a ${new Date(midDate * 1000).toISOString()}`
                    );

                    // Llamada recursiva para la segunda mitad
                    await fetchWithDynamicRange(
                        midDate + 1,
                        endDate,
                        `${new Date(midDate * 1000).toISOString()} a ${formattedEnd}`
                    );
                } else {
                    // Agregar los datos únicos a `allBookings`
                    data.data.bookings.forEach(booking => {
                        if (!allBookings.some(existing => existing.short_id === booking.short_id)) {
                            allBookings.push(booking);
                        }
                    });
                }
            } else {
                console.log(`❌ [Sin datos] Ninguna reserva encontrada en el rango: ${formattedStart} a ${formattedEnd} (${rangeDescription})`);
            }
        }

        // Configuración inicial: Rango de 30 días
        let endDate = Math.floor(Date.now() / 1000);
        const sixMonthsAgo = endDate - oneDayInSeconds * 30 * 3; // Timestamp de 6 meses atrás
        let noDataWeeks = 0;
        // let endDate = Math.floor(new Date("2015-01-26T07:46:07.000Z").getTime() / 1000); // Timestamp desde la fecha
 

        while (noDataWeeks < 3 && endDate >= sixMonthsAgo) {
            const startDate = endDate - oneDayInSeconds * 30; // Rango inicial de 30 días
        
            console.groupCollapsed(`📅 [Inicio de Ciclo] Procesando rango: ${new Date(startDate * 1000).toISOString()} a ${new Date(endDate * 1000).toISOString()}`);
            const previousTotal = allBookings.length; // Guardar el total previo para este ciclo

            await fetchWithDynamicRange(startDate, endDate, "30 días");

            // Validar si se obtuvieron datos en este rango
            const newTotal = allBookings.length;
            const collectedThisCycle = newTotal - previousTotal;

            if (collectedThisCycle > 0) {
                console.log(`📈 [Resumen del Ciclo] Datos recolectados en este ciclo de 30 días: ${collectedThisCycle}`);

                // Enviar datos a la base de datos
                const bookingsToSave = allBookings.slice(previousTotal).map(booking => ({
                    short_id: booking.short_id,
                    product_name: booking.product_name,
                    supplier_company_name: booking.supplier_company_name,
                    seller_company_name: booking.seller_company_name,
                    language_code: booking.language_code,
                    location: booking.location || "N/A",
                    service_flow: booking.service_flow,
                    date_event: safeDate(booking.date_event),
                    date_prebooking: safeDate(booking.date_prebooking),
                    date_booking: safeDate(booking.date_booking),
                    date_modified: safeDate(booking.date_modified),
                    client_name: booking.client_data?.name || "N/A",
                    client_phone: booking.client_data?.phone || "N/A",
                    client_email: booking.client_data?.email || null,
                    client_id: booking.client_data?.id || null, // NUEVO
                    currency: booking.currency,
                    total_price: parseFloat(booking.total_price),
                    payment_partial: parseFloat(booking.payment_partial),
                    ticket_type_count: formatJSON(booking.ticket_type_count),
                    payment_transaction: formatJSON(booking.payment_transaction),
                    status: booking.status,
                    source: booking.source,
                    pdf_download: booking.pdf_download || null, // NUEVO
                    verification_code: booking.verification_code || null, // NUEVO
                    verification_type: booking.verification_type || null, // NUEVO
                }));

                console.log(bookingsToSave);

                try {
                    const saveResponse = await fetch('/api/bookings/batch', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ bookings: bookingsToSave }),
                    });

                    const result = await saveResponse.json();
                    if (result.success) {
                        console.info(`📥 [Guardado] ${bookingsToSave.length} reservas guardadas con éxito.`);
                    } else {
                        console.error(`❌ [Error Guardando] Error al guardar reservas del rango.`, result);
                    }
                } catch (error) {
                    console.error(`❌ [Error] No se pudieron guardar reservas del rango. ` +  startDate, endDate);
                }

                console.groupEnd(`📊 [Acumulado Total] Total de datos acumulados hasta ahora: ${newTotal}`);
                noDataWeeks = 0;
                
            } else {
                noDataWeeks++;
                console.groupEnd(`🔴 [Aviso] Sin datos para este rango de 30 días (${noDataWeeks}/3 semanas sin datos).`);
            }

            endDate = startDate - 1; // Retroceder para el siguiente ciclo
        }

        console.log(`📊 [Resumen Final] Total de datos acumulados: ${allBookings.length}`);
        return allBookings;
    } catch (error) {
        console.error("❌ [Error] Error fetching bookings:", error);
        return [];
    }
}

let toastInterval;

function createToast(message, isError = false) {
    // Crear contenedor del toast
    let toastContainer = document.getElementById("toast-container");

    // Si no existe el contenedor, lo creamos
    if (!toastContainer) {
        toastContainer = document.createElement("div");
        toastContainer.id = "toast-container";
        toastContainer.style.position = "fixed";
        toastContainer.style.bottom = "20px";
        toastContainer.style.right = "20px";
        toastContainer.style.zIndex = "1050";
        toastContainer.style.maxWidth = "300px";
        toastContainer.style.display = "none";
        document.body.appendChild(toastContainer);
    }

    // Crear contenido del toast
    const toast = document.createElement("div");
    toast.id = "toast";
    toast.style.backgroundColor = isError ? "#d9534f" : "#333"; // Rojo para errores
    toast.style.color = "white";
    toast.style.borderRadius = "5px";
    toast.style.padding = "15px";
    toast.style.display = "flex";
    toast.style.alignItems = "center";
    toast.style.boxShadow = "0 4px 6px rgba(0, 0, 0, 0.1)";
    toast.style.marginBottom = "10px";

    // Crear spinner si no es error
    const toastSpinner = document.createElement("div");
    toastSpinner.id = "toast-spinner";
    if (!isError) {
        toastSpinner.style.border = "4px solid transparent";
        toastSpinner.style.borderTop = "4px solid white";
        toastSpinner.style.borderRadius = "50%";
        toastSpinner.style.width = "20px";
        toastSpinner.style.height = "20px";
        toastSpinner.style.marginRight = "10px";
        toastSpinner.style.animation = "spin 1s linear infinite";
    } else {
        toastSpinner.style.display = "none";
    }

    // Crear mensaje
    const toastMessage = document.createElement("span");
    toastMessage.id = "toast-message";
    toastMessage.style.transition = "opacity 0.5s"; // Animación de desvanecimiento
    toastMessage.textContent = message;

    // Ensamblar elementos
    toast.appendChild(toastSpinner);
    toast.appendChild(toastMessage);
    toastContainer.appendChild(toast);

    // Mostrar el toast
    toastContainer.style.display = "block";
}

function updateToastMessage(message) {
    const toastMessage = document.getElementById("toast-message");
    if (toastMessage) {
        // Animación de desvanecimiento
        toastMessage.style.opacity = 0; // Ocultar mensaje actual
        setTimeout(() => {
            toastMessage.textContent = message; // Cambiar texto
            toastMessage.style.opacity = 1; // Mostrar nuevo texto
        }, 500); // Tiempo de desvanecimiento
    }
}

function removeToast() {
    const toastContainer = document.getElementById("toast-container");
    if (toastContainer) {
        toastContainer.remove();
        clearInterval(toastInterval); // Limpiar intervalo si existe
    }
}

// Añadir animación spinner al estilo
const style = document.createElement("style");
style.textContent = `
@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}`;
document.head.appendChild(style);

async function init() {
    try {
        // Mostrar mensaje inicial
        createToast("⏳ Obteniendo datos actualizados de Turitop...");

        // Cambiar el mensaje cada 5 segundos con emojis
        let messages = [
            "⏳ Obteniendo datos actualizados de Turitop...",
            "🔄 Por favor, no cambies de ventana...",
            "📊 Actualizando información, casi listo...",
        ];
        let currentMessageIndex = 0;

        toastInterval = setInterval(() => {
            currentMessageIndex = (currentMessageIndex + 1) % messages.length;
            updateToastMessage(messages[currentMessageIndex]);
        }, 5000);

        // Simulación de la obtención de datos
        const accessToken = await fetchAccessToken();
   

        await fetchBookingsWeekly8(accessToken);

        // Mostrar mensaje de éxito y ocultar después de 30 segundos
        removeToast();
        createToast("✅ Datos actualizados correctamente.");
        setTimeout(removeToast, 30000);
    } catch (error) {
        // Mostrar mensaje de error
        console.error("Initialization error:", error);
        removeToast();
        createToast("❌ Error al obtener datos de Turitop. Por favor, revise la consola.", true);
    }
}

init();
