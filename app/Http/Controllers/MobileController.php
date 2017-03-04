<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileController extends Controller
{
    /**
     * login redirect
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function bingo(){
        return redirect('/');
    }

    function rec2()
    {
        return view('mobile.rec2');
    }

    function quiz()
    {
        return view('mobile.quiz');
    }

    function start()
    {
        return view('mobile.start');
    }

    function pdf()
    {
        return view('mobile.pdf');
    }
}

