<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoEstoque extends Model
{
    use HasFactory;

    protected $fillable = ['produto_id', 'quantidade', 'tipo', 'descricao'];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}