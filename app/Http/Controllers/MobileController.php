<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobileController extends Controller
{
    /**
     * login redirect
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function bingo()
    {
        return redirect('/');
    }

    function rec2()
    {
        session(['upload_list_view' => 'rec2']);
        return redirect('/bingo/upload-list');
    }

    function rec()
    {
        session(['upload_list_view' => 'rec']);
        return redirect('/bingo/upload-list');
    }

    function quiz()
    {
//        return view('mobile.quiz');
        return redirect('/bingo/quizzes');
    }

    function start()
    {
        return view('mobile.start');
    }

    /**
     * PDFダウンロードページ
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function pdf()
    {
        session(['upload_list_view' => 'pdf']);
        return redirect('/bingo/upload-list');
    }

    function pdf_download()
    {
        $uploads = Auth::user()
            ->uploads()
            ->orderBy('number', 'desc')
            ->get()
            ->toArray();
        return view('mobile.pdf_printed', compact('uploads'));
//        $pdf = PDF::loadView('mobile.pdf', compact('uploads'));
//        return $pdf->download('mobile.pdf');

    }

}

