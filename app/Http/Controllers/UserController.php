<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Personal_access_token;



class UserController extends Controller
{
    public function signup(Request $request)
    {
        $username = $request->username;
        $email = $request->email;
        $password = $request->password;
        $existUser = User::where("email", $email)->first();
        if (!$existUser) {
            try {
                $user = User::create([
                    'name' => $username,
                    'email' => $email,
                    'password' => $password
                ]);
                return ['message' => 'success'];
            } catch (\Throwable $th) {
                return ['message' => 'failure'];
            }
        } else {
            return ['message' => 'Already signed Up Please Login'];
        }

    }

    public function login(Request $request)
    {
        $data = $request->only(['email', 'password']);
        if (Auth::attempt($data)) {
            $user = Auth::User();
            $tokens = $user->createToken('MyApp')->accessToken;
            $token = $tokens->token;
            return response()->json(['user' => $user, 'token' => $token], 200);
        }
        return response(['message' => 'Provided email or password is incorrect'], 401);
    }

    public function logout(Request $request)
    {
        $requestToken = $request->header('Authorization');
        $tokenId = Personal_access_token::where('token', $requestToken)->first();
        if ($tokenId) {
            Personal_access_token::where('token', $requestToken)->delete();
            return response()->json(['message' => 'Successfully logged out'], 200);
        }
        return response(['message' => 'Please Login first'], 401);

    }
}
