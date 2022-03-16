<?php

dataset('user-sorts', function () {
    return [
        ['order by name asc' => 'name'],
        ['order by name desc' => '-name'],
        ['order by email asc' => 'email'],
        ['order by email desc' => '-email'],
        ['order by creation date asc' => 'created_at'],
        ['order by creation date desc' => '-created_at'],
        ['order by last update asc' => 'updated_at'],
        ['order by last update desc' => '-updated_at'],
        ['order by name asc and email asc' => 'name,email'],
        ['order by name asc and email desc' => 'name,-email'],
        ['order by name desc and email asc' => '-name,email'],
        ['order by last update desc and name asc' => '-updated_at,name'],
    ];
});
