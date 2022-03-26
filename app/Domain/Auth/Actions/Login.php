<?php

namespace App\Domain\Auth\Actions;

use App\Support\Auth\DTOs\LoginDto;
use Illuminate\Support\Facades\Auth;

class Login
{
    /**
     * Generate the JWT token.
     *
     * @param LoginDto $dto
     * @return string
     */
    public function execute(LoginDto $dto): string
    {
        return Auth::attempt($dto->toArray());
    }
}
