<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web', ['except' => ['showLogin', 'login']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if (!Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('login');
        }
        return redirect()->route('dashboard.users');
    }

    public function showLogin(Request $request){
        return view('auth.login');
    }
}
