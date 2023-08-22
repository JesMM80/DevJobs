<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Este método obtiene las notificaciones del usuario no leídas
        $notificaciones = auth()->user()->unreadNotifications;

        // Limpiamos las notificaciones para que no se vuelvan a mostrar las que ya están vistas.
        auth()->user()->unreadNotifications->markAsRead();

        return view('notificaciones.index',[
            'notificaciones' => $notificaciones
        ]);
    }
}
