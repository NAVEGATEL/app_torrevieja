<nav class="navbar navbar-expand-lg text-light p-3" >


    <h1 class="text-light fs-1 fuente-dancing">
        Navegatel
    </h1>

    <button class="navbar-toggler mb-3 me-5" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon bg-light rounded"></span>
    </button>

    <div class="collapse navbar-collapse me-4 align-items-end text-end d-lg-flex justify-content-end align-items-end" id="navbarNavDropdown" >
        <ul class="navbar-nav">
            
            <li class="mx-0 mx-md-1"><a
                href="{{ route('panel') }}"
                class="list-group-item list-group-item-action rounded my-2"
            >
                Escritorio
            </a></li>
            <li class="mx-0 mx-md-1"><a
                href="{{ route('days.index') }}"
                class="list-group-item list-group-item-action rounded my-2"
            >
                Horarios
            </a></li>
            <li class="mx-0 mx-md-1"><a
                href="{{ route('encargos.index') }}"
                class="list-group-item list-group-item-action rounded my-2 position-relative"
            >
                Encargos
            </a></li>
            <li class="mx-0 mx-md-1"><a
                href="{{ route('products.index') }}"
                class="list-group-item list-group-item-action rounded my-2"
            >
                Productos
            </a></li>
            <li class="mx-0 mx-md-1"><a
                href="{{ route('categories.indexCrud') }}"
                class="list-group-item list-group-item-action rounded my-2"
            >
                Categorías
            </a></li>
            <!-- <li class="mx-0 mx-md-5"><a
                href="{{ route('newsletters.index') }}"
                class="list-group-item list-group-item-action rounded my-2"
            >
                Newsletter
            </a></li> -->
            <li class="mx-0 mx-md-1 me-0 me-lg-5"><a
                href="{{ route('settings.index') }}"
                class="list-group-item list-group-item-action rounded my-2"
            >
                Ajustes
            </a></li>

        
    
            <li class="mx-0 ms-0 ms-lg-5 my-1 mx-md-1">
                <a href="{{ url('/') }}" class="btn btn-warning">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="white"
                            d="M4 21V9l8-6l8 6v12h-6v-7h-4v7H4Z"
                        />
                    </svg>
                </a>
            </li>
            <li class="mx-0 my-1 mx-md-1">
                <a  href="{{ route('logout') }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de que quieres cerrar sesión?')) document.getElementById('logout-form').submit();" class="btn btn-danger">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <g fill="white">
                            <path
                                d="M9.052 4.5C9 5.078 9 5.804 9 6.722v10.556c0 .918 0 1.644.052 2.222H8c-2.357 0-3.536 0-4.268-.732C3 18.035 3 16.857 3 14.5v-5c0-2.357 0-3.536.732-4.268C4.464 4.5 5.643 4.5 8 4.5h1.052Z"
                                opacity=".5"
                            />
                            <path
                                fill-rule="evenodd"
                                d="M9.707 2.409C9 3.036 9 4.183 9 6.476v11.048c0 2.293 0 3.44.707 4.067c.707.627 1.788.439 3.95.062l2.33-.406c2.394-.418 3.591-.627 4.302-1.505c.711-.879.711-2.149.711-4.69V8.948c0-2.54 0-3.81-.71-4.689c-.712-.878-1.91-1.087-4.304-1.504l-2.328-.407c-2.162-.377-3.243-.565-3.95.062Zm3.043 8.545c0-.434-.336-.785-.75-.785s-.75.351-.75.784v2.094c0 .433.336.784.75.784s.75-.351.75-.784v-2.094Z"
                                clip-rule="evenodd"
                            />
                        </g>
                    </svg>
                </a>
            
                <form
                    id="logout-form"
                    action="{{ route('logout') }}"
                    method="POST"
                    style="display: none"
                >
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    
</nav>
