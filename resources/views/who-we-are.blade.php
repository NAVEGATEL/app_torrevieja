@extends('layouts.public')

@section('title', 'Conoce nuestro Asador La Morenica - Villena')
@section('description', '
Asador La Morenica, somos un asador de pollos a leña en Villena, 
comprometidos con la comunidad local y con la calidad de nuestros productos. 
Desde hace 20 años, ofrecemos la mejor comida y servicio a nuestros clientes, 
trabajando con proveedores españoles y asumiendo retos culinarios para crear nuevas 
experiencias gastronómicas. En nuestro asador creemos en el respeto hacia nuestros clientes, 
la comunidad y el medio ambiente. Ven a conocernos y disfruta de nuestra hospitalidad y deliciosos platos caseros.
')

@section('content')
<img src="{{ asset('img/corporativa/maxtor/nosotros/el_equipo.jpg') }}" class="sideImage" style="position: -20% 0 !important" alt="Foto del equipo Armenios que llevan el asador de pollos"
    style="object-position: top;">

<main class="quienes-somos">
    <h1 class="text-center my-5 py-5 fs-10 fuente-dancing">¡Ven a conocer Tu asador de pollos en Villena!<br>
        <i class="fuente-libre fs-4">Desde Armenia con corazón</i>
    </h1>
    <section class="my-5 py-5 container">
        <article>
            <div class="row">
                <div class="col-12 col-md-6">
                    <h2 class="fuente-libre">Del fuego a tu mesa</h2>
                    <p class="fuente-libre">Nuestra historia comienza hace 20 años, cuando decidimos abrir nuestro propio asador de pollos a
                        leña en
                        Villena.
                        Aunque somos de una generación de Armenios, hemos vivido toda la vida aquí y siempre hemos
                        estado comprometidos con la comunidad local.</p>
                    <p class="fuente-libre">Desde el primer día, nuestro objetivo ha sido ofrecer la mejor comida y el mejor servicio a
                        nuestros clientes. Para lograrlo, trabajamos con proveedores 100% españoles que nos proporcionan
                        los mejores ingredientes y productos de la zona. Además, nos gusta asumir retos culinarios para
                        crear nuevos platos y ofrecer una experiencia gastronómica única.</p>
                    <p class="fuente-libre">Pero lo más importante para nosotros son nuestros clientes, quienes son como nuestra familia. Nos
                        encanta recibir a nuevos comensales y ver cómo regresan una y otra vez, ya que nos enorgullece
                        saber que disfrutan de nuestra comida y de nuestra hospitalidad. Es por eso que siempre nos
                        esforzamos por ofrecer un trato cercano y amable, respetando sus gustos y preferencias.</p>
                    <p class="fuente-libre">En "Asador la Morenica" creemos en el respeto, tanto hacia nuestros clientes como hacia la
                        comunidad y el medio ambiente. Por eso, trabajamos de manera sostenible y cuidamos cada detalle
                        para ofrecer una experiencia gastronómica de calidad.</p>
                </div>
                <div class="col-12 col-md-6 text-center text-danger">
                    <img src="{{ asset('img/corporativa/maxtor/nosotros/la_fachada.jpg') }}" class="rounded-4 img-fluid "
                        alt="La facahda del asador la morenica de pollos asados a la brasa en villena">
                </div>
            </div>
        </article>
    </section>


    <section class="my-5 mx-0 py-5 container-fluid row align-items-center bg-light2">
        <div class="py-5 col-12 col-lg-4 text-light text-center">
            <img src="{{ asset('img/corporativa/maxtor/nosotros/el_equipo.jpg') }}" class="rounded-4 img-fluid "
                alt="El equipo que lleva y dirige el asador de pollos la morenica con leña">
        </div>
        <div class="py-5 col-12  col-lg-4 text-center esto">
            <p class="mx-5 fs-3 fst-italic fuente-libre">¿Quieres saber cuál es nuestro secreto para hacer el mejor pollo asado? <br>
                Ven a "Asador la Morenica" y te lo contamos entre risas y buen humor!</p>
        </div>
        <div class="py-5 col-12  col-lg-4 text-light text-center">
            <img src="{{ asset('img/corporativa/maxtor/nosotros/los_duenyos.jpg') }}" class="rounded-4 img-fluid "
                alt="Los dueños que llevan el asador 20 años e innovadores de la gastronomía villenera">
        </div>
    </section>


    <section class="my-0 my-md-2 container-fluid me-0 me-md-5 px-0 px-md-5"> 


        <article class="my-0 my-md-2 py-0 py-md-2  mx-1 mx-md-5 row">

            <img src="{{ asset('img/corporativa/maxtor/nosotros/la_fachada.jpg') }}" class="rounded-5 img-fluid col-6 imagenLG"
                alt="La facahda del asador la morenica de pollos asados a la brasa en villena">

            <div class="col-12 col-lg-6 esto text-center my-2 margenLG1" >
                <h3 class="m-5 fs-3 fst-italic fuente-libre">Tenemos un salón para tus eventos!</h3>
                <p class="m-5 fs-4 fst-italic fuente-libre">Tienes una fiesta, amigos y familia, ¿pero no un lugar dónde reuniros? No te preocupes, justo al lado de nuestro asador
                    tenémos un Salón dónde podrás celebrar tu evento.
                </p>
                <p class="m-5 fs-4 fst-italic fuente-libre">
                    Y si nos encargas a nosotros la comida, te hacemos un descuento!
                </p>
                <a class="btn btn-outline-dark my-5 px-5 fuente-libre fs-4">Próximamente</a>
            </div>

        </article>


        <article class="my-0 my-md-2 py-0 py-md-2  mx-1 mx-md-5 row">

            <div class="col-12 col-lg-6 esto text-center my-2 margenLG2 order-2 order-md-1">
                <h3 class="m-5 fs-3 fst-italic fuente-libre">Nos gusta servirte todo lo que nos pides</h3>
                <p class="m-5 fs-4 fst-italic fuente-libre">
                    Nos encantan los retos culinarios. Si quiers algún plato, pizza, rustidera... y no lo ves en nuestra carta, preguntanos, a lo mejor te sorprendemos 
                </p>
                <p class="m-5 fs-4 fst-italic fuente-libre">
                    La mejor comida casera y original de la zona!
                </p>
                <a  class="btn btn-outline-dark my-5 px-5 fuente-libre fs-4" href="{{route('contact')}}">Preguntanos</a>
            </div>

            <img src="{{ asset('img/corporativa/maxtor/nosotros/nuestro_asador.jpg') }}" class="order-1 order-md-2 img-fluid col-6 rounded-5 imagenLG"
                alt="El asador por dentro en vista panoramica y todos los platos servidor y el equipo esperando a sus clientes">

        </article>


    </section>



    <section class="my-2 my-md-5 py-5 bg-light3">
        <div class="container">
            <div class="row py-5">
                <h2 class="text-center pb-5 fuente-dancing fs-1">Tomamos nota de tu pedido</h2>

                <div class="col-12 col-md-6 d-flex align-content-center flex-column mb-5 mb-md-0">
                    <h4 class="text-center fuente-libre"> Te atendemos por correo, whatsapp o llamada</h4>
                        <a class="btn btn-outline-dark text-decoration-none fs-4 fuente-libre" href="{{ route('contact') }}">Contactar</a>

                </div>
                <div class="col-12 col-md-6 d-flex align-content-center flex-column">
                    <h4 class="text-center fuente-libre">Encarga desde la página web</h4>
                    <a class="text-decoration-none btn btn-outline-dark fs-4 fuente-libre" href="{{ route('makeOrder') }}">
                            Encargar
                    </a>

                </div>
            </div>
        </div>
    </section>

    <section class="my-5 py-5">
        <h2 class="text-center fuente-dancing fs-1">En primera línea durante las fiestas patronales de Villena</h2>
        <article class="my-5">
            <h3 class="text-center fuente-libre fs-4">Nos encargamos de servir los encargos a nuestros vecinos durante los desfiles de Moros y Cristianos</h3>
        </article>

        <article class="row w-100 m-0">

            <div class="col-12 col-md-4 m-0 p-0">
                <img src="{{ asset('img/festeros/caballerosAlada.jpg') }}" alt="Festeos de Villena, en moros y cristianos, la escuadra especial de los caballeros de la mano Alada, participando con asador la morenica, el asador de pollos a la brasa de Villena." class="serFit m-0 p-0 h-100 ">
            </div>

            <div class="col-12 col-md-4 text-center bg-light3 text-light m-0 p-3 d-flex justify-content-center align-items-center">
                <img src="{{ asset('img/festeros/escudo-junta-central.png') }}" alt="Escudo principal de las fiestas de moros y cristianos de Villena, haciendo entender de que va esta sección." class="m-0 p-0  ">
            </div>

            <div class="col-12 col-md-4 m-0 p-0 ">
                <img src="{{ asset('img/festeros/caballerosAladosDesfilando.jpg') }}" alt="Festeos de Villena, en moros y cristianos desfilando, los caballero de la mano alada despues de cenar el encargo de comida casera de asador de pollos de villena a leña." class="serFit m-0 p-0 h-100  ">
            </div>

        </article>
<!-- 
        <article class="row d-none">
            <div class="col-4 text-center bg-dark text-light m-0 p-3">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam ipsam quos optio repudiandae, ab ratione saepe maiores esse tenetur! Suscipit eveniet illo illum distinctio molestiae ipsam beatae delectus quae aliquid.
                Accusamus ab tenetur blanditiis, eligendi similique animi distinctio itaque amet. Ex, sunt ab inventore adipisci eos aliquid ipsum iste, debitis explicabo omnis, deserunt atque unde quaerat! Quisquam, vero repellendus! Hic.
                Deleniti natus nesciunt soluta est, a culpa eveniet, tempore libero placeat alias dolorum, maxime laudantium omnis? Similique, molestiae, mollitia error aut, labore dolor quibusdam nostrum iure accusantium ipsa nisi ullam.
            </div>

            <div class="col-4 m-0 p-0">
                <img src="{{ asset('img/festeros/caballerosAlada.jpg') }}" class="serFit m-0 p-0  ">
            </div>

            <div class="col-4 text-center bg-dark text-light m-0 p-3">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam ipsam quos optio repudiandae, ab ratione saepe maiores esse tenetur! Suscipit eveniet illo illum distinctio molestiae ipsam beatae delectus quae aliquid.
                Accusamus ab tenetur blanditiis, eligendi similique animi distinctio itaque amet. Ex, sunt ab inventore adipisci eos aliquid ipsum iste, debitis explicabo omnis, deserunt atque unde quaerat! Quisquam, vero repellendus! Hic.
                Deleniti natus nesciunt soluta est, a culpa eveniet, tempore libero placeat alias dolorum, maxime laudantium omnis? Similique, molestiae, mollitia error aut, labore dolor quibusdam nostrum iure accusantium ipsa nisi ullam.
            </div>

        </article>

        <article class="row d-none">

            <div class="col-4 m-0 p-0">
                <img src="{{ asset('img/festeros/caballerosAladosDesfilando.jpg') }}" class="serFit m-0 p-0  ">
            </div>

            <div class="col-4 text-center bg-dark text-light m-0 p-3">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam ipsam quos optio repudiandae, ab ratione saepe maiores esse tenetur! Suscipit eveniet illo illum distinctio molestiae ipsam beatae delectus quae aliquid.
                Accusamus ab tenetur blanditiis, eligendi similique animi distinctio itaque amet. Ex, sunt ab inventore adipisci eos aliquid ipsum iste, debitis explicabo omnis, deserunt atque unde quaerat! Quisquam, vero repellendus! Hic.
                Deleniti natus nesciunt soluta est, a culpa eveniet, tempore libero placeat alias dolorum, maxime laudantium omnis? Similique, molestiae, mollitia error aut, labore dolor quibusdam nostrum iure accusantium ipsa nisi ullam.
            </div>

            <div class="col-4 m-0 p-0">
                <img src="{{ asset('img/festeros/caballerosAlada.jpg') }}" class="serFit m-0 p-0  ">
            </div>

        </article> -->
      
        
    </section>
</main>

@endsection