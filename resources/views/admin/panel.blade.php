@extends('admin.layouts.private')

@section('content')

<script>

// Carga de datos al inicializar la página
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



async function fetchBookingsWeekly(accessToken) {
    try {
        let allBookings = [];
        const oneDayInSeconds = 86400;
        const oneWeekInSeconds = oneDayInSeconds * 1;
        let endDate = Math.floor(Date.now() / 1000); // Fecha actual en timestamp
        let noDataWeeks = 0; // Contador para semanas consecutivas sin datos

        while (noDataWeeks < 3) {
            const startDate = endDate - oneWeekInSeconds; // Fecha de inicio de la semana

            console.log(`Fetching data from ${new Date(startDate * 1000).toISOString()} to ${new Date(endDate * 1000).toISOString()}`);

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
                console.log(data.data.bookings.length);
                console.log(data.data.bookings);
                if (data.data.bookings.length === 100) {
                    console.error("La consulta actual tiene exactamente 100 registros");
                }

                data.data.bookings.forEach(booking => {
                    // Evitar duplicados basados en short_id
                    if (!allBookings.some(existing => existing.short_id === booking.short_id)) {
                        allBookings.push(booking);
                    }
                });

                console.log(`Current page: ${Math.floor((Date.now() - endDate * 1000) / oneWeekInSeconds)}`);
                console.log(`Total bookings so far: ${allBookings.length}`);

                noDataWeeks = 0; // Reiniciar el contador de semanas sin datos
            } else {
                console.log(`No data found for week starting ${new Date(startDate * 1000).toISOString()}`);
                noDataWeeks++; // Incrementar contador de semanas sin datos
            }

            endDate = startDate - 1; // Ajustar el rango para la siguiente iteración
        }

        console.log(`Fetched ${allBookings.length} bookings in total.`);
        return allBookings;
    } catch (error) {
        console.error("Error fetching weekly bookings:", error);
        return [];
    }
}

async function fetchBookingsWeekly2(accessToken) {
    try {
        let allBookings = [];
        const oneDayInSeconds = 86400;
        const oneWeekInSeconds = oneDayInSeconds * 1;
        let endDate = Math.floor(Date.now() / 1000); // Fecha actual en timestamp
        let noDataWeeks = 0; // Contador para semanas consecutivas sin datos

        while (noDataWeeks < 3) {
            const startDate = endDate - oneWeekInSeconds; // Fecha de inicio de la semana

            console.log(`Fetching data from ${new Date(startDate * 1000).toISOString()} to ${new Date(endDate * 1000).toISOString()}`);

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
                cantidadEnEstaPetición = data.data.bookings.length

                // Manejar días con exactamente 100 registros
                if (data.data.bookings.length === 100) {
                    cantidadEnEstaPetición = 0
                    console.error("La consulta actual tiene exactamente 100 registros. Dividiendo en consultas de medio día...");
                    
                    // Dividir el día en dos mitades
                    const halfDayInSeconds = oneDayInSeconds / 2;

                    // Primera mitad del día
                    const firstHalfResponse = await fetch("https://app.turitop.com/v1/booking/getbookings", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({
                            access_token: accessToken,
                            data: {
                                filter: {
                                    bookings_date_from: startDate,
                                    bookings_date_to: startDate + halfDayInSeconds,
                                    show_deleted: 1
                                }
                            }
                        }),
                    });

                    const firstHalfData = await firstHalfResponse.json();
                    console.log("firstHalfData: " + firstHalfData.data.bookings.length)
                    if (firstHalfData.status === "SUCCESS" && firstHalfData.data.bookings.length > 0) {
                        firstHalfData.data.bookings.forEach(booking => {
                            if (!allBookings.some(existing => existing.short_id === booking.short_id)) {
                                allBookings.push(booking);
                            }
                        });
                    }

                    // Segunda mitad del día
                    const secondHalfResponse = await fetch("https://app.turitop.com/v1/booking/getbookings", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({
                            access_token: accessToken,
                            data: {
                                filter: {
                                    bookings_date_from: startDate + halfDayInSeconds + 1,
                                    bookings_date_to: endDate,
                                    show_deleted: 1
                                }
                            }
                        }),
                    });

                    const secondHalfData = await secondHalfResponse.json();
                    console.log("secondHalfData: " + secondHalfData.data.bookings.length)
                    if (secondHalfData.status === "SUCCESS" && secondHalfData.data.bookings.length > 0) {
                        secondHalfData.data.bookings.forEach(booking => {
                            if (!allBookings.some(existing => existing.short_id === booking.short_id)) {
                                allBookings.push(booking);
                            }
                        });
                    }

                    cantidadEnEstaPetición = firstHalfData.data.bookings.length + firstHalfData.data.bookings.length
                } else {
                    data.data.bookings.forEach(booking => {
                        if (!allBookings.some(existing => existing.short_id === booking.short_id)) {
                            allBookings.push(booking);
                        }
                    });
                }
                console.log();
                console.log(`Current page: ${Math.floor((Date.now() - endDate * 1000) / oneWeekInSeconds)}`);
                console.log(`Total bookings so far: ${allBookings.length}`);

                noDataWeeks = 0; // Reiniciar el contador de semanas sin datos
            } else {
                console.log(`No data found for week starting ${new Date(startDate * 1000).toISOString()}`);
                noDataWeeks++; // Incrementar contador de semanas sin datos
            }

            endDate = startDate - 1; // Ajustar el rango para la siguiente iteración
        }

        console.log(`Fetched ${allBookings.length} bookings in total.`);
        return allBookings;
    } catch (error) {
        console.error("Error fetching weekly bookings:", error);
        return [];
    }
}

