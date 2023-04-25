<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $fillable = [
        'nomedacategoria'
    ];
    protected $primaryKey = 'pkcategoria';

    public $timestamps = false;
    public $incrementing = true;
    //database firt (criado primeiro)

    public function produto() {
        $this->hasMany(Produto::class, 'fkcategoria');
    }
}
