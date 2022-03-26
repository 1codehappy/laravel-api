<?php

namespace App\Backend\Api\Auth\Controllers;

use App\Backend\Api\Auth\Requests\ForgotPasswordRequest;
use App\Domain\Auth\Actions\GetResetToken;
use App\Domain\Auth\Actions\SendResetLink;
use App\Support\Auth\Contracts\Documentation\ForgotPasswordController as Documentation;
use App\Support\Auth\DTOs\EmailDto;
use App\Support\Core\Api\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller implements Documentation
{
    /**
     * Send a reset link to the user.
     *
     * @param ForgotPasswordRequest $request
     * @param SendResetLink $sendResetLink
     * @param GetResetToken $getResetToken
     * @return JsonResponse
     */
    public function __invoke(
        ForgotPasswordRequest $request,
        SendResetLink $sendResetLink,
        GetResetToken $getResetToken
    ): JsonResponse {
        $dto = EmailDto::fromRequest($request);
        $status = DB::transaction(fn () => $sendResetLink->execute($dto));
        if ($status !== Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }

        $resetToken = $getResetToken->execute($dto);

        return response()->json([
            'message' => __($status),
            'data' => $resetToken->toArray(),
        ])->setStatusCode(201);
    }
}
