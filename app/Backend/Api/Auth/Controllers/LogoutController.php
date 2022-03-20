<?php

namespace App\Backend\Api\Auth\Controllers;

use App\Support\Auth\Contracts\Documentation\LogoutController as Documentation;
use App\Support\Core\Api\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller implements Documentation
{
    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        Auth::logout();

        return response()->json(['message' => 'You\'re logged out successfully.']);
    }
}
