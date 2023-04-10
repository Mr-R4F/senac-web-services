<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\CategoriaResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all(); //chama método estático

        return response()->json([
            'Status' => 200,
            'Mensagem' => 'Lista das categorias retornadas',
            'Categorias' => CategoriaResource::collection($categorias) //pega o json do usuário
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request) //pega requisição
    {
        $categoria = new Categoria();
        $categoria->nomedacategoria = $request->nome_da_categoria;
        $categoria->save();
        return response()->json([
            'Status' => 200,
            'Mensagem' => 'Categoria criada',
            'Categoria' => new CategoriaResource($categoria) //formata a saída
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoriaRequest  $request, Categoria $categoria) //recebe o mesmo dado mesma regras pra o update
    {
        $categoria = Categoria::find($categoria->pkcategoria);
        $categoria->nomedacategoria = $request->nome_da_categoria; //pega a mesma validação
        $categoria->update();

        return response()->json([
            'Status' => 200,
            'Mensagem' => 'Categoria atualizada',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return response()->json([
            'Status' => 200,
            'Mensagem' => 'Categoria apagada',
        ], 200);
    }
}
//recebe do suário e envia json do usuário request response
//
//with -> faz o select innet outer join (faz o cruzamento de tavbelas)
//pedido pois não existe item s/ pedido
