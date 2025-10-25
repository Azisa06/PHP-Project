<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = ['data'];

    // Relacionamento com os itens de venda
    public function itens()
    {
        return $this->hasMany(ItemVenda::class);
    }

    /**
     * Calcula o valor total da venda.
     * Necessário para a view index/show.
     */
    public function getPrecoTotalAttribute()
    {
        return $this->itens->sum(function ($item) {
            return $item->quantidade * $item->preco_venda;
        });
    }
}