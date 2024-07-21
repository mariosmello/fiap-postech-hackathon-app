<?php

test('the create user request check false auth', function () {

    \Illuminate\Support\Facades\Auth::shouldReceive('check')
        ->once()
        ->andReturn(false);

    $request = new \App\Http\Requests\CreateUserRequest();

    expect($request->authorize())->toBeFalse();

});

test('the create user request check true auth', function () {

    \Illuminate\Support\Facades\Auth::shouldReceive('check')
        ->once()
        ->andReturn(true);

    $request = new \App\Http\Requests\CreateUserRequest();

    expect($request->authorize())->toBeTrue();

});
