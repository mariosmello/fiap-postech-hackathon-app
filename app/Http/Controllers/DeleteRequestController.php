<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Models\User;
use App\Models\UserDelete;
use Illuminate\Support\Facades\Auth;

class DeleteRequestController extends Controller
{

    public function store(DeleteUserRequest $request)
    {
        $user_delete = new UserDelete();
        $user_delete->user_id =  Auth::id();
        $user_delete->phone = $request->get('phone');
        $user_delete->address = $request->get('address');
        $user_delete->ip_address = $request->ip();
        $user_delete->save();

        return response()->json([
            'messsage' => "Sua solicitação foi realizada com sucesso. Em breve entraremos em contato."
        ], 201);

    }
}
