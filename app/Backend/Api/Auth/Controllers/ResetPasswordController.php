<?php

namespace App\Backend\Api\Auth\Controllers;

use App\Backend\Api\Auth\Requests\ResetPasswordRequest;
use App\Domain\Auth\Actions\ResetPassword;
use App\Support\Auth\Contracts\Documentation\ResetPasswordController as Documentation;
use App\Support\Auth\DTOs\PasswordDto;
use App\Support\Core\Api\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller implements Documentation
{
    /**
     * Send a reset link to the user.
     *
     * @param ResetPasswordRequest $request
     * @param ResetPassword $action
     * @return JsonResponse
     */
    public function __invoke(ResetPasswordRequest $request, ResetPassword $action): JsonResponse
    {
        $dto = PasswordDto::fromRequest($request);
        $status = DB::transaction(fn () => $action->execute($dto));

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }

        return response()->json([
            'message' => __($status),
        ])->setStatusCode(201);
    }
}
