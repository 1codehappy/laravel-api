<?php

use function Pest\Faker\faker;

dataset('forgot-password-payloads', function () {
    return [
        ['email - null' => ['email' => null]],
        ['email - empty' => ['email' => '']],
        ['email - invalid' => ['email' => faker()->name]],
        ['email - not registered' => ['email' => faker()->email]],
    ];
});
