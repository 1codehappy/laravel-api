<?php

namespace App\Support\Auth\DTOs;

use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class ResetTokenDto extends CastableDataTransferObject
{
    /**
     * The user's email.
     *
     * @var string
     */
    public string $email;

    /**
     * The reset token for the password.
     *
     * @var string
     */
    public string $token;
}
