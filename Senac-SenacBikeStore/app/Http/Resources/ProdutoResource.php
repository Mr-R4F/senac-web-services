<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       //return parent::toArray($request);
        return [
            'id' => $this->pkproduto,
            'nome_do_produto' => $this->nomedoproduto,
            'ano_do_modelo' => $this->anodomodelo,
            'preco_da_lista' => $this->precodalista,
            'moeda' => 'USD',
            'categoria' => [
                'id' => $this->pkcategoria,
                'nome_da_categoria' => $this->nomedacategoria
            ],
            'marca' => [
                'id' => $this->pkmarca,
                'nome_da_categoria' => $this->nomedamarca
            ]
        ];
    }
}
