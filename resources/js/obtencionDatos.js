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
        // let endDate = Math.floor(new Date("2016-02-19T13:49:21.000Z").getTime() / 1000); // Timestamp desde la fecha
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

async function fetchBookingsWeekly7(accessToken) {
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
                // console.warn(`⚠️ [Advertencia] El valor no es un JSON válido. Usando cadena como está: ${data}`);
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
        // let endDate = Math.floor(new Date("2021-06-23T07:47:25.000Z").getTime() / 1000); // Timestamp desde la fecha
        let endDate = Math.floor(Date.now() / 1000); 
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
                    ticket_type_count: formatJSON(booking.ticket_type_count),
                    payment_transaction: formatJSON(booking.payment_transaction),
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
        // let endDate = Math.floor(new Date("2021-06-23T07:47:25.000Z").getTime() / 1000); // Timestamp desde la fecha
        // let endDate = Math.floor(new Date("2015-01-26T07:46:07.000Z").getTime() / 1000); // Timestamp desde la fecha

        let noDataWeeks = 0;

        while (noDataWeeks < 3) {
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

export async function init() {
    // Asi es la fecha actual para buscar por date: let endDate = Math.floor(Date.now() / 1000); // Fecha actual en timestamp
    try {
        const accessToken = await fetchAccessToken();
        await fetchBookingsWeekly8(accessToken);
    } catch (error) {
        console.error("Initialization error:", error);
    }
}

init()