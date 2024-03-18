<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
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
