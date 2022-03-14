<?php

use Illuminate\Support\Str;

use function Pest\Faker\faker;

dataset('role-payloads', function () {
    return [
        ['name - max length: 255' => ['name' => Str::repeat('a', 256)]],
        ['permissions - not array' => ['name' => faker()->name, 'permissions' => 'permissions']],
        ['permissions - not uuid' => ['name' => faker()->name, 'permissions' => [faker()->md5()]]],
        ['permissions - not exists' => ['name' => faker()->name, 'permissions' => [faker()->uuid()]]],
    ];
});
