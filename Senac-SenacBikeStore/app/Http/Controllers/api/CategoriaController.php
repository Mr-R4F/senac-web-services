<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\CategoriaResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) //ORDERNAÇÃO
    {
        $sortParameter = $request->input('ordernacao', 'nome_da_categoria');
        $sortDirection = Str::startsWith($sortParameter, '-') ? 'DESC' : 'ASC';
        $sortColumn = ltrim($sortParameter);

        $categorias = $sortColumn === 'nome_da_categoria' ? Categoria::orderBy('nomedacategoria', $sortDirection)->get() : Categoria::all();

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
    public function show($categoriaId)
    {
        try { //código que consome o recurso

            //validação de entrada para ter certeza que o valor é numérico
            $validator = Validator::make([
                'id' => $categoriaId
            ],[
                'id' => 'integer'
            ]);

            if($validator->fails()) {
                throw ValidationException::withMessages([
                    'id' => 'O campo id deve ser númerico'
                ]);
            }

            $categoria = Categoria::findorFail($categoriaId); //fizemos o que o web services entrega
            //tratamentos de exeção erros.//para corrigir ou mitigar (evitar o contornar)
           // porque se tem ? pois na computação há recursos que se vai usar mais são recursos escasso (conexão, arquivo em disco, memoria, processamento) n]ao necessáriamente tem recurso para ele
            //no caso de falha pra a falta de recurso (tenta-se evitar um probelma)

            //antecipação para algo não disponivel
            //deixa lenta

            return response()->json([
                'status' => 200,
                'mensagem' => 'Categoria retornada',
                'categoria' => new CategoriaResource($categoria)
            ], 200);
        } catch (\Throwable $err) { //em caso de falha vem para cá
            $class = get_class($err);

            switch ($class) { //verifica o tipo da exeção
                case ModelNotFoundException::class:
                    return response()->json([
                        'status' => 200,
                        'mensagem' => 'Categoria retornada',
                        'categoria' =>[]
                    ], 200);
                    break;

                case \Illuminate\Validation\ValidationException::class:
                    return response()->json([
                        'status' => 406,
                        'mensagem' => $err->getMessage(),
                        'categoria' => []
                    ], 406);
                    break;

                default: //coloca um padrão caso não for esse erros
                    return response()->json([
                        'status' => 500,
                        'mensagem' => 'Erro interno',
                        'categoria' => []
                    ], 500);
                    break;
            }
        }
        //uso paRA MANIPULAR recurso possivel de falha
        //no win não há trycatch (tela azul)
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
