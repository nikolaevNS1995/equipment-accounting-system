<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Система управления учета оборудования и мебели",
 *     version="1.0.0"
 * ),
 * @OA\PathItem(
 *     path="/api/"
 * ),
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="bearer"
 *     )
 * )
 */
abstract class Controller
{
    //
}
