<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCompra extends Model
{
    use HasFactory;

    protected $fillable = ['compra_id', 'produto_id', 'quantidade', 'preco_compra'];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->quantidade * $this->preco_unitario;
    }

}
