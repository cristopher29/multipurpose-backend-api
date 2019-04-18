<?php

namespace App\Http\Controllers\Web;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function users(Request $request){

        $users = User::get();
        $data = array();

        foreach ($users as $user){

            $token = $user->api_token;
            $payload = JWTAuth::manager()->decode(new Token($token));
            $expires_at = Carbon::createFromTimestamp($payload->get('exp'))
                ->timezone(Config::get('app.timezone'))
                ->format( "d/m/Y H:i");

            array_push($data, array('user' => $user, 'token' => $token, 'time'=> $expires_at));
        }

        return view('users.users', [
            'user' => auth('web')->user(),
            'users_data' => $data
        ]);
    }
}
