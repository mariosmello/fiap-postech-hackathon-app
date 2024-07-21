<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);


it('user can login', function () {

    $user = \App\Models\User::factory()->create();
    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password'
    ]);
    $response->assertStatus(200);

    expect($response->content())
        ->json()
        ->token_type->toBe('bearer');

});

it('user cant login', function () {

    $user = \App\Models\User::factory()->create();
    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'pass'
    ]);
    $response->assertUnauthorized();

});
