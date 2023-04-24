<?php

namespace App\Virtual\Models;

/**
 *  @OA\Schema(
 *      title="Categoria",
 *      description="Modelo da Categoria",
 *      @OA\Xml(
 *          name="Categoria"
 *      )
 *  )
 */

class Categoria
{
/**
 *  @OA\Property(
 *      title="ID",
 *      description="ID da Categoria",
 *      format="int64",
 *      example=1
 *  )
 * 
 * @var integer
 */

    private $id;

    /**
 *  @OA\Property(
 *      title="nome da categoria",
 *      description="Nome da Categoria",
 *      example="Bicicleta"
 *  )
 * 
 * @var string
 */
}
