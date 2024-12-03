@extends('layouts.public')

@section('content')

<style>
    .bg-fiestas{
        background: rgba(0, 0, 0, 0.48);
        border-radius: 16px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(6.8px);
        -webkit-backdrop-filter: blur(6.8px);
        border: 1px solid rgba(0, 0, 0, 1);
    }
</style>
<div class="container my-5">
    <h1 class="mb-4">Encargos Vista</h1>

    <form>
        <div class="row bg-fiestas p-3 my-5 rounded">

            <div class="col-9"></div>
            <div id="coste" class="btn btn-light col-2" style="cursor: auto;">
                172€
            </div>
            <div class="col-1"></div>

            <div class="col-12 d-flex my-3">
                <select id="menu1" class="form-control mx-2">
                    <option disabled selected value="none">Día y Momento</option>
                    <option value="opcion2">Opción 2</option>
                    <option value="opcion3">Opción 3</option>
                </select>
                
                <select id="menu1" class="form-control mx-2">
                    <option disabled selected value="none">Hora</option>
                    <option value="opcion2">Opción 2</option>
                    <option value="opcion3">Opción 3</option>
                </select>
    
                
            </div>

            <div class="col-12 d-flex my-3">
                <select id="menu1" class="form-control mx-2">
                    <option disabled selected value="none">Menú</option>
                    <option value="opcion2">Opción 2</option>
                    <option value="opcion3">Opción 3</option>
                </select>
    
                <input type="number" id="cantidadMenu1" class="form-control mx-2" name="cantidadMenu1" value="0">
                
            </div>
            <div class="col-12 d-flex my-3">
                <select id="menu1" class="form-control mx-2">
                    <option disabled selected value="none">Menú</option>
                    <option value="opcion2">Opción 2</option>
                    <option value="opcion3">Opción 3</option>
                </select>
    
                <input type="number" id="cantidadMenu1" class="form-control mx-2" name="cantidadMenu1" value="0">
                
            </div>

            <button class="col-3 btn btn-primary my-2 mx-3">Añadir otro menú</button>
        </div>
        
        <button class="col-3 btn btn-primary my-2 mx-3">Añadir otro peido</button>
    </form>

    <script>
       
    </script>


</div>
@endsection