<?php

namespace App\Http\Livewire;

use App\Models\Salario;
use Livewire\Component;
use App\Models\Categoria;
use App\Models\Vacante;
use Illuminate\Support\Carbon;
use Livewire\WithFileUploads;

class EditarVacante extends Component
{
    // A esto se les conoce como life cycle hooks y permiten ejecutar código, en este caso mount, cuando el componente ha
    // sido instanciado y sólo se ejecuta una vez. Le especificamos el modelo y su instancia
    public $vacante_id;//id no podemos usarlo ya que es reservado para livewire, usamos otro nombre
    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;
    public $imagen_nueva;

    Use WithFileUploads;

    // El nombre de rules es una convención de laravel. Validamos los campos.
    protected $rules = [
        'titulo' => 'required|string',
        'salario' => 'required',
        'categoria' => 'required',
        'empresa' => 'required',
        'ultimo_dia' => 'required',
        'descripcion' => 'required',
        // Con el valor nullable le indicamos que puede ir vacío pero en caso contrario, debe ser una imagen
        'imagen_nueva' => 'nullable|image|max:1024',
    ];

    // Debemos indicar en todos el nombre que tenemos en el modelo(BDD) $vacante->salario_id por ejemplo.
    public function mount(Vacante $vacante){
        $this->vacante_id = $vacante->id;
        $this->titulo = $vacante->titulo;
        $this->salario = $vacante->salario_id;
        $this->categoria = $vacante->categoria_id;
        $this->empresa = $vacante->empresa;
        // Con la clase carbon podemos formatear la fecha para poder mostrarla
        $this->ultimo_dia = Carbon::parse($vacante->ultimo_dia)->format('Y-m-d');
        $this->descripcion = $vacante->descripcion;
        $this->imagen = $vacante->imagen;
    }

    public function editarVacante(){
        // validate lo que hará es validar el formulario con las reglas de las propiedades arriba definidas.
        // Tanto validate como $rules son cosas internas de livewire.
        $datos = $this->validate();

        //Comprobamos si hay una nueva imagen
        if($this->imagen_nueva){
            $imagen = $this->imagen_nueva->store('public/vacantes');
            $datos['imagen'] = str_replace('public/vacantes/','',$imagen);
        }

        //Encontrar la vacante a editar
        $vacante = Vacante::find($this->vacante_id);

        //Asignar los valores
        $vacante->titulo = $datos['titulo'];
        $vacante->salario_id = $datos['salario'];
        $vacante->categoria_id = $datos['categoria'];
        $vacante->empresa = $datos['empresa'];
        $vacante->ultimo_dia = $datos['ultimo_dia'];
        $vacante->descripcion = $datos['descripcion'];
        // En esta comprobación a $vacante->imagen le asignamos el valor de $datos['imagen'] si hubiera una imagen nueva
        // o si no hubiera imagen nueva le asignamos el valor que ya tenía $vacante->imagen;
        $vacante->imagen = $datos['imagen'] ?? $vacante->imagen;

        //Guardar la vacante
        $vacante->save();

        //Redireccionar y mostrar mensaje de éxito
        session()->flash('mensaje','La vacante se actualizó correctamente.');

        return redirect()->route('vacantes.index');
    }

    public function render()
    {
        //Consultamos la BD para pasarle información a la vista. Creamos entonces primero un modelo.
        $salarios = Salario::all(); //Con este método nos traemos todos los registros.

        $categorias = Categoria::all();

        return view('livewire.editar-vacante',[
            'salarios' => $salarios,
            'categorias' => $categorias,
        ]);
    }
}
