<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Resources\v1\CategoriaResource;
use App\Http\Requests\v1\StoreCategoriaRequest;
use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoriaController extends Controller
{
    /**
     *  @OA\Get(
     *      path="/api/categorias",
     *      operationId="getCategoriasList",
     *      tags={"Categorias"},
     *      summary="Retorna a lista de Categorias",
     *      description="Retona o JSON da lista de Categorias",
     *      @OA\Response(
     *          response=200,
     *          description="Operação executada com sucesso"
     *      )
     *  )
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
     *  @OA\Post(
     *      path="/api/categorias",
     *      operationId="storeCategoria",
     *      tags={"Categorias"},
     *      summary="Cria uma nova Categoria",
     *      description="Retona o JSON com os dados da nova Categoria",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreCategoriaRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operação executada com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/Categoria")
     *      )
     *  )
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
     *  @OA\Get(
     *      path="/api/categorias/{id}",
     *      operationId="getCategoriaById",
     *      tags={"Categorias"},
     *      summary="Retorna a informação de uma categoria",
     *      description="Retona o JSON da Categoria requisitada",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id da Categoria",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operação executada com sucesso",
     *      )
     *  )
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
     *  @OA\Patch(
     *      path="/api/categorias/{id}",
     *      operationId="updateCategoria",
     *      tags={"Categorias"},
     *      summary="Atualiza uma Categoria existente",
     *      description="Retona o JSON da Categoria atualizada",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id da Categoria",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCategoriaRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operação executada com sucesso",
     *      )
     *  )
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
     *  @OA\Delete(
     *      path="/api/categorias/{id}",
     *      operationId="deleteCategoria",
     *      tags={"Categorias"},
     *      summary="Apaga uma Categoria existente",
     *      description="Apaga uma Categoria existente e não há retorno de dados",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id da Categoria",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operação executada com sucesso",
     *          @OA\jsonContent()
     *      )
     *  )
     */

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
