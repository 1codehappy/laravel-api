<?php

namespace App\Backend\Api\Permission\Controllers;

use App\Backend\Api\Permission\Transformers\PermissionTransformer;
use App\Domain\Permission\Models\Permission;
use App\Support\Core\Api\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PermissionController extends Controller
{
    /**
     * List permissions
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return fractal(
                Permission::all(),
                new PermissionTransformer()
            )
            ->respond()
        ;
    }
}
