<?php

namespace App\Backend\Api\User\Controllers;

use App\Backend\Api\User\Request\UserRequest;
use App\Backend\Api\User\Transformers\UserTransformer;
use App\Domain\User\Actions\CreateUser;
use App\Domain\User\Actions\DeleteUser;
use App\Domain\User\Actions\EditUser;
use App\Domain\User\Actions\PaginateUser;
use App\Domain\User\Models\User;
use App\Support\Core\Api\Controllers\Controller;
use App\Support\User\DTOs\UserDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * List users
     *
     * @param Request $request
     * @param PaginateUser $action
     * @return JsonResponse
     */
    public function index(Request $request, PaginateUser $action): JsonResponse
    {
        $this->authorize('viewAny', User::class);
        $users = $action->execute(
            $request->get('per_page') ?? 50,
            $request->query()
        );

        return fractal($users, new UserTransformer())
            ->respond();
    }

    /**
     * Show user's info
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        $this->authorize('view', User::class);

        return fractal($user, new UserTransformer())
            ->respond();
    }

    /**
     * Create new user
     *
     * @param UserRequest $request
     * @param CreateUser $action
     * @return JsonResponse
     */
    public function store(UserRequest $request, CreateUser $action): JsonResponse
    {
        $dto = UserDto::fromRequest($request);
        $user = DB::transaction(fn () => $action->execute($dto));

        return fractal($user, new UserTransformer())
            ->respond(201);
    }

    /**
     * Update user's data
     *
     * @param UserRequest $request
     * @param User $user
     * @param EditUser $action
     * @return JsonResponse
     */
    public function update(
        UserRequest $request,
        User $user,
        EditUser $action
    ): JsonResponse {
        $dto = UserDto::fromRequest($request);
        $user = DB::transaction(fn () => $action->execute($dto, $user));

        return fractal($user, new UserTransformer())
            ->respond();
    }

    /**
     * Delete user
     *
     * @param User $user
     * @param DeleteUser $action
     * @return JsonResponse
     */
    public function destroy(User $user, DeleteUser $action): JsonResponse
    {
        $this->authorize('delete', User::class);
        DB::transaction(fn () => $action->execute($user));

        return response()->json([], 204);
    }
}
