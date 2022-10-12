<?php

namespace App\Http\Middleware\Jwt;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtInit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            if ($e instanceof TokenExpiredException) {
                // refrescar eltoken si ya expiro
                $newToken = JWTAuth::parseToken()->refresh();
                $request->headers->set('Authorization', 'Bearer' . $newToken);
                $response = $next($request);
                $response->headers->set('Authorization', $newToken);
                return $response;
            }else if ($e instanceof TokenInvalidException) {  // token invalido
                return response()->json(['mensaje' => 'token no valido'],  401);
            }else if($e instanceof TokenBlacklistedException) {
                return response()->json(['mensaje' => 'token black list'], 401);
            }else{
                return response()->json(['mensaje' => 'token no found'],   401);
            }
        }
        return $next($request);
    }
}