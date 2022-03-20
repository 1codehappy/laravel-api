<?php

namespace App\Backend\Api\Auth\Controllers;

use App\Backend\Api\Auth\Requests\EditProfileRequest;
use App\Backend\Api\User\Transformers\UserTransformer;
use App\Domain\User\Actions\EditUser;
use App\Support\Core\Api\Controllers\Controller;
use App\Support\User\DTOs\UserDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EditProfileController extends Controller
{
    /**
     * Edit the user's profile.
     *
     * @param EditProfileRequest $request
     * @return JsonResponse
     */
    public function __invoke(
        EditProfileRequest $request,
        EditUser $action
    ): JsonResponse {
        /** @var \App\Domain\User\Models\User $user */
        $user = Auth::user();
        $dto = UserDto::fromRequest($request);
        $user = DB::transaction(fn () => $action->execute($dto, $user));

        return fractal($user, new UserTransformer())->respond();
    }
}
