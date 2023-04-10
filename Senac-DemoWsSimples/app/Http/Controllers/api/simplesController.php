<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class simplesController extends Controller
{
    public function receber(Request $request) {
        $resultado = $request->valor;

        return response()->json([ //GERA RESPONSE DO TIPO JSON E FORMATA DO JEITO QUE SE QUER
            'status' => 200,
            'mensagem' => 'método executado com sucesso',
            '2' => sqrt(8),
            'resultado' => $resultado
        ], 200); //código real de erro (um é uma coisa o conteudo é outrar)
        //basicamente modificações
        //os verbos começam a virar linhas de apis
        //e de onde surgia o 'api' -> vem da rota api (especialmente do routeServiceProvideer) que diz que se está trabalhando com apis caso contrário redireciona para as rotas de web
        //pq o prefixo cobra ou body que pode-se enviar coisas
        //php artisan route: list mostra todas as rotas no php
    }
}
