<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'descricao', 'preco', 'categoria_id'];

    public function categoria() 
    {
        return $this->belongsTo(CategoriaOrcamento::class);
    }
}
