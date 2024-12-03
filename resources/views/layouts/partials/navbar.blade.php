<div class="d-flex justify-content-between align-items-center p-3 bg-grisSuave">
  <div class="">
    <div class="d-flex align-items-center">
      <a href="tel:+34654027015" class="text-dark elHover" style="text-decoration:none"><h6>Llámanos 654027015</h6></a>
    </div>
  </div>
  <div>


      <a href="https://wa.me/34654027015?text=Hola! Me gustaría encargar..." class="ms-3 text-light">
        
          <img src="{{ asset('img/corporativa/svg/whatsapp.svg') }}" width="22" class="bgHover" alt="Logo whatsapp">
      </a>
      <a href="https://es-es.facebook.com/people/Asador-la-morenica/100064982920008/" class="ms-2 text-light">

          <img src="{{ asset('img/corporativa/svg/facebook.svg') }}" width="25" class="bgHover" alt="Logo facebook">
      </a>
      <a href="https://www.instagram.com/asadolamorenica/?hl=es" class="ms-2 text-light">

          <img src="{{ asset('img/corporativa/svg/instagram.svg') }}" width="25" class="bgHover" alt="Logo instagram">
      </a>


  </div>

</div>

<nav id="navbar-general" class="navbar navbar-light bg-light d-flex justify-content-center align-items-center">
  
  <div class="container-fluid justify-content-center justify-content-md-around flex-column flex-md-row">


    <a class="navbar-brand" href="/">
      <div class="d-flex align-items-center flex-column flex-md-row">
        <img src="{{ asset('img/corporativa/logo-negro-web.png') }}" alt="Asador la Morenica" width="130" class="">
      </div>
    </a>


    <a class="navbar-brand" href="/">
      <div class="d-flex flex-column">
        <span class="fuente-libre fs-1">Asador la Morenica</span>
        <span class="fuente-dancing text-center fs-2">En horno de leña</span>
      </div>
    </a>

    <button class="navbar-toggler d-flex flex-column justify-content-around collapsed mt-3 mt-md-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="toggler-icon  top-bar"></span>
      <span class="toggler-icon middle-bar"></span>
      <span class="toggler-icon bottom-bar"></span>
    </button>

  </div>


  <div class="collapse w-75" id="navbarToggleExternalContent">
    <div class="bg-light px-4 pt-4">
      <ul class="navbar-nav text-center me-auto mb-2 ms-0 ms-md-5">
        <li class="nav-item nav-hover">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item nav-hover">
          <a class="nav-link" href="{{ route('makeOrder') }}">Encarganos</a>
        </li>
        <li class="nav-item nav-hover">
          <a class="nav-link" href="{{ route('categories') }}">Productos</a>
        </li>
        <li class="nav-item nav-hover">
          <a class="nav-link" href="{{ route('whoWeAre') }}">Quienes Somos</a>
        </li>
        <!-- <li class="nav-item nav-hover">
          <a class="nav-link" href="/opinions">Opiniones</a>
        </li> -->
        <li class="nav-item nav-hover">
          <a class="nav-link" href="{{ route('contact') }}">Contacto</a>
        </li>
      </ul>
    </div>
  </div>

</nav>