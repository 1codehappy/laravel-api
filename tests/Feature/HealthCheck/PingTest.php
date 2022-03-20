<?php

it('pings to the pong response.', function () {
    $this->json('GET', '/ping')
        ->assertStatus(200)
        ->assertJson(['pong' => true]);
});
