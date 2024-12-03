
const channelName = 'pollosChanel';
const channelNameChispa = 'chispazoPollo';
const apiKey = "jVwvcw.mYv2yA:LzJ0YKCqrncnG7Zs90n9E349K_yVvQRv5FI9mfJHSII"
const apiKey2 = "jVwvcw.05Vw_w:siT4Nk3MJ03DXCAG_vYM6owlwQvPetU7PqpQnKcpwE8"

const ably = new Ably.Realtime(apiKey);

ably.connection.on('connected', () => {
    console.log('Connected to Ably!');
});

let channel = ably.channels.get(channelName);
let chispazo = ably.channels.get(channelNameChispa);

function sortTableByHoraEntrega() {
    let tbody = document.getElementById('encargos-tbody');
    let rows = Array.from(tbody.rows);

    rows.sort(function(a, b) {
        //Seleccionamos la celda con la fecha para poder ordenarlo
        let dateA = new Date(a.cells[4].textContent);
        let dateB = new Date(b.cells[4].textContent);
        return dateA - dateB;
    });

    for (let row of rows) {
        tbody.appendChild(row);
    }
}

function restarActual(valor){
    let valorNuevo = parseFloat(localStorage.getItem("resto_de_pollos")) + parseFloat(valor);
    localStorage.setItem("resto_de_pollos",valorNuevo)
    document.getElementById("resto_pollos").innerHTML = valorNuevo
    window.location.reload()
}

chispazo.subscribe(function (message){
    console.log('Received: ' + message.data);
    let chispas = JSON.parse(message.data);
    let clave = Object.keys(chispas) // montado sinEncargo resetear
    switch (clave[0]) {
        case "montado":
            // console.log(chispas[clave[0]]);
            controlPollitos(parseFloat(chispas[clave[0]]))
            break;
            case "sinEncargo":
            // console.log(chispas[clave[0]]);
            sinEncargoPollitos(parseFloat(chispas[clave[0]]))
            break;
        case "reseteo":
            inicializarDia()
            break;
        case "encargoEntregado":
            restarActual(parseFloat(chispas[clave[0]]))
            break;
        case "refreshPage":
            window.location.reload();
        default:
            break;
    }


    // console.log(clave[0]);

})

