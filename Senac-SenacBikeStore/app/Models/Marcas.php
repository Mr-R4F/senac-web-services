<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marcas extends Model
{
    use HasFactory;

    protected $table = 'marcas';
    protected $fillable = [
        'nomedamarca'
    ];
    protected $primaryKey = 'pkmarca';

    public $timestamps = false;
    public $incrementing = true;
    //dattabase firt (criado primeiro)
    public function produto() {
        $this->hasMany(Produto::class, 'fkmarca');
    }
}
