<?php

namespace App\Http\Livewire;

use App\Models\Vacante;
use Livewire\Component;

class MostrarVacantes extends Component
{

    // Para algunas funciones de livewire van a escuchar por eventos para que sean ejecutadas. La propiedad listeners es 
    // reservada de livewire. En el array se definen los nombres de las funciones que van a escuchar a eventos.
    // protected $listeners = ['prueba'];

    // public function prueba($vacanteid){
    //     dd($vacanteid);
    // }

    protected $listeners = ['eliminarVacante'];

    public function eliminarVacante(Vacante $vacante){
        $vacante->delete();
    }
    public function render()
    {
        $vacantes = Vacante::where('user_id', auth()->user()->id)->paginate(3);
        return view('livewire.mostrar-vacantes',[
            'vacantes'=>$vacantes
        ]);
    }
}
