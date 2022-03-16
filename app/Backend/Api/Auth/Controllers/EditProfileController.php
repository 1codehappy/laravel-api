<?php

namespace App\Backend\Api\Auth\Controllers;

use App\Backend\Api\Auth\Requests\ProfileUpdate;
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
     * Edit user's profile
     *
     * @param ProfileUpdate $request
     * @return JsonResponse
     */
    public function __invoke(
        ProfileUpdate $request,
        EditUser $action
    ): JsonResponse {
        /** @var \App\Domain\User\Models\User $user */
        $user = Auth::user();
        $dto = UserDto::fromRequest($request);
        $user = DB::transaction(fn () => $action->execute($dto, $user));

        return fractal($user, new UserTransformer())->respond();
    }
}
