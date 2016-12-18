<?php

namespace App\Http\Controllers;

use App\Happy;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    //

    public function invite(Request $request)
    {
        $this->validate($request, [
            'happy_id' => 'required',
            'happy_code' => 'required|exists:happies'
        ]);

        $happy = Happy::where(request()->only('happy_id', 'happy_code'))->first();

        if ($happy) {
            return view('upload.form')->with(compact('happy'));
        }
        return 'invalid invitation';
    }

    public function send_url()
    {
        $this->validate(request(),
            ['email' => 'required|email']
        );

        $url = (new BingoController())->getUrl();

        return $url;
    }
}
