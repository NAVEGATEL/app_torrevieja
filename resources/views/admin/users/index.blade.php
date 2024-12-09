@extends('admin.layouts.private')

@section('content')

    <div class="row py-5 container-fluid">
        <div class="col-lg-12 d-flex justify-content-around align-items-center ">
            <button class="btn btn-outline-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                <b>Stock </b><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 64 64"><path fill="#e7e6e6" d="M3.583 42.634c0 11.747 13.11 21.259 29.3 21.259c16.189 0 29.3-9.512 29.3-21.259c0-11.736-13.11-40.69-29.3-40.69c-16.189 0-29.3 28.953-29.3 40.69"/><path fill="#d1d2d3" d="M24 4.808C12.159 12.403 3.585 33.144 3.585 42.634c0 10.907 11.312 19.877 25.889 21.1C21.404 59.557 3.583 44.761 24 4.804"/><path fill="#f4f5f5" d="M52.648 24.707c0 4.791-3.201 8.671-7.147 8.671c-3.95 0-7.155-3.881-7.155-8.671c0-4.787 3.205-8.667 7.155-8.667c3.946 0 7.147 3.879 7.147 8.667"/><path fill="#25333a" d="M50.24 25.04c0 3.178-2.125 5.752-4.742 5.752c-2.621 0-4.75-2.574-4.75-5.752c0-3.174 2.129-5.756 4.75-5.756c2.617 0 4.742 2.582 4.742 5.756"/><path fill="#f4f5f5" d="M27.873 24.1c0 4.791-3.2 8.669-7.146 8.669c-3.953 0-7.156-3.878-7.156-8.669c0-4.789 3.204-8.667 7.156-8.667c3.946 0 7.146 3.878 7.146 8.667"/><path fill="#25333a" d="M25.469 24.436c0 3.18-2.124 5.752-4.742 5.752c-2.625 0-4.75-2.572-4.75-5.752c0-3.175 2.125-5.754 4.75-5.754c2.618 0 4.742 2.579 4.742 5.754"/><path fill="#de374b" d="M26.415 52.991c-.587 4.429 1.016 8.802 5.274 10.146a8.087 8.087 0 0 0 10.146-5.278c1.271-4.02-.772-8.302-4.602-9.894c.873-1.033 1.521-2.09 1.767-2.862c.745-2.362-1.287-5.108-4.543-6.138c-3.259-1.027-6.5.053-7.245 2.416c-.551 1.746-.043 5.898-.797 11.61M29.18 7.673c-.313 2.357.542 4.685 2.808 5.403a4.304 4.304 0 0 0 5.4-2.812a4.3 4.3 0 0 0-2.449-5.267c.464-.549.812-1.113.94-1.522c.397-1.26-.688-2.72-2.418-3.268c-1.735-.546-3.46.027-3.856 1.287c-.294.927-.024 3.139-.425 6.179"/><path fill="#f05a2a" d="M23.474 39.445c0-4.473 4.216-1.094 9.408-1.094c5.202 0 9.41-3.379 9.41 1.094c0 4.485-4.212 12.955-9.41 12.955c-5.192 0-9.408-8.469-9.408-12.955"/><path fill="#f79420" d="M23.478 36.4c0-4.477 4.214-1.097 9.41-1.097c5.2 0 9.408-3.38 9.408 1.097c0 4.481-4.212 12.951-9.408 12.951s-9.41-8.47-9.41-12.951"/></svg>
            </button>
            
            <h2 class="fuente-libre ms-5 ps-4">Encargos</h2>


