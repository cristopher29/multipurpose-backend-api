<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{

    public function __construct(){

        //$this->middleware('jwt.refresh')->only('refresh');
        $this->middleware('jwt.auth', ['except' => ['login', 'register', 'refresh']]);

    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if(!$token = auth('api')->attempt($credentials)){
            return $this->sendError('jwt-login-credentials', ['Bad credentials'],401);
        }

        return $this->sendResponse($this->prepareToken($token), "Successfully login");

    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password'=> 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('jwt-register-validation', $validator->errors(), 400);
        }


        $user = User::create([
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        $token = auth('api')->fromUser($user);

        DB::table('users')
            ->where('id', $user->id)
            ->update(['api_token' => $token]);

        return $this->sendResponse($this->prepareToken($token), "Successfully register");

    }

    public function logout(Request $request)
    {

        $this->checkToken($request);

        auth('api')->logout();
        return $this->sendResponse([],"Successfully logout");

    }

    public function me(Request $request)
    {
        $this->checkToken($request);

        return $this->sendResponse(auth('api')->user(),"User data");
    }


    public function refresh(Request $request)
    {

        $this->checkToken($request);

        $user = $request->user('api');

        try {
            $token = auth('api')->parseToken()->refresh();
        } catch (JWTException $e) {
            return $this->sendError('jwt-auth',$e->getMessage(), $e->getCode());
        }


        DB::table('users')
            ->where('id', $user->id)
            ->update(['api_token' => $token]);

        return $this->sendResponse($token, "New token");

    }


    protected function checkToken(Request $request)
    {

        if(!auth('api')->parser()->setRequest($request)->hasToken()){
            return $this->sendError('jwt-empty-token',['Token not provided'], 401);
        }

        try{
            auth('api')->checkOrFail();
        }catch (JWTException $e) {
            if($e instanceof TokenExpiredException){
                return $this->sendError('jwt-token-expired',['Token expired'], 401);
            }else if($e instanceof TokenInvalidException){
                return $this->sendError('jwt-token-invalid',['Token invalid'], 401);
            }else if($e instanceof TokenBlacklistedException){
                return $this->sendError('jwt-token-blacklisted',['Token blacklisted'], 401);
            }
        }

        return $this->sendError('jwt-unknown-error',['Unknown error'], 401);
    }

    protected function prepareToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ];
    }

    protected function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    protected function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

}
