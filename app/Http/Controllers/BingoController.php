<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPQRCode\Constants;

class BingoController extends Controller
{
    //

    function __construct()
    {
        $this->middleware('must_logged_in');
    }

    public function index()
    {
        return redirect('/');
    }

    public function uploadList()
    {
        $uploads = Auth::user()->uploads->toArray();
        $url = $this->getUrl();
        \PHPQRCode\QRcode::png($url, storage_path('app/qr/' . Auth::user()->happy_uuid . '.png'), Constants::QR_ECLEVEL_L, 4, 2);
        return view('bingo.uploadList')->with(compact('uploads', 'url'));
    }

    public function getUrl()
    {
        $happy_id = Auth::user()->happy_id;
        $happy_code = Auth::user()->happy_code;

        $query = http_build_query(get_defined_vars());
        $url = url('/invite?' . $query);//InviteControllerへ
        return $url;
    }

    public function quiz()
    {
        return view('bingo.quiz');
    }

    public function start()
    {
        return view('bingo.start');
    }
}
