<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
    <h1 class="text-light fs-1 fuente-dancing">
        AdminPanel
    </h1>

    <button class="navbar-toggler mb-3 me-5" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon bg-light rounded"></span>
    </button>

    <div class="collapse navbar-collapse me-4 align-items-end d-lg-flex justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <!-- Escritorio -->
            <li class="nav-item mx-0 mx-md-1">
                <a href="{{ route('panel') }}" class="list-group-item list-group-item-action rounded my-2">
                    <i class="bi bi-house-door-fill"></i> Escritorio
                </a>
            </li>

            <!-- Usuarios -->
            <li class="nav-item mx-0 mx-md-1">
                <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action rounded my-2">
                    <i class="bi bi-people-fill"></i> Usuarios
                </a>
            </li>

            <!-- Correos Enviados -->
            <li class="nav-item mx-0 mx-md-1">
                <a href="{{ route('newsletters.index') }}" class="list-group-item list-group-item-action rounded my-2">
                    <i class="bi bi-envelope-fill"></i> Correos Enviados
                </a>
            </li>

            <!-- Ajustes -->
            <li class="nav-item mx-0 mx-md-1 me-0 me-lg-5">
                <a href="{{ route('settings.index') }}" class="list-group-item list-group-item-action rounded my-2">
                    <i class="bi bi-gear-fill"></i> Ajustes
                </a>
            </li>

            <!-- Botón para volver al sitio -->
            <li class="nav-item mx-0 ms-0 ms-lg-5 my-1 mx-md-1">
                <a href="{{ url('/') }}" class="btn btn-warning">
                    <i class="bi bi-box-arrow-in-left"></i>
                </a>
            </li>

            <!-- Botón para cerrar sesión -->
            <li class="nav-item mx-0 my-1 mx-md-1">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de que quieres cerrar sesión?')) document.getElementById('logout-form').submit();" class="btn btn-danger">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>
