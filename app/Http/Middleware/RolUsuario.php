<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolUsuario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // Controlamos el acceso a los usuarios a las notificaciones
        if($request->user()->rol === 1){
            // Si no es el usuario 1, le redireccionamos hacia home
            return redirect()->route('home');
        }
        return $next($request);
    }
}
