<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'descricao', 'preco', 'servico_id'];

    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }
}