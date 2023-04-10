<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;
    
    //Modificar campos
    //são campos que são propriedades do model

    protected $fillable = [
        'nome',
        'idade'
    ];

    protected $primaryKey = 'id';
    protected $table = 'clientes';

    public $timestamps = false;
}
