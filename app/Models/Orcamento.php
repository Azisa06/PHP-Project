<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;
<<<<<<< HEAD
    protected $fillable = ['nome', 'descricao', 'preco', 'servico_id'];
=======
    protected $fillable = ['nome', 'descricao', 'preco', 'categoria_id', 'status'];
>>>>>>> 4c3551e80c00387da2d5474371c72ac747dde462

    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }
}