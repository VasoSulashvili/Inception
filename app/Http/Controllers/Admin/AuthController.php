<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\LoginRequest;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function login(LoginRequest $request)
    {
        if(!Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return response()->json(['errors' => 'Invalid Credentials!'], 401);
        }

        $user = Admin::where('email', '=', $request->input('email'))->first();
        $token = $user->createToken('auth', ['role:admin'])->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }
}