channel.subscribe(function (message) {

    window.location.reload();
    
    console.log('Received: ' + message.data);

    let encargo = JSON.parse(message.data);

    let tbody = document.querySelector('#encargos-tbody');

    let newRow = document.createElement('tr');

    // Nombre y apellidos
    let nombreApellidosCell = document.createElement('td');
    nombreApellidosCell.className = "col-2";
    nombreApellidosCell.textContent = encargo['identidad-usuario'];
    newRow.appendChild(nombreApellidosCell);

    // Menu
    // let menuCell = document.createElement('td');
    // menuCell.className = "col-2";
    // menuCell.textContent = encargo['pedido-usuario'];
    // newRow.appendChild(menuCell);

    // polloCell
    let polloCell = document.createElement('td');
    polloCell.className = "col-2";
    polloCell.textContent = encargo['pollo_encargo'];
    newRow.appendChild(polloCell);

    // Detalles
    let detallesCell = document.createElement('td');
    detallesCell.className = "col-3";
    detallesCell.textContent = encargo.detalles;
    newRow.appendChild(detallesCell);

    // Telefono
    let telefonoCell = document.createElement('td');
    telefonoCell.className = "col-2";
    telefonoCell.textContent = encargo['telefono-usuario'];
    newRow.appendChild(telefonoCell);

    // Hora de Entrega
    let horaEntregaCell = document.createElement('td');
    horaEntregaCell.className = "col-2";
    let fechaFormateada = encargo['hora-usuario'].replace('T', ' ').substr(0, 16);
    horaEntregaCell.textContent = fechaFormateada;
    newRow.appendChild(horaEntregaCell);

    // Acciones
    let actionsCell = document.createElement('td');
    actionsCell.className = "col-1";
    actionsCell.style.textAlign = "center";
    actionsCell.style.verticalAlign = "middle";

    // Div de acciones
    let actionsDiv = document.createElement('div');
    actionsDiv.className = "d-flex justify-content-around";

    // Formulario de entrega
    let entregadoForm = document.createElement('form');
    entregadoForm.action = `/encargos/${encargo.id}/entregado`;
    entregadoForm.method = 'POST';
    

    // Crea un input oculto para almacenar el token CSRF
    let csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    entregadoForm.appendChild(csrfInput);

    // Crea un input oculto para almacenar el método PUT
    let methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'PUT';
    entregadoForm.appendChild(methodInput);

    // btn WA B
    let whatsappB = document.createElement('button');
    whatsappB.type = 'button';
    whatsappB.className = 'btn btn-outline-success mx-1';
    // Agrega el atributo data-encargo-id y data-confirmado al nuevo botón (puedes cambiar los valores por los deseados)
    whatsappB.dataset.encargoId = encargo['telefono-usuario'];
    whatsappB.dataset.confirmado = 'false';
    whatsappB.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 258"><defs><linearGradient id="logosWhatsappIcon0" x1="50%" x2="50%" y1="100%" y2="0%"><stop offset="0%" stop-color="#1FAF38"/><stop offset="100%" stop-color="#60D669"/></linearGradient><linearGradient id="logosWhatsappIcon1" x1="50%" x2="50%" y1="100%" y2="0%"><stop offset="0%" stop-color="#F9F9F9"/><stop offset="100%" stop-color="#FFF"/></linearGradient></defs><path fill="url(#logosWhatsappIcon0)" d="M5.463 127.456c-.006 21.677 5.658 42.843 16.428 61.499L4.433 252.697l65.232-17.104a122.994 122.994 0 0 0 58.8 14.97h.054c67.815 0 123.018-55.183 123.047-123.01c.013-32.867-12.775-63.773-36.009-87.025c-23.23-23.25-54.125-36.061-87.043-36.076c-67.823 0-123.022 55.18-123.05 123.004"/><path fill="url(#logosWhatsappIcon1)" d="M1.07 127.416c-.007 22.457 5.86 44.38 17.014 63.704L0 257.147l67.571-17.717c18.618 10.151 39.58 15.503 60.91 15.511h.055c70.248 0 127.434-57.168 127.464-127.423c.012-34.048-13.236-66.065-37.3-90.15C194.633 13.286 162.633.014 128.536 0C58.276 0 1.099 57.16 1.071 127.416Zm40.24 60.376l-2.523-4.005c-10.606-16.864-16.204-36.352-16.196-56.363C22.614 69.029 70.138 21.52 128.576 21.52c28.3.012 54.896 11.044 74.9 31.06c20.003 20.018 31.01 46.628 31.003 74.93c-.026 58.395-47.551 105.91-105.943 105.91h-.042c-19.013-.01-37.66-5.116-53.922-14.765l-3.87-2.295l-40.098 10.513l10.706-39.082Z"/><path fill="#FFF" d="M96.678 74.148c-2.386-5.303-4.897-5.41-7.166-5.503c-1.858-.08-3.982-.074-6.104-.074c-2.124 0-5.575.799-8.492 3.984c-2.92 3.188-11.148 10.892-11.148 26.561c0 15.67 11.413 30.813 13.004 32.94c1.593 2.123 22.033 35.307 54.405 48.073c26.904 10.609 32.379 8.499 38.218 7.967c5.84-.53 18.844-7.702 21.497-15.139c2.655-7.436 2.655-13.81 1.859-15.142c-.796-1.327-2.92-2.124-6.105-3.716c-3.186-1.593-18.844-9.298-21.763-10.361c-2.92-1.062-5.043-1.592-7.167 1.597c-2.124 3.184-8.223 10.356-10.082 12.48c-1.857 2.129-3.716 2.394-6.9.801c-3.187-1.598-13.444-4.957-25.613-15.806c-9.468-8.442-15.86-18.867-17.718-22.056c-1.858-3.184-.199-4.91 1.398-6.497c1.431-1.427 3.186-3.719 4.78-5.578c1.588-1.86 2.118-3.187 3.18-5.311c1.063-2.126.531-3.986-.264-5.579c-.798-1.593-6.987-17.343-9.819-23.64"/></svg>`
    // Agrega el evento onclick para llamar a la función confirmarPedido
    whatsappB.onclick = function() {
        confirmarPedido(this);
    };

    actionsDiv.appendChild(whatsappB);


    // btn Crea el botón 'Entregado' y agrégalo al formulario
    let entregadoButton = document.createElement('button');
    entregadoButton.type = 'submit';
    entregadoButton.className = 'btn btn-primary';
    entregadoButton.onclick = function() {
        return confirm('¿Estas seguro que quieres marcar el pedido como entregado?');
    };
    let entregadoIcon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    entregadoIcon.setAttribute('width', '24');
    entregadoIcon.setAttribute('height', '24');
    entregadoIcon.setAttribute('viewBox', '0 0 24 24');
    entregadoIcon.innerHTML = '<path fill="white" d = "m10.6 16.6l7.05-7.05l-1.4-1.4l-5.65 5.65l-2.85-2.85l-1.4 1.4l4.25 4.25ZM12 22q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22Z">'
    entregadoButton.appendChild(entregadoIcon);
    entregadoForm.appendChild(entregadoButton);
    actionsDiv.appendChild(entregadoForm);

    // btn Formulario de borrado
    let deleteForm = document.createElement('form');
    deleteForm.action = `/encargos/${encargo.id}/borrar`;
    deleteForm.method = 'POST';
    deleteForm.onsubmit = () => {
        return confirm('¿Estas seguro que quieres borrar este encargo?');
    };

    // Crea un input oculto para almacenar el token CSRF
    let csrfDeleteInput = document.createElement('input');
    csrfDeleteInput.type = 'hidden';
    csrfDeleteInput.name = '_token';
    csrfDeleteInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    deleteForm.appendChild(csrfDeleteInput);

    // Crea un input oculto para almacenar el método DELETE
    let methodDeleteInput = document.createElement('input');
    methodDeleteInput.type = 'hidden';
    methodDeleteInput.name = '_method';
    methodDeleteInput.value = 'DELETE';
    deleteForm.appendChild(methodDeleteInput);

    // Crea el botón 'Borrar' y agrégalo al formulario
    let deleteButton = document.createElement('button');
    deleteButton.type = 'submit';
    deleteButton.className = 'btn btn-danger';

    let deleteIcon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    deleteIcon.setAttribute('width', '24');
    deleteIcon.setAttribute('height', '24');
    deleteIcon.setAttribute('viewBox', '0 0 24 24');
    deleteIcon.innerHTML = '<path fill="currentColor" d="M9 3v1H4v2h1v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1V4h-5V3H9m0 5h2v9H9V8m4 0h2v9h-2V8Z"/>';

    deleteButton.appendChild(deleteIcon);
    deleteForm.appendChild(deleteButton);

    actionsDiv.appendChild(deleteForm);
    actionsCell.appendChild(actionsDiv);
    newRow.appendChild(actionsCell);

    // Agrega la nueva fila a la tabla
    tbody.appendChild(newRow);
    sortTableByHoraEntrega();

});
    