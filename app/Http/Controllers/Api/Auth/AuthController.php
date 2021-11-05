<?php

namespace App\Http\Controllers\Api\auth;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'verifyToken', 'register']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'   => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {;
            return $this->respondWithToken($token);
        }

        return response()->json(['message' => 'Invalid Credentials'], 401);
    }

    /**
     * Register Person via email,first_name,last_name,email,password,password_confirmation field
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return object User
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|between:2,100',
            'last_name' => 'required|string|between:2,100',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'

        ]);

        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password =  Hash::make($request->password);

        if (!$user->save()) {

            return response()->json(['message' => 'Opps!! Something Went Wrong on Creating Account'], 500);
        }

        return response()->json(['message' => 'Successfully User Account Created', 'person' => $user]);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }



    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }

    public function verifyToken()
    {
        try {


            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false,  'message' => 'Token is Invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false,  'message' => 'Token is Expired']);
            } else {
                return response()->json(['success' => false,  'message' => 'Authorization Token not found']);
            }
        }

        // the token is valid and we have found the user
        return response()->json(['success' => true, 'message' => 'Token is valid',], 200);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user =  $this->guard()->user();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
            'user' => $user,

        ]);
    }
}
