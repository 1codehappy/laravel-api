<?php

it('pings to the pong response.', function () {
    $response = $this->get('/ping');
    $response->assertStatus(200)
        ->assertJson(['pong' => true]);
});
