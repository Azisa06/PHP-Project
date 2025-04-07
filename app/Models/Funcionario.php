<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'celular', 'cpf', 'email', 'categoria_id'];

    public function categoria() 
    {
        return $this->belongsTo(CategoriaFuncionario::class);
    }
}
