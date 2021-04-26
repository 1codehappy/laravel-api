<?php

namespace App\Backend\Api\Auth\Controllers;

use App\Support\Core\Api\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        Auth::logout();

        return response()->json([
            'message' => 'Successfully logged out.',
        ]);
    }
}
