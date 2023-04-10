<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProdutoResource;
use App\Http\Requests\StoreProdutoRequest;
use App\Models\Produto;

//use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produtos = Produto::all(); //chama método estático

        return response()->json([
            'Status' => 200,
            'Mensagem' => 'Lista de produtos retornadas',
            'Categorias' => ProdutoResource::collection($produtos) //pega o json do usuário
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
    public function store(StoreProdutoRequest $request)
    {
        $produtos = new Produto();
        $produtos->nomedoproduto = $request->nome_do_produto;
        $produtos->anodomodelo = $request->ano_do_modelo;
        $produtos->precodalista = $request->nome_da_lista;
        $produtos->save();

        return response()->json([
            'Status' => 200,
            'Mensagem' => 'Produto criado',
            'Marcas' => new ProdutoResource($produtos) //formata a saída
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProdutoRequest $request, Produto $produto)
    {
        $produtos = Produto::find($produto->pkproduto);
        $produtos->nomedoproduto = $request->nome_do_produto; //pega a mesma validação
        $produtos->anodomodelo = $request->ano_do_modelo; //pega a mesma validação
        $produtos->precodalista = $request->preco_da_lista; //pega a mesma validação
        $produtos->update();

        return response()->json([
            'Status' => 200,
            'Mensagem' => 'Produto atualizado',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreProdutoRequest $produto)
    {
        $produto->delete();

        return response()->json([
            'Status' => 200,
            'Mensagem' => 'Produto apagado',
        ], 200);
    }
}
