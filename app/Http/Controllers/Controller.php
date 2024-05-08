<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *    title="API Title",
 *    version="1.0.0",
 *    description="Description of your API",
 *    @OA\Contact(
 *      email="admin@example.com",
 *      name="Admin"
 *    ),
 *    @OA\License(
 *      name="Apache 2.0",
 *      url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *    )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
