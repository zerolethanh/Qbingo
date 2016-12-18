<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QRController extends Controller
{
    //
    public function getQRImg($filename)
    {
        $path = storage_path('app/qr/' . $filename);

        if (file_exists($path)) {
            $fp = fopen($path, 'rb');
            header("Content-Type: image/png");
            header("Content-Length: " . filesize($path));
            fpassthru($fp);
        }

//        return 'QRCODE not exists in storage/app/qr';
    }
}
