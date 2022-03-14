<?php

dataset('permission-sorts', function () {
    return [
        ['order by name asc' => 'name'],
        ['order by name desc' => '-name'],
        ['order by creation date asc' => 'created_at'],
        ['order by creation date desc' => '-created_at'],
        ['order by last update asc' => 'updated_at'],
        ['order by last update desc' => '-updated_at'],
        ['order by last update desc and name asc' => '-updated_at,name'],
    ];
});
