<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {


            $user = JWTAuth::parseToken()->authenticate();
            if ($user && in_array($user->user_role, $roles)) {
                return $next($request);
            }else {
                return response()->json(['success' => false,  'message' => 'you are not allowed to access this page']);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false,  'message' => 'Token is Invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false,  'message' => 'Token is Expired']);
            } else {
                return response()->json(['success' => false,  'message' => 'Authorization Token not found']);
            }
        }

    }
}
