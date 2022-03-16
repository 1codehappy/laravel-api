<?php

use Illuminate\Support\Str;

use function Pest\Faker\faker;

dataset('user-payloads', function () {
    return [
        ['name - max length: 255' => ['name' => Str::repeat('a', 256), 'email' => faker()->email]],
        ['roles - not array' => ['name' => faker()->name, 'email' => faker()->email, 'roles' => 'roles']],
        ['roles - not uuid' => ['name' => faker()->name, 'email' => faker()->email, 'roles' => [faker()->md5()]]],
        ['roles - not exists' => ['name' => faker()->name, 'email' => faker()->email, 'roles' => [faker()->uuid()]]],
        ['permissions - not array' => ['name' => faker()->name, 'email' => faker()->email, 'permissions' => 'permissions']],
        ['permissions - not uuid' => ['name' => faker()->name, 'email' => faker()->email, 'permissions' => [faker()->md5()]]],
        ['permissions - not exists' => ['name' => faker()->name, 'email' => faker()->email, 'permissions' => [faker()->uuid()]]],
    ];
});
