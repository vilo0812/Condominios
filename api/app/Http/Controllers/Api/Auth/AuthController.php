<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
	public function __construct()
    {
        $this->middleware('jwt.init', ['except' => ['login']]);
    }

     public function login()
    { // funcion para crear el token eh iniciar session
        $credentials = request(['email', 'password']);
        $token = JWTAuth::attempt($credentials);
        return !$token ? response()->json(['error' => 'Not Autorization'],400) :
             response()->json(
             	[
             		'access_token' => $token,
             		'token_type' => 'bearer',
                    'user' => new UserResource(User::find(Auth::user()->id)),
                ],
                200);
    }

    public function logout()
    {// destruir session
        try {
	        JWTAuth::parseToken()->invalidate();
	        return response()->json(['mensaje' => 'session it is over ','confirmation' => true],200);

        } catch (JWTException $e) {
        	return  response()->json(['mensaje' => $e, 'status' => 500],500);
        }
    }

    public function me(){
        $user = Auth::user();
        return response()->json(
            [
                'user' => new UserResource($user)
            ],
            200
        );
    }

    public function refresh(){
        $token = Auth::guard()->refresh();
        return response()->json(
			[
				'access_token' => $token,
     			'token_type' => 'bearer',
            	'user' => new UserResource(User::find(Auth::user()->id)),
            ],
            200);
    }
}
