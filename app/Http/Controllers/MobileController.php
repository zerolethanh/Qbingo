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
//        $pdf = PDF::loadView('mobile.pdf_printed', compact('uploads'));
//        return $pdf->download('mobile.pdf');

    }

    function upload_jpeg_dataurl(Request $request)
    {
        $jpeg_dataurl = $request->jpeg_dataurl;

        list($type, $jpeg_dataurl) = explode(';', $jpeg_dataurl);
        list(, $jpeg_dataurl) = explode(',', $jpeg_dataurl);
        $jpeg_dataurl = base64_decode($jpeg_dataurl);

        $download_key = str_random();
        $save_to = $this->saveToPath($download_key);
        if (!is_dir($dir = pathinfo($save_to, PATHINFO_DIRNAME))) {
            mkdir($dir, 0777, true);
        }
        $write = file_put_contents($save_to, $jpeg_dataurl);

        if ($write) {
            return [
                'saved' => true,
                'download_url' => url('/mobile/download_jpeg_dataurl?download_key=' . $download_key)
            ];
        }
        return [
            'saved' => false,
            'err' => true,
            'err_message' => 'can not save to ' . $save_to
        ];
    }

    function saveToPath($download_key)
    {
        return storage_path('temp/' . Auth::user()->happy_id . "_$download_key.jpg");
    }

    function download_jpeg_dataurl(Request $request)
    {
        $download_key = $request->download_key;

        if (is_file($file = $this->saveToPath($download_key))) {
            return response()->download($file);
        }
        return 'file requested not found';
    }

}

