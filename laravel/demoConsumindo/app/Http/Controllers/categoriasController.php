<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client; //chama um 'endpoint' http

class categoriasController extends Controller
{
    //função lista categorias
    public function listarcategorias() {
        $client = new Client(['base_uri' => 'http://hostwind.lucianoconde.net']); //criar cliente e passa uri base
        $response = $client->request('GET', '/disciplinaws202301/demomaster/api/categorias'); //comando a ser enviado - dominio e subdominio
        $saida = json_decode($response->getBody()); //retorna json 
        return view('listarcategorias', ['categorias' => $saida]);// e manda para a view
        //criar apis
    }
}
