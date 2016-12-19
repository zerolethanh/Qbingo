<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QRController extends Controller
{
    //
    public function getQRImg($filename)
    {
        $file = storage_path('app/qr/' . $filename);
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }

//        if (file_exists($path)) {
//            $fp = fopen($path, 'rb');
//            header("Content-Type: image/png");
//            header("Content-Length: " . filesize($path));
//            fpassthru($fp);
//        }

//        return 'QRCODE not exists in storage/app/qr';
    }
}
