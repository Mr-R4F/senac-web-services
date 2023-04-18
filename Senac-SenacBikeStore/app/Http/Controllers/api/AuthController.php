<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['register', 'login']]);
    }

    public function register(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email'=> 'required|email:rfc,dns',
            'password'=> 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password)
        ]);

        $token = $user->createToken('Laravel-10-Passport-Auth')->accessToken;
        return response()->json(['token' => $token], 200);
    }

    public function login(Request $request) {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(auth()->attempt($data)) {
            $token = auth()->user()->createToken('Laravel-10-Passport-Auth')->accessToken;
            return response()->json(['token', $token], 200);
        } else {
            return response()->json(['error', 'Unauthorised'], 200);
        }
    }

    public function logout(Request $request) {
        $accessToken = auth()->user()->token();
        $token = $request->user()->tokens->find($accessToken);
        $token->revoke();
        
        return response()->json(['token' =>'You have been successfully logged out'], 200);
    }

    public function userInfo() {
        $user = auth()->user();

        return response()->json(['user' => $user], 200);
    }
}
