<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = ['data'];

    public function itens()
    {
        return $this->hasMany(ItemCompra::class);
    }

    public function getTotalAttribute()
    {
        return $this->itens->sum(function ($item) {
            return $item->quantidade * $item->preco_unitario;
        });
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
