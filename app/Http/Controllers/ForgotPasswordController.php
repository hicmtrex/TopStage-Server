<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function forgot_stage(Request $request)
    {
        $credentials = request()->validate(['email' => 'required|email']);

        //Password::sendResetLink($credentials);
        // return response()->json(["msg" => 'Reset password link sent on your email id.']);

        $fields = $request->validate([
            'email' => 'required|string',
        ]);
        $user = Stage::where('email', $fields['email'])->first();

        $token = $user->createToken('sara-pfe-user')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];


        return response($response, 200);
    }

    public function reset_stage(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $user = Stage::where('email', $fields['email'])->first();

        if ($user) {
            $user->password = bcrypt($fields['password']);
            $user->save();
            return response($user);
        } else {
            return "Error";
        }
    }

    public function forgot_user(Request $request)
    {
        // $credentials = request()->validate(['email' => 'required|email']);

        // Password::sendResetLink($credentials);
        // return response()->json(["msg" => 'Reset password link sent on your email id.']);

        $fields = $request->validate([
            'email' => 'required|string',
        ]);
        $user = User::where('email', $fields['email'])->first();

        $token = $user->createToken('sara-pfe-user')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];


        return response($response, 200);
    }

    public function reset_user(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if ($user) {
            $user->password = bcrypt($fields['password']);
            $user->save();
            return response($user);
        } else {
            return "Error";
        }
    }
}
