@extends('layouts.public') 

@section('title', 'Asador de Pollos a Leña - Asador La Morenica')
@section('description', '
El Asador de pollos en horno de leña. Comida para llevar casera, a la brasa y en Villena, cerca de ti, tu Asador la paz.
')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error) 
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<video class="d-block d-md-none" width="100%" style="object-fit: contain;" alt="Baner principal original, video de nuestros pollos a la brasa" poster="{{ asset('img/miniatura.jpg') }}" autoplay loop muted> 
     
    <source src="{{ asset('img/corporativa/sliders/pollos_slider_home.mov') }}" type="video/mp4">
    Tu navegador no soporta Etiquetas video de HTML5 
</video>
<video class="d-none d-md-block" width="100%" height="700px" style="object-fit: cover;" alt="Baner principal original, video de nuestros pollos a la brasa" poster="{{ asset('img/miniatura.jpg') }}" autoplay loop muted> 
   
    <source src="{{ asset('img/corporativa/sliders/pollos_slider_home.mov') }}" type="video/mp4">
    Tu navegador no soporta Etiquetas video de HTML5 
</video>
 
<main class="home-blade">
    <h1 class="text-center mt-0 pt-0 mt-md-5 pt-md-5 my-5 py-5"><b class="fuente-dancing fs-10">Asador de pollos a leña</b> <br><i>pollos a la brasa cerca de ti</i></h1>


    <!-- Navidad versión Móvil Tablet -->
    <section class="d-block d-lm-none container-fluid my-5 py-5 bodySnow">

        <div class="snow"></div>

        <h2 class="fuente-dancing text-center fs-1 text-light">
            ¡¡¡ Estas Fechas Cocinaremos Para Ti !!!
        </h2>

        <style>
            .carousel-item img {
                height: 800px; /* Cambia esto al tamaño que prefieras */
            }
        </style>

        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('img/corporativa/pancartas/cena_anyo_nuevo.jpg') }}" class="d-block w-100 roounded-top rounded-md-end rounded-4" style="object-fit: contain;" alt="baner principal es un pollo mirando un cartel de que el pollo nos hace felices" />
                </div>
            <div class="carousel-item">
                    <img src="{{ asset('img/corporativa/pancartas/cena_navidad.jpg') }}" class="d-block w-100 roounded-top rounded-md-end rounded-4" style="object-fit: contain;" alt="baner principal es un pollo mirando un cartel de que el pollo nos hace felices" />
                </div>
            <div class="carousel-item">
                <img src="{{ asset('img/corporativa/pancartas/navidades_con_asador_la_morenica.jpg') }}" class="d-block w-100 roounded-top rounded-md-end rounded-4" style="object-fit: contain;" alt="baner principal es un pollo mirando un cartel de que el pollo nos hace felices" />
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

        </div>
    </section>

    <!-- Navidad versión Ordenador -->
    <section class="d-none d-lm-block container-fluid my-5 py-5 bodySnow">

        <div class="snow"></div>

        <h2 class="fuente-dancing text-center fs-1 text-light">
            ¡¡¡ Estas Fechas Cocinaremos Para Ti !!!
        </h2>

        <div id="" class="" data-bs-ride="">
        
            <img src="{{ asset('img/corporativa/pancartas/cena_anyo_nuevo.jpg') }}" class="d-block w-100 roounded-top rounded-md-end rounded-4" style="object-fit: contain;" alt="baner principal es un pollo mirando un cartel de que el pollo nos hace felices" />
    
            <img src="{{ asset('img/corporativa/pancartas/cena_navidad.jpg') }}" class="d-block w-100 roounded-top rounded-md-end rounded-4" style="object-fit: contain;" alt="baner principal es un pollo mirando un cartel de que el pollo nos hace felices" />
 
            <img src="{{ asset('img/corporativa/pancartas/navidades_con_asador_la_morenica.jpg') }}" class="d-block w-100 roounded-top rounded-md-end rounded-4" style="object-fit: contain;" alt="baner principal es un pollo mirando un cartel de que el pollo nos hace felices" />
       
        </div>


    </section>



    <section class="container my-5 py-5">
        <p class="fuente-libre text-center fs-3">¡Estos son nuestros menús más vendidos! <br> No te pierdas nuestros últimos platos</p>
        @php
        $categorPos = 0;
        @endphp
        @foreach ($productos as $producto)

        @php
        $categorPos++;
        @endphp
        @if($categorPos % 2 == 0 )
        <article class="hov-bg my-5mt-5 bg-detail">
            <div class="row hrefOut">
                <div class="col-12 col-md-6 order-1 order-md-1">
                    <img src="{{ asset('img/products/' . $producto->image) }}" class="sideImage roounded-top rounded-md-end rounded-4" style="object-fit: cover;" alt="baner principal es un pollo mirando un cartel de que el pollo nos hace felices" />
                </div>

                <div class="col-12 col-md-6 p-0 order-2 order-md-2 py-5">
                    <div class="d-flex flex-column">
                        <h3 class="mb-5 text-center fuente-dancing fs-7">
                            {{ $producto->name }}
                        </h3>
                        <p class="m-5 fuente-libre fs-4 text-center">
                            {{ $producto->description }}
                        </p>
                    </div>
                </div>
            </div>
        </article>
        @else
        <article class="hov-bg my-5 mt-5 bg-detail">
            <div class="row hrefOut">
                <div class="col-12 col-md-6 p-0 order-2 order-md-1 py-5">
                    <div class="d-flex flex-column">
                        <h3 class="mb-5 text-center fuente-dancing fs-7">
                            {{ $producto->name }}
                        </h3>
                        <p class="m-5 fuente-libre fs-4 text-center">
                            {{ $producto->description }}
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-6 order-1 order-md-2">
                    <img src="{{ asset('img/products/' . $producto->image) }}" class="sideImage rounded-top rounded-md-start rounded-4" style="object-fit: cover;" alt="baner principal es un pollo mirando un cartel de que el pollo nos hace felices" />


                </div>
            </div>
        </article>
        @endif @endforeach
    </section>

    <section class="my-5 nosotros-relative">
        <div class="bg-nosotros_slider"></div>
        <article class="container nosotros-absolut">
            <h3 class="text-light text-center fuente-dancing fs-10">
                Conocenos
            </h3>
            <p class="text-light text-center fuente-libre m-5">
                Llevamos más de 20 años en Villena, orgullosos de ser un referente en la zona gracias a nuestro horno de
                leña para asar pollos, lo que les confiere un sabor inigualable
                y una textura distinta.
                <br>
                <br>
                Pero no solo somos especialistas en pollo asado, en nuestro restaurante encontrarás una gran variedad de
                platos españoles y de nuestra propia cultura armenia, que fusionamos
                para ofrecerte una experiencia gastronómica única. Desde sabrosas tapas hasta deliciosas especialidades
                armenias, nuestra carta es un viaje culinario que no te dejará indiferente.
                <br>
                <br>
                Nos importa que te sientas como en casa, por eso te recibiremos con una sonrisa y un trato cercano y
                amable. Nos encanta compartir nuestra pasión
                por la buena comida y la hospitalidad con todos nuestros clientes, y estamos seguros de que en cada
                visita te sentirás parte de la familia.
                <br>
                <br>
                ¡Te esperamos en para que descubras todo lo que nuestra cocina tiene para ofrecerte!
            </p>
            <div class="position-relative my-5">
                <a href="{{ route('whoWeAre') }}" class="btn btn-outline-light nosotros-btn-absolut">Sobre Nosotros</a>
            </div>
        </article>
    </section>

    <section class="my-5 py-5">
        <h3 class="my-5 text-center fuente-dancing fs-10"> Nuestros Productos </h3>
        <div class="row justify-content-around m-5">
            <p class="fuente-libre text-center fs-3"> ¿No sabes que pedir? <br> ¡Aquí tienes nuestras categorías más vendidas! </p>
            
            @foreach ($categorias as $categoria)

            @php
            $imag ='image-not-found.svg';
            if ($categoria->image && file_exists(public_path('img/products/' . $categoria->image))) {
                $imag = $categoria->image;
            }
            @endphp
            <div class="card col-12 col-md-6 col-lg-4 m-3" style="width: 20rem">
                <a class="row hrefOut" href="{{ route('categories') }}?categoria={{ $categoria->id }}">
                    <img src="{{ asset('img/products/' . $imag) }}" class="sideImage roounded-top rounded-md-end rounded-4" style="object-fit: cover;" alt="{{ $producto->name }} Nuestra categoría de selección única" />

                    <div class="card-body">
                        <h5 class="card-title">{{ $categoria->name }}</h5>
                        <p class="card-text">
                            {{ $categoria->description }}
                        </p>
                    </div>
                </a>
            </div>
            @endforeach


        </div>
        <a href="{{ route('categories') }}" class="link-hover">
            <h3 class="my-5 text-center fuente-libre link-hover"> Haz click aquí y descubre todas nuestras categorías </h3>
        </a>
    </section>

</main>

@endsection