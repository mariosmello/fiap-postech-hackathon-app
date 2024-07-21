<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can create a user when authenticated and login', function () {

    $user = \App\Models\User::factory()->create();
    $token = auth()->login($user);

    $data = [
        'name' => fake()->name,
        'email' => fake()->email,
        'password' => fake()->password,
    ];

    // 201 http created
    $this->postJson('/api/users/create',$data,[
        'Authorization' => 'Bearer ' . $token
    ])->assertStatus(201);

    $response = $this->postJson('/api/login', [
        'email' => $data['email'],
        'password' => $data['password']
    ]);
    $response->assertStatus(200);

    expect($response->content())
        ->json()
        ->token_type->toBe('bearer');

});

it('cant create a user when unauthenticated', function () {

    $data = [
        'name' => fake()->name,
        'email' => fake()->email,
        'password' => fake()->password,
    ];

    // 201 http created
    $this->postJson('/api/users/create',$data,[
        'Authorization' => 'Bearer 123'
    ])->assertStatus(401);

});
