<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemVenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'venda_id',
        'produto_id',
        'quantidade',
        'preco_venda', // Preço pelo qual o produto foi vendido
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->quantidade * $this->preco_venda;
    }
}