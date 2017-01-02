<?php

namespace App\Http\Controllers;

use App\Happy;
use App\Mail\InviteMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InviteController extends Controller
{
    //

    public function invite(Request $request)
    {
        $this->validate($request, [
            'happy_id' => 'required',
            'happy_code' => 'required'
        ]);

        $happy = Happy::where(request()->only('happy_id', 'happy_code'))->first();

        if ($happy) {
            return view('upload.form')->with(compact('happy'));
        }

        return '招待リンクが不正です。もう一度ご確認ください。';
    }

//    public function send_url()
//    {
//        $url = (new BingoController())->getUrl();
//
//        Mail::to(request('email'))->send(new InviteMail($url));
//
//    }
}
