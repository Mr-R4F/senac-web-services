<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreMarcaRequest;
use App\Http\Resources\v1\MarcaResource;
use App\Models\Marcas;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = Marcas::all(); //chama método estático

        return response()->json([
            'Status' => 200,
            'Mensagem' => 'Lista das marcas retornadas',
            'Marcas' => MarcaResource::collection($marcas) //pega o json do usuário (os dados)
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
    public function store(StoreMarcaRequest $request) //pega requisição
    {
        $marcas = new Marcas();
        $marcas->nomedamarca = $request->nome_da_marca;
        $marcas->save();

        return response()->json([
            'Status' => 200,
            'Mensagem' => 'Marca criada',
            'Marcas' => new MarcaResource($marcas) //formata a saída
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Marcas $marca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marcas $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMarcaRequest $request, Marcas $marca) //recebe o mesmo dado mesma regras pra o update
    {
        $marcas = Marcas::find($marca->pkmarca);
        $marcas->nomedamarca = $request->nome_da_marca; //pega a mesma validação
        $marcas->update();

        return response()->json([
            'Status' => 200,
            'Mensagem' => 'Marca atualizada',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marcas $marcas)
    {
        $marcas->delete();

        return response()->json([
            'Status' => 200,
            'Mensagem' => 'Marca apagada',
        ], 200);
    }
}
