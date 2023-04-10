<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

//FAZ LIGAÇÃO ENTRE MODEL E VIEW (PRINCIPA LLIGAÇÃO)
//RECURSO ->controllers
//verbo caminho ação
//serve de roteamento
//ideial para separar estruturas
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
