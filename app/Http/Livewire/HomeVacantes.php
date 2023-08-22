<?php

namespace App\Http\Livewire;

use App\Models\Vacante;
use Livewire\Component;

class HomeVacantes extends Component
{
    public $termino;
    public $categoria;
    public $salario;

    // Este listener conecta el componente filtrarvacantes con este y escucha por el evento terminosBusqueda. Cuando este
    // evento ocurra, manda llamar al método 'buscar'.
    protected $listeners = ['terminosBusqueda' => 'buscar'];

    // Este método recibe las variables que le pasamos desde el componente filtrarvacantes
    public function buscar($termino,$categoria,$salario){

        // Asignando los valores aquí cuando se llama a este método, ya los tendremos disponibles en el método render.
        $this->termino = $termino;
        $this->categoria = $categoria;
        $this->salario = $salario;
    }

    public function render()
    {
        //$vacantes = Vacante::all();

        // Este when se va a ejecutar únicamente si los valores de término, etc tienen algo. En la función anónima se
        // pasa en automático la query actual.
        $vacantes = Vacante::when($this->termino, function($query){
            $query->where('titulo','LIKE',"%" . $this->termino . "%");
        })
        ->when($this->termino, function($query){
            // orWhere busca el término en el título y si no lo encuentra lo busca en la empresa
            $query->orWhere('empresa','LIKE',"%" . $this->termino . "%");
        })
        ->when($this->categoria, function($query){
            // orWhere busca el término en el título y si no lo encuentra lo busca en la empresa
            $query->Where('categoria_id',$this->categoria);
        })
        ->when($this->salario, function($query){
            // orWhere busca el término en el título y si no lo encuentra lo busca en la empresa
            $query->Where('salario_id',$this->salario);
        })
        ->paginate(5);

        return view('livewire.home-vacantes',[
            'vacantes' => $vacantes
        ]);
    }
}
