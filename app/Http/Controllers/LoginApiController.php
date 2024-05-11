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
            $user = Auth::user();
            $role = $user->role;

            $user = User::where('email', $credentials['email'])->first();

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

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Password reset link sent'])
            : response()->json(['error' => $status], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                // event(new PasswordReset($user)); // Uncomment this line if you have defined PasswordReset event
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password has been reset successfully'])
            : response()->json(['error' => $status], 400);
    }
}
