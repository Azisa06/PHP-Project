<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;
    protected $fillable = ['data', 'descricao', 'preco', 'servico_id', 'cliente_id', 'status_id'];

    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function statusOrcamento()
    {
        return $this->belongsTo(StatusOrcamento::class, 'status_id');
    }
}