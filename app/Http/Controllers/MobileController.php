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

    function convertPHPSizeToBytes($sSize)
    {
        if (is_numeric($sSize)) {
            return $sSize;
        }
        $sSuffix = substr($sSize, -1);
        $iValue = substr($sSize, 0, -1);
        switch (strtoupper($sSuffix)) {
            case 'P':
                $iValue *= 1024;
                break;
            case 'T':
                $iValue *= 1024;
                break;
            case 'G':
                $iValue *= 1024;
                break;
            case 'M':
                $iValue *= 1024;
                break;
            case 'K':
                $iValue *= 1024;
                break;
        }
        return $iValue;
    }

    function upload_jpeg_dataurl(Request $request)
    {
        $jpeg_dataurl = $request->jpeg_dataurl;
        if ($jpeg_dataurl > ($post_max_size = $this->convertPHPSizeToBytes(ini_get('post_max_size')))) {
            return 'post size must smaller than ' . $post_max_size . ' bytes, post size is ' . $request->dataurisize . ' bytes';
        }
        list($type, $jpeg_dataurl) = explode(';', $jpeg_dataurl);
        list(, $jpeg_dataurl) = explode(',', $jpeg_dataurl);
        $jpeg_dataurl = base64_decode($jpeg_dataurl);

        $download_key = str_random();
        $type = last(explode('/', $type));
        $save_to = $this->saveToPath($download_key, $type);
        if (!is_dir($dir = pathinfo($save_to, PATHINFO_DIRNAME))) {
            mkdir($dir, 0777, true);
        }
        $write = file_put_contents($save_to, $jpeg_dataurl);

        if ($write) {
            return [
                'saved' => true,
                'download_url' => url("/mobile/download_jpeg_dataurl?download_key=$download_key&type=$type")
            ];
        }
        return [
            'saved' => false,
            'err' => true,
            'err_message' => 'can not save to ' . $save_to
        ];
    }

    function saveToPath($download_key, $type)
    {
        return storage_path('temp/' . Auth::user()->happy_id . "_$download_key.$type");
    }

    function download_jpeg_dataurl(Request $request)
    {
        $download_key = $request->download_key;
        $type = $request->type ?: 'jpeg';

        if (is_file($file = $this->saveToPath($download_key, $type))) {
            return response()->download($file);
        }
        return 'file requested not found';
    }

}

