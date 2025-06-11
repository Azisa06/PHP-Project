<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao', 'categoria_id'];

    public function categoria() 
    {
        return $this->belongsTo(CategoriaProduto::class);
    }

    public function itensCompra()
    {
        return $this->hasMany(ItemCompra::class);
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }

    public function estoques()
    {
        return $this->hasMany(Estoque::class);
    }

    public function ultimoEstoque()
    {
        return $this->hasOne(Estoque::class)->latestOfMany();
    }

    public function getEstoqueAtualAttribute()
    {
        return $this->estoques->sum('quantidade');
    }
}
