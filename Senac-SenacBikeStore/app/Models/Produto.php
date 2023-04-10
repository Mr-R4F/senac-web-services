<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';
    protected $fillable = [
        'nomedoproduto',
        'anodomodelo',
        'precodelista'
    ];
    protected $primaryKey = 'pkproduto';

    public $timestamps = false;
    public $incrementing = true;

    public function categoria() {
        return $this->belongsTo(Categoria::class, 'fkcategoria');
    }

    public function marca() {
        return $this->belongsTo(Marcas::class, 'fkmarca');
    }

    public function itemDoPedido() {
        return $this->hasMany(itemDoPedido::class, 'fkproduto');
    }
}
