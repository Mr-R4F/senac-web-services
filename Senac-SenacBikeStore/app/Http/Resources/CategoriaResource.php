<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
/*         return parent::toArray($request); */
        return [
            'id' => $this->pkcategoria,
            'nome_da_categoria' => $this->nomedacategoria
        ];
    }
} //exibe o web service (como vai exibir o json de saida)
//aqui muda