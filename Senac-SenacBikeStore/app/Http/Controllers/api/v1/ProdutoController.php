<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ProdutoResource;
use App\Http\Requests\v1\StoreProdutoRequest;
use App\Models\Produto;
use Illuminate\Http\Request;

use Illuminate\Support\Str;


class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    public function index(Request $request) //PAGINAÇÃO
    {
        $input = $request->input('pagina'); //captura a entrada

        $query = Produto::with('categoria', 'marca'); //traz categoria e marca junto a paginação

        if($input) {  //se manduo algo 
            $page = $input;//recebe a página definida pelo user
            $perPage = 10; //qtd por página
            $query->offset(($page - 1) * $perPage)->limit($perPage);
            $produtos = $query->get();

            $recordsTotal = Produto::count();//conta os elementos do array
            $numberOfPages = ceil($recordsTotal / $perPage);
            $response = response()->json([
                'status' => 200,
                'mensagem' => 'Lista de produtos retornada',
                'produos' => ProdutoResource::collection($produtos),
                'meta' => [
                    'total_numero_de_registros' => (string) $recordsTotal,
                    'numero_de_registro_por_pagina' =>  (string) $recordsTotal,
                    'numero_de_paginas' => (string) $numberOfPages,
                    'pagina_atual' => $page
                ]
            ], 200);
        } else {
            $produtos = $query->get();

            $response = response()->json([
                'status' => 200,
                'mensagem' => 'Lista de produtos retornada',
                'produos' => ProdutoResource::collection($produtos)
            ], 200);

            return $response;
        }

        $produtos = Produto::all(); //chama método estático

        return response()->json([
            'Status' => 200,
            'Mensagem' => 'Lista de produtos retornadas',
            'Categorias' => ProdutoResource::collection($produtos) //pega o json do usuário
        ], 200);

        //ordernar 
        //paginar (pegar bloco)
        //filtrar pegar algo especifico (evita stress do banco)
        //nome e val do campo
    } */

    /* public function index(Request $request) //FILTRO
    {
        //trabalha com o filtro de entrada
        $query = Produto::with('categoria', 'marca');

        $filterParameter = $request->input('filtro');

        if($filterParameter === null) {
            //retorna todos os produtos   
            $produtos = $query->get();

            $response = response()->json([
                'status' => 200,
                'mensagem' => 'Listagem de produtos retornada',
                'produtos' => ProdutoResource::collection($produtos)
            ], 200);
            return $response;
        } else {
            //obtém o nome do filtro e o criterio
            [$filteCriteria, $filterValue] = explode(':', $filterParameter);
            if($filteCriteria === 'nome_da_categoria') {
                //faz inner join para obter a categoria

                $produtos = $query->join('categorias', 'pkcategoria', '=', 'fkcategoria')
                    ->where('nomedacategoria', '=', $filterValue)->get();
                
                $response = response()->json([
                    'status' => 200,
                    'mensagem' => 'Listagem de produtos retornada',
                    'produtos' => ProdutoResource::collection($produtos)
                ], 200);
                return $response;
            } else {
                //usuário chamou um filtro que não existe  
                $response = response()->json([
                    'status' => 406,
                    'mensagem' => 'Filtro não aceita',
                    'produtos' => []
                ], 406);
                return $response;
            }
        }
    } */

    public function index(Request $request) //TUDO JUNTO
    {
        //trabalha com o filtro de entrada
        $query = Produto::with('categoria', 'marca');
        $mensagem = 'Lista de produtos retornada';
        $codigoDeRetorno = 0;

        //realiza o processamento do filtro
        //Obtém o parametro do filtro
        $filterParameter = $request->input('filtro');

        if($filterParameter === null) {
            //retorna todos os produtos & Default
            $mensagem = 'Lista de produtos retornada - completa';
            $codigoDeRetorno = 200;
        } else {
            //obtém o nome do filtro e o criterio
            [$filteCriteria, $filterValue] = explode(':', $filterParameter);

            //se o filtro está adequado
            if($filteCriteria === 'nome_da_categoria') {
                //faz inner join para obter a categoria

                $produtos = $query->join('categorias', 'pkcategoria', '=', 'fkcategoria')
                    ->where('nomedacategoria', '=', $filterValue)->get();

                $mensagem = 'Lista de produtos retornada - filtrada';
                $codigoDeRetorno = 200;
            } else {
                //usuário chamou um filtro que não existe, então não há nada a retornar (erro 406 - not  accepted)
               $produtos = [];
               $mensagem = 'Filtro não aceito';
               $codigoDeRetorno = 200;
            }
        }

        if($codigoDeRetorno === 200) {
            //realiza o processamento da ordenação
            $sorts = explode(',', $request->input('ordenacao', ''));

            foreach ($sorts as $sortColumn) {
                $sortDirection = Str::startsWith($sortColumn, '-') ? 'DESC' : 'ASC';
                $sortColumn = ltrim($sortColumn, '-');

                switch ($sortColumn) {
                    case 'nome_da_produto':
                        $query->orderBy('nomedoproduto', $sortDirection);
                        break;

                    case 'ano_do_modelo':
                        $query->orderBy('anodomodelo', $sortDirection);
                        break;

                    case 'preco_da_lista':
                        $query->orderBy('precodalista', $sortDirection);
                        break;
                    
                    default:
                        break;
                }
            }
            $mensagem = $mensagem . '+Ordenada';
        }

        //realiza o processamento da paginação

        $input = $request->input('pagina');

        if($input) {
            $page = $input;
            $perPage = 10;
            $query->offset(($page - 1) * $perPage)->limit($perPage);
            $produtos = $query->get();

            $recordsTotal = Produto::count();
            $numberOfPages = ceil($recordsTotal / $perPage);
            $mensagem = $mensagem . '+Paginada';
        }

        if($codigoDeRetorno === 200) {
            $produtos = $query->get();

            $response = response()->json([
                'status' => 200,
                'mensagem' => $mensagem,
                'produtos' => ProdutoResource::collection($produtos)
            ], 200);
        } else {
            $response = response()->json([
                'status' => 406,
                'mensagem' => $mensagem,
                'produtos' => $produtos
            ], 406);
        }
        return $response;
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
    public function show($categoriaId)
    {
      
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
