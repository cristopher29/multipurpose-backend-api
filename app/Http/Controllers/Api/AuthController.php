<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(){

        $this->middleware('jwt.refresh')->only('refresh');
        $this->middleware('jwt.auth', ['except' => ['login', 'register', 'refresh']]);

    }

    public function login(Request $request){

        $credentials = $request->only('email', 'password');

        if(!$token = Auth::guard('api')->attempt($credentials)){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->sendResponse($this->prepareToken($token), "Successfully login");

    }

    public function register(Request $request){


        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password'=> 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }


        $user = User::create([
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);
        $user->save();

        $token = Auth::guard('api')->fromUser($user);

        return $this->sendResponse($this->prepareToken($token), "Successfully register");

    }

    public function logout(Request $request){

        Auth::guard('api')->logout();
        return $this->sendResponse([],"Successfully logout");

    }

    public function me(Request $request)
    {
        return $this->sendResponse(JWTAuth::user(),"User data");
    }


    public function refresh(Request $request){

        $token = Auth::guard('api')->fromUser(Auth::guard('api')->user());
        return $this->sendResponse($token, "New token");

    }

    protected function prepareToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ];
    }

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
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
