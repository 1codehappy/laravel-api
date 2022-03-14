<?php

dataset('profile-payloads', function () {
    return [
        ['email - null' => ['name' => 'Bob Marley', 'email' => null]],
        ['email - empty' => ['name' => 'Peter Tosh', 'email' => '']],
        ['name - null' => ['name' => null, 'email' => 'bob@example.com']],
        ['name - empty' => ['name' => '', 'email' => 'peter@example.com']],
    ];
});