<!--            <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    <b>Sumar Stock </b><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 64 64"><path fill="#f29a2e" d="M7.6 20.4c1.8 2.9 3.8 3.3 5.2 1.6c2.2-2.6-.2-5.9-2.8-6.8c-4.3-1.7-8 3.1-8 3.1s4.1-.4 5.6 2.1"/><path fill="#e1eaf2" d="M42.8 10.2c-7.7 4.5-1.3 15.3-15.2 18.2l14.8 7.3c3 5.2 11.3 5.6 11.3 5.6s2.1-6.2.4-10.8c4.6 0 7.8-2.8 7.8-2.8s-2.6-9.2-10.5-9.2c7.8-3.2 9.2-9.8 9.2-9.8s-6.9-4.8-17.8 1.5"/><path fill="#f4bc58" d="M35.7 62H21.4c0-1.2 8.4-1.4 8.8-9.4c1.3 8.9 5.5 8.2 5.5 9.4"/><g fill="#d1dce6"><path d="M49.4 30.6c0 11.5-9.4 23.3-21 23.3s-21-11.8-21-23.3c0-7.7 16.6-2.3 21-2.3c11.6-.1 21-9.3 21 2.3"/><path d="M36.4 49.2c0 2.3-3.3 7.3-6.2 7.3c-2.9 0-6.2-3.4-6.2-5.7c0-2.3 12.4-2.7 12.4-1.6"/></g><path fill="#e1eaf2" d="M6.5 26.3c0 3 .6 11.7.6 11.7l2.7-3.4l3.2 3.8l.7-5.3l4.9 3.5l-.9-5.2l5.9.6l-2.7-3.2l4.1-2.7s-5 1.1-4.9-2c.1-3.1 2.6-11.9-.5-13.2c-5.7-2.1-13.1 2.7-13.1 15.4"/><g fill="#3e4347"><ellipse cx="6.5" cy="16.1" rx=".7" ry=".3"/><circle cx="11.5" cy="16.7" r="1.5"/></g><g fill="#e24b4b"><path d="M7.8 23.6c0 3.2-2.1.9-2.1.9c-.7 0-3.6 2.2-2.6-1.5c1.3-4.8 6.3-8 6.3-8s-1.6 2.8-1.6 8.6"/><path d="M20.8 10.6V9.4c-.2-2.5 3.4-3.5 3-4.8c-.6-1.7-5.3-.6-7.6 3.1c-.3.4-.5.9-.6 1.5c-.1-.4-.2-.8-.4-1.2c-1.1-2.3 2.2-4.4 1.2-5.5c-1.3-1.5-5.2 1.1-6.1 5.4c-.2.9-.2 1.8.1 2.7c-.1-.1-.2-.2-.3-.2c-1.7-1.3 0-4-1.2-4.6c-1.8-.8-3.4 2.8-2.5 6.3c.6 2 2.8 4.1 4.6 2.4c.6-.5 2-1.3 2.8-1.6c.6-.2 2.2-.1 3.2.6c.9.6 1.6 1.8 2.9 1.8c5.7.2 8.8-5.3 6.7-6.5c-1.1-.8-2.8 1.2-5.8 1.8"/></g><path fill="#e1eaf2" d="M42.5 43.9c-.9-2.2-3.5-3.4-3.5-3.4c2.7-1.4 4.3-4.4 4.3-4.4c-1.4-.6-6.8-1-6.8-1c1.2-1.2 2.2-2.9 2.2-2.9s-6.2-1.5-11.4 1.3c-6.8 3.8-4.8 12.8 2.9 13.8c8.5 1.1 12.3-3.4 12.3-3.4"/></svg>
                </button> -->
                  
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Stock Actual <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 64 64"><path fill="#f29a2e" d="M7.6 20.4c1.8 2.9 3.8 3.3 5.2 1.6c2.2-2.6-.2-5.9-2.8-6.8c-4.3-1.7-8 3.1-8 3.1s4.1-.4 5.6 2.1"/><path fill="#e1eaf2" d="M42.8 10.2c-7.7 4.5-1.3 15.3-15.2 18.2l14.8 7.3c3 5.2 11.3 5.6 11.3 5.6s2.1-6.2.4-10.8c4.6 0 7.8-2.8 7.8-2.8s-2.6-9.2-10.5-9.2c7.8-3.2 9.2-9.8 9.2-9.8s-6.9-4.8-17.8 1.5"/><path fill="#f4bc58" d="M35.7 62H21.4c0-1.2 8.4-1.4 8.8-9.4c1.3 8.9 5.5 8.2 5.5 9.4"/><g fill="#d1dce6"><path d="M49.4 30.6c0 11.5-9.4 23.3-21 23.3s-21-11.8-21-23.3c0-7.7 16.6-2.3 21-2.3c11.6-.1 21-9.3 21 2.3"/><path d="M36.4 49.2c0 2.3-3.3 7.3-6.2 7.3c-2.9 0-6.2-3.4-6.2-5.7c0-2.3 12.4-2.7 12.4-1.6"/></g><path fill="#e1eaf2" d="M6.5 26.3c0 3 .6 11.7.6 11.7l2.7-3.4l3.2 3.8l.7-5.3l4.9 3.5l-.9-5.2l5.9.6l-2.7-3.2l4.1-2.7s-5 1.1-4.9-2c.1-3.1 2.6-11.9-.5-13.2c-5.7-2.1-13.1 2.7-13.1 15.4"/><g fill="#3e4347"><ellipse cx="6.5" cy="16.1" rx=".7" ry=".3"/><circle cx="11.5" cy="16.7" r="1.5"/></g><g fill="#e24b4b"><path d="M7.8 23.6c0 3.2-2.1.9-2.1.9c-.7 0-3.6 2.2-2.6-1.5c1.3-4.8 6.3-8 6.3-8s-1.6 2.8-1.6 8.6"/><path d="M20.8 10.6V9.4c-.2-2.5 3.4-3.5 3-4.8c-.6-1.7-5.3-.6-7.6 3.1c-.3.4-.5.9-.6 1.5c-.1-.4-.2-.8-.4-1.2c-1.1-2.3 2.2-4.4 1.2-5.5c-1.3-1.5-5.2 1.1-6.1 5.4c-.2.9-.2 1.8.1 2.7c-.1-.1-.2-.2-.3-.2c-1.7-1.3 0-4-1.2-4.6c-1.8-.8-3.4 2.8-2.5 6.3c.6 2 2.8 4.1 4.6 2.4c.6-.5 2-1.3 2.8-1.6c.6-.2 2.2-.1 3.2.6c.9.6 1.6 1.8 2.9 1.8c5.7.2 8.8-5.3 6.7-6.5c-1.1-.8-2.8 1.2-5.8 1.8"/></g><path fill="#e1eaf2" d="M42.5 43.9c-.9-2.2-3.5-3.4-3.5-3.4c2.7-1.4 4.3-4.4 4.3-4.4c-1.4-.6-6.8-1-6.8-1c1.2-1.2 2.2-2.9 2.2-2.9s-6.2-1.5-11.4 1.3c-6.8 3.8-4.8 12.8 2.9 13.8c8.5 1.1 12.3-3.4 12.3-3.4"/></svg></h5>
                
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body position-relative">
                <div class="border p-3">
                    <div class="d-flex justify-content-around align-items-center">
                        <b>Total de pollos Montado: </b>
                        <b id="total_Pollos" class=" border text-center fs-1 mb-1 px-3 rounded">3</b>
                    </div>
                    <div class="d-flex justify-content-around align-items-center">
                        <button class="btn btn-outline-dark px-5" onclick="chispazoAbly({'montado':'-1'})"><b>-1</b></button>
                        <button class="btn btn-outline-dark px-5" onclick="chispazoAbly({'montado':'+1'})"><b>+1</b></button>
                    </div>
                    <div class="d-flex justify-content-around align-items-center pt-1">
                        <button class="btn btn-outline-dark px-5" onclick="chispazoAbly({'montado':'-6'})"><b>-6</b></button>
                        <button class="btn btn-outline-dark px-5" onclick="chispazoAbly({'montado':'+6'})"><b>+6</b></button>
                    </div>
                </div>

                <br>

                <div class="border p-3 d-flex justify-content-around align-items-center">
                    <b>Total de pollos Actual: </b>
                    <b id="resto_pollos" class=" border text-center fs-1 p-3 px-3 rounded">0</b>
                </div>

                <br>

                <div class="border p-3 d-flex justify-content-around align-items-center">
                    <b>Con Encargos: </b>
                    <b class="total_Encargo border text-center fs-1 p-3 px-3 rounded">0</b>
                </div>

                <br>

                <div class="border p-3 d-flex justify-content-around align-items-center">
                    <b>Sin Encargo: </b>
                    <b class="total_Sin_Encargo border text-center fs-1 p-3 px-3 rounded">0</b>
                </div>

                <br>

                <div class="border p-3">
                    <div class="d-flex justify-content-around align-items-center">
                        <b class="text-center">Venta de SIN encargo: </b>
                    </div>
                    <div class="d-flex justify-content-around align-items-center">
                        <button class="btn btn-dark px-5 py-3 mx-1" onclick="chispazoAbly({'sinEncargo':'-0.5'})"><b class="fs-2">-0.5</b></button>
                        <button class="btn btn-outline-dark px-5 py-3 mx-1" onclick="chispazoAbly({'sinEncargo':'+0.5'})"><b class="fs-2">+0.5</b></button>
                    </div>
                    <div class="d-flex justify-content-around align-items-center pt-1">
                        <button class="btn btn-primary px-5 py-3 mx-1" onclick="chispazoAbly({'sinEncargo':'-1'})"><b class="fs-2">-1</b></button>
                        <button class="btn btn-outline-dark px-5 py-3 mx-1" onclick="chispazoAbly({'sinEncargo':'+1'})"><b class="fs-2">+1</b></button>
                    </div>
                </div>
                <button type="button" class="position-relative mt-5 btn btn-outline-light text-danger" onclick='chispazoAbly({"reseteo":0})'>Iniciar Día</button>
            </div>
            </div>

            <a class="btn btn-outline-success" href="{{ route('encargos.create') }}"><b>Nuevo encargo</b></a>
        </div>
    </div>

    <div id="encargos-content">
    @include('admin.encargos._table')
