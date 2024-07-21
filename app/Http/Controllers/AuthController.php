<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthDoctorRequest;
use App\Http\Requests\AuthPatientRequest;

class AuthController extends Controller
{

    public function login_doctor(AuthDoctorRequest $request)
    {
        $credentials = $request->safe()->only(['crm', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function login_patient(AuthPatientRequest $request)
    {
        $credentials = $request->safe()->only(['email', 'document', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }
}
