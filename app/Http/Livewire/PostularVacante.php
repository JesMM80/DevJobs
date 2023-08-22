<?php

namespace App\Http\Livewire;

use App\Models\Vacante;
use App\Notifications\NuevoCandidato;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostularVacante extends Component
{
    use WithFileUploads;

    public $cv;
    public $vacante;

    protected $rules = [
        'cv' => 'required|mimes:pdf'
    ];

    public function mount(Vacante $vacante){
        // De esta forma ya tenemos disponible el valor y lo podemos usar en la función postularme
        $this->vacante = $vacante;
    }

    public function postularme(){
    
        // validate lo que hará es validar el formulario con las reglas de las propiedades arriba definidas
        $datos = $this->validate();

        //Almacenamos el cv
        $cv = $this->cv->store('public/cv');
        $datos['cv'] = str_replace('public/cv/','', $cv); //Nos quedamos sólamente con el nombre de la imagen.

        //Crear candidato a la vacante. Gracias a la relación que hemos definido en el modelo de vacante en la función
        //candidatos podemos insertar el registro. 
        //En este caso candidatos va con paréntesis porque queremos acceder a las funciones.
        $this->vacante->candidatos()->create([
            'user_id' => auth()->user()->id,
            'cv' => $datos['cv'],
            // La vacante no hace falta ya que la definimos en el modelo de la vacante
        ]);


        //Crear la notificación previamente, luego hemos definido la relación del reclutador con la vacante.
        //En el constructor especificamos los datos que le queremos pasar al constructor de la clase NuevoCandidato para que 
        //los métodos sepan qué datos le pasamos y qué métodos son llamados.
        $this->vacante->reclutador->notify(new NuevoCandidato($this->vacante->id,$this->vacante->titulo,auth()->user()->id));

        //Mostrar al usuario un mensaje de ok. Luego en la vista tenemos que comprobar si existe sessión para mostrar el 
        //mensaje
        session()->flash('mensaje','Se envió correctamente tu información.');
        return redirect()->back(); //Vuelve a la página anterior.
    }

    public function render()
    {
        return view('livewire.postular-vacante');
    }
}
