<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensDoPedido extends Model
{
    use HasFactory;

    protected $table = 'itensdopedido';
    protected $fillable = [
        'quantidade',
        'precodelista',
        'desconto',
    ];
    protected $primaryKey = 'pkitemdopedido';

    public $timestamps = false;
    public $incrementing = true;

    public function pedido() {
        return $this->belongsTo(Pedido::class, 'fkpedido');
    }

    public function produto() {
        return $this->belongsTo(Produto::class, 'fkproduto');
    }
}
