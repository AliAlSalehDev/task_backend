<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Common\SharedMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Traits\Api\SharedMessageTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use SharedMessageTrait;

    public function register(RegisterRequest $request): JsonResponse
    {
        $registerUserData = $request->validated();
        $user = User::create([
            'name' => $registerUserData['name'],
            'email' => $registerUserData['email'],
            'password' => Hash::make($registerUserData['password']),
        ]);
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;

        $data = [
            "token" => $token,
            "user" => $user
        ];
        return $this->handleSharedMessage(new SharedMessage(__('success.register_successful'), $data, true, null, 200));
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $loginUserData = $request->validated();
        $user = User::where('email',$loginUserData['email'])->first();
        if(!$user || !Hash::check($loginUserData['password'],$user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        $data = [
            "token" => $token,
            "user" => $user
        ];
        return $this->handleSharedMessage(new SharedMessage(__('success.login_successful'), $data, true, null, 200));
    }
}
