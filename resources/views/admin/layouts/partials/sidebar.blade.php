<nav class="navbar navbar-expand-lg p-3">
    <h1 class="text-light fs-1 fuente-uno">
        Administración
    </h1>

    <button class="navbar-toggler mb-3 me-5 border-0 btn btn-outline-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0,0,256,256" >
            <g id="navsvgforfill" fill="#f1f1f1" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" 
            stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" 
            font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
            <g transform="scale(5.12,5.12)">
                <path d="M5,8c-0.72127,-0.0102 -1.39216,0.36875 -1.75578,0.99175c-0.36361,0.623 -0.36361,1.39351 0,2.01651c0.36361,
                0.623 1.0345,1.00195 1.75578,0.99175h40c0.72127,0.0102 1.39216,-0.36875 1.75578,-0.99175c0.36361,-0.623 0.36361,
                -1.39351 0,-2.01651c-0.36361,-0.623 -1.0345,-1.00195 -1.75578,-0.99175zM5,23c-0.72127,-0.0102 -1.39216,0.36875 
                -1.75578,0.99175c-0.36361,0.623 -0.36361,1.39351 0,2.01651c0.36361,0.623 1.0345,1.00195 1.75578,0.99175h40c0.72127,0.0102 1.39216,
                -0.36875 1.75578,-0.99175c0.36361,-0.623 0.36361,-1.39351 0,-2.01651c-0.36361,-0.623 -1.0345,-1.00195 -1.75578,-0.99175zM5,
                38c-0.72127,-0.0102 -1.39216,0.36875 -1.75578,0.99175c-0.36361,0.623 -0.36361,1.39351 0,2.01651c0.36361,0.623 1.0345,1.00195 
                1.75578,0.99175h40c0.72127,0.0102 1.39216,-0.36875 1.75578,-0.99175c0.36361,-0.623 0.36361,-1.39351 0,-2.01651c-0.36361,-0.623 
                -1.0345,-1.00195 -1.75578,-0.99175z"></path></g></g>
        </svg>
    </button>

    <div class="collapse navbar-collapse me-4 align-items-end d-lg-flex justify-content-end text-light" id="navbarNav">
        <ul class="navbar-nav">
            <!-- Escritorio -->
            <li class="nav-item mx-0 mx-md-1">
                <a href="{{ route('panel') }}" class="animated-link list-group-item list-group-item-action rounded m-2 color-light text-center">
                    <i class="bi bi-house-door-fill"></i> Escritorio
                </a>
            </li>

            <!-- Usuarios -->
            <li class="nav-item mx-0 mx-md-1">
                <a href="{{ route('users.index') }}" class="animated-link list-group-item list-group-item-action rounded m-2 color-light text-center">
                    <i class="bi bi-people-fill"></i> Usuarios
                </a>
            </li>

            <!-- Correos Enviados -->
            <li class="nav-item mx-0 mx-md-1">
                <a href="{{ route('emails.index') }}" class="animated-link list-group-item list-group-item-action rounded m-2 color-light text-center">
                    <i class="bi bi-envelope-fill"></i> Correos Enviados
                </a>
            </li>

            <!-- Ajustes -->
            <!-- <li class="nav-item mx-0 mx-md-1">
                <a href="{{ route('settings.index') }}" class="animated-link list-group-item list-group-item-action rounded m-2 color-light text-center">
                    <i class="bi bi-gear-fill"></i> Ajustes
                </a>
            </li> -->

            <!-- Botón para cerrar sesión -->
            <li class="nav-item mx-0">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de que quieres cerrar sesión?')) document.getElementById('logout-form').submit();" class="btn btn-outline-light border-0 ms-3">
                    <img width="20" height="20" src="https://img.icons8.com/ios/50/exit--v1.png" alt="exit--v1" style="color:white !important;"/>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>


<style>

</style>
