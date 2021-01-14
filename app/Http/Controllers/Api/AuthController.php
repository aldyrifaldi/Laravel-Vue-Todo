<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWTAuth as JWTAuthJWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => ['required','string','max:255'],
            'email' => ['required','string','max:255','email','unique:users'],
            'password' => ['required','string','min:8','confirmed']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $request->merge([
            'password' => Hash::make($request->password)
        ]);

        $user = User::create($request->only('username','email','password'));

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'success',
            'data' => $user,
            'meta' => [
                'token' => $token
            ]
        ],Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => ['required','string','email','max:255'],
            'password' => ['required','string','min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!$token = JWTAuth::attempt($request->only('email','password'))) {
            return response()->json([
                'message' => 'unauthorized',
                'errors' => [
                    'roots' => 'Credentials is not valid'
                ]
            ],Response::HTTP_UNAUTHORIZED);
        }
        return response()->json([
            'message' => 'success',
            'data' => Auth::user(),
            'meta' => [
                'token' => $token
            ],
        ],Response::HTTP_CREATED);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'message' => 'logout success',
        ],Response::HTTP_OK);
    }
}
