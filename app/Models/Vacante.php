<?php

namespace App\Models;

use App\Models\User;
use App\Models\Salario;
use App\Models\Candidato;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vacante extends Model
{
    use HasFactory;

    //Al igual que la propiedad $fillable, la propiedad $dates es una convención de laravel para fechas.
    protected $dates = ['ultimo_dia'];

    protected $fillable = [
        'titulo',
        'salario_id',
        'categoria_id',
        'empresa',
        'ultimo_dia',
        'descripcion',
        'imagen',
        'user_id',
    ];

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function salario(){
        return $this->belongsTo(Salario::class);
    }

    public function candidatos(){
        // Una vacante puede tener muchos candidatos
        return $this->hasMany(Candidato::class)->orderBy('created_at','DESC');
    }

    public function reclutador(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