</div>
 
<script>


    function copntrolStockDisponible(){
        // const resto_pollos = document.querySelector("#resto_pollos")
        
        const resultados_encargo = document.querySelector(".total_Encargo")
        const resultados_sin_encargo = document.querySelector(".total_Sin_Encargo")
        
        const totalPollos = localStorage.getItem("total_de_pollos");
        const restoPollos = localStorage.getItem("resto_de_pollos");
        
        // Esto controla los encargos que tenemos. Los cuenta y nos da el numero
        const pollitoNene = document.querySelectorAll(".pollitoNene")
        let total_actual_encargo = 0
        pollitoNene.forEach(pollito => {

            if(pollito.innerHTML.includes(" y ")){
                total_actual_encargo += parseInt(pollito.innerHTML) + 0.5;
            }else if (pollito.innerHTML.includes("1/2")) {
                total_actual_encargo += 0.5;
            } else if (parseInt(pollito.innerHTML)) {
                total_actual_encargo += parseInt(pollito.innerHTML);
            } else {
                total_actual_encargo += 0;
            }

        })
        
      
        // Aqui le decimos al DOM cuantos encargos tenemos
        resultados_encargo.innerHTML = total_actual_encargo

        // Aqui restamos los pollos que tenemos menos los encargos y se lo decimos al DOM
        resultados_sin_encargo.innerHTML = restoPollos - total_actual_encargo

    }

    function controlPollitos(operacion){
        // Actualizamos el valor del DOM del Total Absoluto
        const resultados_totales = document.getElementById("total_Pollos")
        let newValue_absoluto = parseFloat(resultados_totales.innerHTML) + operacion;
        localStorage.setItem("total_de_pollos", newValue_absoluto);
        resultados_totales.innerHTML = newValue_absoluto
        
        // Ahora debo sumar el valor sumado al Valor Actual
        const resto_pollos = document.getElementById("resto_pollos")
        let newValue_actual =  parseFloat(resto_pollos.innerHTML) + operacion
        localStorage.setItem("resto_de_pollos", newValue_actual);
        resto_pollos.innerHTML = newValue_actual

        copntrolStockDisponible()
    }

    function sinEncargoPollitos(operacion){
        const resto_pollos = document.getElementById("resto_pollos")
        let newValue =  parseFloat(resto_pollos.innerHTML) + operacion
        localStorage.setItem("resto_de_pollos", newValue);
        resto_pollos.innerHTML = newValue
        copntrolStockDisponible()
    }
    
    function inicializarDia(){
        localStorage.setItem("total_de_pollos", "0");
        localStorage.setItem("resto_de_pollos", "0"); 
        document.getElementById("total_Pollos").innerHTML = localStorage.getItem("total_de_pollos")
        document.getElementById("resto_pollos").innerHTML = localStorage.getItem("resto_de_pollos")
        copntrolStockDisponible()
        // window.location.reload();
    }
    
    document.addEventListener("DOMContentLoaded", function () { 

        const resultados_totales = document.getElementById("total_Pollos")
        const resto_totales = document.getElementById("resto_pollos")
        
        let newValue = localStorage.getItem("total_de_pollos");
        resultados_totales.innerHTML = newValue;
        
        let newValue2 = localStorage.getItem("resto_de_pollos");
        resto_totales.innerHTML = newValue2;

        copntrolStockDisponible()

        // console.log("Total de pollos:", totalPollos);

        

    });


    function chispazoAbly(valor){
        const channelName = 'chispazoPollo';
        const apiKey = "jVwvcw.mYv2yA:LzJ0YKCqrncnG7Zs90n9E349K_yVvQRv5FI9mfJHSII"
        const ably = new Ably.Realtime(apiKey);

        let channel = ably.channels.get(channelName);

        channel.publish('NuevoChispazo', JSON.stringify(valor));
    }

</script>


    
@endsection