<?php

namespace App\Domain\Auth\Actions;

use App\Support\Auth\DTOs\EmailDto;
use App\Support\Auth\DTOs\ResetTokenDto;
use Illuminate\Support\Facades\Cache;

class GetResetToken
{
    /**
     * Get the last token created to reset the password.
     *
     * @param EmailDto $dto
     * @return ResetTokenDto
     */
    public function execute(EmailDto $dto): ResetTokenDto
    {
        $token = Cache::get($dto->email);

        return new ResetTokenDto([
            'email' => $dto->email,
            'token' => $token,
        ]);
    }
}
