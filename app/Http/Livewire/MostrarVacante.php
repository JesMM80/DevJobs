<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MostrarVacante extends Component
{
    // Definimos la variable vacante para que la pueda coger la vista
    public $vacante;

    public function render()
    {
        return view('livewire.mostrar-vacante');
    }
}
