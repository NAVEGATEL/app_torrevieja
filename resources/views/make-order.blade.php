@extends('layouts.public')

@section('title', 'Encarga tu pollo a la brasa y rápido - Asador la Morenica')
@section('description', '
Haz tu pedido online, en nuestro asador de pollos de la Morenica, Villena. 
En nuestra página de encargos encontrarás un formulario fácil y rápido de usar para hacer tus pedidos 
y elegir los productos que deseas. Nuestro equipo se encargará de preparar tu pedido y tenerlo listo para que puedas recogerlo en nuestro 
asador de pollos en pocos minutos.
')
@section('content')
<div class="makeOrder">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/l10n/es.js"></script>

    <script lang="text/javascript" src="https://cdn.ably.com/lib/ably.min-1.js"></script>


    <img src="{{ asset('img/corporativa/sliders/makeOrder_slider.jpeg') }}" class="sideImage"
        alt="baner principal es un pollo mirando un cartel de que el pollo nosn hace felices" />

    <div class="container makeOrder-blade my-5">

        <h1 class="text-center py-5 my-5"><b class="fuente-dancing fs-10">Encarga rápido</b><br><i> y prueba la
                Gastronomía más innovadora</i></h1>

        <div class="d-flex flex-wrap justify-content-center">

            <div id="carouselExampleControls" class="carousel" data-ride="carousel">

                <div class="carousel-inner">
                    <!-- slider de los menus solo imagenes -->
                    @php
                    $prod = 0;
                    @endphp

                    <!-- ####################### -->
                    @foreach ($productos as $producto)
                    @if( $prod < 3) <div class="card m-3 carousel-item active" style="width: 20rem; height: 22rem;"
                        data-ident="{{$prod}}">
                        @else
                        <div class="card m-3 carousel-item" style="width: 20rem; height: 22rem;" data-ident="{{$prod}}">
                            @endif
                            <img src="{{ asset('img/products/' . $producto->image) }}" class="card-img-top" alt="baner principal es un pollo mirando un cartel de que el pollo nos hace felices" />


                            <div class="card-body">
                                <h5 class="card-title"> {{ $producto->name }}</h5>
                                <p class="card-text"> {{ $producto->description }}</p>
                            </div>
                        </div>

                        @php
                        $prod++;
                        @endphp

                        @endforeach
                        <!-- ######################## -->
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls2"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls2"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

            </div>


        </div>

        <div class="my-5 pt-5 border-bottom">
            <h2 class="text-center my-5 fs-1">Haz tu pedido <br><small class="fs-1 fuente-dancing">Con ese toque a
                    brasas</small></h2>
        </div>

  


               <!-- FORMULARIO --- ETIQUETA -->
               <form id="formul" action="{{ route('encargos.store') }}" method="post" class="my-5 needs-validation" novalidate>
                @csrf
                <div class="row align-items-center fuente-libre">
                    <div class="col-12 col-md-4">
                        <label for="identidad-usuario">Nombre & Apellidos</label>
                        <input class="form-control p-3" type="text" name="identidad-usuario" id="identidad-usuario" placeholder="Nombre" pattern="[A-Za-z\s]+" required>
                        <div class="invalid-feedback">
                            Por favor, introduce un nombre válido.
                        </div>
                    </div>
    
                    <div class="col-12 col-md-3">
                                @php
                                $opcionesPollo = array(
                                    array('value' => '0', 'text' => '0'),
                                    array('value' => '0.5', 'text' => '1/2'),
                                    array('value' => '1', 'text' => '1'),
                                    array('value' => '1.5', 'text' => '1 y 1/2'),
                                    array('value' => '2', 'text' => '2'),
                                    array('value' => '2.5', 'text' => '2 y 1/2'),
                                    array('value' => '3', 'text' => '3'),
                                    array('value' => '3.5', 'text' => '3 y 1/2'),
                                    array('value' => '4', 'text' => '4'),
                                    array('value' => '4.5', 'text' => '4 y 1/2'),
                                    array('value' => '5', 'text' => '5'),
                                    array('value' => '5.5', 'text' => '5 y 1/2'),
                                    array('value' => '6', 'text' => '6'),
                                    array('value' => '6.5', 'text' => '6 y 1/2'),
                                    array('value' => '7', 'text' => '7'),
                                    array('value' => '7.5', 'text' => '7 y 1/2'),
                                    array('value' => '8', 'text' => '8'),
                                    array('value' => '8.5', 'text' => '8 y 1/2'),
                                    array('value' => '9', 'text' => '9'),
                                    array('value' => '9.5', 'text' => '9 y 1/2'),
                                    array('value' => '10', 'text' => '10'),
                                );
                    
                                @endphp
                                <!-- pollo_encargo -->
                                <label for="pollo_encargo">Pollo</label>
                                <select class="form-select p-3" aria-label="Default select example" name="pollo_encargo" id="pollo_encargo" required>
                                    <option disabled>Selecciona tu menú</option>
                                    @foreach($opcionesPollo as $pollito)
                                    <option value="{{$pollito["value"]}}" class="fs-3 fuente-libre">
                                        {{$pollito["text"]}}
                                    </option>
                                    @endforeach
                                </select>

                                <select class="d-none" aria-label="Default select example" name="pedido-usuario" id="pedido-usuario" required>
                                    <option disabled>Selecciona tu menú</option>
                                    <option value="Otro"selected>obsoleto</option> 
                                    <!-- @foreach($productos as $producto)
                                    <option value="{{$producto->name}}">
                                        {{$producto->name}}
                                    </option>
                                    @endforeach -->
                                </select>
                                
                                <div class="invalid-feedback">
                                    Por favor, selecciona un menú.
                                </div>
                    </div>
    
                    <div class="mt-3 mt-md-0 col-12 col-md-5">
                        <textarea name="detalles" id="detalles-user" cols="40" class="form-control" rows="3" placeholder="¿Quieres algo más?... ¡Escribenos aquí!" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s\d]*$"></textarea>
                    </div>
    
                    <div class="my-3"></div>
                    
                    <div class="col-md-4">
                        <label for="hora-usuario">¿Cuándo?</label>
                        <input type="text" class="form-control p-3" name="hora-usuario" id="hora-usuario" required>
                        <div class="invalid-feedback">
                            Por favor, selecciona una fecha y hora.
                        </div>
                    </div>   
    
                    <div class="col-12 col-md-4">
                        <label for="email-usuario">Email</label>
                        <input class="form-control p-3" type="email" name="email-usuario" id="email-usuario" placeholder="correo@correo.es" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" required>
                        <div class="invalid-feedback">
                            Por favor, introduce un correo electrónico válido.
                        </div>
                    </div>
                    
    
                    <div class="col-12 col-md-4">
                        <label for="telefono-usuario">Teléfono</label>
                        <input class="form-control p-3" type="text" name="telefono-usuario" id="telefono-usuario" pattern="^(6|7|8|9)\d{8}$" placeholder="678126354" required>
                        <div class="invalid-feedback">
                            Por favor, introduce un número de teléfono válido.
                        </div>
                    </div>
    
                </div>
                <div class="float-end my-5 d-flex flex-column justify-content-end align-items-end">
                    <label for="politicas-privacidad-usuario">
                        <input class="form-check-input mx-2" type="checkbox" name="politicas-privacidad-usuario" id="politicas-privacidad-usuario" required />
                        He leído y acepto la <a href="{{ route('privacyPolices') }}">política de privacidad</a>
                    </label>
                    <div class="invalid-feedback">
                        Debes aceptar la política de privacidad para continuar.
                    </div>
                    <button type="submit" id="boten" class="btn btn-outline-dark w-50 my-3">Encargar</button>
                </div>
            </form>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
    
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div id="mensaje" class="alert alert-success" role="alert" style="display: none;">
                ¡Encargo enviado correctamente!<br>Cuando lo veamos, te confirmaremos el pedido a través de WhatsApp.
              </div>
        </main>
        <div class="py-5 my-5"></div>


        <script>
            window.csrfToken = '{{ csrf_token() }}';
            window.routeEncargosStore = '{{ route('encargos.store') }}';
            window.days = @json($days);
            
        </script>
        
        @vite(['resources/js/makeOrder.js'])


    </div @endsection