async function fetchBookingsWeekly3(accessToken) {
    try {
        let allBookings = [];
        const oneDayInSeconds = 86400;

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

                if (data.data.bookings.length === 100) {
                    console.error(
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
        let endDate = Math.floor(Date.now() / 1000); // Fecha actual en timestamp
        let noDataWeeks = 0;

        while (noDataWeeks < 3) {
            const startDate = endDate - oneDayInSeconds * 30; // Rango inicial de 30 días

            console.log(`📅 [Inicio de Ciclo] Procesando rango: ${new Date(startDate * 1000).toISOString()} a ${new Date(endDate * 1000).toISOString()}`);
            await fetchWithDynamicRange(startDate, endDate, "30 días");

            // Validar si se obtuvieron datos en este rango
            if (allBookings.length === 0) {
                noDataWeeks++;
                console.log(`🔴 [Aviso] Sin datos para este rango de 30 días (${noDataWeeks}/3 semanas sin datos).`);
            } else {
                noDataWeeks = 0;
            }

            endDate = startDate - 1; // Retroceder para el siguiente ciclo
        }

        console.log(`📊 [Resumen] Total de datos acumulados: ${allBookings.length}`);
        return allBookings;
    } catch (error) {
        console.error("❌ [Error] Error fetching bookings:", error);
        return [];
    }
}

async function fetchBookingsWeekly4(accessToken) {
    try {
        let allBookings = [];
        const oneDayInSeconds = 86400;

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

                if (data.data.bookings.length === 100) {
                    console.error(
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
        let endDate = Math.floor(Date.now() / 1000); // Fecha actual en timestamp
        let noDataWeeks = 0;

        while (noDataWeeks < 3) {
            const startDate = endDate - oneDayInSeconds * 30; // Rango inicial de 30 días

            console.log(`📅 [Inicio de Ciclo] Procesando rango: ${new Date(startDate * 1000).toISOString()} a ${new Date(endDate * 1000).toISOString()}`);
            const previousTotal = allBookings.length; // Guardar el total previo para este ciclo

            await fetchWithDynamicRange(startDate, endDate, "30 días");

            // Validar si se obtuvieron datos en este rango
            const newTotal = allBookings.length;
            const collectedThisCycle = newTotal - previousTotal;

            if (collectedThisCycle > 0) {
                console.log(`📈 [Resumen del Ciclo] Datos recolectados en este ciclo de 30 días: ${collectedThisCycle}`);
                console.log(`📊 [Acumulado Total] Total de datos acumulados hasta ahora: ${newTotal}`);
                noDataWeeks = 0;
            } else {
                noDataWeeks++;
                console.log(`🔴 [Aviso] Sin datos para este rango de 30 días (${noDataWeeks}/3 semanas sin datos).`);
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

async function fetchBookingsWeekly5(accessToken) {
    try {
        let allBookings = [];
        const oneDayInSeconds = 86400;

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

                if (data.data.bookings.length === 100) {
                    console.error(
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
        let endDate = Math.floor(Date.now() / 1000); // Fecha actual en timestamp
        let noDataWeeks = 0;

        while (noDataWeeks < 3) {
            const startDate = endDate - oneDayInSeconds * 30; // Rango inicial de 30 días

            console.group(`📅 [Inicio de Ciclo] Procesando rango: ${new Date(startDate * 1000).toISOString()} a ${new Date(endDate * 1000).toISOString()}`);
            const previousTotal = allBookings.length; // Guardar el total previo para este ciclo

            await fetchWithDynamicRange(startDate, endDate, "30 días");

            // Validar si se obtuvieron datos en este rango
            const newTotal = allBookings.length;
            const collectedThisCycle = newTotal - previousTotal;

            if (collectedThisCycle > 0) {
                console.log(`📈 [Resumen del Ciclo] Datos recolectados en este ciclo de 30 días: ${collectedThisCycle}`);
                console.groupEnd(`📊 [Acumulado Total] Total de datos acumulados hasta ahora: ${newTotal}`);
                noDataWeeks = 0;
            } else {
                noDataWeeks++;
                console.groupEnd(`🔴 [Aviso] Sin datos para este rango de 30 días (${noDataWeeks}/3 semanas sin datos).`);
            }

            endDate = startDate - 1; // Retroceder para el siguiente ciclo
        }

        console.log(`📊 [Resumen Final] Total de datos acumulados: ${allBookings.length}`);

        // Construcción y envío de datos a Laravel
        for (const booking of allBookings) {
            const bookingData = {
                short_id: booking.short_id,
                product_name: booking.product_name,
                supplier_company_name: booking.supplier_company_name,
                seller_company_name: booking.seller_company_name,
                language_code: booking.language_code,
                location: booking.location,
                service_flow: booking.service_flow,
                date_event: new Date(booking.date_event * 1000).toISOString(),
                date_prebooking: new Date(booking.date_prebooking * 1000).toISOString(),
                date_booking: new Date(booking.date_booking * 1000).toISOString(),
                date_modified: new Date(booking.date_modified * 1000).toISOString(),
                client_name: booking.client_data?.name || "N/A",
                client_phone: booking.client_data?.phone || "N/A",
                client_email: booking.client_data?.email || null,
                currency: booking.currency,
                total_price: parseFloat(booking.total_price),
                payment_partial: parseFloat(booking.payment_partial),
                ticket_type_count: booking.ticket_type_count,
                payment_transaction: booking.payment_transaction || [],
                status: booking.status,
                source: booking.source,
            };

            try {
                const saveResponse = await fetch('/api/bookings', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(bookingData),
                });

                const result = await saveResponse.json();
                if (result.success) {
                    console.info(`📥 [Guardado] Reserva ${booking.short_id} guardada con éxito.`);
                } else {
                    console.error(`❌ [Error Guardando] Error al guardar la reserva ${booking.short_id}.`, result);
                }
            } catch (error) {
                console.error(`❌ [Error] No se pudo guardar la reserva ${booking.short_id}.`, error);
            }
        }

        return allBookings;
    } catch (error) {
        console.error("❌ [Error] Error fetching bookings:", error);
        return [];
    }
}

async function fetchBookingsWeekly6(accessToken) {
    try {
        let allBookings = [];
        const oneDayInSeconds = 86400;

        // Función auxiliar para validar y convertir fechas
        const safeDate = (timestamp) => {
            return timestamp && !isNaN(new Date(timestamp * 1000)) ? new Date(timestamp * 1000).toISOString() : null;
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

                if (data.data.bookings.length === 100) {
                    console.error(
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
        let endDate = Math.floor(Date.now() / 1000); // Fecha actual en timestamp
        let noDataWeeks = 0;

        while (noDataWeeks < 3) {
            const startDate = endDate - oneDayInSeconds * 30; // Rango inicial de 30 días

            console.group(`📅 [Inicio de Ciclo] Procesando rango: ${new Date(startDate * 1000).toISOString()} a ${new Date(endDate * 1000).toISOString()}`);
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
                    currency: booking.currency,
                    total_price: parseFloat(booking.total_price),
                    payment_partial: parseFloat(booking.payment_partial),
                    ticket_type_count: booking.ticket_type_count,
                    payment_transaction: booking.payment_transaction || [],
                    status: booking.status,
                    source: booking.source,
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


async function init() {
    try {
        const accessToken = await fetchAccessToken();
        await fetchBookingsWeekly6(accessToken);
    } catch (error) {
        console.error("Initialization error:", error);
    }
}

// Llamar a la función init al cargar la página
document.addEventListener("DOMContentLoaded", init);


</script>

<main class="container col-12 position-relative panel">

    <section class="background mt-5 rounded">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <h1 class="text-center text-light my-5 fs-9 fuente-libre ">EduPress 9<i class="text-danger">.</i>7</h1>
    </section>
    
    <h1 class="fs-3 py-3 text-center">Panel de datos</h1>
    <nav>
        <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Productos</button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Categorias</button>
            <button class="nav-link" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled"
                type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">Ajustes</button>
        </div>
    </nav>
    <section class="tab-content py-5 mx-5" id="nav-tabContent">
        

        <article class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
            tabindex="0">
            <h2 class=" text-center">Bienvenido al panel de Administración de Asador la Morenica</h2>
            <div class="accordion my-5" id="accordionEdu">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            ¿Qué puedo hacer?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionEdu">
                        <div class="accordion-body">
                            <strong>Te he preparado un panel muy intuitivo!</strong>
                            <ul>
                                <li>Dónde puedes cambiar tu horario de apertura</li>
                                <li>Puedes ver los encargos que tienes pendientes</li>
                                <li>Puedes Crear, editar, eliminar los Productos</li>
                                <li>Puedes editar y crear nuevas categorias para los productos anteriores</li>
                                <li>Podrás decidir que mostrar en tu Web</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Horario de Apertura
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionEdu">
                        <div class="accordion-body">
                            <strong>¿Y si nos vamos de vacaciones?</strong>
                            <br>El objetivo es póder cambiar en la web los horarios definidos. Es decir, poder
                            Actualizar los hoarios por si un día abrimos o cerramos, de manera rápida y sencilla.<br>Si
                            es festivo, o por si nos da en Año Nuevo abrir hasta las 21:00
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Encargos pendientes
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionEdu">
                        <div class="accordion-body">
                            <strong>¿Por qué el pollo cruzó la calle? Para llegar al horno y ser un encargo más</strong> <br>
                            Tenemos preparado un panel de Pedidos en su Versión Número 3.0 <br>
                            Aquí podremos Observar los encargos que nos han echo a traves de la Web. Y ténemos la posibilidad de crear nosotros los encargos para los días indicados.
                            De manera que tendremos dichos encargos Ordenados por fecha de entrega y de una manera intuitiva poder prepararlos y gestionarlos.
                        </div>
                    </div>
                </div>
            </div>
        </article>


        <article class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
            <h2 class=" text-center">¿Qué le dijo el pollo asado a las patatas fritas? ¡Eres mi mejor acompañante!</h2>
            <div class="accordion my-5" id="accordionEdu2">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne">
                            Crear Nuevo Producto
                        </button>
                    </h2>
                    <div id="collapseOne2" class="accordion-collapse collapse show" data-bs-parent="#accordionEdu2">
                        <div class="accordion-body">
                            <strong>Y con una pizca de Sal</strong>
                            <br>
                            <ol>
                                <li>Ponle un Nombre</li><li>Sube una Imágen</li><li>Identificalo con una Categoría existente</li><li>Y añade una descripción</li>
                            </ol>
                            <br>

                            De esta manera podras dar de alta un Nuevo Producto en tu Web

                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo">
                            Editar producto existente
                        </button>
                    </h2>
                    <div id="collapseTwo2" class="accordion-collapse collapse" data-bs-parent="#accordionEdu2">
                        <div class="accordion-body">
                            <strong>¿Sale desfavorecida la foto?</strong>
                            <br>
                            Tan sencillo cómo localizar el producto que quieres Editar. Haz click en ella y modifica los datos... imagenes... Y dale a enviar, de todo lo demas se encarga Jorge!
                            
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree2" aria-expanded="false" aria-controls="collapseThree">
                            Eliminar! 
                           </button>
                    </h2>
                    <div id="collapseThree2" class="accordion-collapse collapse" data-bs-parent="#accordionEdu2">
                        <div class="accordion-body my-2">
                            <svg id="Layer_1" style="enable-background:new 0 0 64 64;" version="1.1" viewBox="0 0 64 64" xml:space="preserve"  class=" mx-2 "width="30px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><style type="text/css">
                                .st0{fill:url(#SVGID_1_);}
                                .st1{fill:url(#SVGID_2_);}
                                .st2{fill:url(#SVGID_3_);}
                                .st3{fill:url(#SVGID_4_);}
                                .st4{fill:url(#SVGID_5_);}
                                .st5{fill:#FFFFFF;}
                                .st6{fill:url(#SVGID_6_);}
                                .st7{fill:url(#SVGID_7_);}
                                .st8{fill:url(#SVGID_8_);}
                                .st9{fill:url(#SVGID_9_);}
                                .st10{fill:url(#SVGID_10_);}
                                .st11{fill:#FFBF0B;}
                                .st12{fill:#1A1A54;}
                                .st13{fill:#DC2863;}
                                .st14{fill:none;stroke:#1A1A54;stroke-width:3;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
                                .st15{fill:#0B85FF;}
                                .st16{opacity:0.5;fill:#FFFFFF;}
                                .st17{fill:#00AF64;}
                                .st18{fill:#00D17C;}
                                .st19{fill:none;stroke:#00D17C;stroke-width:3;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
                                .st20{fill:#8C5C3B;}
                                .st21{opacity:0.1;fill:#1A1A54;}
                                .st22{opacity:0.2;fill:#1A1A54;}
                                .st23{fill:none;stroke:#FFFFFF;stroke-width:2;stroke-linecap:round;stroke-miterlimit:10;}
                                .st24{fill:#E86942;}
                                .st25{fill:#6642AD;}
                                .st26{fill:url(#SVGID_11_);}
                                .st27{fill:url(#SVGID_12_);}
                                .st28{fill:url(#SVGID_13_);}
                                .st29{opacity:0.2;}
                                .st30{fill:none;stroke:#1A1A54;stroke-width:2;stroke-miterlimit:10;}
                                .st31{fill:#E8E8EE;}
                                .st32{fill:#D1D1DC;}
                                .st33{fill:none;stroke:#D1D1DC;stroke-width:1.8172;stroke-linecap:round;stroke-miterlimit:10;}
                                .st34{opacity:0.5;fill:#E8E8EE;}
                                .st35{fill:none;stroke:#E8E8EE;stroke-width:7.1126;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
                                .st36{fill:none;stroke:#D1D1DC;stroke-width:2.3709;stroke-linecap:round;stroke-miterlimit:10;}
                                .st37{fill:#F2AD00;}
                                .st38{fill:none;stroke:#E8E8EE;stroke-width:5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
                                .st39{fill:none;stroke:#FFFFFF;stroke-width:4;stroke-linecap:square;stroke-miterlimit:10;}
                            </style><circle class="st11" cx="32" cy="32" r="32"/><g><path class="st12" d="M17.8,42.7c0.5-1.1,1.2-1.8,2.1-2.4c0.9-0.5,2-0.9,3.1-0.9c1.1,0,2.3,0.3,3.2,0.9c0.9,0.6,1.6,1.5,2,2.5   c0.2,0.5-0.1,1.1-0.6,1.3c-0.1,0-0.2,0.1-0.3,0.1l-0.2,0c-1,0-1.7-0.1-2.3-0.1c-0.6,0-1.1,0-1.7,0c-0.5,0-1.1,0.1-1.8,0.1   c-0.6,0-1.4,0.1-2.2,0.1l-0.4,0c-0.6,0-1.1-0.6-1.1-1.2C17.7,42.9,17.8,42.8,17.8,42.7z"/></g><circle class="st5" cx="38.5" cy="24.5" r="7.5"/><circle class="st5" cx="38.5" cy="24.5" r="7.5"/><circle class="st5" cx="38.5" cy="24.5" r="7.5"/><circle class="st12" cx="40.5" cy="24.5" r="4.5"/><circle class="st5" cx="13.5" cy="24.5" r="7.5"/><circle class="st12" cx="15.5" cy="24.5" r="4.5"/><g><g><path class="st31" d="M7,54.3c-1.4-6.3,1.5-9.9,6.8-10.9c5.3-1,9.5,0.9,11,7.2S24.3,62.9,19,63.9C13.7,64.9,8.5,60.6,7,54.3z"/></g><g><path class="st31" d="M8.8,45.8c0.3,0.3,0.6,0.7,0.9,1c0.3,0.3,0.7,0.6,1,0.9c0.3,0.3,0.7,0.5,0.9,0.5c0.2,0.1,0.6,0.1,0.2-0.3    c1.9,0.8,2.7,3,1.9,4.9c-0.8,1.9-3,2.7-4.9,1.9c-1.3-0.8-1.7-1.5-2.1-2.1c-0.4-0.6-0.6-1.2-0.8-1.8c-0.2-0.6-0.4-1.1-0.5-1.7    c-0.1-0.6-0.2-1.1-0.3-1.7C5,46.3,5.7,45.2,6.8,45c0.7-0.1,1.4,0.1,1.8,0.6L8.8,45.8z"/></g><g><path class="st31" d="M12,43.5c0.2,0.3,0.5,0.8,0.7,1.1c0.3,0.4,0.5,0.7,0.8,1c0.3,0.3,0.6,0.6,0.8,0.7c0.2,0.1,0.5,0.2,0.2-0.2    c1.7,1.2,2.1,3.5,0.9,5.1s-3.5,2.1-5.1,0.9c-1.1-1-1.3-1.8-1.6-2.5c-0.2-0.7-0.4-1.3-0.5-1.9c-0.1-0.6-0.1-1.2-0.2-1.7    c0-0.6,0-1.1,0-1.7c0-1.1,0.9-2,2-2c0.7,0,1.3,0.4,1.7,0.9L12,43.5z"/></g><g><path class="st31" d="M15.6,41.4c0.3,0.3,0.6,0.6,0.9,1c0.3,0.3,0.6,0.7,0.8,1c0.3,0.4,0.5,0.8,0.8,1.2c0.2,0.5,0.5,1,0.6,1.7    c0,2-1.6,3.7-3.7,3.7s-3.7-1.6-3.7-3.7c0.1,0,0.3-0.2,0.4-0.4c0.1-0.2,0.2-0.5,0.2-0.8c0-0.3,0.1-0.6,0.1-1l0-1l0-0.4    c0-1.1,0.9-2,2.1-2C14.7,40.7,15.3,41,15.6,41.4z"/></g><g><path class="st32" d="M17.5,42.1c0.2,0.7,0.4,1.4,0.5,2.2c0.2,0.7,0.3,1.5,0.4,2.3l0,0c0.1,0.8-0.5,1.4-1.2,1.5    c-0.8,0.1-1.4-0.5-1.5-1.2c0-0.1,0-0.2,0-0.3c0.1-0.6,0.1-1.3,0.1-2.1c0-0.7,0-1.4-0.1-2.2l0,0c0-0.5,0.4-0.9,0.9-1    C17,41.4,17.4,41.7,17.5,42.1z"/></g><g><path class="st31" d="M19.5,34.7c0.4,1.1,0.8,2.2,1.2,3.3c0.4,1.1,0.7,2.2,1,3.3c0.7,2.2,1.2,4.5,1.6,6.8c0.3,1.6-0.8,3.2-2.4,3.5    c-1.6,0.3-3.2-0.8-3.5-2.4c0-0.1,0-0.3,0-0.4c-0.1-2.1-0.3-4.2-0.7-6.3c-0.2-1.1-0.4-2.1-0.6-3.2c-0.2-1.1-0.5-2.1-0.7-3.1l0-0.1    c-0.3-1.2,0.4-2.3,1.6-2.6C18,33.2,19.1,33.7,19.5,34.7z"/></g></g><g><path class="st12" d="M6.2,10.9c0.8-1.2,1.9-1.9,3.1-2.5c1.2-0.5,2.6-0.8,3.9-0.7C14.6,7.7,16,8,17.1,8.6c0.6,0.2,1.1,0.7,1.7,1   c0.5,0.4,1,0.8,1.4,1.3c0.3,0.3,0.2,0.8-0.1,1c-0.1,0.1-0.3,0.2-0.5,0.2l-0.1,0c-0.6,0-1.2-0.2-1.7-0.3c-0.5-0.1-1.1-0.2-1.6-0.2   c-1-0.2-2-0.2-3-0.2c-1,0-1.9,0.1-2.9,0.2c-1,0.1-2,0.4-3,0.6l-0.2,0c-0.5,0.1-0.9-0.2-1-0.7C6,11.3,6.1,11,6.2,10.9z"/></g><g><path class="st12" d="M44.1,12.1c-1-0.2-2.1-0.5-3-0.6c-1-0.1-1.9-0.2-2.9-0.2c-1,0-1.9,0.1-3,0.2c-0.5,0-1,0.2-1.6,0.2   c-0.5,0.1-1.1,0.2-1.7,0.3l-0.1,0c-0.4,0-0.7-0.3-0.8-0.7c0-0.2,0.1-0.4,0.2-0.5c0.4-0.5,0.9-0.9,1.4-1.3c0.5-0.3,1-0.8,1.7-1   c1.2-0.6,2.5-0.9,3.8-0.9c1.3,0,2.7,0.2,3.9,0.7c1.2,0.5,2.3,1.3,3.1,2.5c0.3,0.4,0.2,0.9-0.2,1.2c-0.2,0.1-0.4,0.2-0.7,0.1   L44.1,12.1z"/></g></svg>
                        
                            <strong class="my-5">¿Eres el pollo o eres el gallo?</strong> <br>
                            
                            Mira te lo voy a explicar, si eres un pollito (Administrador), entonces solo te dejo eliminar los productos de manera temporal<br>
                            Pero si eres el Gallo (Super Administrador), lleva cuidado que de un canto lo eliminas para siempre.
                        </div>
                    </div>
                </div>
            </div>
        </article>


        <article class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0"> 
            <h2 class=" text-center">
                - Oiga, como preparan el pollo?
                <br>
                - Pues no hacemos nada especial.... tan solo les decimos que van a morir.</h2>
            <div class="accordion my-5" id="accordionEdu3">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne3">
                            Crear una nueva categoría, Editar o Eliminar
                        </button>
                    </h2>
                    <div id="collapseOne3" class="accordion-collapse collapse show" data-bs-parent="#accordionEdu3">
                        <div class="accordion-body">
                            <strong>¡¿Enserio?!</strong>
                            <ul>
                                <li>Localiza el Menú de navegación de arriba</li>
                                <li>Haz click en la información que necesitas aunque ponga "productos"</li>
                                <li>Accede a Categorias</li>
                                <li>Y sigue el mismo rollo que al crear un producto</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo3" aria-expanded="false" aria-controls="collapseTwo3">
                            ---------------------------------
                        </button>
                    </h2>
                    <div id="collapseTwo3" class="accordion-collapse collapse" data-bs-parent="#accordionEdu3">
                        <div class="accordion-body">
                            <strong>¿Y si nos vamos de vacaciones?</strong>
                            <br>El objetivo es póder cambiar en la web los horarios definidos. Es decir, poder
                            Actualizar los hoarios por si un día abrimos o cerramos, de manera rápida y sencilla.<br>Si
                            es festivo, o por si nos da en Año Nuevo abrir hasta las 21:00
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree3" aria-expanded="false" aria-controls="collapseThree3">
                            -------------------------
                        </button>
                    </h2>
                    <div id="collapseThree3" class="accordion-collapse collapse" data-bs-parent="#accordionEdu3">
                        <div class="accordion-body">
                            <strong>¿Por qué el pollo cruzó la calle? Para llegar al horno y ser un encargo más</strong> <br>
                            Tenemos preparado un panel de Pedidos en su Versión Número 3.0 <br>
                            Aquí podremos Observar los encargos que nos han echo a traves de la Web. Y ténemos la posibilidad de crear nosotros los encargos para los días indicados.
                            De manera que tendremos dichos encargos Ordenados por fecha de entrega y de una manera intuitiva poder prepararlos y gestionarlos.
                        </div>
                    </div>
                </div>
            </div>
        </article>


        <article class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">
            <h2 class=" text-center">---------------------------------</h2>
            <div class="accordion my-5" id="accordionEdu4">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
                            El objetivo 
                        </button>
                    </h2>
                    <div id="collapseOne4" class="accordion-collapse collapse show" data-bs-parent="#accordionEdu4">
                        <div class="accordion-body">
                            <strong>Ajustar un pollo asado es como ajustar un presupuesto: si te pasas, lo quemas.</strong>
                            <p>El objetivo principal es poder ajustar lo que mostramos en nuestra WEB.</p>
                            <p>Por ello te proporciono varios campos dónde puedes seleccionar que quieres mostrar</p>
                            <p>Pero respetando la idea de los campos</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo4" aria-expanded="false" aria-controls="collapseTwo4">
                            Ajustes de los tres primeros campos del menú - HOME
                        </button>
                    </h2>
                    <div id="collapseTwo4" class="accordion-collapse collapse" data-bs-parent="#accordionEdu4">
                        <div class="accordion-body">
                            <p>Situado en la primera parte de la página "HOME"</p>
                            <p>Podrás cambiar los menús que aparecen.</p>
                            <p>Seguimos la filosofía del orden que ves. En el orden que lo coloques en los ajustes se verán.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree4" aria-expanded="false" aria-controls="collapseThree4">
                            Ajustes de las cuatro categorias - HOME
                        </button>
                    </h2>
                    <div id="collapseThree4" class="accordion-collapse collapse" data-bs-parent="#accordionEdu4">
                        <div class="accordion-body">
                            <p>Situado a bajo del todo de la HOME</p>
                            <p>Mostramos 4 categorías que seleccionemos. Siguiendo el mismo rollo de la orden que el anterior ajuste.</p>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        
    </section>


</main>










@endsection