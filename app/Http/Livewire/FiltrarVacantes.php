<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Salario;
use Livewire\Component;

class FiltrarVacantes extends Component
{
    // Creamos los 3 atributos porque vamos a requerir lo que el usuario escriba en las búsquedas. Estos van asociados
    // a los input de la vista filtrar-vacantes.
    // Estos datos se pasaran al componente de homevacantes ya que es el que buscará los datos y renderiza la vista
    public $termino;
    public $categoria;
    public $salario;

    // A este método se le llama desde el formulario de la vista una vez se pulse en el botón submit
    public function leerDatosFormulario(){
        // Para comunicarnos con el componente 'padre' homevacantes que es el que renderiza todo, usamos emit, que es el 
        // evento que se emite y le pasamos los valores de búsqueda. Para ello además hay que generar un 'listener' para que escuche por ese evento. Esto lo hacemos 
        // en el componente padre homevacante escuchando por 'terminosBusqueda'.
        $this->emit('terminosBusqueda', $this->termino, $this->categoria, $this->salario);
    }

    public function render()
    {
        $salarios = Salario::all();
        $categorias = Categoria::all();

        return view('livewire.filtrar-vacantes',[
            'salarios' => $salarios,
            'categorias' => $categorias,
        ]);
    }
}
