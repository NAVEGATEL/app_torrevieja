<nav class="navbar navbar-expand-lg p-3">
    <h1 class="text-light fs-1 fuente-uno">
        Administración
    </h1>

    <button class="navbar-toggler mb-3 me-5 btn btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon rounded"></span>
    </button>

    <div class="collapse navbar-collapse me-4 align-items-end d-lg-flex justify-content-end text-light" id="navbarNav">
        <ul class="navbar-nav">
            <!-- Escritorio -->
            <li class="nav-item mx-0 mx-md-1">
                <a href="{{ route('panel') }}" class="animated-link list-group-item list-group-item-action rounded m-2 color-light">
                    <i class="bi bi-house-door-fill"></i> Escritorio
                </a>
            </li>

            <!-- Usuarios -->
            <li class="nav-item mx-0 mx-md-1">
                <a href="{{ route('users.index') }}" class="animated-link list-group-item list-group-item-action rounded m-2 color-light">
                    <i class="bi bi-people-fill"></i> Usuarios
                </a>
            </li>

            <!-- Correos Enviados -->
            <li class="nav-item mx-0 mx-md-1">
                <a href="{{ route('newsletters.index') }}" class="animated-link list-group-item list-group-item-action rounded m-2 color-light">
                    <i class="bi bi-envelope-fill"></i> Correos Enviados
                </a>
            </li>

            <!-- Ajustes -->
            <li class="nav-item mx-0 mx-md-1">
                <a href="{{ route('settings.index') }}" class="animated-link list-group-item list-group-item-action rounded m-2 color-light">
                    <i class="bi bi-gear-fill"></i> Ajustes
                </a>
            </li>

            <!-- Botón para cerrar sesión -->
            <li class="nav-item mx-0">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de que quieres cerrar sesión?')) document.getElementById('logout-form').submit();" class="btn btn-outline-light border-0">
                    <img width="20" height="20" src="https://img.icons8.com/ios/50/exit--v1.png" alt="exit--v1" />
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
