<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function users(Request $request){

        $users = DB::table('users')->get();

        return view('users.users', [
            'user' => Auth::guard('web')->user(),
            'users' => $users
        ]);
    }
}
