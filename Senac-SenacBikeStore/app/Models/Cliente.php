<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $fillable = [
        'nome',
        'telefone',
        'email',
        'rua',
        'cidade',
        'estado',
        'cep'
    ];
    protected $primaryKey = 'pkcliente';

    public $timestamps = false;
    public $incrementing = true;

    public function pedido() {
        return $this->hasMany(Pedido::class, 'fkcliente');
    }
}
