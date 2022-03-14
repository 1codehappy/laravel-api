<?php

dataset('password-payloads', function () {
    return [
        ['password - null' => ['password' => null, 'password_confirmation' => 'secret1234']],
        ['password - empty' => ['password' => '', 'password_confirmation' => 'password']],
        ['password confirmation - null' => ['password' => 'secret1234', 'password_confirmation' => null]],
        ['password confirmation - empty' => ['password' => 'password', 'password_confirmation' => '']],
        ['password - different inputs' => ['password' => 'password', 'password_confirmation' => 'secret1234']],
        ['password - min length: 8' => ['password' => 'test', 'password_confirmation' => 'test']],
    ];
});
