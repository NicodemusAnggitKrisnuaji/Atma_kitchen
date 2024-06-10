<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = User::where('email', $credentials['email'])->first();
            $role = $user->role;

            if (in_array($role, ['Customer', 'MO'])) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Login Success',
                    'data' => $user
                ], 200);
            } else {
                Auth::logout();
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid Role',
                    'data' => null
                ], 401);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid email or password',
                'data' => null
            ], 401);
        }
    }

    public function actionLogout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logout Successful']);
    }
    
}
