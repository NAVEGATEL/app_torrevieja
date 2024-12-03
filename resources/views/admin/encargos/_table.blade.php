<div class="table-responsive mx-1">
    <!-- Este lo voy a meter en un bucle -->
    <!-- El bucle va a recorrer el len() de la cantidad de días distintos que tengo en mi array de pedidos -->
    <!-- Por cada Iteración crearemos una tabla, y le pondrémos de titulo el día de hoy -->


<!-- Itera sobre las fechas únicas -->
@php
    $fechaAnterior = null;
    $fechaHoy = now()->format('Y-m-d');
    $diasDistintos = [];
@endphp

<table class="table table-bordered">
    <thead>
        <tr class="fs-3">
            <th class="col-2"><b>Nombre</b></th>
            <th class="col-1"><b>Pollo</b></th>
            <th class="col-3"><b>Detalles</b></th>
            <th class="col-2"><b>Teléfono</b></th>
            <th class="col-2"><b>Hora</b></th>
            <th class="col-1"><b> </b></th>
        </tr>
    </thead>

    <tbody id="encargos-tbody">






    @foreach ($encargos as $encargo)
        @php
            $fechaActual = substr($encargo->hora_entrega, 0, 10);
            $esFechaDeHoy = ($fechaActual === $fechaHoy);
        @endphp

        @if ($encargo->entregado !== 1 && $esFechaDeHoy)



                <tr class="fs-3">
                    <td class="col-2">{{ $encargo->nombre_apellidos ? $encargo->nombre_apellidos  : " "}}</td>
                    <td class="col-1 pollitoNene">
                    @php 

                        $pollo_encargo = $encargo->pollo_encargo;
                        if ($pollo_encargo) {
                            switch (true) {
                                case $pollo_encargo == "0.5":
                                    echo "1/2";
                                    break;
                                case $pollo_encargo == intval($pollo_encargo):
                                    echo $pollo_encargo == "0.5" ? '1/2' : $pollo_encargo;
                                    break;
                                default:
                                    $parte_entera = intval($pollo_encargo);
                                    $parte_decimal = ($pollo_encargo - $parte_entera) * 2;
                                    echo $parte_entera . ' y ' . $parte_decimal . '/2';
                                    break;
                            }
                        } else {
                            echo ' ';
                        }
                        @endphp
                        
                    </td>
                    <td class="col-3">{{ $encargo->detalles ? $encargo->detalles : " " }}</td>
                    <td class="col-2">{{ $encargo->telefono ? $encargo->telefono : " " }}</td>
                    <td class="col-2">{{ $encargo->hora_entrega ? substr($encargo->hora_entrega, 11,16) : " " }}</td>
                    <td class="col-1" style="text-align: center; vertical-align: middle;">
                        <div class="d-flex justify-content-around">
                            
                            @if($encargo->confirmado !== 1)
                                <!-- <button type="submit" class="btn btn-outline-success mx-1" onclick="return confirm('Vamos a confirmar el pedido por WhatsApp!')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 258"><defs><linearGradient id="logosWhatsappIcon0" x1="50%" x2="50%" y1="100%" y2="0%"><stop offset="0%" stop-color="#1FAF38"/><stop offset="100%" stop-color="#60D669"/></linearGradient><linearGradient id="logosWhatsappIcon1" x1="50%" x2="50%" y1="100%" y2="0%"><stop offset="0%" stop-color="#F9F9F9"/><stop offset="100%" stop-color="#FFF"/></linearGradient></defs><path fill="url(#logosWhatsappIcon0)" d="M5.463 127.456c-.006 21.677 5.658 42.843 16.428 61.499L4.433 252.697l65.232-17.104a122.994 122.994 0 0 0 58.8 14.97h.054c67.815 0 123.018-55.183 123.047-123.01c.013-32.867-12.775-63.773-36.009-87.025c-23.23-23.25-54.125-36.061-87.043-36.076c-67.823 0-123.022 55.18-123.05 123.004"/><path fill="url(#logosWhatsappIcon1)" d="M1.07 127.416c-.007 22.457 5.86 44.38 17.014 63.704L0 257.147l67.571-17.717c18.618 10.151 39.58 15.503 60.91 15.511h.055c70.248 0 127.434-57.168 127.464-127.423c.012-34.048-13.236-66.065-37.3-90.15C194.633 13.286 162.633.014 128.536 0C58.276 0 1.099 57.16 1.071 127.416Zm40.24 60.376l-2.523-4.005c-10.606-16.864-16.204-36.352-16.196-56.363C22.614 69.029 70.138 21.52 128.576 21.52c28.3.012 54.896 11.044 74.9 31.06c20.003 20.018 31.01 46.628 31.003 74.93c-.026 58.395-47.551 105.91-105.943 105.91h-.042c-19.013-.01-37.66-5.116-53.922-14.765l-3.87-2.295l-40.098 10.513l10.706-39.082Z"/><path fill="#FFF" d="M96.678 74.148c-2.386-5.303-4.897-5.41-7.166-5.503c-1.858-.08-3.982-.074-6.104-.074c-2.124 0-5.575.799-8.492 3.984c-2.92 3.188-11.148 10.892-11.148 26.561c0 15.67 11.413 30.813 13.004 32.94c1.593 2.123 22.033 35.307 54.405 48.073c26.904 10.609 32.379 8.499 38.218 7.967c5.84-.53 18.844-7.702 21.497-15.139c2.655-7.436 2.655-13.81 1.859-15.142c-.796-1.327-2.92-2.124-6.105-3.716c-3.186-1.593-18.844-9.298-21.763-10.361c-2.92-1.062-5.043-1.592-7.167 1.597c-2.124 3.184-8.223 10.356-10.082 12.48c-1.857 2.129-3.716 2.394-6.9.801c-3.187-1.598-13.444-4.957-25.613-15.806c-9.468-8.442-15.86-18.867-17.718-22.056c-1.858-3.184-.199-4.91 1.398-6.497c1.431-1.427 3.186-3.719 4.78-5.578c1.588-1.86 2.118-3.187 3.18-5.311c1.063-2.126.531-3.986-.264-5.579c-.798-1.593-6.987-17.343-9.819-23.64"/></svg></button> -->
                                <button type="button" data-telefono="{{$encargo->telefono}}" data-fecha="{{$encargo->hora_entrega}}" data-encargo-id="{{ $encargo->id }}" data-confirmado="{{ $encargo->confirmado }}" class="btn btn-outline-success mx-1" onclick="confirmarPedido(this)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 258"><defs><linearGradient id="logosWhatsappIcon0" x1="50%" x2="50%" y1="100%" y2="0%"><stop offset="0%" stop-color="#1FAF38"/><stop offset="100%" stop-color="#60D669"/></linearGradient><linearGradient id="logosWhatsappIcon1" x1="50%" x2="50%" y1="100%" y2="0%"><stop offset="0%" stop-color="#F9F9F9"/><stop offset="100%" stop-color="#FFF"/></linearGradient></defs><path fill="url(#logosWhatsappIcon0)" d="M5.463 127.456c-.006 21.677 5.658 42.843 16.428 61.499L4.433 252.697l65.232-17.104a122.994 122.994 0 0 0 58.8 14.97h.054c67.815 0 123.018-55.183 123.047-123.01c.013-32.867-12.775-63.773-36.009-87.025c-23.23-23.25-54.125-36.061-87.043-36.076c-67.823 0-123.022 55.18-123.05 123.004"/><path fill="url(#logosWhatsappIcon1)" d="M1.07 127.416c-.007 22.457 5.86 44.38 17.014 63.704L0 257.147l67.571-17.717c18.618 10.151 39.58 15.503 60.91 15.511h.055c70.248 0 127.434-57.168 127.464-127.423c.012-34.048-13.236-66.065-37.3-90.15C194.633 13.286 162.633.014 128.536 0C58.276 0 1.099 57.16 1.071 127.416Zm40.24 60.376l-2.523-4.005c-10.606-16.864-16.204-36.352-16.196-56.363C22.614 69.029 70.138 21.52 128.576 21.52c28.3.012 54.896 11.044 74.9 31.06c20.003 20.018 31.01 46.628 31.003 74.93c-.026 58.395-47.551 105.91-105.943 105.91h-.042c-19.013-.01-37.66-5.116-53.922-14.765l-3.87-2.295l-40.098 10.513l10.706-39.082Z"/><path fill="#FFF" d="M96.678 74.148c-2.386-5.303-4.897-5.41-7.166-5.503c-1.858-.08-3.982-.074-6.104-.074c-2.124 0-5.575.799-8.492 3.984c-2.92 3.188-11.148 10.892-11.148 26.561c0 15.67 11.413 30.813 13.004 32.94c1.593 2.123 22.033 35.307 54.405 48.073c26.904 10.609 32.379 8.499 38.218 7.967c5.84-.53 18.844-7.702 21.497-15.139c2.655-7.436 2.655-13.81 1.859-15.142c-.796-1.327-2.92-2.124-6.105-3.716c-3.186-1.593-18.844-9.298-21.763-10.361c-2.92-1.062-5.043-1.592-7.167 1.597c-2.124 3.184-8.223 10.356-10.082 12.48c-1.857 2.129-3.716 2.394-6.9.801c-3.187-1.598-13.444-4.957-25.613-15.806c-9.468-8.442-15.86-18.867-17.718-22.056c-1.858-3.184-.199-4.91 1.398-6.497c1.431-1.427 3.186-3.719 4.78-5.578c1.588-1.86 2.118-3.187 3.18-5.311c1.063-2.126.531-3.986-.264-5.579c-.798-1.593-6.987-17.343-9.819-23.64"/></svg></button>
                                <!--  Logica a continuar:
                                            - Debo crear una funcion
                                            - Esta lanzara el mensaje confirmar
                                            - Si este es true:
                                                - Enviamos el mensaje por la Api WA B -> Si este es true---
                                                    - Cambiamos en Base de datos "Confirmado"
                                                    - Refrescamos la página
                                -->
                            @endif

                            @if (!$encargo->entregado)
                            
                            <button id="encargo-button" type="submit" class="btn btn-primary mx-1"  data-encargo="{{$encargo->pollo_encargo}}" 
                                onclick="middleWareOk({'encargoEntregado':'-'+this.dataset.encargo}, {{$encargo->id}})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="white" d="m10.6 16.6l7.05-7.05l-1.4-1.4l-5.65 5.65l-2.85-2.85l-1.4 1.4l4.25 4.25ZM12 22q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22Z"/></svg>
                            </button> 

                            @endif
                            <form action="{{ route('encargos.borrar', ['encargo' => $encargo->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mx-1" onclick="return confirm('¿Estas seguro que quieres borrar este encargo?')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9 3v1H4v2h1v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1V4h-5V3H9m0 5h2v9H9V8m4 0h2v9h-2V8Z"/></svg></button>
                            </form>
                        </div>
                    </td>
                </tr>


            @php
                $fechaAnterior = $fechaActual;
            @endphp

        @endif

        @if ($fechaAnterior !== $fechaActual && !$esFechaDeHoy &&  !in_array($fechaActual, $diasDistintos))
        
            @php
                $diasDistintos[] = $fechaActual;
            @endphp  

        @endif
        
    @endforeach




