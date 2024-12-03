// Ejemplo de validación de formulario de Bootstrap
(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()

const carousel_inner = document.querySelectorAll(".card");
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    // Con una expresión regular detectamos si es dispositivo, entonces quitamos las clases active, dejandoselo solo a uno.
    carousel_inner[1].setAttribute("class", "card m-3 carousel-item")
    carousel_inner[2].setAttribute("class", "card m-3 carousel-item")
}

let scrollPosition = 0;
// carousel_inner.forEach(e=>console.log(e))

document.querySelector(".carousel-control-next").addEventListener("click", function () {
    let activos = document.querySelectorAll(".carousel-inner .active");

    if (activos[activos.length - 1].dataset.ident != 5) {
        let quit = activos[0].dataset.ident
        carousel_inner[quit].setAttribute("class", "card m-3 carousel-item")

        let id = parseInt(activos[activos.length - 1].dataset.ident) + 1
        carousel_inner[id].setAttribute("class", "card m-3 carousel-item active")
    }
});

document.querySelector(".carousel-control-prev").addEventListener("click", function () {
    let activos = document.querySelectorAll(".carousel-inner .active");
    if (activos[0].dataset.ident != 0) {

        let quit = activos[activos.length - 1].dataset.ident
        carousel_inner[quit].setAttribute("class", "card m-3 carousel-item")

        let id = parseInt(activos[0].dataset.ident) - 1
        carousel_inner[id].setAttribute("class", "card m-3 carousel-item active")
    }
});

document.getElementById("boten").addEventListener("click", function (e) {
    e.preventDefault();
    publicacionEnCanal()
})

function obtenerDatos() {
    const usuario_nombre = document.getElementById("identidad-usuario").value

    const usuario_menu = document.getElementById("pedido-usuario").value

    const usuario_detalle = document.getElementById("detalles-user").value

    const usuario_cuando = document.getElementById("hora-usuario").value

    const usuario_email = document.getElementById("email-usuario").value

    const usuario_tel = document.getElementById("telefono-usuario").value
    
    const pollo_encargo = document.getElementById("pollo_encargo").value

    const usuario_aceptaPoliticas = document.getElementById("politicas-privacidad-usuario").checked
    
    if (!usuario_aceptaPoliticas) {
        alert("Debe aceptar las políticas de Privacidad")
    }else {
        return { "identidad-usuario": usuario_nombre, "pollo_encargo":pollo_encargo,"detalles": usuario_detalle, "hora-usuario": usuario_cuando, "email-usuario": usuario_email, "telefono-usuario": usuario_tel, "confirmado":false, "pedido-usuario": usuario_menu,}
    }
}


function publicacionEnCanal() {

    const formulario = document.getElementById('formul');
    if (!formulario.checkValidity()) {
        formulario.classList.add('was-validated');
        return;
    }

    const datosForm = obtenerDatos();
    let jsonData = JSON.stringify(datosForm);

    console.log(jsonData);
    

    window.CSRF_TOKEN = window.csrfToken;
    fetch(window.routeEncargosStore, {
        method: 'POST',

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':window.csrfToken
        },

        body: JSON.stringify(jsonData)
    })
    .then(response => {
    
        if (response.status === 200) {
            let formulario = document.getElementById('formul');
            formulario.reset();
            // Mostrar mensaje de éxito
            let mensaje = document.getElementById('mensaje');
            mensaje.style.display = 'block';
            setTimeout(() => {
            mensaje.style.display = 'none';
            }, 5000); 

            return response.json();
        } else {
            throw new Error('Error al guardar el encargo en el servidor');
        }
    })
    .then(encargo => {
        console.log('Encargo creado:', encargo);
        if (encargo.id) {
            const channelName = 'pollosChanel';
            const apiKey = "jVwvcw.mYv2yA:LzJ0YKCqrncnG7Zs90n9E349K_yVvQRv5FI9mfJHSII"
            const ably = new Ably.Realtime(apiKey);

            let channel = ably.channels.get(channelName);

            channel.publish('NuevoPedido', JSON.stringify({ ...datosForm, id: encargo.id }));
            formulario.classList.remove('was-validated');
        }
    })
    .catch(error => {
        console.error(error);
    });



}

// Espera a que se cargue todo el contenido del documento antes de ejecutar el script
document.addEventListener("DOMContentLoaded", function () {
    // Almacena la lista de días abiertos en una variable
    const days = window.days;

    // Determina si una fecha dada está permitida en función de los días abiertos y las cerrados
    function isDateAllowed(date) {
        const dayOfWeek = date.getDay();
        const isOpen = days.some(
            (day) =>
                new Date(day.date).toDateString() === date.toDateString() &&
                !day.is_open
        );
        const isClosed = days.some(
            (day) =>
                new Date(day.date).toDateString() === date.toDateString() &&
                day.is_open
        );
        return (dayOfWeek === 5 || dayOfWeek === 6 || dayOfWeek === 0 || isOpen) && !isClosed;
    }

    // Devuelve las horas de apertura y cierre para una fecha dada
    async function getOpeningHours(date) {
        const response = await fetch(`/get-opening-hours/${date.toISOString().split('T')[0]}`);
        const hours = await response.json();
        return {
            startTime: hours.start_time,
            endTime: hours.end_time,
        };
    }

    // Inicializa el calendario de flatpickr con la configuración necesaria
    const fp = flatpickr("#hora-usuario", {
        locale: "es",
        enableTime: true,
        time_24hr: true,
        dateFormat: "Y-m-d\\TH:i",
        altFormat: "j F H:i",
        altInput: true,
        allowInput:true,
        minDate: "today",
        disable: [
            function (date) {
                return !isDateAllowed(date);
            },
        ],
        // Cuando el calendario esté listo, actualiza los días inhabilitados
        onReady: async function (selectedDates, dateStr, instance) {
            setTimeout(() => updateDisabledDays(instance), 100);
            if (selectedDates[0]) {
                const openingHours = await getOpeningHours(selectedDates[0]);
                instance.set("minTime", openingHours.startTime);
                instance.set("maxTime", openingHours.endTime);
            }
        },
        // Cuando se cambie la fecha seleccionada, actualiza los días inhabilitados y las horas de apertura/cierre
        onChange: async function (selectedDates, dateStr, instance) {
            setTimeout(() => updateDisabledDays(instance), 100);
            if (selectedDates[0]) {
                const openingHours = await getOpeningHours(selectedDates[0]);
                instance.set("minTime", openingHours.startTime);
                instance.set("maxTime", openingHours.endTime);
            }
        },
        // Cuando cambie el mes, actualiza los días inhabilitados
        onMonthChange: function (selectedDates, dateStr, instance) {
            setTimeout(() => updateDisabledDays(instance), 100);
        },
        // Cuando se abra el calendario, actualiza los días inhabilitados
        onOpen: function (selectedDates, dateStr, instance) {
            setTimeout(() => updateDisabledDays(instance), 100);
        },
    });

    // Función para actualizar los estilos de los días inhabilitados en el calendario
    function updateDisabledDays(fp) {
        const disabledDays = fp.days.childNodes;
        const now = new Date();
        now.setHours(0, 0, 0, 0);

        disabledDays.forEach((day) => {
            const date = new Date(day.dateObj.getTime());
            if (!isDateAllowed(date) || date < now) {
                day.classList.add("flatpickr-disabled-day");
            } else {
                day.classList.remove("flatpickr-disabled-day");
            }
        });
    }
});