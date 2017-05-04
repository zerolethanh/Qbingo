<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $user->load('ticket')
                ->load('ticket.shop')
                ->load('ticket.shop.master');
        }
        $user = collect($user)->toArray();
        unset($user['ticket']['issued_password']);
        unset($user['ticket']['shop']['raw_password']);
        unset($user['ticket']['shop']['remember_token']);
        unset($user['ticket']['shop']['master']['password']);
        unset($user['ticket']['shop']['master']['raw_password']);
        unset($user['ticket']['shop']['master']['remember_token']);
        return $user;
    }
}