</tbody>
</table>










@php
    $fechaHoy = now()->format('Y-m-d');
    $fechaAnterior = $fechaHoy;
@endphp



@foreach ($diasDistintos as $diaNum)




    <h2 class="text-center pt-5 mt-5 mb-4 border-top border-4 border-primary">{{ $diaNum }}</h2>

    


    <table class="table table-bordered">
        <thead>
            <tr class="fs-3">
                <th class="col-2"><b>Nombre</b></th>
                <th class="col-1"><b>Pollo</b></th>
                <th class="col-3"><b>Detalles</b></th>
                <th class="col-2"><b>Teléfono</b></th>
                <th class="col-2"><b>Hora</b></th>
                <th class="col-1"><b> </b></th>
            </tr>
        </thead>

        <tbody id="encargos-tbody">
    













        @foreach ($encargos as $encargo)



            @php
                $fechaActual = substr($encargo->hora_entrega, 0, 10);
                $esFechaDeHoy = ($fechaActual === $fechaHoy);
            @endphp

            @if ($encargo->entregado !== 1 && !$esFechaDeHoy && $fechaActual == $diaNum)
        

                <tr class="fs-3">
                    <td class="col-2">{{ $encargo->nombre_apellidos ? $encargo->nombre_apellidos  : " "}}</td>
                    <td class="col-1">
                    @php 

                        $pollo_encargo = $encargo->pollo_encargo;
                        if ($pollo_encargo) {
                            switch (true) {
                                case $pollo_encargo == "0.5":
                                    echo "1/2";
                                    break;
                                case $pollo_encargo == intval($pollo_encargo):
                                    echo $pollo_encargo == "0.5" ? '1/2' : $pollo_encargo;
                                    break;
                                default:
                                    $parte_entera = intval($pollo_encargo);
                                    $parte_decimal = ($pollo_encargo - $parte_entera) * 2;
                                    echo $parte_entera . ' y ' . $parte_decimal . '/2';
                                    break;
                            }
                        } else {
                            echo ' ';
                        }
                        @endphp
                        
                    </td>
                    <td class="col-3">{{ $encargo->detalles ? $encargo->detalles : " " }}</td>
                    <td class="col-2">{{ $encargo->telefono ? $encargo->telefono : " " }}</td>
                    <td class="col-2">{{ $encargo->hora_entrega ? substr($encargo->hora_entrega, 11,16) : " " }}</td>
                    <td class="col-1" style="text-align: center; vertical-align: middle;">
                        <div class="d-flex justify-content-around">
                            
                            @if($encargo->confirmado !== 1)
                                <!-- <button type="submit" class="btn btn-outline-success mx-1" onclick="return confirm('Vamos a confirmar el pedido por WhatsApp!')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 258"><defs><linearGradient id="logosWhatsappIcon0" x1="50%" x2="50%" y1="100%" y2="0%"><stop offset="0%" stop-color="#1FAF38"/><stop offset="100%" stop-color="#60D669"/></linearGradient><linearGradient id="logosWhatsappIcon1" x1="50%" x2="50%" y1="100%" y2="0%"><stop offset="0%" stop-color="#F9F9F9"/><stop offset="100%" stop-color="#FFF"/></linearGradient></defs><path fill="url(#logosWhatsappIcon0)" d="M5.463 127.456c-.006 21.677 5.658 42.843 16.428 61.499L4.433 252.697l65.232-17.104a122.994 122.994 0 0 0 58.8 14.97h.054c67.815 0 123.018-55.183 123.047-123.01c.013-32.867-12.775-63.773-36.009-87.025c-23.23-23.25-54.125-36.061-87.043-36.076c-67.823 0-123.022 55.18-123.05 123.004"/><path fill="url(#logosWhatsappIcon1)" d="M1.07 127.416c-.007 22.457 5.86 44.38 17.014 63.704L0 257.147l67.571-17.717c18.618 10.151 39.58 15.503 60.91 15.511h.055c70.248 0 127.434-57.168 127.464-127.423c.012-34.048-13.236-66.065-37.3-90.15C194.633 13.286 162.633.014 128.536 0C58.276 0 1.099 57.16 1.071 127.416Zm40.24 60.376l-2.523-4.005c-10.606-16.864-16.204-36.352-16.196-56.363C22.614 69.029 70.138 21.52 128.576 21.52c28.3.012 54.896 11.044 74.9 31.06c20.003 20.018 31.01 46.628 31.003 74.93c-.026 58.395-47.551 105.91-105.943 105.91h-.042c-19.013-.01-37.66-5.116-53.922-14.765l-3.87-2.295l-40.098 10.513l10.706-39.082Z"/><path fill="#FFF" d="M96.678 74.148c-2.386-5.303-4.897-5.41-7.166-5.503c-1.858-.08-3.982-.074-6.104-.074c-2.124 0-5.575.799-8.492 3.984c-2.92 3.188-11.148 10.892-11.148 26.561c0 15.67 11.413 30.813 13.004 32.94c1.593 2.123 22.033 35.307 54.405 48.073c26.904 10.609 32.379 8.499 38.218 7.967c5.84-.53 18.844-7.702 21.497-15.139c2.655-7.436 2.655-13.81 1.859-15.142c-.796-1.327-2.92-2.124-6.105-3.716c-3.186-1.593-18.844-9.298-21.763-10.361c-2.92-1.062-5.043-1.592-7.167 1.597c-2.124 3.184-8.223 10.356-10.082 12.48c-1.857 2.129-3.716 2.394-6.9.801c-3.187-1.598-13.444-4.957-25.613-15.806c-9.468-8.442-15.86-18.867-17.718-22.056c-1.858-3.184-.199-4.91 1.398-6.497c1.431-1.427 3.186-3.719 4.78-5.578c1.588-1.86 2.118-3.187 3.18-5.311c1.063-2.126.531-3.986-.264-5.579c-.798-1.593-6.987-17.343-9.819-23.64"/></svg></button> -->
                                <button type="button" data-telefono="{{$encargo->telefono}}" data-fecha="{{$encargo->hora_entrega}}" data-encargo-id="{{ $encargo->id }}" data-confirmado="{{ $encargo->confirmado }}" class="btn btn-outline-success mx-1" onclick="confirmarPedido(this)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 258"><defs><linearGradient id="logosWhatsappIcon0" x1="50%" x2="50%" y1="100%" y2="0%"><stop offset="0%" stop-color="#1FAF38"/><stop offset="100%" stop-color="#60D669"/></linearGradient><linearGradient id="logosWhatsappIcon1" x1="50%" x2="50%" y1="100%" y2="0%"><stop offset="0%" stop-color="#F9F9F9"/><stop offset="100%" stop-color="#FFF"/></linearGradient></defs><path fill="url(#logosWhatsappIcon0)" d="M5.463 127.456c-.006 21.677 5.658 42.843 16.428 61.499L4.433 252.697l65.232-17.104a122.994 122.994 0 0 0 58.8 14.97h.054c67.815 0 123.018-55.183 123.047-123.01c.013-32.867-12.775-63.773-36.009-87.025c-23.23-23.25-54.125-36.061-87.043-36.076c-67.823 0-123.022 55.18-123.05 123.004"/><path fill="url(#logosWhatsappIcon1)" d="M1.07 127.416c-.007 22.457 5.86 44.38 17.014 63.704L0 257.147l67.571-17.717c18.618 10.151 39.58 15.503 60.91 15.511h.055c70.248 0 127.434-57.168 127.464-127.423c.012-34.048-13.236-66.065-37.3-90.15C194.633 13.286 162.633.014 128.536 0C58.276 0 1.099 57.16 1.071 127.416Zm40.24 60.376l-2.523-4.005c-10.606-16.864-16.204-36.352-16.196-56.363C22.614 69.029 70.138 21.52 128.576 21.52c28.3.012 54.896 11.044 74.9 31.06c20.003 20.018 31.01 46.628 31.003 74.93c-.026 58.395-47.551 105.91-105.943 105.91h-.042c-19.013-.01-37.66-5.116-53.922-14.765l-3.87-2.295l-40.098 10.513l10.706-39.082Z"/><path fill="#FFF" d="M96.678 74.148c-2.386-5.303-4.897-5.41-7.166-5.503c-1.858-.08-3.982-.074-6.104-.074c-2.124 0-5.575.799-8.492 3.984c-2.92 3.188-11.148 10.892-11.148 26.561c0 15.67 11.413 30.813 13.004 32.94c1.593 2.123 22.033 35.307 54.405 48.073c26.904 10.609 32.379 8.499 38.218 7.967c5.84-.53 18.844-7.702 21.497-15.139c2.655-7.436 2.655-13.81 1.859-15.142c-.796-1.327-2.92-2.124-6.105-3.716c-3.186-1.593-18.844-9.298-21.763-10.361c-2.92-1.062-5.043-1.592-7.167 1.597c-2.124 3.184-8.223 10.356-10.082 12.48c-1.857 2.129-3.716 2.394-6.9.801c-3.187-1.598-13.444-4.957-25.613-15.806c-9.468-8.442-15.86-18.867-17.718-22.056c-1.858-3.184-.199-4.91 1.398-6.497c1.431-1.427 3.186-3.719 4.78-5.578c1.588-1.86 2.118-3.187 3.18-5.311c1.063-2.126.531-3.986-.264-5.579c-.798-1.593-6.987-17.343-9.819-23.64"/></svg></button>
                                <!--  Logica a continuar:
                                            - Debo crear una funcion
                                            - Esta lanzara el mensaje confirmar
                                            - Si este es true:
                                                - Enviamos el mensaje por la Api WA B -> Si este es true---
                                                    - Cambiamos en Base de datos "Confirmado"
                                                    - Refrescamos la página
                                -->
                            @endif

                            @if (!$encargo->entregado)
                            

                            @endif
                            <form action="{{ route('encargos.borrar', ['encargo' => $encargo->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mx-1" onclick="return confirm('¿Estas seguro que quieres borrar este encargo?')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9 3v1H4v2h1v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1V4h-5V3H9m0 5h2v9H9V8m4 0h2v9h-2V8Z"/></svg></button>
                            </form>
                        </div>
                    </td>
                </tr>


            @else

                @php
                    $fechaAnterior = $fechaActual;
                @endphp  
                
            @endif



        @endforeach

















        </tbody>
    </table>

    @php
        $fechaAnterior = $fechaActual;
    @endphp

    
