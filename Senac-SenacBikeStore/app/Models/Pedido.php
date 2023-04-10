<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    protected $fillable = [
        'statusdopedido',
        'datadopedido',
        'datarequisitada',
        'datadaentrega'
    ];
    protected $primaryKey = 'pkpedido';

    public $timestamps = false;
    public $incrementing = true;

    public function cliente() {
        return $this->belongsTo(Cliente::class, 'fkcliente');
    }

    public function itemDoPedido() {
        return $this->hasMany(ItensDoPedido::class, 'fkpedido');
    }
}
