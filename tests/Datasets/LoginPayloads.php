<?php

dataset('login-payloads', function () {
    return [
        ['email - null' => ['email' => null, 'password' => 'secret1234']],
        ['email - empty' => ['email' => '', 'password' => 'test']],
        ['password - null' => ['email' => 'bob@example.com', 'password' => null]],
        ['password - empty' => ['email' => 'peter@example.com', 'password' => '']],
    ];
});