@endforeach

















</div>

<script>

function middleWareOk(valor,identificador){
    if(confirm("Confirma que vas a Entregar el pedido: ")){

        // Hay que remplazar de la siguiente manera para separar laravel de JS
        const url = `{{ route("encargos.entregado", ["encargo" => "__ENCARGO_ID__"]) }}`.replace("__ENCARGO_ID__", identificador);
        fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
            },
            body: JSON.stringify({'encargo':identificador})
        })
        .then(response => response.json())
        .then(data => { 
            chispazoAbly(valor);
        })
        .catch(error => {
            console.error('Error al enviar el formulario', error);
            chispazoAbly(valor);
        });
    }
}

function confirmarPedido(btn) {
    // Obtenemos el ID y el estado del encargo del atributo data-*
    const encargoId = btn.dataset.encargoId;
    let confirmado = btn.dataset.confirmado;

    // Mostramos el cuadro de confirmación
    if (confirm("Vamos a confirmar el pedido por WhatsApp!!!")) {
        // Cambiamos el estado del encargo a confirmado (true)
        confirmado = 1;
        // Modificamos el atributo data-confirmado del botón
        btn.dataset.confirmado = confirmado;

        // Enviamos una petición al servidor para actualizar el estado del encargo
        fetch('{{ route("encargo.actualizar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Asegúrate de incluir el token CSRF en la solicitud
            },
            body: JSON.stringify({
                encargoId: encargoId,
                confirmado: confirmado
            })
        })
        .then(response => {
            // Si la respuesta del servidor es exitosa, recargamos la página para reflejar el cambio en el estado del encargo
            if (response.ok) {
                window.open(`https://wa.me/34${btn.dataset.telefono}?text=Hola!%20Desde%20Asador%20la%20morenica%20Te%20confirmamos%20que%20tu%20pedido%20estará%20listo%20en:%20${btn.dataset.fecha}.%20Te%20esperamos!%20...`);
                // window.location.href = adsf
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error al enviar la solicitud al servidor:', error);
        });
    }
}
</script>


<script lang="text/javascript" src="https://cdn.ably.com/lib/ably.min-1.js"></script>
@vite(['resources/js/admin/encargos/encargos-table.js'])
