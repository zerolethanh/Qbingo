<?php

namespace App\Http\Controllers;

use App\Happy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HappyController extends Controller
{

    function __construct()
    {

    }

    public function index()
    {
        //
        if (Auth::check()) {
            return $this->login(request());
        }
        return view('happy.index');
    }

    public function login(Request $request)
    {

        if (Auth::check()) {
            $login_succ = true;
        } else {
            $this->validate($request, [
                'happy_id' => 'required|exists:happies',
                'password' => 'required'
            ]);
            $credentials['happy_id'] = $request->happy_id;
            $credentials['password'] = $request->password;
            $login_succ = Auth::attempt($credentials, true, true);//remember & login
        }
        if ($login_succ) {
            $user = Auth::user();
            $uploads = $user->uploads()->get();
        }
//        return compact('login_succ', 'user', 'uploads');



        return view('bingo.control');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
