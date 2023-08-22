<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Salario;
use App\Models\Vacante;
use Livewire\Component;
use Livewire\WithFileUploads;

class CrearVacante extends Component
{
    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;

    use WithFileUploads;

    // El nombre de rules es una convención de laravel
    protected $rules = [
        'titulo' => 'required|string',
        'salario' => 'required',
        'categoria' => 'required',
        'empresa' => 'required',
        'ultimo_dia' => 'required',
        'descripcion' => 'required',
        'imagen' => 'required|image|max:1024',
    ];

    public function crearVacante()
    {
        // validate lo que hará es validar el formulario con las reglas de las propiedades arriba definidas
        $datos = $this->validate();

        //Almacenamos la imagen en el HDD con nombre aleatorio que proporciona laravel
        $imagen = $this->imagen->store('public/vacantes');
        $datos['imagen'] = str_replace('public/vacantes/','', $imagen); //Nos quedamos sólamente con el nombre de la imagen.

        //Creamos la vacante con un componente de livewire. Hemos definido correctamente el fillable en el modelo y ahora
        // lo llamamos para insertar el registro en la BDD
        Vacante::create([
            'titulo' => $datos['titulo'],
            'salario_id'=> $datos['salario'],
            'categoria_id'=> $datos['categoria'],
            'empresa'=> $datos['empresa'],
            'ultimo_dia'=> $datos['ultimo_dia'],
            'descripcion'=> $datos['descripcion'],
            'imagen'=> $datos['imagen'],
            'user_id'=> auth()->user()->id,
        ]);

        //Cremos el mensaje de alerta
        session()->flash('mensaje','La vacante se publicó correctamente');

        // Redireccionamos al usuario a la pantalla de listado de vacantes
        return redirect()->route('vacantes.index');
    }

    public function render()
    {
        //Consultamos la BD para pasarle información a la vista. Creamos entonces primero un modelo.
        $salarios = Salario::all(); //Con este método nos traemos todos los registros.

        $categorias = Categoria::all();
        return view('livewire.crear-vacante',[
            'salarios' => $salarios,
            'categorias' => $categorias,
        ]); //De esta forma le pasamos los registros a la vista crear-vacante
    }
}
