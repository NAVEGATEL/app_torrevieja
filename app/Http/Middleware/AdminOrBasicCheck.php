<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class AdminOrBasicCheck
{
    public function handle($request, Closure $next)
    {

        if (Auth::check()) {
            $user = Auth::user();
            // dd($user);
            
            if ($user->rol_id == 1 || $user->rol_id == 2) {
                return $next($request);
            }
        }

        // Si el usuario no es un administrador o un usuario básico, puedes redirigirlo o devolver una respuesta de error.
        return redirect()->route("fiestas.index");
    }
}